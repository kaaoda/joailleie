@extends('layouts.main')

@section('pageTitle', 'Suppliers')

@push('cssPageDependencies')
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="col-12">
                            <div class="alert alert-warning alert-has-icon">
                                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Warning</div>
                                    <ul>
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <div class="author-box-name">
                                    <a href="#">{{ $supplier->name }}</a>
                                </div>
                                <div class="author-box-job">Supplier</div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Supplier Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Contact Name
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $supplier->contact_name }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Phone
                                    </span>
                                    <span class="float-right text-muted">
                                        ({{ $supplier->phone_prefix }}){{ $supplier->phone_number }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Transactions
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $supplier->transactions_count }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Total Transactions Ore
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $supplier->transactions_sum_ore_weight_in_grams ?? 0 }}g
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Balance
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ number_format($supplier->balance) }} EGP
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <form action="{{ route('supplier_transactions.store') }}" method="POST">
                            @csrf
                            <input hidden name="supplier_id" value="{{ $supplier->id }}" />
                            <div class="card-header">
                                <h4>Create Transaction</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="selectgroup w-100">
                                        @foreach ($divisions as $division)
                                            <label class="selectgroup-item">
                                                <input type="radio" name="product_division_id"
                                                    value="{{ $division->id }}" class="selectgroup-input-radio"
                                                    checked="">
                                                <span class="selectgroup-button">{{ $division->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Grams / Carat points</label>
                                    <input type="number" min="0.01" step="0.01" class="form-control"
                                        name="ore_weight_in_grams" />
                                </div>
                                <div class="form-group">
                                    <label>Cost per gram/carat points</label>
                                    <input type="number" min="0.01" step="0.01" class="form-control"
                                        name="cost_per_gram" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Cost Type</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cost_type" value="GOLD"
                                                class="selectgroup-input-radio" checked="">
                                            <span class="selectgroup-button">Gold</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cost_type" value="MONEY"
                                                class="selectgroup-input-radio">
                                            <span class="selectgroup-button">Cash</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Paid Amount</label>
                                    <input type="number" min="0.01" step="0.01" class="form-control"
                                        name="paid_amount" />
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" class="form-control" name="date" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Transaction type</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="transaction_scope" value="ORE"
                                                class="selectgroup-input-radio" checked="">
                                            <span class="selectgroup-button">Ore</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="transaction_scope" value="PRODUCTS"
                                                class="selectgroup-input-radio">
                                            <span class="selectgroup-button">Products</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Products number</label>
                                    <input type="number" min="1" class="form-control" name="products_number" />
                                </div>
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select name="currency_id" class="form-control">
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->name }} -
                                                {{ $currency->code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit">Create</button>
                                <button class="btn btn-secondary" type="reset">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card profile-widget mt-0">
                        <div class="profile-widget-header mb-0">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Gold In</div>
                                    <div class="profile-widget-item-value">{{$goldIn}}g</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Gold Out</div>
                                    <div class="profile-widget-item-value">{{$goldOut}}g</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Rest</div>
                                    <div class="profile-widget-item-value">{{$goldIn - $goldOut}}g</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about"
                                        role="tab" aria-selected="true">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings"
                                        role="tab" aria-selected="false">Settings</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="section-title">Transactions</div>
                                    <div class="row">
                                        <div class="col-12">
                                            <ul
                                                class="list-unstyled user-details list-unstyled-border list-unstyled-noborder">
                                                @forelse ($transactions as $transaction)
                                                    <li class="media">
                                                        <div class="media-body">
                                                            <div class="media-title">{{ $transaction->date }}</div>
                                                            <div class="text-job text-muted">
                                                                {{ $transaction->transaction_scope }}:
                                                                {{ $transaction->division->name }}</div>
                                                        </div>
                                                        <div class="media-items">
                                                            <div class="media-item">
                                                                <div class="media-value">
                                                                    {{ number_format($transaction->cost_per_gram) }}
                                                                </div>
                                                                <div class="media-label">Cost</div>
                                                            </div>
                                                            <div class="media-item">
                                                                <div class="media-value">
                                                                    {{ number_format($transaction->ore_weight_in_grams) }}
                                                                </div>
                                                                <div class="media-label">Grams</div>
                                                            </div>
                                                            <div class="media-item">
                                                                <div class="media-value">
                                                                    <button class="btn btn-primary" type="button"
                                                                        data-toggle="collapse"
                                                                        data-target="#transactionDetails-{{ $transaction->id }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        Details
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="media">
                                                        <div class="media-body">
                                                            <div class="collapse"
                                                                id="transactionDetails-{{ $transaction->id }}">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        class="table table-bordered table-sm text-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Currency</th>
                                                                                <th>Paid Amount</th>
                                                                                <th>Products Number</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <th>{{ $transaction->currency->code }}</th>
                                                                                <td>{{ number_format($transaction->paid_amount) }}
                                                                                </td>
                                                                                <td>{{ $transaction->products_number }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </li>
                                                @empty
                                                    <li class="media">Nothing</li>
                                                @endforelse
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel"
                                    aria-labelledby="profile-tab2">
                                    <form method="post" class="needs-validation" action="{{ route('dues.store') }}">
                                        @csrf
                                        <input type="hidden" name="dueable_type"
                                            value="{{ App\Models\Supplier::class }}">
                                        <input type="hidden" name="dueable_id" value="{{ $supplier->id }}">
                                        <div class="card-header">
                                            <h4>Add Payment</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-12">
                                                    <label>Amount</label>
                                                    <input type="number" min="1" class="form-control"
                                                        name="paid_amount" required />
                                                </div>
                                                <div class="form-group col-md-4 col-12">
                                                    <label>Date</label>
                                                    <input type="date" class="form-control" name="paid_at" required />
                                                </div>
                                                <div class="form-group">
                                                    <label>Notices</label>
                                                    <textarea class="form-control" name="notices"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                    <div class="section-title">Follow-up payment</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-2">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Amount</th>
                                                    <th>Due Date</th>
                                                    <th>Notices</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($supplier->dues as $due)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ number_format($due->paid_amount) }}</td>
                                                        <td>{{ $due->paid_at }}</td>
                                                        <td>{{ $due->notices }}</td>
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

    <!-- Page Specific JS File -->
@endpush
