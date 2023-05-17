@extends('layouts.main')

@section('pageTitle', 'Products')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}">
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.success')
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link @if(!request()->query("branch")) active @endif" href="{{request()->url()}}">All <span class="badge badge-primary">{{ $list->total() }}</span></a>
                                </li>
                                @foreach ($branches as $branch)
                                    <li class="nav-item">
                                        <a class="nav-link @if(request()->query("branch") == $branch->id) active @endif" href="{{ route('products.index',['branch' => $branch->id]) }}">{{$branch->name}} <span class="badge badge-primary">{{$branch->products_count}}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>All Products ({{ $list->total() }})</h4>
                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                <a href="{{ route('products.create') }}" class="btn btn-icon icon-left btn-danger"><i class="fa fa-plus"></i> Add Product</a>
                                <a href="{{ route('bulk.createGoldProducts') }}" class="btn btn-icon icon-left btn-warning"><i class="fas fa-database"></i> Add Bulk Gold</a>
                                <a href="{{ route('bulk.createDiamondProducts') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-gem"></i> Add Bulk Diamond</a>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div class="float-left">
                                <select class="form-control selectric">
                                    <option>Action For Selected</option>
                                    <option>Move to Archive</option>
                                    <option>Delete Permanently</option>
                                </select>
                            </div>
                            <div class="float-right">
                                <form action="{{url()->full()}}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search" value="{{request()->query("search")}}" />
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="clearfix mb-3"></div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th class="pt-2">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                    class="custom-control-input" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Category</th>
                                        <th>Created At</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($list as $product)
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-{{$product->id}}">
                                                    <label for="checkbox-{{$product->id}}" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#">
                                                    <img alt="image" src="{{ $product->thumbnail_path }}"
                                                        class="rounded-circle" width="35" data-toggle="title"
                                                        title="">
                                                    <span class="d-inline-block ml-1">{{ $product->barcode }}</span>
                                                </a>
                                            </td>
                                            <td>{{ $product->branch->name }}
                                                <div class="table-links">
                                                    <a
                                                        href="{{ route('products.show', ['product' => $product->id]) }}">View</a>
                                                    <div class="bullet"></div>
                                                    <a
                                                        href="{{ route('products.edit', ['product' => $product->id]) }}">Edit</a>
                                                    <div class="bullet"></div>
                                                    <a onclick="deleteModel('{{ route('products.destroy', ['product' => $product->id]) }}', $(this).parent('div').parent('td').parent('tr'))"
                                                        href="javascript:void" class="text-danger">Trash</a>
                                                </div>
                                            </td>
                                            <td><a href="#">{{ $product->category->name }}</a></td>
                                            <td>10-02-2019</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                @if($product->quarantined)
                                                    <div class="badge badge-warning">Quarantined</div>
                                                @else
                                                    <div class="badge badge-success">Active</div>
                                                @endif
                                            </td>
                                            <td><a href="{{route('products.show', ['product' => $product->id])}}" class="btn btn-info">Detail</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $list->withQueryString()->links() }}
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
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/deleteModel.js') }}"></script>
@endpush
