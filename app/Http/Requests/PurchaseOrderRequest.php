<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
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
        //if account type == 0 //capex Accounting Value and Accumulated Depreciation are required
        $rules = [
            'asset_type_id' => 'required|numeric|in:0,1',
            'company_id' => 'required|numeric|min:1',
            'brand_model_id' => 'nullable|numeric|min:1',
            'segment_id' => 'required|numeric|min:1',
            'isDisposal' => 'required|in:0,1',
            'asset_value' => 'required|numeric',
            'isPEZA' => 'required|in:0,1',
            'lifespan' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            'po_number' => 'required|numeric',
            'serial_number' => 'required|string|max:255',
            'date_acquired' => 'required|date_format:Y-m-d',
            'date_expired' => 'required|date_format:Y-m-d|after:date_acquired',
            'warranty_date' => 'required|date_format:Y-m-d|before_or_equal:date_expired',
            'warranty_description' => 'required',
            'sap_code' => 'nullable|string|max:255',

        ];

        if ($this->getMethod() == 'PATCH')
        {
            $rules['id'] = 'required|numeric|min:1';
            $rules['account_type'] = 'required|numeric|in:0,1';
            $rules['accounting_value'] = 'nullable|required_if:account_type,0|numeric';
            $rules['accumulated_depreciation'] = 'nullable|required_if:account_type,0|numeric';
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
            'accounting_value.required_if' => 'Required if CAPEX',
            'accumulated_depreciation.required_if' => 'Required if CAPEX',
        ];
    }
}
