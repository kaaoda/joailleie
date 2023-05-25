@extends('layouts.main')

@section('pageTitle', 'Show Order ' . $order->order_number)

@push('cssPageDependencies')
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                @include("components.alerts.success")
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <div class="author-box-name">
                                    <a href="#">{{ $order->order_number }}</a>
                                </div>
                                <div class="author-box-job">{{ $order->created_at }}</div>
                            </div>
                            <div class="text-center">
                                <div class="author-box-description">
                                    @if ($order->invoice)
                                        <a href="{{route('invoices.show', ['invoice' => $order->invoice->id])}}" class="btn btn-icon icon-left btn-warning"><i class="fas fa-eye"></i>Show Invoice</a>
                                        @if (!$order->orderReturn)
                                            <a href="{{route('returns.create', ['order' => $order->id])}}" class="btn btn-icon icon-left btn-dark"><i class="fas fa-undo"></i>Return Order</a>
                                        @else
                                            <a href="{{route('returns.show', ['return' => $order->orderReturn->id])}}" class="btn btn-icon icon-left btn-warning"><i class="fas fa-eye"></i>Show Return Info</a>
                                        @endif
                                        
                                    @else
                                        <a href="{{route('invoices.create', ['order' => $order->id])}}" class="btn btn-icon icon-left btn-success"><i class="fas fa-file"></i>Create Invoice</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Name
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $order->customer->full_name }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Phone
                                    </span>
                                    <span class="float-right text-muted">
                                        ({{ $order->customer->phone_prefix }}){{ $order->customer->phone_number }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Mail
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $order->customer->email }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Nationality
                                    </span>
                                    <span class="float-right text-muted">
                                        <a href="#">{{ $order->customer->nationality }}</a>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about"
                                        role="tab" aria-selected="true">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                        aria-selected="false">Setting</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="row">
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Products</strong>
                                            <br>
                                            <p class="text-muted">{{ count($order->products) }}</p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Units</strong>
                                            <br>
                                            <p class="text-muted">{{ $order->products->sum('pivot.quantity') }}</p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Sub-Total</strong>
                                            <br>
                                            <p class="text-muted">{{ $order->products->sum('pivot.price') }}</p>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <strong>Has Invoice</strong>
                                            <br>
                                            <p class="text-muted">
                                                @if ($order->invoice)
                                                    <i class='fas fa-check text-success'></i>
                                                @else
                                                    <i class='fas fa-times text-danger'></i>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <p class="m-t-30"></p>
                                    <div class="section-title">Additional Services</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Service</th>
                                                    <th scope="col">Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($order->additionalServices as $service)
                                                    <tr>
                                                        <th scope="row">{{$loop->iteration}}</th>
                                                        <td>{{$service->description}}</td>
                                                        <td>{{$service->cost}}</td>
                                                    </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="4">Nothing</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="section-title">Products</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Qty.</th>
                                                    <th scope="col">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($order->products as $product)
                                                    <tr>
                                                        <th scope="row">{{$loop->iteration}}</th>
                                                        <td><a href="{{route('products.show', ['product' => $product->id])}}">{{$product->name}}</a></td>
                                                        <td>{{$product->pivot->quantity}}</td>
                                                        <td>{{$product->pivot->price}}</td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel"
                                    aria-labelledby="profile-tab2">
                                    <form method="post" class="needs-validation">
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
                                    </form>
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
@endpush
