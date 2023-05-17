<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
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
            "type" => ['required', "in:order,return"],
            "id" => ['required', 'numeric'],
            "paid_amount" => ['required', "numeric", 'min:0'],
            "payment" => ['nullable', 'array'],
            "next_due_date" => ['nullable', Rule::requiredIf(function(){
                return count($this->payment) == 0 || Order::findOrFail($this->id)->total > $this->paid_amount;
            }), 'date', 'date_format:Y-m-d'],
            "currency_id" => ["nullable", "exists:currencies,id"],
            "foreign_paid" => ["nullable", "numeric", "min:0.001"]
        ];
    }
}
