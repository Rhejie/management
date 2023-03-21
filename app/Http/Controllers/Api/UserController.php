<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;

use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserAccountRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use App\Traits\ResultTrait;

use App\Http\Resources\PermissionResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    use ResultTrait;
    
    public function register(UserRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true, $request->validator->messages());
        }

        //check if already registered
        if ($this->validEmail($request->email)) {
            return $this->result(true, 'Already registered');
        }

        if (!$role = Role::find($request->role_id)) {
            return $this->result(true, 'Role not found');
        }

        try {
            // $password = Str::random(8);
            $employee = Employee::findOrFail($request->employee_id);

            if ($employee->email != $request->email) {
                return $this->result(true, (object)[
                    'email' => ['Not registered email']
                ]);
            }
            
            $password = 'cams_inspiro';

            $user = $employee->account()->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
            ]);

            $user->assignRole($role->name);

            // Mail::to($request->email)->send(new WelcomeEmail($password));

            return response()->json([
                'error' => false,
                'message' => 'Successfully added ' .$request->name .' with role as ' .$role->name,
                'generated_password' => $password,
            ]);
            
        }
        catch (ModelNotFoundException $e) {
            return $this->result(true, 'Employee not found');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function statusUpdate(UserRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true, $request->validator->messages());
        }

        try {
            $user = User::findOrFail($request->id)->update([
                'status' => $request->status,
            ]);

            return $this->result(false, 'User status updated');
            
        }
        catch (ModelNotFoundException $e) {
            return $this->result(true, 'User not found');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function all()
    {
        return UserResource::collection(User::where('id', '!=', 1)->get());
    }

    public function requestToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if($validator->fails()){
            return $this->result(true, $validator->errors());
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return [
                'error' => true,
                'message' => 'You are unauthorized'
            ];
        }

        if ($user->status == 0) {
           return $this->result(true, 'Deactivated Account');
        }

        $user->tokens()->delete();

        $token = $user->createToken($request->email, ['user:'.strtolower($user->getRoleNames()->first())])->plainTextToken;

        $role = ($user->role() == 'Super Admin') ? 'admin' : $user->role();
    
        return response()->json([
            'error' => false,
            'token' => $token,
            // 'token' => explode('|',$token)[1],
            'role' => strtolower($role),
            'permissions' => PermissionResource::collection($user->getAllPermissions()),
        ], 201);
    }

    public function profileUpdate(UserAccountRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->result(true,$request->validator->messages());
        }

        if (!$role = Role::find($request->role_id)) {
            return $this->result(true, 'Role not found');
        }

        try {
            $user = User::findOrFail($request->id);
            $user->name = $request->name;
            $user->status = $request->status;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            $user->syncRoles([$role->name]);
            return $this->result(false, 'Profile Updated');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->result(true, 'Unknown User');
        }
        catch (\Throwable $th) {
            return $this->result(true, $th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();

            return $this->result(false, 'logged out');
        } catch (\Throwable $th) {
            return $this->result(true, 'Unauthorized Token');
        }
    }

    public function checkToken()
    {
        if (auth()->user()) {
            $role = strtolower(auth()->user()->role());
            if ($role == 'super admin') {
                $role = 'admin';
            }
            return response()->json([
                'role' => $role,
                'authenticated' => true,
                'permissions' => PermissionResource::collection($user->getAllPermissions()),
            ], 201);
        }

        return response()->json([
            'role' => null,
            'authenticated' => false,
            'permissions' => [],
        ], 401);
    }

    //check if email exists
    private function validEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
