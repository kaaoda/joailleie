<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestorationRequestRequest extends FormRequest
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
            "customer_id" => 'required|exists:customers,id',
            "weight" => "required|numeric|min:0",
            "deposit" => "required|numeric|min:0",
            "cost" => "required|numeric|min:0",
            "notices" => "required|string",
            'picture_path' => "nullable|image|mimes:png,jpg"
        ];
    }
}
