<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request){
    
    	$user=User::create([
    		'name'=>$request->name,
    		'email'=>$request->email,
    		'password'=>bcrypt($request->password)
    	]);
    	  $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
            	'error' =>[
            		'email'=>['soory We cannot find u with those details']
            	]
            ],422);
        }

        //return $this->respondWithToken($token);
    	return (new UserResource($request->user()))->additional([
    		'meta'=>[
    			'token'=>$token
    		]
    	]);
    }
    public function login(UserLoginRequest $request){
    
    	  $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //return $this->respondWithToken($token);
    	return (new UserResource($request->user()))->additional([
    		'meta'=>[
    			'token'=>$token
    		]
    	]);
    }
    public function user(Request $request){
    	return new UserResource($request->user());
    }
    public function logout(){
    	auth()->logout();
    }
}