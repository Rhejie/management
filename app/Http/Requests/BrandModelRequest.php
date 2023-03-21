<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandModelRequest extends FormRequest
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
        $rules = [];

        if ($this->getMethod() == 'PATCH' || $this->getMethod() == 'POST') {
            $rules['name'] = 'required|string|max:255';
            $rules['other_name'] = 'nullable|string|max:255';
            $rules['brand_id'] = 'required|numeric|min:1';
            $rules['description'] = 'required|string|max:255';
        }
        
        if ($this->getMethod() == 'PATCH')
            $rules['id'] = 'required|numeric|min:1';

        if ($this->getMethod() == 'DELETE')
            $rules = ['id' => 'required|numeric|min:1'];

        return $rules;
    }

    public function messages()
    {
        return [
            'sap_code.unique' => "Duplicate sap code[".$this->request->get('sap_code')."].",
        ];
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
