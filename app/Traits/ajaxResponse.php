<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ajaxResponse
{
    protected function jsonResponse
    (
        string $status = 'success', 
        int $statusCode = 200, 
        string $message = 'Response successful',
        mixed $data = null
    ) : JsonResponse
    {
        return response()->json([
            'status' => $status,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ]);
    }
}
