@extends('layouts.main')

@section('pageTitle', 'Show Invoice ' . $invoice->invoice_number)

@push('cssPageDependencies')
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col text-center"><strong>Invoice</strong></div>
                        <div class="col-12">
                            <div class="invoice-title">
                                <h2><img src="{{asset('assets/img/color.png')}}?a=0" width="100px" /></h2>
                                <div class="invoice-number">#{{ $invoice->invoice_number }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        {{ $invoice->invoicable->customer->full_name }}<br>
                                        {{ $invoice->invoicable->customer->phone_number }}<br>
                                        {{ $invoice->invoicable->customer->email }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <address>
                                        <strong>Employee:</strong><br>
                                        Mohamed Ameen
                                    </address>
                                </div>
                                <div class="col-6 text-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        June 26, 2018<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
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
                                    @foreach ($invoice->invoicable->products as $product)
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
                                            <th>{{$invoice->invoicable->total}}</th>
                                            <th colspan="2">{{$invoice->invoicable->products->sum('weight')}}g</th>
                                            @if(count($diamonds))
                                                <th>{{$diamonds->sum('number_of_stones')}} diamond stone with {{$diamonds->sum('weight') / 100}}carat</th>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-8">
                                    <div class="section-title">Payments</div>
                                    @if($invoice->payments->count())
                                    <div class="table-responsive">
                                        <table class="table table-sm mainTable">
                                            <thead>
                                                <tr>
                                                    <th>Method</th>
                                                    <th>Amount</th>
                                                    <th>Exchange Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($invoice->payments as $payment)
                                                    <tr>
                                                        <th>{{ $payment->paymentMethod->name }}</th>
                                                        <td>{{ $payment->value }} {{$payment->currency->code}}</td>
                                                        @if($payment->rate) <td>{{ $payment->rate }} {{mainCurrency()->code}}</td> @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-sm mainTable">
                                            <thead>
                                                <tr>
                                                    <th>Total Paid</th>
                                                    <th>Rest</th>
                                                    <th>Next Due Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>{{$invoice->paid_amount}} {{mainCurrency()->code}}</th>
                                                    <th>{{($invoice->invoicable->total - $invoice->paid_amount) > 0 ? $invoice->invoicable->total - $invoice->paid_amount . mainCurrency()->code : ""}}</th>
                                                    <th>{{$invoice->next_due_date}}</th>
                                                </tr>
                                                <tr>
                                                    <th>{{$formatter->format($invoice->paid_amount)}} جنيها مصرياً</th>
                                                    <th>{{($invoice->invoicable->total - $invoice->paid_amount) > 0 ? $formatter->format($invoice->invoicable->total - $invoice->paid_amount)." جنيها مصرياً " : ""}}</th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ $invoice->invoicable->total }} {{ mainCurrency()->code }}</div>
                                    </div>
                                    {{-- <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">VAT (14%)</div>
                                        <div class="invoice-detail-value">{{ 0.14 * $invoice->invoicable->total }} {{ mainCurrency()->code }}
                                        </div>
                                    </div> --}}
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ ceil($invoice->invoicable->total) }}
                                            {{ mainCurrency()->code }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right d-print-none">
                    <button id="print" class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('pageScripts')
<script>
    $( "#print" ).click(function() {
        window.print()
    });
</script>
@endpush
