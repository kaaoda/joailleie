@extends('layouts.main')

@section('pageTitle', 'Product Details')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}">
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <img alt="image" src="{{ $product->thumbnail_path }}"
                                    class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#">{{ $product->barcode }}</a>
                                </div>
                                <div class="author-box-job">{{ $product->category->name }} / {{ $product->division->name }}
                                </div>
                            </div>
                            {{-- <div class="text-center">
                                <div class="author-box-description">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur voluptatum alias
                                        molestias
                                        minus quod dignissimos.
                                    </p>
                                </div>
                                <div class="mb-2 mt-3">
                                    <div class="text-small font-weight-bold"></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Product Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Gold Weight
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $product->weight }}g
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Gold Kerat
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $product->kerat }}k
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Branch
                                    </span>
                                    <span class="float-right text-muted">
                                        <a href="#">{{ $product->branch->name }}</a>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Supplier
                                    </span>
                                    <span class="float-right text-muted">
                                        <a href="#">{{ $product->supplier->name }}</a>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Barcode</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Number</div>
                                    </div>
                                    <div class="float-right">
                                        <strong>{{ $product->barcode }}</strong>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-title">Print</div>
                                    </div>
                                    <div class="float-right">
                                        <a target="_blank" href="{{route('bulk.printBarcode',['barcode'=>[$product->barcode]])}}" class="btn btn-primary">Print Barcode</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                {{-- <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about"
                                        role="tab" aria-selected="true">About</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                        aria-selected="false">Setting</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="settings" role="tabpanel"
                                    aria-labelledby="profile-tab2">
                                    {{-- <form method="post" class="needs-validation">
                                        <div class="card-header">
                                            <h4>Edit Profile</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-12">
                                                    <label>First Name</label>
                                                    <input type="text" class="form-control" value="John">
                                                    <div class="invalid-feedback">
                                                        Please fill in the first name
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Last Name</label>
                                                    <input type="text" class="form-control" value="Deo">
                                                    <div class="invalid-feedback">
                                                        Please fill in the last name
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-7 col-12">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" value="test@example.com">
                                                    <div class="invalid-feedback">
                                                        Please fill in the email
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-5 col-12">
                                                    <label>Phone</label>
                                                    <input type="tel" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Bio</label>
                                                    <textarea class="form-control summernote-simple">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur voluptatum alias molestias minus quod dignissimos.</textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group mb-0 col-12">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="remember"
                                                            class="custom-control-input" id="newsletter">
                                                        <label class="custom-control-label" for="newsletter">Subscribe to
                                                            newsletter</label>
                                                        <div class="text-muted form-text">
                                                            You will get new information about products, offers and
                                                            promotions
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form> --}}
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
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/chartjs/chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/deleteModel.js') }}"></script>

@endpush
