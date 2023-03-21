<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SoftwareLicenseRequest extends FormRequest
{
    public $validator = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'account_type' => 'required|numeric',
            'asset_class_id' => 'required|numeric',
            'asset_subclass_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'brand_model_id' => 'nullable|numeric',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('software_licenses')->ignore($this->request->get('id'))
            ],
            'description' => 'required|string|max:255',
            'segment_id' => 'required|numeric',
            'isDisposal' => 'nullable',
            'asset_value' => 'required|numeric',
            'accounting_value' => 'required|numeric',
            'accumulated_depreciation' => 'required|numeric',
            'isPEZA' => 'required|boolean',
            'lifespan' => 'required|numeric',
            'mother_asset' => 'nullable',
            'mother_asset_code' => 'nullable',

            'po_number' => 'required|numeric',

            'asset_number' => 'nullable|string|max:255',
            'serial_number' => 'required|string|max:255',
            'date_acquired' => 'required|date_format:Y-m-d',
            'date_expired' => 'required|date_format:Y-m-d',
            'quantity' => 'required|numeric|min:1',
            'warranty_date' => 'required|date_format:Y-m-d',
            'warranty_description' => 'required',

            // 'status' => 'required|string|max:255', //1=new, 2=for re-purpose, 3=for re-assignment, 4=assigned
            'sap_code' => 'nullable',

        ];

        if ($this->getMethod() == 'PATCH')
            $rules['id'] = 'required|numeric|min:1';
        
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
