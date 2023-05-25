@extends('layouts.main')

@section('pageTitle', 'Maintenance Requests')

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
                            <h4>Maintenance Requests</h4>
                            <a href="{{route('restorations.create')}}" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Add Request</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>Request Number</th>
                                            <th>Customer</th>
                                            <th>weight</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $restorationRequest)
                                            <tr>
                                                <td>{{$restorationRequest->request_number}}</td>
                                                <td>{{$restorationRequest->customer->full_name}}</td>
                                                <td>{{$restorationRequest->weight}}g</td>
                                                <td>
                                                    @if ($restorationRequest->status)
                                                        <span class="badge badge-success">Completed</span>
                                                    @else
                                                        <span class="badge badge-primary">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button onclick="deleteModel('{{route('restorations.destroy', ['restoration' => $restorationRequest->id])}}', $(this).parent('td').parent('tr'))" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                    <a href="{{route("restorations.edit", ['restoration' => $restorationRequest->id])}}" class="btn btn-icon btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="{{route("restorations.show", ['restoration' => $restorationRequest->id])}}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a>
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
    <script src="{{asset('assets/bundles/izitoast/js/iziToast.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/deleteModel.js') }}"></script>
@endpush
