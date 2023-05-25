<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestorationRequestTransactionRequest extends FormRequest
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
            "restoration_request_id" => "required|exists:restoration_requests,id",
            "employee_name" => "required|string|max:255",
            "description" => "required|string",
            "happened_at" => "required|date"
        ];
    }
}
