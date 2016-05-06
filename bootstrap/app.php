<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

// $app->withFacades();

// $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/../app/Http/routes.php';
});

config([
	'service'	=> [
		'course' => [
			'information'	=> 'http://api2.mycodeville.com/attempt-assignment/%s/question/%s',
			'testcase'		=> 'http://api2.mycodeville.com/attempt-assignment/%s/question/%s/testcases'
		],
		'compiler' => [
			'compile'		=> 'http://localhost/compile',
			'test'			=> 'http://localhost/checkTestCase'
		]	
	],
	'dummytext' => 'อุตสาหการกับดักวืดทัวร์ เปโซอีโรติกสุนทรีย์วืดไบเบิล แรงใจ โกลด์แพตเทิร์นแฮมเบอร์เกอร์ซูเอี๋ยโฮลวีต สถาปัตย์ รีดไถ คอร์ปอเรชั่นโจ๋วีไอพีเยลลี่ควิก อุปทาน ใช้งานคอนแท็คไฟแนนซ์ โค้ชแอสเตอร์วอลล์ดิสเครดิตเอาต์ ผู้นำหลวงตาเวสต์โบรกเกอร์ ศากยบุตรสหัชญาณสต๊อกแคมป์ตี๋ ปิยมิตร มหภาคเจ๊าะแจ๊ะเช็งเม้งเก๊ะ แกรนด์ไบเบิล ยูวี 

	แจ๊กเก็ตม้านั่งตุ๊ก ซีอีโอคอลเล็กชั่น ป๋อหลอซิลเวอร์เจล รีวิวทับซ้อนยูโร ไอซียูควิกมาร์ค โกะ บอกซ์คำตอบรุสโซ เอาท์มอบตัวนู้ดซีอีโอโฮป บลอนด์ชิฟฟอนมาร์เก็ตติ้ง มอลล์ ครูเสดโปรเจ็ค ซิมโฟนีแต๋ว ดีกรีจิ๊ก พาสปอร์ตแหววโกเต็กซ์ตังค์ สเกตช์ เปราะบางบัตเตอร์'

]);

return $app;
