<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class Doctorcontroller extends Controller
{
    
    public function index(){
        $doctors = Doctor::all();
        return response()->json($doctors,200);
    }

//-------------------------------------------------------------------------------------------------------------------

 

    public function show($id){
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor,201);
    }

//------------------------------------------------------------------------------------------




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
