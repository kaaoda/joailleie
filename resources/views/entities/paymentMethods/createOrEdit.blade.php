@extends('layouts.main')

@section('pageTitle', isset($paymentMethod) ? 'Update Payment Method' : 'Add new payment Method')

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.wrong')
                <div class="col-12">
                    <div class="card">
                        @isset($paymentMethod)
                            <form action="{{ route('paymentMethods.update', ['paymentMethod' => $paymentMethod->id]) }}" method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('paymentMethods.store') }}" method="POST">
                                @endisset

                                @csrf
                                <div class="card-header">
                                    <h4>{{ isset($paymentMethod) ? 'Update Payment Method' : 'Add new payment Method' }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Payment Method Name <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            @isset($paymentMethod)
                                        value="{{ $paymentMethod->name }}"
                                    @endisset
                                            name="name" />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                            class="fas fa-check"></i>{{ isset($paymentMethod) ? 'Update' : 'Add' }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
