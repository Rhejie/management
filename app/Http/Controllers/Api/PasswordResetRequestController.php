<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use App\Mail\SendRequestPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetRequestController extends Controller
{
    public function sendPasswordResetEmail(Request $request){
        // If email does not exist
        $user = $this->validEmail($request->email);

        if(!$user) {
            return response()->json([
                'message' => 'Email does not exist.'
            ], 404);
        } else {
            // If email exists
            $this->sendMail($user);
            return response()->json([
                'message' => 'Check your inbox, we have sent a link to reset email.'
            ], 201);            
        }
    }


    public function sendMail($user){
        $token = $this->generateToken($user->email);
        $body = (object)[
            'header' => 'Password Reset',
            'message' => 'Please click the button to change your password',
        ];
        Mail::to($user->email)->send(new SendRequestPasswordMail($token, $body));
    }

    public function validEmail($email) {
       return User::where('email', $email)->first();
    }

    public function generateToken($email){
      $isOtherToken = PasswordReset::where('email', $email)->first();

      if($isOtherToken) {
        return $isOtherToken->token;
      }

      $token = Str::random(80);
      $this->storeToken($token, $email);
      return $token;
    }

    public function storeToken($token, $email){

        PasswordReset::create([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);
    }
}

