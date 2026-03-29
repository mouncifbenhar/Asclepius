<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
     protected $fillable = [
            'name',
            'level',
            'description', 
            'date_recorded',
            'notes', 
            'user_id'
    ];

    protected $casts = [
        'notes' => 'array'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
