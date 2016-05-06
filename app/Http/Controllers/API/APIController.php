<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller as BaseController;

class APIController extends BaseController 
{
	protected function respond($status, $data = [])
	{
		return response()->json($data, $status);
	}

}
