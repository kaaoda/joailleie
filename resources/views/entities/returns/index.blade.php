@extends('layouts.main')

@section('pageTitle', 'Returns & Exchanges')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}">
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Returns & Exchanges</h4>
                            {{-- <a href="{{ route('returns.create') }}" class="btn btn-lg btn-icon icon-left btn-warning"><i class="fa fa-plus"></i> Create Return</a> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Branch</th>
                                            <th>Type</th>
                                            <th>Created At</th>
                                            <th>Invoiced</th>
                                            <th>Action</th>
                                        </tr>
                                        @forelse ($list as $orderReturn)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$orderReturn->order->order_number}}</td>
                                                <td>{{$orderReturn->order->customer->full_name}}</td>
                                                <td>{{$orderReturn->order->branch->name}}</td>
                                                <td>{{$orderReturn->type}}</td>
                                                <td>{{$orderReturn->created_at}}</td>
                                                <td>
                                                    @if ($orderReturn->invoice)
                                                        <div class="badge badge-success"><i class="fas fa-check"></i></div>
                                                    @else
                                                        <div class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i></div>
                                                    @endif
                                                </td>
                                                <td><a href="{{route('returns.show', ['return' => $orderReturn->id])}}" class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="8">No returns yet!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            {{ $list->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
@endpush
