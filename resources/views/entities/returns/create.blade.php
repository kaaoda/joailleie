@extends('layouts.main')

@section('pageTitle', 'Create Return')

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
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('returns.store') }}" method="POST">
                            <input type="hidden" name="order_id" value="{{request()->query('order')}}" />
                            @csrf
                            <div class="card-header">
                                <h4>Create Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="control-label">Toggle switches</div>
                                            <div class="custom-switches mt-2">
                                                <label class="custom-switch">
                                                    <input type="radio" name="type" value="RETURN"
                                                        class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Refund</span>
                                                </label>
                                                <label class="custom-switch">
                                                    <input type="radio" name="type" value="EXCHANGE"
                                                        class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Replace</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Gold Price Now (for diamond products set to 0)</label>
                                            <input type="number" class="form-control mb-2 mr-sm-2" min="0"
                                                step="0.001" name="goldPrice" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Order Products (select survived products only)</h4>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <th></th>
                                                            <th>Barcode</th>
                                                            <th>Weight</th>
                                                        </tr>
                                                        @foreach ($order->products as $product)
                                                            <tr>
                                                                <td class="p-0 text-center">
                                                                    <div class="custom-checkbox custom-control">
                                                                        <input type="checkbox" data-checkboxes="mygroup"
                                                                            name="products[]" class="custom-control-input"
                                                                            value="{{ $product->id }}"
                                                                            id="checkbox-{{ $product->id }}">
                                                                        <label for="checkbox-{{ $product->id }}"
                                                                            class="custom-control-label">&nbsp;</label>
                                                                    </div>
                                                                </td>
                                                                <td class="product-barcode">{{ $product->barcode }}</td>
                                                                <td>{{ $product->weight }}g</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
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
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/dynamic-form.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
    <script>
        //dynamic form
        const dynamic_form = $("#dynamic_form").dynamicForm("#dynamic_form", ".addService", ".removeService", {
            limit: 10,
            formPrefix: "additional_services",
            normalizeFullForm: false,
        });

        //products selection
        const resultsContainer = $("div#selected-products");
        const productsAdded = [];
        const orderProducts = $('td.product-barcode').map(function(i, e) {
            return e.innerText
        }).toArray()

        $("input#barcode-search").on("change", function(event) {
            if (!$(this).val()) return
            if (orderProducts.includes($(this).val())) {
                iziToast.info({
                    title: 'Dublicated!',
                    message: "Product already existed in original order!",
                    position: 'topRight'
                });
                return;
            }
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

                    } else {
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
