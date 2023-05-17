@extends('layouts.main')

@section('pageTitle', 'Create Order')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}" />
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.wrong')
                @if ($errors->any())
                    <div class="col-12">
                        <div class="alert alert-warning alert-has-icon">
                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                        <div class="alert-body">
                            <div class="alert-title">Warning</div>
                            <ul>
                                @foreach ($errors->all() as $err)
                                    <li>{{$err}}</li>
                                @endforeach
                            </ul>
                        </div>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <div class="card-header">
                                <h4>Create Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <select id="select-customer" class="@error('customer_id') is-invalid @enderror"
                                                name="customer_id">
                                                <option selected value="">Select customer name</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Branch</label>
                                            <select id="select-branch" class="@error('branch_id') is-invalid @enderror"
                                                name="branch_id">
                                                <option selected value="">Select Branch name</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col mt-3">
                                        <div class="form-group">
                                            <label>Gold Price Now (for diamond products set to 0)</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0" step="0.001" name="goldPrice" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 justify-content-center">
                                    <div class="col-12">
                                        <div class="form-row justify-content-center">
                                            <div class="form-group col-md-6">
                                                <input type="search" class="form-control" placeholder="Search by barcode"
                                                    id="barcode-search" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="selected-products">
                                    </div>
                                </div>
                                <hr />
                                <h6>Additional Services / Costs</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-inline" id="dynamic_form">
                                            <input type="text" class="form-control mb-2 mr-sm-2" id="servicesDesc" name="servicesDesc"
                                                placeholder="Description" />
                                            <input type="number" min="0" class="form-control mb-2 mr-sm-2" id="servicesCost" name="servicesCost"
                                                placeholder="Price" />
                                            <div class="btn-group mb-2" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-icon btn-danger removeService"><i
                                                        class="fas fa-times"></i></button>
                                                <button type="button" class="btn btn-icon btn-primary addService"><i
                                                        class="fas fa-plus"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                        class="fas fa-plus"></i>Create</button>
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
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select2.js') }}"></script>
    <script src="{{ asset('assets/js/dynamic-form.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
    <script>
        //init nice select 
        NiceSelect.bind(document.getElementById("select-customer"), {
            searchable: true
        });
        NiceSelect.bind(document.getElementById("select-branch"), {
            searchable: true
        });

        //dynamic form
        const dynamic_form = $("#dynamic_form").dynamicForm("#dynamic_form", ".addService", ".removeService", {
            limit: 10,
            formPrefix: "additional_services",
            normalizeFullForm: false,
        });

        //products selection
        const resultsContainer = $("div#selected-products");
        const productsAdded = [];

        $("input#barcode-search").on("change", function(event) {
            if (!$(this).val()) return
            axios.post("{{ route('products.searchByBarcodeWithAjax') }}", {
                    barcode: $(this).val()
                })
                .then(res => {
                    console.log(res)
                    const product = res.data;
                        if (!productsAdded.includes(product.id)) {
                            const li =
                                `<div class="form-row" id="${product.id}">
                                    <input type="number" hidden value="${product.id}" name="products[]" />
                                <div class="form-group col-md-4">
                                    <label for="productName-${product.id}">Product</label>
                                    <input type="text" class="form-control" id="productName-${product.id}" readonly value="${product.barcode}" />
                                    <small id="passwordHelpBlock" class="form-text text-muted">Weight is ${product.weight}g / ${product.kerat}k</small>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="productPrice-${product.id}">${product.category.division.name == "GOLD" ? 'Sale manufacturing value' : 'Sale Price'}</label>
                                    <input type="text" class="form-control" name="prices[${product.id}]" id="productPrice-${product.id}" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="discount-${product.id}">Discount</label>
                                    <input type="text" class="form-control" name="discounts[${product.id}]" id="discount-${product.id}" />
                                </div>
                            </div>`;
                            resultsContainer.append(li);
                            productsAdded.push(product.id);
                            
                        }
                        else
                        {
                           iziToast.info({
                                title: 'Existed!',
                                message: "Product already added!",
                                position: 'topRight'
                            }); 
                        }


                    $(this).val(null)
                })
                .catch(function(err) {
                    iziToast.error({
                        title: 'Not Found!',
                        message: "This barcode doesn't match with any product",
                        position: 'topRight'
                    });
                })
        });
    </script>
@endpush
