<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use App\Http\Requests\UpdatePasswordRequest;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;
use App\Models\PasswordReset;

class ChangePasswordController extends Controller {

    public function passwordResetProcess(UpdatePasswordRequest $request){
      return $this->updatePasswordRow($request)->count() > 0 ? $this->resetPassword($request) : $this->tokenNotFoundError();
    }

    // Verify if token is valid
    private function updatePasswordRow($request){
       return PasswordReset::where([
           'email' => $request->email,
           'token' => $request->passwordToken
       ]);
    }

    // Token not found response
    private function tokenNotFoundError() {
        return response()->json([
          'error' => 'Either your email or token is wrong.'
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // Reset password
    private function resetPassword($request) {
        // find email
        $userData = User::whereEmail($request->email)->first();
        // update password
        $userData->update([
          'password'=> Hash::make($request->password),
          'email_verified_at' => now()
        ]);
        
        // remove verification data from db
        $this->updatePasswordRow($request)->delete();

        // reset password response
        return response()->json([
          'data'=>'Password has been updated.'
        ],Response::HTTP_CREATED);
    }    

}
