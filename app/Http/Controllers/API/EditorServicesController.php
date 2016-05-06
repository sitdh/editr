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

	public function submit(Request $request, $id)
	{
		// Get  test case
		$question_info = $this->getTestcaseInformation($id);

		// Submit file and test case to compiler
		//

		// return result
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

	protected function getTestcaseInformation($id) 
	{
		$content_url = sprintf(
			config('service.course.testcase'),
			$id	
		);
		$raw_data = $this->getContent($content_url);

		$content = json_decode($raw_data);

		return $this->questionCleanup($content);
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

}
