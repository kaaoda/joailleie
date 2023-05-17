@extends('layouts.main')

@section('pageTitle', isset($product) ? 'Update Product' : 'Add new Product')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}" />
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
                        <div class="card-header">
                            <h4>Product</h4>
                        </div>
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-xs-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Supplier</label>
                                            <select id="select-supplier" class="@error('supplier_id') is-invalid @enderror"
                                                name="supplier_id">
                                                <option selected value="">Select supplier name</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
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
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control selectric" id="select-category" name="category_id">
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
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                                    <div class="col-sm-12 col-md-7">
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">Choose File</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gold Weight</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="number" step="0.001" class="form-control" name="goldWeight" />
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kerat</label>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="kerat" value="18"
                                                    class="selectgroup-input-radio" checked="">
                                                <span class="selectgroup-button">18k</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="kerat" value="21"
                                                    class="selectgroup-input-radio">
                                                <span class="selectgroup-button">21k</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="kerat" value="24"
                                                    class="selectgroup-input-radio">
                                                <span class="selectgroup-button">24k</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Barcode
                                        (C128)</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="barcode" />
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Purchase price / gram <span class="text-warning">(optional)</span></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="number" step="0.001" class="form-control" name="cost" />
                                    </div>
                                </div>
                                
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" id="manufacturingLabel">Manufacturing Value</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="number" step="0.001" class="form-control" name="manufacturing_value" />
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" id="LowestManufacturingLabel">Lowest manufacturing value for sale</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="number" step="0.001" class="form-control" name="lowest_manufacturing_value_for_sale" />
                                    </div>
                                </div>
                                
                                <section id="diamonds">
                                    <hr />
                                    <h6>Diamonds</h6>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Currency</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control" name="currency_id">
                                                <option selected value="">Choose one...</option>
                                                @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-inline" id="dynamic_form">
                                                <input type="text" class="form-control mb-2" name="number_of_stones"
                                                    id="number_of_stones" placeholder="Number of stones" />
                                                <input type="number" step="0.001" min="1" class="form-control mb-2"
                                                    name="weight" step="0.001" id="weight" placeholder="Weight" />
                                                <input type="text" min="0" class="form-control mb-2"
                                                    name="color" id="color" placeholder="Color" />
                                                <input list="clarityList" type="text" min="0"
                                                    class="form-control mb-2" name="diamondClarity" id="diamondClarity"
                                                    placeholder="Clarity" />
                                                <datalist id="clarityList">
                                                    <option value="VVS1" />
                                                </datalist>
                                                <input list="shapesList" type="text" min="0"
                                                    class="form-control mb-2" name="diamondShape" id="diamondShape"
                                                    placeholder="Shape" />
                                                <datalist id="shapesList">
                                                    <option value="Oval" />
                                                </datalist>
                                                <input type="number" step="0.001" min="1" class="form-control mb-2"
                                                    name="price" step="0.001" id="price" placeholder="Price" />
                                                <div class="btn-group mb-2" role="group" aria-label="Basic example">
                                                    <button type="button"
                                                        class="btn btn-icon btn-danger removeDiamond"><i
                                                            class="fas fa-times"></i></button>
                                                    <button type="button" class="btn btn-icon btn-primary addDiamond"><i
                                                            class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageScripts')
    <script src="{{ asset('assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select2.js') }}"></script>
    <script src="{{ asset('assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/js/dynamic-form.js') }}"></script>
    <script>
        $("#diamonds").hide()
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
        //init nice select 
        NiceSelect.bind(document.getElementById("select-supplier"), {
            searchable: true
        });
        NiceSelect.bind(document.getElementById("select-branch"), {
            searchable: true
        });
        $(".selectric").selectric();



        //check category division
        $("select#select-category").on("change", function(event) {
            const division = $(":selected", this).data('division');
            let dynamic_form = null;
            if (division.toLowerCase() === "diamond") {
                $("#diamonds").slideDown()
                $("#kerat").slideUp()
                $("#manufacturingLabel").html("Product Price");
                $("#LowestManufacturingLabel").html("Lowest price for sale");
                //dynamic form
                dynamic_form = $("#dynamic_form").dynamicForm("#dynamic_form", ".addDiamond",
                    ".removeDiamond", {
                        limit: 10,
                        formPrefix: "diamonds",
                        normalizeFullForm: false,
                    });
            } else {
                dynamic_form = null;
                $("#diamonds").slideUp()
                $("#kerat").slideDown()
                $("#manufacturingLabel").html("Manufacturing Value");
                $("#LowestManufacturingLabel").html("Lowest manufacturing value for sale");
            }
        });
    </script>
@endpush
