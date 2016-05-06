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
		$content_url = sprintf(
			config('service.course.testcase'),
			$id	
		);
		$content = $this->getContent($content_url);

		return response()->json($content);

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

}
