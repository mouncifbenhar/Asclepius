<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use OpenApi\Attributes as OA;


class Appointmentcontroller extends Controller
{

 #[OA\Post(
        path:'/appointments',
        tags:['appointments'],
        security:[['sanctum' => []]],
        requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required:['appointment_date','status','doctor_id'],
            properties:[
                new OA\Property(property:'appointment_date', type:'date'),
                new OA\Property(property:'status', type:'string' , enum:["pending", "confirmed", "cancelled"]),
                new OA\Property(property:'doctor_id',type:'integer')
            ]
        )
        ),
      responses:[
        new OA\Response(response:200 , description:"add appointments successfuly"),
        new OA\Response(response:401 ,description: 'failed')
       ]

    )]
   public function store(Request $request)
   {
    $date = Carbon::today();
    $data = $request->validate([
          'appointment_date' => 'required|date_format:Y-m-d',
          'status' => 'required|in:pending,confirmed,cancelled',
          'doctor_id' => 'required',
    ]);
    

    if($date >= $data['appointment_date']){
       return response()->json([
        'massege' => 'the appointment_date must be in futuer'
       ]);
    }
    $data['user_id'] = auth()->id();
    $Appointment = Appointment::create($data);
     
    $doctor = Doctor::where('id', $data['doctor_id'])->first();

    return response()->json([
           'massege' => 'you made an appointment with doctor',
           'doctor' => $doctor['name'],
           'Appointment' => $Appointment 
    ],200);
    
   }
   //------------------------------------------------------------------------------------------------------------------



#[OA\Get(
    path:'/appointments',
    tags:['appointments'],
    security:[['sanctum' => []]],
    responses:[
        new OA\Response(response:200 , description:"all appointments"),
        new OA\Response(response:401 ,description: 'failed')
       ]
)]

  public function index(){
           
    $Appointments = auth()->user()->appointments()->get();
    
    return response()->json([
        'massege' => 'your Appointment',
        'Appointment' => $Appointments
    ],201);
   }
   //--------------------------------------------------------------------------------------------

 #[OA\Get(
      path:'/appointments/{id}',
      tags:['appointments'],
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
        $Appointment = auth()->user()->appointments()->findOrFail($id);
        return response()->json($Appointment,201);

   }
   //-----------------------------------------------------------------------------------------------------------

  #[OA\Delete(
      path:'/appointments/{id}',
      tags:['appointments'],
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
   public function destroy($id){

           $Appointment = auth()->user()->appointments()->findOrFail($id);
           $Appointment->update(['status' => 'cancelled']);
           return response()->json([
               'massege' => 'Appointment has cen Cancel',
               'Appointment' => $Appointment 
           ],201);

   }
   //---------------------------------------------------------------------------------------------------------------------
   public function update(){
          
   }


}
