@extends('layouts.main')

@section('pageTitle', isset($employee) ? 'Update Employee' : 'Add new Employee')

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.wrong')
                <div class="col-12">
                    <div class="card">
                        @isset($employee)
                            <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('employees.store') }}" method="POST">
                                @endisset

                                @csrf
                                <div class="card-header">
                                    <h4>{{ isset($employee) ? 'Update Employee' : 'Add new Employee' }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <select class="form-control" name="branch_id">
                                            <option selected value="">Choose Branch...</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Employee Name <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" @isset($employee) value="{{ $employee->full_name }}" @endisset name="full_name" />
                                        @error('full_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" @isset($employee) value="{{ $employee->phone_number }}" @endisset name="phone_number" />
                                        @error('phone_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Job Title <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="text" class="form-control @error('job_title') is-invalid @enderror" @isset($employee) value="{{ $employee->job_title }}" @endisset name="job_title" />
                                        @error('job_title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                            class="fas fa-check"></i>{{ isset($employee) ? 'Update' : 'Add' }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
