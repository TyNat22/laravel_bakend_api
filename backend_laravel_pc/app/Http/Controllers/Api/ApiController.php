<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function sendSuccess($data, $message = '', $status = 200)
    {
        $res = [
            'statusCode' => $status,
            'message' => $message,
            'data' => $data
        ];
        return response()->json($res);
    }

    public function sendError($error, $status, $data = [])
    {
        $res = [
            'statusCode' => $status,
            'message' => $error,
            'data' => $data
        ];
        return response()->json($res);
    }
}
