<?php

namespace App\Http\Requests\ZohoAPI;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DealRequest extends FormRequest
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
            'Deal_Name' => ['required', 'string', 'max:255'],
            'Stage' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'Deal_Name.required' => 'Deal Name є обов’язковим полем.',
            'Stage.required' => 'Stage є обов’язковим полем.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(["success" => false, "errors" => $validator->errors()], 422)
        );
    }
}
