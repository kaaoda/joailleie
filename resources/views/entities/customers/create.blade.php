@extends('layouts.main')

@section('pageTitle', 'Add new customer')

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{route('customers.store')}}" method="POST">
                            @csrf
                            <div class="card-header">
                                <h4>Add new customer</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Full Name <i class="fas fa-asterisk text-danger"></i></label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" />
                                    @error('full_name')
                                        <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control @error('email') is-invalid @else is-valid @enderror" />
                                    @error('email')
                                        <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Phone <i class="fas fa-asterisk text-danger"></i></label>
                                    <div class="input-group">
                                        <input type="text" placeholder="+20" name="phone_prefix" class="form-control @error('phone_prefix') is-invalid @enderror">
                                        <input type="text" placeholder="0000000000" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nationality <i class="fas fa-asterisk text-danger"></i></label>
                                    <input type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality" />
                                    @error('nationality')
                                        <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                        class="fas fa-check"></i> Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
