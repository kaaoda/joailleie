@extends('layouts.main')

@section('pageTitle', isset($branch) ? 'Update Branch' : 'Add new branch')

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.wrong')
                <div class="col-12">
                    <div class="card">
                        @isset($branch)
                            <form action="{{ route('branches.update', ['branch' => $branch->id]) }}" method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('branches.store') }}" method="POST">
                                @endisset

                                @csrf
                                <div class="card-header">
                                    <h4>{{ isset($branch) ? 'Update Branch' : 'Add new branch' }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Branch Name <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            @isset($branch)
                                        value="{{ $branch->name }}"
                                    @endisset
                                            name="name" />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Supervisor</label>
                                        <select class="custom-select @error('name') is-invalid @enderror" name="supervisor_id">
                                            <option selected value="">Select supervisor name</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}">{{$user->full_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('supervisor_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                            class="fas fa-check"></i>{{ isset($branch) ? 'Update' : 'Add' }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
