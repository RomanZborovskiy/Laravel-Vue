<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreMeatIntakeMeatRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'part_id'=> [
                'required',
                'exists:meat_parts,id',
                Rule::unique('meat_intake_items')->where('intake_id', $request->intake_id)
            ],
            'type_id'=>[
                'required',
                'exists:meat_types,id'
            ],
            'intake_id'=>['required'],
            'quantity'=>['required'],
        ];
    }
}
