<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplyTransactionRequest extends FormRequest
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
            "supplier_id" => ["required", "exists:suppliers,id"],
            "product_division_id" => ["required", 'exists:product_divisions,id'],
            "ore_weight_in_grams" => ["required", "numeric", "min:0.01"],
            "cost_per_gram" => ["required", "numeric", "min:0.01"],
            "paid_amount" => ["required", "numeric", "min:0.01"],
            "date" => ["required", "date"],
            "transaction_scope" => ["required", "in:ORE,PRODUCTS"],
            "cost_type" => ["required", "in:GOLD,MONEY"],
            "products_number" => ["nullable", "required_if:transaction_type,=,PRODUCTS", "numeric", "min:1"],
            "currency_id" => ["required", "exists:currencies,id"]
        ];
    }
}
