@extends('layouts.main')

@section('pageTitle', 'Joaillerie System')

@section('mainContent')
    <section class="section">
        @can('isManager')
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
                                        <div class="col-7 col-xl-7 mb-3">Gold cost</div>
                                        <div class="col-5 col-xl-5 mb-3">
                                            <span class="text-big">{{ number_format($monthFinancials->oreCost) }} EGP</span>
                                        </div>
                                        <div class="col-7 col-xl-7 mb-3">Total Masna3ya</div>
                                        <div class="col-5 col-xl-5 mb-3">
                                            <span class="text-big">{{ number_format($monthFinancials->totalExpenses) }}
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
                                            <h5 class="m-b-0">
                                                {{ number_format($monthFinancials->totalIncome - ($monthFinancials->totalExpenses + $monthFinancials->oreCost) + ($diamondMonthlyEarning->totalIncome - $diamondMonthlyEarning->oreCost)) }}
                                                EGP</h5>
                                            <p class="text-muted font-14 m-b-0">Monthly Net Profit</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="list-inline text-center">
                                        <div class="list-inline-item p-r-30">
                                            <h5 class="mb-0 m-b-0">
                                                {{ number_format($monthFinancials->totalIncome + $diamondMonthlyEarning->totalIncome) }}
                                                EGP</h5>
                                            <p class="text-muted font-14 m-b-0">Monthly Income</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-bg">
                            <div class="py-3 d-flex justify-content-between">
                                <div class="col">
                                    <h6 class="mb-0">Gold In</h6>
                                    <span class="font-weight-bold mb-0 font-20">{{ $goldIn }}g</span>
                                </div>
                                <i class="fas fa-coins card-icon col-orange font-30 p-r-30"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-bg">
                            <div class="py-3 d-flex justify-content-between">
                                <div class="col">
                                    <h6 class="mb-0">Gold Out</h6>
                                    <span class="font-weight-bold mb-0 font-20">{{ $goldOut }}g</span>
                                </div>
                                <i class="fas fa-cart-arrow-down card-icon col-green font-30 p-r-30"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <!-- Support tickets -->
                    <div class="card">
                        <div class="card-header">
                            <h4>Active Maintenance Requests</h4>
                        </div>
                        <div class="card-body">
                            @forelse ($activeRestorationRequests as $restoration)
                                <div class="support-ticket media pb-1 mb-3">
                                    <img src="{{ asset('storage/' . $restoration->picture_path) }}" class="user-img mr-2"
                                        alt="">
                                    <div class="media-body ml-3">
                                        <button type="button" class="btn btn-primary mb-1 float-right">ِActive <span class="badge badge-transparent">{{ $restoration->transactions->count() }}</span></button>
                                        <span class="font-weight-bold">#{{ $restoration->request_number }}</span>
                                        <a href="{{route('restorations.show', ['restoration' => $restoration->id])}}">{!! $restoration->notices !!}</a>
                                        @if ($restoration->lastTransaction)
                                            <p class="my-1">{{ $restoration->lastTransaction->description }}</p>
                                            <small class="text-muted">Action by <span
                                                    class="font-weight-bold font-13">{{ $restoration->lastTransaction->employee_name }}</span>
                                                &nbsp;&nbsp; - {{ $restoration->lastTransaction->happened_at }}</small>
                                        @endif
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>
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
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sales Section</h4>
                        </div>
                        <div class="card-body">
                            <strong>You can create orders, customers and browse them</strong>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </section>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/index.js') }}"></script>
@endpush
