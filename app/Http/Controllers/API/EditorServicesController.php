<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class EditorServicesController extends Controller 
{

	public function __construct(){}

	public function course($question_id) {
		return response()->json(['value' => $question_id]);
	}

	public function submit(Request $request)
	{
		// Get  test case
		//

		// Submit file and test case to compiler
		//

		// return result
	}
}
