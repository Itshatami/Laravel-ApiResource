<?php

namespace App\Traits;

trait ApiResponse
{
   // Success Response
   protected function sResponse($data, $message = null, $code)
   {
      return response()->json([
         'status' => 'success',
         'message' => $message,
         'data' => $data
      ], $code);
   }

   // Error Response
   protected function eResponse($message = null, $code)
   {
      return response()->json([
         'status' => 'error',
         'message' => $message
      ], $code);
   }
}
