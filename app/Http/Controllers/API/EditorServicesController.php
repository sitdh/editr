<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Response;

class ExampleController extends APIController {

	public function course($question_id) {
		return response()->json($question_id);
	}
}
