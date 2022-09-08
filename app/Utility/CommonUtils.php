<?php

namespace App\Utility;

class CommonUtils
{
    public static function sendResponse($result, $message, $token=null)
    {
        $response = [
            'success' => true,
            'result'  => $result,
            'msg'     => $message,
            'token'   => $token
        ];
        return response()->json($response, 200);
    }

    public static function sendError($result, $message, $token=null)
    {
        $response = [
            'success' => false,
            'result'  => $result,
            'msg'     => $message,
            'token'    => $token
        ];
        return response()->json($response, 200);
    }
}