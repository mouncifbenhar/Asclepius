<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;

class Swaggercontroller extends Controller
{
        #[OA\Get(
        path: '/test',
        summary: 'Test endpoint',
        tags: ['Test'],
        responses: [
            new OA\Response(response: 200, description: 'OK')
        ]
    )]
    public function test()
    {
        return response()->json(["message" => "Swagger works"]);
    }

}



