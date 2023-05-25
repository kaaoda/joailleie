@extends('layouts.main')

@section('pageTitle', 'Create Invoice')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}" />
@endpush

@section('mainContent')
@isset($order)
    <section class="section">
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">#{{ $order->order_number }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        {{ $order->customer->full_name }}<br>
                                        {{ $order->customer->phone_number }}<br>
                                        {{ $order->customer->email }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Employee:</strong><br>
                                        <div class="form-group">
                                            <select class="form-control" id="select-user" name="user_id">
                                                <option selected value="">Choose User...</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        June 26, 2018<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center">
                                    <tr class="bg-whitesmoke">
                                        <th data-width="10">#</th>
                                        <th colspan="2">Item</th>
                                        <th>Price</th>
                                        <th>Gold</th>
                                        <th>Kerat</th>
                                        @if(count($diamonds))
                                            <th>Diamonds</th>
                                        @endif
                                    </tr>
                                    @foreach ($order->products as $product)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}</td>
                                            <td colspan="2">
                                                {{ $product->barcode }}</td>
                                            <td>
                                                {{ $product->pivot->price / $product->pivot->quantity }}
                                                {{ mainCurrency()->code }}</td>
                                            <td>
                                                {{ $product->weight }}g</td>
                                            <td>{{ $product->kerat }}k</td>
                                            @if ($product->diamonds->count())
                                            <td class="p-0">
                                                
                                                    <table class="table table-sm m-0">
                                                        <thead>
                                                            <tr class="bg-whitesmoke">
                                                                <th>Diamond Stones</th>
                                                                <th>Weight</th>
                                                                <th>Clarity</th>
                                                                <th>Color</th>
                                                                <th>Shape</th>
                                                                {{-- <th>Price</th>
                                                                <th>Currency</th>
                                                                <th>Rate</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($product->diamonds as $diamond)
                                                                <tr>
                                                                    <td>{{ $diamond->number_of_stones }}</td>
                                                                    <td>{{ $diamond->weight }}sm</td>
                                                                    <td>{{ $diamond->clarity }}</td>
                                                                    <td>{{ $diamond->color }}</td>
                                                                    <td>{{ $diamond->shape }}</td>
                                                                    {{-- <td>{{ $diamond->price }}</td>
                                                                    <td>{{ $diamond->currency->code }}</td>
                                                                    <td>{{ $diamond->exchange_rate }}</td> --}}
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                        <tr class="bg-whitesmoke">
                                            <th colspan="3">Totals</th>
                                            <th>{{$order->total}}</th>
                                            <th colspan="2">{{$order->products->sum('weight')}}g</th>
                                            @if(count($diamonds))
                                                <th>{{$diamonds->sum('number_of_stones')}} diamond stone with {{$diamonds->sum('weight') / 100}}carat</th>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="section-title">Payment Methods</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm mainTable">
                                            <thead>
                                                <tr>
                                                    @foreach ($paymentMethods as $method)
                                                        <th>{{ $method->name }}</th>
                                                    @endforeach
                                                    <th>Customer Account (max: {{$order->customer->balance}})</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($paymentMethods as $method)
                                                        <td class="payment-method" data-method="{{ $method->id }}">0</td>
                                                    @endforeach
                                                    <td class="payment-method" data-method="customerBalance">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm mainTable">
                                            <thead>
                                                <tr>
                                                    <th>Total Paid</th>
                                                    <th>Rest</th>
                                                    <th>Next Due Date</th>
                                                    <th colspan="2">Paid with foreign currency</th>
                                                    <th>Discount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th id="paid">0</th>
                                                    <th id="rest">0</th>
                                                    <td id="next_due_date">YYYY-MM-DD</td>
                                                    <th>
                                                        <select id="currency_id">
                                                            @foreach ($currencies as $currency)
                                                                <option data-rate="{{round($currency->exchange_rate)}}" value="{{$currency->id}}">{{$currency->name}} - {{$currency->code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                    <td id="foreign_currency_paid">0</td>
                                                    <td id="discount">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ $order->total }} {{ mainCurrency()->code }}</div>
                                    </div>
                                    {{-- <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">VAT (14%)</div>
                                        <div class="invoice-detail-value">{{ 0.14 * $order->total }} {{ mainCurrency()->code }}
                                        </div>
                                    </div> --}}
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ ceil($order->total) }}
                                            {{ mainCurrency()->code }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">
                        <button id="process-payment-btn" class="btn btn-primary btn-icon icon-left"><i
                                class="fas fa-credit-card"></i> Process
                            Payment</button>
                        <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                    <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>
@endisset
@isset($orderReturn)
    <section class="section">
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">#{{ $orderReturn->order->order_number }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        {{ $orderReturn->order->customer->full_name }}<br>
                                        {{ $orderReturn->order->customer->phone_number }}<br>
                                        {{ $orderReturn->order->customer->email }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Employee:</strong><br>
                                        Mohamed Ameen
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        June 26, 2018<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center">
                                    <tr class="bg-whitesmoke">
                                        <th data-width="10">#</th>
                                        <th colspan="2">Item</th>
                                        <th>Price</th>
                                        <th>Gold</th>
                                        <th>Kerat</th>
                                        @if(count($diamonds))
                                            <th>Diamonds</th>
                                        @endif
                                    </tr>
                                    @foreach ($orderReturn->products as $product)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}</td>
                                            <td colspan="2">
                                                {{ $product->barcode }}</td>
                                            <td>
                                                {{ $product->pivot->price }}
                                                {{ mainCurrency()->code }}</td>
                                            <td>
                                                {{ $product->weight }}g</td>
                                            <td>{{ $product->kerat }}k</td>
                                            @if ($product->diamonds->count())
                                            <td class="p-0">
                                                
                                                    <table class="table table-sm m-0">
                                                        <thead>
                                                            <tr class="bg-whitesmoke">
                                                                <th>Diamond Stones</th>
                                                                <th>Weight</th>
                                                                <th>Clarity</th>
                                                                <th>Color</th>
                                                                <th>Shape</th>
                                                                {{-- <th>Price</th>
                                                                <th>Currency</th>
                                                                <th>Rate</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($product->diamonds as $diamond)
                                                                <tr>
                                                                    <td>{{ $diamond->number_of_stones }}</td>
                                                                    <td>{{ $diamond->weight }}sm</td>
                                                                    <td>{{ $diamond->clarity }}</td>
                                                                    <td>{{ $diamond->color }}</td>
                                                                    <td>{{ $diamond->shape }}</td>
                                                                    {{-- <td>{{ $diamond->price }}</td>
                                                                    <td>{{ $diamond->currency->code }}</td>
                                                                    <td>{{ $diamond->exchange_rate }}</td> --}}
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                        <tr class="bg-whitesmoke">
                                            <th colspan="3">Totals</th>
                                            <th>{{$orderReturn->total}}</th>
                                            <th colspan="2">{{$orderReturn->products->sum('weight')}}g</th>
                                            @if(count($diamonds))
                                                <th>{{$diamonds->sum('number_of_stones')}} diamond stone with {{$diamonds->sum('weight') / 100}}carat</th>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="section-title">Payment Methods</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm mainTable">
                                            <thead>
                                                <tr>
                                                    @foreach ($paymentMethods as $method)
                                                        <th>{{ $method->name }}</th>
                                                    @endforeach
                                                    <th>Customer Balance (max: {{$orderReturn->order->customer->balance}})</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($paymentMethods as $method)
                                                        <td class="payment-method" data-method="{{ $method->id }}">0</td>
                                                    @endforeach
                                                    <td class="payment-method" data-method="customerBalance">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm mainTable">
                                            <thead>
                                                <tr>
                                                    <th>Total Paid</th>
                                                    <th>Rest</th>
                                                    <th>Next Due Date</th>
                                                    <th colspan="2">Paid with foreign currency</th>
                                                    <th>Discount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th id="paid">0</th>
                                                    <th id="rest">0</th>
                                                    <td id="next_due_date">YYYY-MM-DD</td>
                                                    <th>
                                                        <select id="currency_id">
                                                            @foreach ($currencies as $currency)
                                                                <option data-rate="{{round($currency->exchange_rate)}}" value="{{$currency->id}}">{{$currency->name}} - {{$currency->code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                    <td id="foreign_currency_paid">0</td>
                                                    <td id="discount">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ ceil($orderReturn->total) }} {{ mainCurrency()->code }}</div>
                                    </div>
                                    {{-- <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">VAT (14%)</div>
                                        <div class="invoice-detail-value">{{ 0.14 * $order->total }} {{ mainCurrency()->code }}
                                        </div>
                                    </div> --}}
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ ceil($orderReturn->total) }}
                                            {{ mainCurrency()->code }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">
                        <button id="process-payment-btn" class="btn btn-primary btn-icon icon-left"><i
                                class="fas fa-credit-card"></i> Process
                            Payment</button>
                        <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                    <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>
@endisset
@endsection


@push('pageScripts')
    <script src="{{ asset('assets/bundles/editable-table/mindmup-editabletable.js') }}"></script>
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        'use strict';
        $(function() {
            let totalPaid = 0;
            let foreign_paid = 0;
            let next_due_date = '';
            function reCalculateTotal(total, paid_with_local_currency = foreign_paid)
            {
                totalPaid = 0;

                $("td.payment-method").each((index, element) => {
                    totalPaid += parseFloat($(element).text())
                });

                totalPaid+= paid_with_local_currency;

                $("th#rest").html(Math.ceil(total - totalPaid) + " {{ mainCurrency()->code }}");
                $("th#paid").html(totalPaid + " {{ mainCurrency()->code }}");
            }

            $('.mainTable').editableTableWidget();
            const payment = {};
            const total = {{ isset($order) ? $order->total : $orderReturn->total }};
            $('table td').on('validate', function(evt, newValue) {
                if(evt.target.id != "next_due_date")
                {
                    // if ((parseFloat(newValue) + totalPaid) > total) { 
                    //     return false; // mark cell as invalid 
                    // }
                }
                else
                {
                    if (totalPaid >= total) { 
                        return false; // mark cell as invalid 
                    }
                }
            });
            $('table td').on('change', function(evt, newValue) {
                if (evt.target.dataset['method']) 
                {
                    payment[`payment:${evt.target.dataset['method']}`] = newValue;
                    reCalculateTotal(total);
                } 
                else if (evt.target.id == 'next_due_date')
                {
                    next_due_date = newValue;
                }
                else if(evt.target.id = "foreign_currency_paid")
                {
                    const rate = $("select#currency_id").find(":selected").data("rate");
                    let paid_with_local_currency = newValue * rate;
                    foreign_paid = paid_with_local_currency;
                    reCalculateTotal(total, paid_with_local_currency);
                }

                if(total == totalPaid) $("#next_due_date").html("-")
                console.log(payment);
            });

            $("button#process-payment-btn").on("click", function(event){
                $(this).attr("disabled",true);
                axios.post("{{route('invoices.store')}}",{
                    type:"order",
                    id:{{request()->query('order') ?? request()->query('orderReturn')}},
                    paid_amount:totalPaid,
                    next_due_date:next_due_date,
                    payment,
                    foreign_paid: foreign_paid > 0 ? foreign_paid : null ,
                    currency_id:$("select#currency_id").find(":selected").val(),
                    user_id:$("select#select-user").find(":selected").val()
                })
                .then(res => {
                    console.log(res);
                    if(res.data.success === true)
                        
                        alert('Done');
                })
                .catch(err => {
                    console.log(err);
                    iziToast.warning({
                        title: 'Warning!',
                        message: err.response.data.message,
                        position: 'topRight'
                    });
                })
                .finally(() => {
                    $(this).removeAttr("disabled");
                })
            });
        });
    </script>
@endpush
