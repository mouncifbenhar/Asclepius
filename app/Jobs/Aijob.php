<?php

namespace App\Jobs;

use App\Models\History;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class Aijob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $symptom;
    protected $id;
    public function __construct($symptom,$user_id)
    {
        $this->symptom = $symptom ;
        $this->id = $user_id ;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $Symptom = $this->symptom;
        
        $prompt = "
        Symptoms:
        name: {$Symptom->name}. 
        level: {$Symptom->level}. 
        description: {$Symptom->description}. 
        Provide general wellness advice.  
        Do not give medical diagnosis.
        in 20 words";


        $response = Http::withHeaders([
                  'x-goog-api-key' => env('GEMINI_API_KEY'),
                   'Content-Type' => 'application/json'
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent',
        
                ["contents" => [["parts" => ["text" => $prompt]]]]
        
        );

        if(isset($response->json()['candidates'][0]['content']['parts'][0]['text'])){
           $advice = $response->json()['candidates'][0]['content']['parts'][0]['text'];
        }else{
             $advice = "empty";
        }
        
        History::create([
          'advice' => $advice,
          'user_id' => $this->id
         ]);
    }

}
