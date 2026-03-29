<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
           
            'status',
            'user_id',
            'doctor_id',
            'appointment_date'
    ];

    protected $casts = [
         'appointment_date' => 'datetime'
    ];


    public function doctor(){
        return $this->belongsTo(Doctor::class,'Doctor_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
