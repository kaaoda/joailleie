<?php

namespace App\Http\Requests;

use App\Models\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
        $division = $this->category_id ? ProductCategory::find($this->category_id)->division->name : NULL;
        return [
            "category_id" => ['required', 'numeric', 'exists:product_categories,id'],
            "supplier_id" => ['required', 'numeric', 'exists:suppliers,id'],
            "currency_id" => ['nullable', Rule::requiredIf(isset($this->diamonds) && count($this->diamonds) > 0), 'numeric', 'exists:currencies,id'],
            "branch_id" => ['required', 'numeric', 'exists:branches,id'],
            "goldWeight" => ['required', 'numeric', 'min:0'],
            "cost" => ['nullable', 'numeric', 'min:0'],
            "manufacturing_value" => ['required', 'numeric', 'min:0'],
            "lowest_manufacturing_value_for_sale" => ['required', 'numeric', 'min:0'],
            "image" => ['nullable', 'file', 'mimes:png,jpg'],
            "barcode" => ['nullable', 'digits_between:12,13', 'numeric'],
            "kerat" => [Rule::requiredIf(isset($this->goldWeight) && $this->goldWeight > 0), 'in:18,21,24'],
            "diamonds" => ["nullable", 'array']
        ];
    }
}
