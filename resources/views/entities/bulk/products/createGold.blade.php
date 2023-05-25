@extends('layouts.main')

@section('pageTitle', 'Create Bulk Gold Products')

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
                            <div class="card-header">
                                <h4>Create Bulk Gold Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center align-items-center product" id="dynamic_form">
                                            <button style="height: 42px;margin-top: -10px;" type="button" class="btn btn-icon btn-sm btn-warning print-btn"><i class="fas fa-print"></i></button>
                                            <input type="text" class="form-control mb-2" id="weight" name="weight" placeholder="Weight" />
                                            <input type="text" class="form-control mb-2" name="cost" id="cost" placeholder="Cost" />
                                            <input type="number" min="0" class="form-control mb-2" name="sales" id="sales" placeholder="Ticket Price" />
                                            <select id="supplier_id" class="form-control" name="supplier_id">
                                                <option selected value="">Supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                            <select id="branch_id" class="form-control" name="branch_id">
                                                <option selected value="">Branch</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control selectric" id="category_id" name="category_id">
                                                <option selected value="">Category</option>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form style="visibility: hidden;" id="additionForm" action="{{ route('bulk.storeGoldProducts') }}" method="POST" target="_blank">
        @csrf
        <div class="inputs">
            
        </div>
    </form>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/js/dynamic-form.js') }}"></script>
    <!-- Page Specific JS File -->
    <script>
        //dynamic form
        const dynamic_form = $("#dynamic_form").dynamicForm("#dynamic_form", ".addService", ".removeService", {
            limit: 1000,
            formPrefix: "products",
            normalizeFullForm: false,
        });
        
        const additionForm = $("form#additionForm");
        const inputsDiv = additionForm.find(".inputs");
        
        
        //printing
        $(document).on("click", "button.print-btn", function(event){
            const containerDiv = $(this).closest(".product");
            console.log(containerDiv)
            if(containerDiv.attr('index') % 2 !== 0)
            {
                const prev = containerDiv.prev();
                

                //append last product inputs to form
                inputsDiv.append(`<input type="text" name="products[products][0][weight]" value="${containerDiv.find('input[origname=weight]').val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][0][cost]" value="${containerDiv.find('input[origname=cost]').val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][0][sales]" value="${containerDiv.find('input[origname=sales]').val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][0][supplier_id]" value="${containerDiv.find('select[origname=supplier_id]').find(":selected").val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][0][branch_id]" value="${containerDiv.find('select[origname=branch_id]').find(":selected").val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][0][category_id]" value="${containerDiv.find('select[origname=category_id]').find(":selected").val()}" />`);
                
                //append prev product inputs to form
                inputsDiv.append(`<input type="text" name="products[products][1][weight]" value="${prev.find('input[origname=weight]').val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][1][cost]" value="${prev.find('input[origname=cost]').val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][1][sales]" value="${prev.find('input[origname=sales]').val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][1][supplier_id]" value="${prev.find('select[origname=supplier_id]').find(":selected").val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][1][branch_id]" value="${prev.find('select[origname=branch_id]').find(":selected").val()}" />`);
                inputsDiv.append(`<input type="text" name="products[products][1][category_id]" value="${prev.find('select[origname=category_id]').find(":selected").val()}" />`);
                additionForm.submit();
                inputsDiv.html(null);
            }
            
            
            // console.log(containerDiv.find('input[origname=weight]').val(), containerDiv.find('input[origname=sales]').val());
            // console.log(prev.find('input[origname=weight]').val(), prev.find('input[origname=sales]').val());
        });
    </script>
@endpush
