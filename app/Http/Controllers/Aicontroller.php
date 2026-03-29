<?php

namespace App\Http\Controllers;

use App\Jobs\Aijob;
use App\Models\History;
use App\Models\Symptom;
use OpenApi\Attributes as OA;

class Aicontroller extends Controller
{
    
#[OA\Post(
    path:'/ai/health-advice',
    tags:['Ai'],
    security:[['sanctum' => []]],
    responses:[
        new OA\Response(response:200 , description:"ai-health-advice"),
        new OA\Response(response:401 ,description: 'failed')
       ]
)]

       public function Aihealth_advice(){
       $Symptom = Symptom::where('user_id',auth()->id())->orderby('created_at','desc')->first();
       $user_id = auth()->id();
       Aijob::dispatch($Symptom,$user_id);
    
}
//-------------------------------------------------------------------------------------------------------
#[OA\Get(
    path:'/ai/latest-advice ',
    tags:['Ai'],
    security:[['sanctum' => []]],
    responses:[
        new OA\Response(response:200 , description:"advice"),
        new OA\Response(response:401 ,description: 'failed')
       ]
)]

public function latest_advice(){
      
       $lastadvice = History::latest()->first();
       return response()->json([
        'advice' => $lastadvice 
       ],200);
}
//--------------------------------------------------------------------------------------------


#[OA\Get(
    path:'/ai/historys',
    tags:['Ai'],
    security:[['sanctum' => []]],
    responses:[
        new OA\Response(response:200 , description:"Ai advice History"),
        new OA\Response(response:401 ,description: 'failed')
       ]
)]
public function index(){
     $advices = History::where('user_id',auth()->id())->get();

     return response()->json([
             'massege' => ' Ai advice History',
             'advices' => $advices 
     ],200);
    

}

}


