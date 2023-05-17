@extends('layouts.main')

@section('pageTitle', 'Create Bulk Gold Products')

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @if (session()->has('done'))
                    <div class="col-12">
                        <div class="alert alert-info alert-has-icon">
                            <div class="alert-icon"><i class="fas fa-info"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Products Added</div>
                                <ul>
                                    @forelse (session()->get('done') as $barcode)
                                        <li>{{$barcode}}</li>
                                    @empty
                                        <li>No Products Added</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if (session()->has('failed'))
                    <div class="col-12">
                        <div class="alert alert-dark alert-has-icon">
                            <div class="alert-icon"><i class="fas fa-heartbeat"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Products Failed</div>
                                <ul>
                                    @forelse (session()->get('failed') as $text)
                                        <li>{{$text}}</li>
                                    @empty
                                        <li>No Products Failed</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('bulk.storeGoldProducts') }}" method="POST">
                            @csrf
                            <div class="card-header">
                                <h4>Create Bulk Gold Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-inline" id="dynamic_form">
                                            <input type="text" class="form-control mb-2 mr-sm-2" id="weight" name="weight" placeholder="Weight" />
                                            <input type="text" class="form-control mb-2 mr-sm-2" name="cost" id="cost" placeholder="Manufacturing Value" />
                                            <input type="number" min="0" class="form-control mb-2 mr-sm-2" name="sales" id="sales" placeholder="Sale Value" />
                                            <select id="supplier_id" class="form-control" name="supplier_id">
                                                <option selected value="">Select supplier name</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control selectric" id="category_id" name="category_id">
                                                <option selected value="">Choose one...</option>
                                                @foreach ($categories as $division => $subcategories)
                                                    <optgroup label="{{ $division }}">
                                                        @foreach ($subcategories as $category)
                                                            <option data-division="{{ $division }}"
                                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                            <div class="btn-group mb-2" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-icon btn-danger removeService"><i class="fas fa-times"></i></button>
                                                <button type="button" class="btn btn-icon btn-primary addService"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                        class="fas fa-check"></i>Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/js/dynamic-form.js') }}"></script>
    <!-- Page Specific JS File -->
    <script>
        //dynamic form
        const dynamic_form = $("#dynamic_form").dynamicForm("#dynamic_form", ".addService", ".removeService", {
            limit: 100,
            formPrefix: "products",
            normalizeFullForm: false,
        });

    </script>
@endpush
