<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use Editor\Connection;
use Editor\CourseInformationConnection;

class EditorServicesController extends Controller 
{

	public function __construct(){}

	public function course($question_id) {
		return response()->json(['value' => $question_id]);
	}

	public function compile(Request $request)
	{
		// Submit file and test case to compiler
		//
		$script = $request->input('script'); 
		$result = $this->getCompileResult($script);

		// return result
		return $this->tranformToJson([
			'compiled' => [
				'results'	=> $result
			]
		]);
	}

	public function testScript(Request $request) 
	{
		$aid = $request->input('aid') == null ? 1 : $request->input('aid');
		$qid = $request->input('qid') == null ? 1 : $request->input('qid');

		// Get  test case
		$testsuite = $this->getTestcaseInformation($aid, $qid);

		$script = $request->input('script'); 
		$result = $this->getTestResult($script, $testsuite);

		return $this->tranformToJson([
			'tested' => [
				'results'	=> $result
			]
		]);
	}

	public function question(Request $req)
	{
		$aid = $req->input('aid') == null ? 1 : $req->input('aid');
		$qid = $req->input('qid') == null ? 1 : $req->input('qid');

		// Get  test case
		$courseInformation = $this->getContent(
			sprintf( 
				config('service.course.information'),
				max(1, ((int)$aid % 2)),
				1 + ((int)$qid % 2)
			)
		);

		return $this->tranformToJson($courseInformation);
	}

	protected function getContent($url)
	{
		$context = stream_context_create(
			[
				'http' => ['header'=>'Connection: close\r\n']
			]
		);

		return file_get_contents($url, false, $context);
	}

	protected function getTestcaseInformation($aid, $qid, $is_raw = false) 
	{
		$content_url = sprintf(
			config('service.course.testcase'),
			max(1, ((int)$aid % 2)),
			1 + ((int)$qid % 2)
		);
		$raw_data = $this->getContent($content_url);

		$content = json_decode($raw_data);

		return $is_raw ? $content : $this->questionCleanup($content) ;
	}

	protected function questionCleanup($content) 
	{
		$testcase = [];
		foreach( $content->test_case as $tc ) 
		{
			$testset = [];

			foreach( $tc->input as $t )
			{
				$testset[] = $t->value;
			}

			$testset[] = $tc->output->value;

			$testcase[] = $testset;
		}

		return $testcase;
	}

	protected function getCompileResult($script, $input = '')
	{
		$compileResult = $this->sendMessageToCompile(
			config('service.compile.test'),
			[
				'lang'			=> 'python',
				'sourceCode'	=> $script,
				'input'			=> $input
			]
		);

		return $compileResult;
	}

	protected function getTestResult($script, $testsuite)
	{
		$respond = [];
		
		foreach($testsuite as $testcase)
		{
			$output = array_pop($testcase);
			$input = implode(' ', $testcase);
			$compileResult = $this->sendMessageToCompile(
				config('service.compile.test'),
				[
					'lang'			=> 'python',
					'sourceCode'	=> $script,
					'input'			=> $input,
					'output'		=> $output
				]
			);

			$respond[] = $compileResult;

		}

		return $respond;
	}

	protected function sendMessageToCompile($endpoint, $params)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$server_respond = curl_exec($ch);
		curl_close($ch);

		return $server_respond;
	}

	protected function tranformToJson($content, $status = 0)
	{
		$status = (0 == $status) ? Response::HTTP_OK : $status ;
		
		return (new Response($content, $status))
		   ->header('Content-Type', 'application/json');
	}
}

