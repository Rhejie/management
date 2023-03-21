<?php
 
namespace App\Traits;
 
trait ResultTrait {
 
    public function result(bool $error, $message)
    {
        $port = $error ? 501 : 201;
        return response()->json([
            'error' => $error,
            'message' => $message
        ], $port);
    }
}