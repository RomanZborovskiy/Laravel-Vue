<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeatCutOutputRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'outputs' => 'required|array|min:1',
            'outputs.*.product_id' => 'exists:products,id',
            'outputs.*.meat_intake_item_id' => 'required',
            'outputs.*.amount' => 'numeric',
            'outputs.*.total_weight_kg' => 'numeric|min:0.01',
        ];
    }
}
