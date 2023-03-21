<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetSubclassRequest extends FormRequest
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
            'asset_class_id' => 'required|numeric|min:1',
            'sap_code' => 'nullable|numeric|unique:asset_subclasses',
            'extension' => 'nullable|string|max:255',
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
