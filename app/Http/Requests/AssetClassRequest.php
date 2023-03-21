<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AssetClassRequest extends FormRequest
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
            'asset_type_id' => 'required|numeric|in:0,1',
            'name' => 'required|string|max:255',
            // 'sap_code' => 'required|string|unique:asset_classes'
            'sap_code' => [
                'required',
                'string', 
                Rule::unique('asset_classes')->ignore($this->request->get('id'))
            ]
        ];
        
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
