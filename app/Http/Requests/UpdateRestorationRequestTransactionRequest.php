<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestorationRequestTransactionRequest extends FormRequest
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
            "restoration_request_id" => "nullable|exists:restoration_requests,id",
            "employee_name" => "nullable|string|max:255",
            "description" => "nullable|string",
            "happened_at" => "nullable|date"
        ];
    }
}
