<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'proponent_number' => 'required|string|max:255|unique:employees,employee_number',
            'site_id' => 'required|numeric|min:1',
            'campaign_id' => 'required|numeric|min:1',
            'email' => 'required|email|max:255|unique:employees',
        ];

        if ($this->getMethod() == 'PATCH' || $this->getMethod() == 'DELETE') {
            $rules['id'] = 'required|numeric|min:1';
            $rules['proponent_number'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
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

    public function messages()
    {
        return [
            'proponent_number.unique' => 'Employee number is already taken',
            'name.required' => 'Name is required',
            'proponent_number.required' => 'Employee number is required',
            'site_id.required' => 'Site is required',
            'campaign_id.required' => 'Campaign is required',
        ];
    }
}
