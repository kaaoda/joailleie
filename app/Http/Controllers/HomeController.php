<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Due;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\RestorationRequest;
use App\Models\SupplyTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    private static function calcCountersMonthly(string $modelClass, string $dateColumn = 'created_at')
    {
        $model = new($modelClass);
        $newNumber = $model::whereMonth($dateColumn, date('m'))->count();
        $prevMonthNumber = $model::whereMonth($dateColumn, date('m' ,strtotime('-1 month')))->count();
        $percent = $prevMonthNumber == 0 ? 'N/A' : ($newNumber - $prevMonthNumber) / ($prevMonthNumber * 100) . "%";
        return (object)compact('newNumber', 'percent');
    }

    private static function calcGoldMonthlyEarning()
    {
        $currentMonthOrders = Order::doesntHave('orderReturn')->whereMonth("date", date('m'))->with("products")->whereRelation("products.category.division", "name", "=", "GOLD")->get();

        $currentMonthInvoices = Invoice::whereMonth("date", date('m'))->whereRelation("division", "name", "=", "GOLD")->get();
        $currentMonthInvoices = $currentMonthInvoices->filter(function ($invoice) {
            if (($invoice->invoicable_type === Order::class && $invoice->invoicable->orderReturn === NULL) || $invoice->invoicable_type === OrderReturn::class)
                return $invoice;
        });
        $currentMonthInvoicesDues = Due::whereMonth("paid_at", date('m'))
            ->whereHasMorph("dueable", [Invoice::class], function (Builder $builder) {
                $builder->whereRelation("division", "name", "=", "GOLD");
            })
            ->get();
        $customerBalances = Customer::sum('balance');
        $totalIncome = $currentMonthInvoices->sum("paid_amount") + $currentMonthInvoicesDues->sum("paid_amount");
        

        $oreCost = $currentMonthOrders->reduce(function($accumlate, $order){
            return $accumlate + $order->products->sum(function ($product) {
                return $product->pivot->gram_price * $product->weight;
            });
        });

        $totalExpenses = $currentMonthOrders->reduce(function ($accumlate, $order) {
            return $accumlate + $order->products->sum(function ($product) {
                return $product->manufacturing_value * $product->weight;
            });
        });
        return (object)compact('totalIncome','oreCost', 'totalExpenses', 'customerBalances');
    }

    private static function calcDiamondMonthlyEarning()
    {
        $currentMonthOrders = Order::doesntHave('orderReturn')->whereMonth("date", date('m'))->with("products")->whereRelation("products.category.division", "name", "=", "DIAMOND")->get();

        $currentMonthInvoices = Invoice::whereMonth("date", date('m'))->whereRelation("division", "name", "=", "DIAMOND")->get();
        $currentMonthInvoices = $currentMonthInvoices->filter(function($invoice){
            if(($invoice->invoicable_type === Order::class && $invoice->invoicable->orderReturn === NULL) || $invoice->invoicable_type === OrderReturn::class)
                return $invoice;
        });
        $currentMonthInvoicesDues = Due::whereMonth("paid_at", date('m'))
            ->whereHasMorph("dueable", [Invoice::class], function(Builder $builder){
                $builder->whereRelation("division", "name", "=", "DIAMOND");
            })
            ->get();
        $customerBalances = Customer::sum('balance');
        $totalIncome = $currentMonthInvoices->sum("paid_amount") + $currentMonthInvoicesDues->sum("paid_amount");


        $oreCost = $currentMonthOrders->reduce(function ($accumlate, $order) {
            return $accumlate + $order->products->sum("manufacturing_value");
        });
        return (object)compact('totalIncome', 'oreCost', 'customerBalances');
    }

    private static function calcDailyEarning()
    {
        $currentDayInvoices = Invoice::whereDay("date", today())->get();
        $currentDayInvoicesDues = Due::whereDay("paid_at", today())->where("dueable_type", Invoice::class)->get();

        $totalIncome = $currentDayInvoices->sum("paid_amount") + $currentDayInvoicesDues->sum("paid_amount");

        return $totalIncome;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if(Gate::allows('isManager'))
        {
            //get every day total payments with different methods: cash, credit card, ...etc
            $dailyPaymentsDivisions = PaymentMethod::whereHas("invoicePayments", function(Builder $builder){
                $builder->whereDay("created_at", "=", today());
            })->withSum("invoicePayments", "value")->get()->pluck("invoice_payments_sum_value", "name");

            //get most and least selling products, 3 for each
            // $highProducts = Product::withCount("orders")->orderByDesc("orders_count")->take(3)->get();
            // $lowProducts = Product::withCount("orders")->orderBy("orders_count")->take(3)->get();

            //get counters for new customers, orders, products and earning in current month
            $customers = self::calcCountersMonthly(Customer::class);
            $orders = self::calcCountersMonthly(Order::class, 'date');
            $products = self::calcCountersMonthly(Product::class);
            $returns = self::calcCountersMonthly(OrderReturn::class); //self::calcCountersMonthly(ProductReturn::class, 'date');
            $monthFinancials = self::calcGoldMonthlyEarning();
            $dayIncome = self::calcDailyEarning();
            $diamondMonthlyEarning = self::calcDiamondMonthlyEarning();
            $goldIn = Product::whereRelation('category.division', 'name', '=', 'GOLD')->whereMonth("created_at", date('m'))->sum("weight");
            $goldOut = Order::whereRelation('invoice.division', 'name', '=', 'GOLD')
                ->whereMonth("created_at", date('m'))
                ->with('products')
                ->withSum('products', 'weight')
                ->get()->sum('products_sum_weight');

            $activeRestorationRequests = RestorationRequest::where("status", FALSE)->with('lastTransaction')->get();
            return view("entities.home", compact(
                'dailyPaymentsDivisions',  
                'customers', 
                'orders',
                'products',
                'returns',
                'monthFinancials',
                'dayIncome',
                'diamondMonthlyEarning',
                'goldIn',
                'goldOut',
                'activeRestorationRequests'
            ));
        }
        return view("entities.home");
    }
}
