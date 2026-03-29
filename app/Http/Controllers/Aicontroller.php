<?php

namespace App\Http\Controllers;

use App\Jobs\Aijob;
use App\Models\History;
use App\Models\Symptom;
use OpenApi\Attributes as OA;

class Aicontroller extends Controller
{
    


       public function Aihealth_advice(){
       $Symptom = Symptom::where('user_id',auth()->id())->orderby('created_at','desc')->first();
       $user_id = auth()->id();
       Aijob::dispatch($Symptom,$user_id);
    
}
//-------------------------------------------------------------------------------------------------------


public function latest_advice(){
      
       $lastadvice = History::latest()->first();
       return response()->json([
        'advice' => $lastadvice 
       ],200);
}
//--------------------------------------------------------------------------------------------


public function index(){
     $advices = History::where('user_id',auth()->id())->get();

     return response()->json([
             'massege' => ' Ai advice History',
             'advices' => $advices 
     ],200);
    

}

}


