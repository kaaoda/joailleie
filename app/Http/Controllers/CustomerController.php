<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Due;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected static function calcCustomersRankRatio(Collection $customers)
    {
        $customers->loadCount("orders");
        $start = $customers->min("orders_count");
        $end = $customers->max("orders_count");
        $rankRatio = ($end - $start) / 3;
        $customers->each(function($customer) use ($start, $end, $rankRatio){
            if ($customer->orders_count >= $start && $customer->orders_count <= $rankRatio) 
                $customer->rank = "Low";
            elseif ($customer->orders_count > $rankRatio && $customer->orders_count <= $rankRatio*2) 
                $customer->rank = "Average";
            elseif ($customer->orders_count > $rankRatio*2 && $customer->orders_count <= $end) 
                $customer->rank = "High";
            else
                $customer->rank = $customer->orders_count <= $start && $customer->orders_count <= $rankRatio;
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        self::calcCustomersRankRatio($customers);
        return view("entities.customers.index", [
            "list" => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("entities.customers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        if(Customer::create($request->safe()->toArray()))
            return redirect()->route("customers.index")->with("success", "Customer added successfully");
        else
        {
            return back()->withErrors([
                "err" => "Something strange happen, try again or contact tech support"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->loadCount("orders")->load("orders", "orders.invoice.dues");
        //dd($customer);
        $debts = $customer->orders->whereNotNull("invoice")->sum(function($order){
            $orderPaid = $order->total - $order->invoice->paid_amount;
            $invoiceDuesPaid = $order->invoice->dues->sum(function($due){
                return $due->paid_amount;
            });
            return $orderPaid - $invoiceDuesPaid;
        });
        $nearestOrder = $customer->orders->whereNotNull("invoice.next_due_date")->sortBy("invoice.next_due_date")->first();
        $nearestDueDate = $nearestOrder ? $nearestOrder->invoice->next_due_date : NULL;
        $totalWeight = $customer->orders->sum(function($order){
            return $order->products()->sum('weight');
        });
        $totalSpend = $customer->orders->sum(function ($order) {
            return $order->invoice->paid_amount;
        });
        $invoices = $customer->orders->map(function ($order) {
            return $order->invoice;
        })->filter();

        $invoiceDues = $invoices->flatMap(function ($invoice) {
                return $invoice->dues;
            })->filter();
        return view("entities.customers.show", compact("customer", "debts", "nearestDueDate", 'totalWeight', "totalSpend", "invoiceDues"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        return $customer->update($request->safe()->toArray())
         ? back()->with("success", "Saved!") 
         : back()->withErrors(['error' => 'Updates not saved']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->deleteOrFail();
            return response(["success" => "Customer deleted"]);
        } catch (QueryException $e) {
            return response([
                "error" => "This record can't deleted!",
                "sql" => $e->getMessage()
            ], 400);
        }
    }
}
