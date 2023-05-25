<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDueRequest extends FormRequest
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
            "dueable_type" => ["required", "string", "starts_with:App\\Models\\"],
            "dueable_id" => ['required', 'numeric', "min:1", "exists:".$this->dueable_type.",id"],
            "paid_amount" => ['required', 'numeric'],
            "paid_at" => ['required', 'date', "before_or_equal:today"],
            "notices" => ['nullable']
        ];
    }
}
