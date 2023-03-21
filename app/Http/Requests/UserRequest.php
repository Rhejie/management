<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public $validator = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => 'required|numeric|min:1',
            'employee_id' => 'required|numeric|min:1',
        ];
        if ($this->getMethod() == 'PATCH') {
            $rules['id'] = 'required|numeric|min:1';
            $rules['status'] = 'required|numeric|in:1,2';
        }
        return $rules;
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            return response()->json([
                'error' => true
            ]);
        }
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
