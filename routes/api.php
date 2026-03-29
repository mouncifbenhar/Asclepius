<?php


use App\Http\Controllers\Aicontroller;
use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Appointmentcontroller;
use App\Http\Controllers\Doctorcontroller;
use App\Http\Controllers\Swaggercontroller;
use App\Http\Controllers\Symptomcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register',[Authcontroller::class,'register']);
Route::post('/login',[Authcontroller::class,'login']);

Route::get('/test',[Swaggercontroller::class,'test']);






Route::middleware('auth:sanctum')->group(function(){

Route::post('/logout',[Authcontroller::class,'logout']);
Route::apiResource('/symptoms', Symptomcontroller::class);
Route::apiResource('/doctors', Doctorcontroller::class);
Route::get('/search_doctors',[Doctorcontroller::class,'search']);
Route::apiResource('/appointments', Appointmentcontroller::class);
Route::post('/ai/health-advice',[Aicontroller::class,'Aihealth_advice']);
Route::get('/ai/latest-advice',[Aicontroller::class,'latest_advice']);
Route::get('/ai/historys',[Aicontroller::class,'index']);

Route::get('/user', function (Request $request) {
    return $request->user();
});
});