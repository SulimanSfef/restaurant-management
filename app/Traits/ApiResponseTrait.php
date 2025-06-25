<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data = null, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function errorResponse($message = 'Something went wrong', $status = 400, $errors = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}



