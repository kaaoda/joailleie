@extends('layouts.main')

@section('pageTitle', 'Customers')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include("components.alerts.success")
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Customers</h4>
                            <a href="{{route('customers.create')}}" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Add Customer</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Full Name</th>
                                            <th>Nationality</th>
                                            <th>Create Date</th>
                                            <th>Completed Orders</th>
                                            <th>Rank</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $customer)
                                            <tr>
                                                <td>
                                                    {{$loop->iteration}}
                                                </td>
                                                <td>{{$customer->full_name}}</td>
                                                <td>{{$customer->nationality}}</td>
                                                <td>{{$customer->created_at}}</td>
                                                <td>{{$customer->orders_count}}</td>
                                                <td>
                                                    @switch($customer->rank)
                                                        @case("Low")
                                                            <div class="badge badge-danger badge-shadow">Low</div>
                                                            @break
                                                        @case("Average")
                                                            <div class="badge badge-warning badge-shadow">Average</div>
                                                            @break
                                                        @case("High")
                                                            <div class="badge badge-success badge-shadow">High</div>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td><a href="{{route('customers.show', ['customer' => $customer->id])}}" class="btn btn-info">Detail</a></td>
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
    </section>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
@endpush
