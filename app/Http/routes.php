<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return response()->json(['a'=>'b']); // $app->version();
});

$app->post('api/question/submit', 'API\EditorServicesController@submit');

$app->get('api/question/{course_id}', 'API\EditorServicesController@course');
