@extends('layouts.main')

@section('pageTitle', 'Transfers')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}">
@endpush

@section('mainContent')
    @include('components.alerts.warning')
    @include('components.alerts.success')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Transfer Request <code>{{ $productTransferRequest->created_at }}</code></h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Barcode</th>
                                        <th scope="col">Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productTransferRequest->products as $product)
                                        <tr>
                                            <td>{{$product->barcode}}</td>
                                            <td>{{$product->name}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-whitesmoke">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Destination: {{ $productTransferRequest->branch->name }}</strong>
                                @if(!$productTransferRequest->approved)
                                <form action="{{route('transfers.update', ['transfer' => $productTransferRequest->id])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="approve" value="1" />
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                                @endif
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
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
@endpush
