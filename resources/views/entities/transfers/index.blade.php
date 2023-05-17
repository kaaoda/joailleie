@extends('layouts.main')

@section('pageTitle', 'Transfers')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}">
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include("components.alerts.success")
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Transfers</h4>
                            <a href="{{route('transfers.create')}}" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Create Transfer</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Destination</th>
                                            <th>Products</th>
                                            <th>Status</th>
                                            <th>Issued at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transfers as $transfer)
                                            <tr>
                                                <td>
                                                    {{$loop->iteration}}
                                                </td>
                                                <td>{{$transfer->branch->name}}</td>
                                                <td>{{$transfer->products_count}}</td>
                                                <td>@if($transfer->approved) <span class="badge badge-success">Approved</span> @else <span class="badge badge-warning">Pending</span> @endif </td>
                                                <td>{{$transfer->created_at}}</td>
                                                <td>
                                                    <button onclick="deleteModel('{{route('transfers.destroy', ['transfer' => $transfer->id])}}', $(this).parent('td').parent('tr'))" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                    {{-- <a href="{{route("transfers.edit", ['transfer' => $transfer->id])}}" class="btn btn-icon btn-sm btn-primary"><i class="fas fa-edit"></i></a> --}}
                                                    <a href="{{route("transfers.show", ['transfer' => $transfer->id])}}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                                </td>
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
    <script src="{{asset('assets/bundles/izitoast/js/iziToast.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/deleteModel.js') }}"></script>
@endpush
