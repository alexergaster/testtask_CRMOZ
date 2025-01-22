<?php

namespace App\Http\Requests\ZohoAPI;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountRequest extends FormRequest
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
            'Account_Name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄґҐ\s\-]+$/u'],
            'Website' => ['required', 'url', 'max:255'],
            'Phone' => ['required', 'string', 'regex:/^\+?[0-9\s\-]{10,15}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'Account_Name.required' => 'Account Name є обов’язковим полем.',
            'Account_Name.regex' => 'Account Name може містити лише літери, пробіли та дефіси.',
            'Website.required' => 'Website є обов’язковим полем.',
            'Website.url' => 'Website повинен бути з дійсним URL.',
            'Phone.required' => 'Phone є обов’язковим полем.',
            'Phone.regex' => 'Phone повинен мати валідний формат (наприклад, +380123456789).',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(["success" => false, "errors" => $validator->errors()], 422)
        );
    }
}
