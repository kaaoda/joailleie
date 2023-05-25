@extends('layouts.main')

@section('pageTitle', 'Maintenance Requests')

@push('cssPageDependencies')
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <h2 class="section-title mb-0">Request Details #{{$restoration->request_number}}</h2>
            <div class="row">
                <div class="col-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <a href="{{asset('storage/'.$restoration->picture_path)}}" target="_blank"><img alt="image" src="{{asset('storage/'.$restoration->picture_path)}}" class="rounded-circle profile-widget-picture"></a>
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Cost</div>
                                    <div class="profile-widget-item-value">{{ $restoration->cost }}
                                        {{ mainCurrency()->code }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Paid Price</div>
                                    <div class="profile-widget-item-value">{{ $restoration->deposit }}
                                        {{ mainCurrency()->code }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Weight</div>
                                    <div class="profile-widget-item-value">{{ $restoration->weight }}g</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">Customer: {{ $restoration->customer->full_name }}</div>
                            <p>Details / Notices: {!! $restoration->notices !!}</p>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" data-toggle="modal" data-target="#addTransactionModal"
                                    class="btn btn-danger">Add Transaction</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="activities">
                        @forelse ($restoration->transactions as $transaction)
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job">{{ $transaction->happened_at }}</span>
                                        <div class="float-right dropdown">
                                            <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-title">Options</div>
                                                <a href="#" class="dropdown-item has-icon"><i class="fas fa-edit"></i>Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="dropdown-item has-icon text-danger"><i class="fas fa-trash-alt"></i>Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <p><strong>{{$transaction->employee_name}}:</strong> {{$transaction->description}}</p>
                                </div>
                            </div>
                        @empty
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job">{{ $restoration->created_at }}</span>
                                    </div>
                                    <p>Request created with no transactions!</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal with form -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('restorationsTransactions.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="restoration_request_id" value="{{$restoration->id}}" />
                        <div class="form-group">
                            <label>Employee Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="employee_name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Date Time</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="datetime-local" class="form-control" name="happened_at" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Details</label>
                            <div class="input-group">
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pageScripts')
@endpush
