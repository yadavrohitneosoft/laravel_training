<?php
namespace App\Http\Traits; 
use Redirect,Response;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Collection;  
trait ResponseTrait {

    //success response
    protected function successResponse($data, $message = null, $code = 200){
		return response()->json([
			'status'=>1, 
            'response_msg' => 'success',
			'message' => $message, 
			'data' => $data
		], $code);
	}

    //error response
	protected function errorResponse($message = null, $code){
		return response()->json([
			'status'=>0,
            'response_msg' => 'error',
			'message' => $message,
			'data' => null
		], $code);
	}


}