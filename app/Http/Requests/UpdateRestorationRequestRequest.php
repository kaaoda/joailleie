<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestorationRequestRequest extends FormRequest
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
            "customer_id" => 'nullable|exists:customers,id',
            "weight" => "nullable|numeric|min:0",
            "deposit" => "nullable|numeric|min:0",
            "cost" => "nullable|numeric|min:0",
            "notices" => "nullable|string",
            "status" => 'nullable|in:on,off'
        ];
    }
}
