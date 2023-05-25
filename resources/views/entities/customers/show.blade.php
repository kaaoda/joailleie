@extends('layouts.main')

@section('pageTitle', 'Customer: ' . $customer->full_name)

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('mainContent')
    @include('components.alerts.success')
    @include('components.alerts.warning')
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <div class="author-box-name">
                                    <a href="#">{{ $customer->full_name }}</a>
                                </div>
                                <div class="author-box-job">{{ $customer->nationality }}</div>
                            </div>
                            <div class="text-center">
                                <div class="author-box-description">
                                    <p>{{ $customer->notices ?? 'No notices about him' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Personal Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Full Name
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $customer->full_name }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Phone
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $customer->phone_number }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Mail
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $customer->email ?? 'No Email' }}
                                    </span>
                                </p>
                                {{-- <p class="clearfix">
                                    <span class="float-left">
                                        Balance
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $customer->balance }} {{ mainCurrency()->code }}
                                    </span>
                                </p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Financials</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Orders</div>
                                    </div>
                                    <div class="media-progressbar">
                                        <strong>{{ $customer->orders_count }}</strong>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Debts</div>
                                    </div>
                                    <div class="media-progressbar">
                                        <strong
                                            class="@if ($debts - $customer->balance > 0) text-danger @else text-success @endif">{{ abs($debts - $customer->balance) }}
                                            {{ mainCurrency()->code }} (@if ($debts - $customer->balance > 0) Debit @else Credit @endif)</strong>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Next Due Date</div>
                                    </div>
                                    <div class="media-progressbar">
                                        <strong>{{ $nearestDueDate }}</strong>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Total Orders Weight</div>
                                    </div>
                                    <div class="media-progressbar">
                                        <strong class="float-right">{{ $totalWeight }}g</strong>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Total Spend</div>
                                    </div>
                                    <div class="media-progressbar">
                                        <strong class="float-right">{{$totalSpend}}</strong>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about"
                                        role="tab" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                        aria-selected="false">Setting</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#balance" role="tab"
                                        aria-selected="false">Account</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="section-title">Orders</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Order</th>
                                                    <th>Total</th>
                                                    <th>Due Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->orders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><a
                                                                href="{{ route('orders.show', ['order' => $order->id]) }}">{{ $order->order_number }}</a>
                                                        </td>
                                                        <td>{{ $order->total }}</td>
                                                        <td>{{ $order->date }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="section-title">Follow-up payment</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-2">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Invoice</th>
                                                    <th>Amount</th>
                                                    <th>Due Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->orders as $order)
                                                    @if ($order->invoice)
                                                        @foreach ($order->invoice->dues as $due)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td><a
                                                                        href="{{ route('invoices.show', ['invoice' => $order->invoice->id]) }}">{{ $order->invoice->invoice_number }}</a>
                                                                </td>
                                                                <td>{{ $due->paid_amount }}</td>
                                                                <td>{{ $due->paid_at }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                                    <form method="post" class="needs-validation" action="{{ route('dues.store') }}">
                                        @csrf
                                        <input type="hidden" name="dueable_type"
                                            value="{{ App\Models\Invoice::class }}">
                                        <div class="card-header">
                                            <h4>Add Payment</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-12">
                                                    <label>Invoice</label>
                                                    <select name="dueable_id" class="form-control">
                                                        @forelse ($customer->orders->whereNotNull('invoice')->where("invoice.completed", "=", FALSE) as $order)
                                                            <option value="{{ $order->invoice->id }}">
                                                                {{ $order->invoice->invoice_number }}</option>
                                                        @empty
                                                            <option value="NULL">No active invoices</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 col-12">
                                                    <label>Amount</label>
                                                    <input type="number" min="1" class="form-control"
                                                        name="paid_amount" required />
                                                </div>
                                                <div class="form-group col-md-4 col-12">
                                                    <label>Date</label>
                                                    <input type="date" class="form-control" name="paid_at" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Add</button>
                                        </div>
                                    </form>

                                    <form method="post"
                                        action="{{ route('customers.update', ['customer' => $customer->id]) }}"
                                        class="needs-validation">
                                        @csrf
                                        @method('PUT')
                                        <div class="card-header">
                                            <h4>Notices</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Notices</label>
                                                    <textarea name="notices" required class="form-control">{{ $customer->notices }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="balance" role="tabpanel"
                                    aria-labelledby="profile-tab3">
                                    <form method="post" class="needs-validation" action="{{ route('dues.store') }}">
                                        @csrf
                                        <input type="hidden" name="dueable_type"
                                            value="{{ App\Models\Customer::class }}" />
                                        <input type="hidden" name="dueable_id" value="{{ $customer->id }}" />
                                        <div class="card-header">
                                            <h4>Charge / Withdraw</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-12">
                                                    <label>Amount (+/-)</label>
                                                    <input type="number" class="form-control" name="paid_amount" required />
                                                </div>
                                                <div class="form-group col-md-4 col-12">
                                                    <label>Notices</label>
                                                    <input type="text" class="form-control" name="notices" />
                                                </div>
                                                <div class="form-group col-md-4 col-12">
                                                    <label>Date</label>
                                                    <input type="date" class="form-control" name="paid_at" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                    {{-- <div class="table-responsive">
                                        <table class="table table-striped" id="table-2">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Amount</th>
                                                    <th>Notices</th>
                                                    <th>Due Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->dues as $due)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $due->paid_amount }}</td>
                                                        <td>{{ $due->notices }}</td>
                                                        <td>{{ $due->paid_at }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> --}}
                                    <hr />
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="tableExport"
                                            style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Desc.</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->orders as $order)
                                                    <tr>
                                                        <td>{{$order->date}}</td>
                                                        <td>Order #{{$order->order_number}} with {{$order->products()->sum('weight')}}g products</td>
                                                        <td>{{$order->invoice ? number_format($order->total - $order->invoice->paid_amount) : 'N/A'}}</td>
                                                        <td>{{$order->invoice ? number_format($order->invoice->paid_amount) : 'N/A'}}</td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($customer->dues as $due)
                                                    <tr>
                                                        <td>{{ $due->paid_at }}</td>
                                                        <td>{{ $due->notices }}</td>
                                                        @if ($due->paid_amount > 0)
                                                            <td>0</td>
                                                            <td>{{ $due->paid_amount }}</td>
                                                        @else
                                                            <td>{{ $due->paid_amount }}</td>
                                                            <td>0</td>
                                                        @endif
                                                        
                                                    </tr>
                                                @endforeach
                                                @foreach ($invoiceDues as $due)
                                                    <tr>
                                                        <td>{{ $due->paid_at }}</td>
                                                        <td>{{ $due->notices }}</td>
                                                        @if ($due->paid_amount > 0)
                                                            <td>0</td>
                                                            <td>{{ $due->paid_amount }}</td>
                                                        @else
                                                            <td>{{ $due->paid_amount }}</td>
                                                            <td>0</td>
                                                        @endif
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/export-tables/buttons.print.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
@endpush
