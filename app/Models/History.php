<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class History extends Model
{
    protected $fillable = [
        'advice',
        'user_id'
    ];

     public function user(){
     return $this->belongsTo(User::class,'user_id');
    }
}
