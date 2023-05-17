@extends('layouts.main')

@section('pageTitle', 'Joaillerie System')

@section('mainContent')
    <section class="section">
        <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                @include('components.homeCounterCard', [
                    'title' => 'New Customer',
                    'icon' => 'fas fa-briefcase',
                    'color' => 'l-bg-orange',
                    'counter' => $customers,
                ])
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                @include('components.homeCounterCard', [
                    'title' => 'New Orders',
                    'icon' => 'fas fa-phone',
                    'color' => 'l-bg-cyan',
                    'counter' => $orders,
                ])
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                @include('components.homeCounterCard', [
                    'title' => 'New Products',
                    'icon' => 'fas fa-book-open',
                    'color' => 'l-bg-green',
                    'counter' => $products,
                ])
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                @include('components.homeCounterCard', [
                    'title' => 'Returns',
                    'icon' => 'fas fa-redo',
                    'color' => 'l-bg-purple',
                    'counter' => $returns,
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-12 col-lg-6">
                <div class="card ">
                    <div class="card-header">
                        <h4>Revenue details (Gold)</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-7 col-xl-7 mb-3">Total orders</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">{{ number_format($orders->newNumber) }}</span>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Total Income</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">{{ number_format($monthFinancials->totalIncome) }} EGP</span>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Ore cost</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">{{ number_format($monthFinancials->oreCost) }} EGP</span>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Total expense</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">{{ number_format($monthFinancials->totalExpenses) }}
                                            EGP</span>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Total Customers Balance</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">{{ number_format($monthFinancials->customerBalances) }}
                                            EGP</span>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Net profit</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span
                                            class="text-big">{{ number_format($monthFinancials->totalIncome - ($monthFinancials->totalExpenses + $monthFinancials->oreCost)) }}
                                            EGP</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-12 col-lg-6">
                <div class="card ">
                    <div class="card-header">
                        <h4>Revenue details (Diamond)</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-7 col-xl-7 mb-3">Total orders</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">{{ number_format($orders->newNumber) }}</span>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Total Income</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">{{ number_format($diamondMonthlyEarning->totalIncome) }}
                                            EGP</span>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Products cost</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">{{ number_format($diamondMonthlyEarning->oreCost) }}
                                            EGP</span>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Net profit</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span
                                            class="text-big">{{ number_format($diamondMonthlyEarning->totalIncome - $diamondMonthlyEarning->oreCost) }}
                                            EGP</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-0">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="list-inline text-center">
                                    <div class="list-inline-item p-r-30">
                                        <h5 class="m-b-0"></h5>
                                        <p class="text-muted font-14 m-b-0">Today Income</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="list-inline text-center">
                                    <div class="list-inline-item p-r-30">
                                        <h5 class="m-b-0">{{ number_format(($monthFinancials->totalIncome - ($monthFinancials->totalExpenses + $monthFinancials->oreCost)) + ($diamondMonthlyEarning->totalIncome - $diamondMonthlyEarning->oreCost)) }}
                                            EGP</h5>
                                        <p class="text-muted font-14 m-b-0">Monthly Net Profit</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="list-inline text-center">
                                    <div class="list-inline-item p-r-30">
                                        <h5 class="mb-0 m-b-0">{{number_format($monthFinancials->totalIncome + $diamondMonthlyEarning->totalIncome)}} EGP</h5>
                                        <p class="text-muted font-14 m-b-0">Monthly Income</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Most and least selling Categories</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                    class="custom-control-input" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Product Name</th>
                                        <th>Sold Times</th>
                                        <th>Indicator</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($highProducts as $highProduct)
                                        <tr>
                                            <td class="p-0 text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-1">
                                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                <img alt="image"
                                                    src="{{ asset('storage/' . $highProduct->thumbnail_path) }}"
                                                    class="rounded-circle" width="35" data-toggle="title"
                                                    title="{{ $highProduct->name }}">
                                                {{ $highProduct->name }}
                                            </td>
                                            <td>{{ $highProduct->orders_count }}</td>
                                            <td>
                                                <div class="badge badge-success">High</div>
                                            </td>
                                            <td><a href="{{ route('products.show', ['product' => $highProduct->id]) }}"
                                                    class="btn btn-outline-primary">Detail</a></td>
                                        </tr>
                                    @endforeach
                                    @foreach ($lowProducts as $lowProduct)
                                        <tr>
                                            <td class="p-0 text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-1">
                                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                <img alt="image"
                                                    src="{{ asset('storage/' . $lowProduct->thumbnail_path) }}"
                                                    class="rounded-circle" width="35" data-toggle="title"
                                                    title="{{ $lowProduct->name }}">
                                                {{ $lowProduct->name }}
                                            </td>
                                            <td>{{ $lowProduct->orders_count }}</td>
                                            <td>
                                                <div class="badge badge-danger">Low</div>
                                            </td>
                                            <td><a href="{{ route('products.show', ['product' => $lowProduct->id]) }}"
                                                    class="btn btn-outline-primary">Detail</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-6 col-lg-12 col-xl-6">
                <!-- Support tickets -->
                <div class="card">
                    <div class="card-header">
                        <h4>Active Maintenance Requests</h4>
                    </div>
                    <div class="card-body">
                        <div class="support-ticket media pb-1 mb-3">
                            <img src="assets/img/users/user-1.png" class="user-img mr-2" alt="">
                            <div class="media-body ml-3">
                                <div class="badge badge-pill badge-success mb-1 float-right">Feature</div>
                                <span class="font-weight-bold">#89754</span>
                                <a href="javascript:void(0)">Please add advance table</a>
                                <p class="my-1">Hi, can you please add new table for advan...</p>
                                <small class="text-muted">Created by <span class="font-weight-bold font-13">John
                                        Deo</span>
                                    &nbsp;&nbsp; - 1 day ago</small>
                            </div>
                        </div>
                        <div class="support-ticket media pb-1 mb-3">
                            <img src="assets/img/users/user-2.png" class="user-img mr-2" alt="">
                            <div class="media-body ml-3">
                                <div class="badge badge-pill badge-warning mb-1 float-right">Bug</div>
                                <span class="font-weight-bold">#57854</span>
                                <a href="javascript:void(0)">Select item not working</a>
                                <p class="my-1">please check select item in advance form not work...</p>
                                <small class="text-muted">Created by <span class="font-weight-bold font-13">Sarah
                                        Smith</span>
                                    &nbsp;&nbsp; - 2 day ago</small>
                            </div>
                        </div>
                        <div class="support-ticket media pb-1 mb-3">
                            <img src="assets/img/users/user-3.png" class="user-img mr-2" alt="">
                            <div class="media-body ml-3">
                                <div class="badge badge-pill badge-primary mb-1 float-right">Query</div>
                                <span class="font-weight-bold">#85784</span>
                                <a href="javascript:void(0)">Are you provide template in Angular?</a>
                                <p class="my-1">can you provide template in latest angular 8.</p>
                                <small class="text-muted">Created by <span class="font-weight-bold font-13">Ashton
                                        Cox</span>
                                    &nbsp;&nbsp; -2 day ago</small>
                            </div>
                        </div>
                        <div class="support-ticket media pb-1 mb-3">
                            <img src="assets/img/users/user-6.png" class="user-img mr-2" alt="">
                            <div class="media-body ml-3">
                                <div class="badge badge-pill badge-info mb-1 float-right">Enhancement</div>
                                <span class="font-weight-bold">#25874</span>
                                <a href="javascript:void(0)">About template page load speed</a>
                                <p class="my-1">Hi, John, can you work on increase page speed of
                                    template...</p>
                                <small class="text-muted">Created by <span class="font-weight-bold font-13">Hasan
                                        Basri</span>
                                    &nbsp;&nbsp; -3 day ago</small>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="card-footer card-link text-center small ">View
                        All</a>
                </div>
                <!-- Support tickets -->
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daily Payments</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dailyPaymentsDivisions as $paymentDivision => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $paymentDivision }}</td>
                                            <td>{{ $value ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/index.js') }}"></script>
@endpush
