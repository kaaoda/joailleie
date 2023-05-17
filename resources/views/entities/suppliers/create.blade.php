@extends('layouts.main')

@section('pageTitle', 'Add new supplier')

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{route('suppliers.store')}}" method="POST">
                            @csrf
                            <div class="card-header">
                                <h4>Add new supplier</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Business Name <i class="fas fa-asterisk text-danger"></i></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" />
                                    @error('name')
                                        <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Contact Name <i class="fas fa-asterisk text-danger"></i></label>
                                    <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror" />
                                    @error('contact_name')
                                        <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Phone <i class="fas fa-asterisk text-danger"></i></label>
                                    <div class="input-group">
                                        <input type="text" placeholder="0000000000" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror">
                                        @error('phone_number')
                                        <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                    </div>
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
