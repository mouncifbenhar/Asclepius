<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;


class Authcontroller extends Controller
{




#[OA\Post(
    path:'/register',
    tags:['Auth'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
               required: ["name","email","password"],
               properties: [
                new OA\Property(property:"name",type:"string"),
                new OA\Property(property:"email",type:"string"),
                new OA\Property(property:"password",type:"string")
               ]
        )
    ),
    responses:[
        new OA\Response(response:200 , description:"regiter successfuly"),
        new OA\Response(response:401 ,description: 'Registration failed')
    ]
)]

    public function register(Request $request){
      
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6'
    ]);
    $data['password'] = Hash::make($data['password']);
    $user = User::create($data);

    return response()->json([
            'massege' => 'successfully register',
            'user' => $user
    ],201);
    }

//--------------------------------------------------------------------------

 #[OA\Post(
    path: '/login',
    tags: ['Auth'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email","password"],
            properties: [
                new OA\Property(property: "email", type: "string"),
                new OA\Property(property: "password", type: "string")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: 'Login success'),
        new OA\Response(response: 401, description: 'Unauthorized')
    ]
)]

     public function login(Request $request){
        
       $request->validate([
           'email' => 'required|email',
           'password' => 'required'
       ]);

       if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['massege' => 'Invalid login'],401);
       }
       $user = User::where('email',$request->email)->first();
       $token = $user->createToken('api-token')->plainTextToken;

       return response()->json([
              'massege' => 'successfull login',
              'user' => $user,
              'token' => $token
       ],200);
     }

    // -----------------------------------------------------



    #[OA\Post(
        path:"/logout",
        tags:['Auth'],
        security:[['sanctum'=>[]]],
        responses:[
            new OA\Response(response:200, description:"logout ok")
        ]
    )]

     public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'massege' => 'successfully logout',
        ],201);
     }
}
