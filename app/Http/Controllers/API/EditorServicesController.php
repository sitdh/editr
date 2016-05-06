<?php

namespace App\Http\Controllers\API;

class ExampleController extends APIController {

	public function course($question_id) {
		return $this->respond(Response::HTTP_OK, $question_id);
	}
}
