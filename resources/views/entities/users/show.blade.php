@extends('layouts.main')

@section('pageTitle', 'User: ' . $user->name)

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}" />
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
                                    <a href="#">{{$user->name}}</a>
                                </div>
                                <div class="author-box-job">{{ $user->role->name }}</div>
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
                                        Login Name
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $user->username }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Branch
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $user->branch->id }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Mail
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $user->email ?? 'No Email' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card">
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
                                        <strong>{{ $user->orders_count }}</strong>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Debts</div>
                                    </div>
                                    <div class="media-progressbar">
                                        <strong class="@if($debts > 0) text-danger @else text-success @endif">{{ $debts }} {{ mainCurrency()->code }}</strong>
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
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                        aria-selected="false">About</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="settings">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    {{-- <div class="section-title">Orders</div>
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
                                                @foreach ($user->orders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><a href="{{route('orders.show', ['order' => $order->id])}}">{{ $order->order_number }}</a></td>
                                                        <td>{{ $order->total }}</td>
                                                        <td>{{ $order->date }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> --}}
                                    
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
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
@endpush
