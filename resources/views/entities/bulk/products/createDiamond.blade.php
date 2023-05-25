@extends('layouts.main')

@section('pageTitle', 'Create Bulk Diamond Products')

@push('cssPageDependencies')
    <style>
        select {
            margin-top: -9px;
        }
    </style>
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.warning')
                @if (session()->has('done'))
                    <div class="col-12">
                        <div class="alert alert-info alert-has-icon">
                            <div class="alert-icon"><i class="fas fa-info"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Products Added</div>
                                <ul>
                                    @forelse (session()->get('done') as $barcode)
                                        <li>{{ $barcode }}</li>
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
                                        <li>{{ $text }}</li>
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
                        <div class="card-header">
                            <h4>Create Bulk Diamond Products</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form class="repeater" action="{{ route('bulk.storeDiamondProducts') }}" method="POST" target="_blank">
                                        @csrf
                                        <select class="form-control mb-3" name="currency_id">
                                            <option selected value="">Currency</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div data-repeater-list="outer-list">
                                            <div data-repeater-item>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <input type="text" class="form-control mb-2" name="weight"
                                                        placeholder="Gold Weight" />
                                                    <input type="text" class="form-control mb-2" name="cost"
                                                        placeholder="Cost Value" />
                                                    <input type="number" min="0" class="form-control mb-2"
                                                        name="sales" placeholder="Sale Value" />
                                                    <select id="supplier_id" class="form-control" name="supplier_id">
                                                        <option selected value="">Supplier</option>
                                                        @foreach ($suppliers as $supplier)
                                                            <option value="{{ $supplier->id }}">
                                                                {{ $supplier->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select id="branch_id" class="form-control" name="branch_id">
                                                        <option selected value="">Branch</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->id }}">{{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <select class="form-control selectric" id="category_id"
                                                        name="category_id">
                                                        <option selected value="">Category</option>
                                                        @foreach ($categories as $division => $subcategories)
                                                            <optgroup label="{{ $division }}">
                                                                @foreach ($subcategories as $category)
                                                                    <option data-division="{{ $division }}"
                                                                        value="{{ $category->id }}">
                                                                        {{ $category->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>

                                                    <button type="button" class="btn btn-icon btn-sm btn-danger"
                                                        data-repeater-delete><i class="fas fa-times"></i></button>
                                                </div>
                                                <!-- innner repeater -->
                                                <div class="inner-repeater">
                                                    <div data-repeater-list="inner-list">
                                                        <div data-repeater-item
                                                            class="d-flex justify-content-center align-items-center px-5">
                                                            <input type="text" class="form-control mb-2" name="number_of_stones" placeholder="Number of stones" />
                                                            <input type="number" step="0.001" min="1" class="form-control mb-2" name="weight" step="0.001" placeholder="Weight in sm" />
                                                            <input type="text" min="0" class="form-control mb-2" name="color" placeholder="Color" />
                                                            <input list="clarityList" type="text" min="0" class="form-control mb-2" name="clarity" placeholder="Clarity" />
                                                            <datalist id="clarityList">
                                                                <option value="VVS1" />
                                                            </datalist>
                                                            <input list="shapesList" type="text" min="0"
                                                                class="form-control mb-2" name="shape"
                                                                id="diamondShape" placeholder="Shape" />
                                                            <datalist id="shapesList">
                                                                <option value="Oval" />
                                                            </datalist>
                                                            <input type="number" step="0.001" min="1"
                                                                class="form-control mb-2" name="price" step="0.001"
                                                                id="price" placeholder="Price" />
                                                            <button type="button" class="btn btn-icon btn-sm btn-warning"
                                                                data-repeater-delete><i class="fas fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-icon btn-sm btn-primary mx-5"
                                                        data-repeater-create><i class="fas fa-gem"></i></button>
                                                </div>
                                                <hr class="my-5" />
                                            </div>
                                            
                                        </div>
                                        <button type="button" class="btn btn-icon btn-sm btn-success"
                                            data-repeater-create><i class="fas fa-plus"></i></button>
                                        <button type="submit" class="btn btn-icon btn-sm btn-dark float-right" ><i class="fas fa-check"></i>save</button>
                                    </form>
                                    {{-- <form id="additionForm" action="{{ route('bulk.storeDiamondProducts') }}" method="POST"
                                        target="_blank">
                                        @csrf --}}
                                </div>
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
    <script src="{{ asset('assets/js/jquery.repeater.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $(".repeater").repeater({
                // (Required if there is a nested repeater)
                // Specify the configuration of the nested repeaters.
                // Nested configuration follows the same format as the base configuration,
                // supporting options "defaultValues", "show", "hide", etc.
                // Nested repeaters additionally require a "selector" field.
                repeaters: [{
                    // (Required)
                    // Specify the jQuery selector for this nested repeater
                    selector: ".inner-repeater",
                }, ],
            });
        });
    </script>
@endpush
