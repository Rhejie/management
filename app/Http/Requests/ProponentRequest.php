<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProponentRequest extends FormRequest
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
            'proponent_number' => 'required|string|max:255',
            'proponent_type_id' => 'required|numeric|min:1',
            'company_id' => 'required_if:proponent_type_id,1,2,3|numeric|min:1',
            'site_id' => 'nullable|required_if:proponent_type_id,1,2|numeric|min:1',
            'cost_center_id' => 'nullable|required|numeric|min:1',
            'email' => 'nullable|required_if:proponent_type_id,1|email|max:255|unique:proponents',
            // 'rank_id' => 'nullable|required_if:proponent_type_id,1|numeric|min:1',
            'tagged_proponent_id' => 'nullable|required_if:proponent_type_id,4|numeric|min:1',
            'sap_code' => 'nullable|string|max:255'
        ];

        if ($this->getMethod() == 'PATCH' || $this->getMethod() == 'DELETE') {
            $rules['id'] = 'required|numeric|min:1';
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
