<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['prefix'=>'topics'],function(){
	Route::post('/', [TopicController::class, 'store'])->middleware('auth:api');
	Route::get('/', [TopicController::class, 'index']);
	Route::get('/{topic}', [TopicController::class, 'show']);
	Route::patch('/{topic}', [TopicController::class, 'update'])->middleware('auth:api');
	Route::delete('/{topic}', [TopicController::class, 'destroy'])->middleware('auth:api');
	//post route group
	Route::group(['prefix'=>'/{topic}/posts'],function(){
		Route::get('/{post}',[PostController::class,'show'])->middleware('auth:api');
		Route::post('/',[PostController::class,'store'])->middleware('auth:api');
		Route::patch('/{post}',[PostController::class,'update'])->middleware('auth:api');
		Route::delete('/{post}',[PostController::class,'destroy'])->middleware('auth:api');
		//likes
		Route::group(['prefix'=>'/{post}/likes'],function(){
			Route::post('/',[PostLikeController::class,'store'])->middleware('auth:api');
		});
	});

});