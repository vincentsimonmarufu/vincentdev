<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseController extends Controller
{

    /**
     * success response method.
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($data, $message)
    {
        if($data == ""|| $data == null){
            $response = ['success' => true, 'message' => $message];
        }
        if(!empty($data)){
            $response = ['success' => true, 'data' => $data, 'message' => $message];
        }
        
        return response()->json($response, 200);
    }


    /**
     * return error response.
     * @return \Illuminate\Http\Response
     */
    public function sendError($message, $errorsMessages = [], $code = 404)
    {
        $response = ['success' => false, 'message' => $message];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorsMessages;
        }
        return response()->json($response, $code);
    }
}
