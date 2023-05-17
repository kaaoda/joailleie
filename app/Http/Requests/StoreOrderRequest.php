<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            "customer_id" => ["required", "exists:customers,id"],
            "branch_id" => ["required", "exists:branches,id"],
            "products" => ['required', 'array', 'exists:products,id'],
            "prices" => ["required", "array", "min:".count($this->products), "max:".count($this->products)],
            "prices.*" => ["required", "numeric", "min:0"],
            "goldPrice" => ["nullable" , "numeric", "min:0"],
            "additional_services.additional_services" => ["nullable", "array"],
            "additional_services.additional_services.*.servicesDesc" => ["nullable", "string"],
            "additional_services.additional_services.*.servicesCost" => ["nullable", "numeric", "min:0"],
        ];
    }
}
