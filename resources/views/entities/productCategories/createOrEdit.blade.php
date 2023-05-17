@extends('layouts.main')

@section('pageTitle', isset($cat) ? 'Update Category' : 'Add new Category')

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.wrong')
                <div class="col-12">
                    <div class="card">
                        @isset($cat)
                            <form action="{{ route('product_categories.update', ['product_category' => $cat->id]) }}" method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('product_categories.store') }}" method="POST">
                                @endisset

                                @csrf
                                <div class="card-header">
                                    <h4>{{ isset($cat) ? 'Update Category' : 'Add new Category' }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Category Name <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            @isset($cat)
                                        value="{{ $cat->name }}"
                                    @endisset
                                            name="name" />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Division</label>
                                        <select class="custom-select @error('product_division_id') is-invalid @enderror" name="product_division_id" />
                                            <option selected value="">Select Division</option>
                                            <option value="2">Diamond</option>
                                            <option value="1">Gold</option>
                                        </select>
                                        @error('product_division_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                            class="fas fa-check"></i>{{ isset($cat) ? 'Update' : 'Add' }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
