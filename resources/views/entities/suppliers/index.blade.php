@extends('layouts.main')

@section('pageTitle', 'Suppliers')

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
                            <h4>Suppliers</h4>
                            <a href="{{route('suppliers.create')}}" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Add Supplier</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Business Name</th>
                                            <th>Contact Name</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $supplier)
                                            <tr>
                                                <td>
                                                    {{$loop->iteration}}
                                                </td>
                                                <td>{{$supplier->name}}</td>
                                                <td>{{$supplier->contact_name}}</td>
                                                <td>{{$supplier->phone_number}}</td>
                                                <td>
                                                    <button onclick="deleteModel('{{route('suppliers.destroy', ['supplier' => $supplier->id])}}', $(this).parent('td').parent('tr'))" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                    <a href="{{route('suppliers.edit', ['supplier' => $supplier->id])}}" class="btn btn-icon btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="{{route('suppliers.show', ['supplier' => $supplier->id])}}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a>
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
