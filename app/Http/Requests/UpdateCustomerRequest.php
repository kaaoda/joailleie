<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "full_name" => ['nullable'],
            "phone_number" => ["nullable", "numeric", "digits:10", "unique:customers", "min:0"],
            "email" => ["nullable", "email", "unique:customers"],
            "nationality" => ["nullable", "string"],
            "notices" => ['nullable', "string"]
        ];
    }
}
