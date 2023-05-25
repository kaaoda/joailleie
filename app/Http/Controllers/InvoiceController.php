<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Currency;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderReturn;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use NumberFormatter;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->has("order")) {
            $order = Order::findOrFail($request->query("order"));
            if ($order->invoice) return redirect()->route("invoices.show", ['invoice' => $order->invoice->id]);
            $order->load(["customer", "products", "products.diamonds.currency"]);
            return view("entities.invoices.create", [
                "paymentMethods" => PaymentMethod::all(),
                "order" => $order,
                'diamonds' => $order->products->pluck('diamonds')->collapse(),
                "currencies" => Currency::where("main", FALSE)->get(),
                "users" => User::all()
            ]);
        } 
        elseif ($request->has("orderReturn")) {
            $orderReturn = OrderReturn::findOrFail($request->query("orderReturn"));
            if($orderReturn->type === "RETURN" || ($orderReturn->type === "EXCHANGE" && $orderReturn->diff_amount < 0)) return back();
            if ($orderReturn->invoice) return redirect()->route("invoices.show", ['invoice' => $orderReturn->invoice->id]);
            $orderReturn->load(["order", "order.customer", "products", "products.diamonds.currency"]);
            return view("entities.invoices.create", [
                "paymentMethods" => PaymentMethod::all(),
                "orderReturn" => $orderReturn,
                'diamonds' => $orderReturn->products->pluck('diamonds')->collapse(),
                "currencies" => Currency::where("main", FALSE)->get(),
                "users" => User::all()
            ]);
        }
        else
            return back();
    }

    private static function getPaymentMethodsDivisionsData($safeData, $orderTotal, Invoice $invoice)
    {
        $paymentMethodsDivisions = [];
        foreach ($safeData->payment as $division => $paymentAmount) {
            if($paymentAmount == 0) continue;
            $divisionId = Str::afterLast($division, 'payment:');
            if($divisionId === "customerBalance")
            {
                if($invoice->invoicable_type === Order::class)
                    $invoice->invoicable->customer->decrement("balance", $paymentAmount);
            }
            else
            {
                $paymentMethodsDivisions[] = new InvoicePayment([
                    "payment_method_id" => $divisionId,
                    "value" => $paymentAmount,
                    "percent" => $paymentAmount / $orderTotal * 100,
                    "currency_id" => Currency::where("main", TRUE)->first()->id
                ]);
            }
        }

        if (isset($safeData->foreign_paid)) {
            $currency = Currency::find($safeData->currency_id);
            $paymentMethodsDivisions[] = new InvoicePayment([
                "payment_method_id" => PaymentMethod::where("name", "Cash")->first()->id,
                "value" => $safeData->foreign_paid,
                "percent" => ($currency->exchange_rate * $safeData->foreign_paid) / $orderTotal * 100,
                "currency_id" => $safeData->currency_id,
                "rate" => $currency->exchange_rate
            ]);
        }
        $invoice->payments()->saveMany($paymentMethodsDivisions);
        return $invoice;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $safe = $request->safe();
        
        $order = $safe->type === "order" ? Order::findOrFail($safe->id) : OrderReturn::findOrFail($safe->id);
        
        $lastTnvoice = Invoice::latest()->first();
        //return response($lastTnvoice ? (int)$lastTnvoice->id + 1 : 1);
        try {
            $response = DB::transaction(function () use ($safe, $order, $lastTnvoice) {
                $invoice = Invoice::create([
                    "invoicable_type" => $safe->type === "order" ? Order::class : OrderReturn::class,
                    "invoicable_id" => $safe->id,
                    "invoice_number" => $lastTnvoice !== NULL ? "INV-00" . (int)$lastTnvoice->id + 1 : "INV-00" . 1,
                    "date" => now(),
                    "paid_amount" => $safe->paid_amount > $order->total ? $order->total : $safe->paid_amount,
                    "completed" => $safe->paid_amount >= $order->total,
                    "next_due_date" => $safe->paid_amount < $order->total ? $safe->next_due_date : NULL,
                    "user_id" => $safe->user_id,
                    "product_division_id" => $order->products()->first()->division->id
                ]);

                if($safe->paid_amount > $order->total)
                    $order->customer->increment("balance", $safe->paid_amount - $order->total);

                return self::getPaymentMethodsDivisionsData($safe, $order->total, $invoice);
            });
            return response(['success' => TRUE]);
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $this->authorize("view", $invoice);
        $invoice->load(["invoicable.products.diamonds.currency", "payments.PaymentMethod", "payments.currency"]);
        if($invoice->invoicable_type === Order::class)
            $invoice->load(["invoicable.customer"]);
        else
            $invoice->load(["invoicable.order.customer"]);
        $diamonds = $invoice->invoicable->products->pluck('diamonds')->collapse();
        $formatter = new NumberFormatter("ar_EG", NumberFormatter::SPELLOUT);
        return view("entities.invoices.show", compact('invoice', 'diamonds', 'formatter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
