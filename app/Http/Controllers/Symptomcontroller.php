<?php

namespace App\Http\Controllers;

use App\Models\Symptom;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class Symptomcontroller extends Controller
{

    #[OA\Post(
        path:'/symptoms',
        tags:['symptoms'],
        security:[['sanctum' => []]],
        requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required:['name','level','date_recorded'],
            properties:[
                new OA\Property(property:'name', type:'string'),
                new OA\Property(property:'level', type:'string' , enum:["mild", "moderate", "severe"]),
                new OA\Property(property:'description', type:'string'),
                new OA\Property(property:'date_recorded',type:'date'),
                new OA\Property(property:'notes',type:'string')
            ]
        )
        ),
      responses:[
        new OA\Response(response:200 , description:"add symptoms successfuly"),
        new OA\Response(response:401 ,description: 'failed')
       ]

    )]
    public function store(Request $request){
            
         $data = $request->validate([
               'name' => 'required',
               'level' => 'required|in:mild,moderate,severe',
               'description' => 'nullable|string', 
               'date_recorded' => 'required|date_format:Y-m-d',
               'notes' => 'nullable|string'
         ]);
         $data['user_id'] = auth()->id();
         $symptom = Symptom::create($data);
         
         return response()->json([   
         'massege' => 'symptom created successfully',
         'symptom' =>  $symptom
         ],201);
    }

//---------------------------------------------------------------------------------------------------------------------------

#[OA\Get(
    path:'/symptoms',
    tags:['symptoms'],
    security:[['sanctum' => []]],
    responses:[
        new OA\Response(response:200 , description:"all symptoms"),
        new OA\Response(response:401 ,description: 'failed')
       ]
)]
         public function index(){

         $symptoms = Symptom::where('user_id',auth()->id())->get();
         return response()->json($symptoms,201);

        }



//-------------------------------------------------------------------------------------------------------------------------------------


  #[OA\Get(
      path:'/symptoms/{id}',
      tags:['symptoms'],
      security:[['sanctum' => []]],
      parameters:[
        new OA\Parameter(name:"id",in:'path',required:true, 
                         schema: new OA\Schema(type:"integer"))
      ],
       responses:[
        new OA\Response(response:200 , description:"symptoms"),
        new OA\Response(response:401 ,description: 'failed')
       ]
  )]
    public function show($id){

       $symptom = auth()->user()->Symptoms()->findOrFail($id);
       return response()->json($symptom,200);

    }
//---------------------------------------------------------------------------------------------------------------------------------------    
    
#[OA\Delete(
      path:'/symptoms/{id}',
      tags:['symptoms'],
      security:[['sanctum' => []]],
      parameters:[
        new OA\Parameter(name:"id",in:'path',required:true, 
                         schema: new OA\Schema(type:"integer"))
      ],
       responses:[
        new OA\Response(response:200 , description:"deleted symptoms"),
        new OA\Response(response:401 ,description: 'failed')
       ]
  )]
public function destroy($id){
        $symptom = auth()->user()->Symptoms()->findOrFail($id);
        $symptom->delete();
        return response()->json([
            'massege' => 'symptom has deleted successfully'
        ],201);
    }
//------------------------------------------------------------------------------------------------------------------------------------------    
    
 #[OA\Put(
        path:'/symptoms/{id}',
        tags:['symptoms'],
        security:[['sanctum' => []]],
        parameters:[
        new OA\Parameter(name:"id",in:'path',required:true, 
                         schema: new OA\Schema(type:"integer"))
        ],
        requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required:['name','level','date_recorded'],
            properties:[
                new OA\Property(property:'name', type:'string'),
                new OA\Property(property:'level', type:'string' , enum:["mild", "moderate", "severe"]),
                new OA\Property(property:'description', type:'string'),
                new OA\Property(property:'date_recorded',type:'date'),
                new OA\Property(property:'notes',type:'string')
            ]
        )
        ),
      responses:[
        new OA\Response(response:200 , description:"update symptoms successfuly"),
        new OA\Response(response:401 ,description: 'failed')
       ]

    )]

public function update(Request $request,$id){

        $symptom = auth()->user()->Symptoms()->findOrFail($id);
        $data = $request->validate([
               'name' => 'required',
               'level' => 'required|in:mild,moderate,severe',
               'description' => 'nullable|string', 
               'date_recorded' => 'required|date_format:Y-m-d',
               'notes' => 'nullable|string'
        ]);
        $symptom->update($data);
        return response()->json([
            'massege' => 'symptom has update successfully',
            'symptom' => $symptom 
        ],200);

    } 
    

}


