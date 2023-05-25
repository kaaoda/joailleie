@extends('layouts.main')

@section('pageTitle', isset($user) ? 'Update User' : 'Add new user')

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.wrong')
                <div class="col-12">
                    <div class="card">
                        @isset($user)
                            <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('users.store') }}" method="POST">
                                @endisset

                                @csrf
                                <div class="card-header">
                                    <h4>{{ isset($user) ? 'Update User' : 'Add new user' }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="form-control" name="branch_id">
                                            @foreach (App\Models\Branch::all() as $branch)
                                                <option @if(isset($user) && $user->branch_id == $branch->id) selected @endif value="{{$branch->id}}">{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control" name="role_id">
                                            @foreach (App\Models\Role::all() as $role)
                                                <option @if(isset($user) && $user->role_id == $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>User Name <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" @isset($user) placeholder="{{ $user->name }}" @endisset name="name" />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Login Name <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" @isset($user) placeholder="{{ $user->username }}" @endisset name="username" />
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password <i class="fas fa-asterisk text-danger"></i></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" />
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                            class="fas fa-check"></i>{{ isset($user) ? 'Update' : 'Add' }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
