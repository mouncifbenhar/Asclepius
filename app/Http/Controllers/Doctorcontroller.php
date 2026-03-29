<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class Doctorcontroller extends Controller
{
    #[OA\Get(
    path: '/doctors',
    tags: ['doctors'],
    security:[['sanctum' => []]],
    responses: [
        new OA\Response(response: 200, description: 'OK'),
    ]
    )]
    public function index(){
        $doctors = Doctor::all();
        return response()->json($doctors,200);
    }

//-------------------------------------------------------------------------------------------------------------------

 #[OA\Get(
      path:'/doctors/{id}',
      tags:['doctors'],
      security:[['sanctum' => []]],
      parameters:[
        new OA\Parameter(name:"id",in:'path',required:true, 
                         schema: new OA\Schema(type:"integer"))
      ],
       responses:[
        new OA\Response(response:200 , description:"doctors"),
        new OA\Response(response:401 ,description: 'failed')
       ]
  )]

    public function show($id){
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor,201);
    }

//------------------------------------------------------------------------------------------

#[OA\Get(
        path:'/search_doctors',
        tags:['doctors'],
        security:[['sanctum' => []]],
            parameters:[
                new OA\Parameter(name:'specialty', in:'query',schema: new OA\Schema(type:"string")),
                new OA\Parameter(name:'city',in:'query',schema: new OA\Schema(type:"string")),
            ],
      responses:[
        new OA\Response(response:200 , description:"doctors"),
        new OA\Response(response:401 ,description: 'failed')
       ]

    )]


    public function search(Request $request){
           $query = Doctor::query();
           if($request->has('specialty')){
              $query->where('specialty',$request->specialty);
           }
           if($request->has('city')){
             $query->where('city',$request->city);
           }
         $doctors = $query->get();
         return response()->json($doctors,201);
    }
}
