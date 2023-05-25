@extends('layouts.main')

@section('pageTitle', isset($restoration) ? 'Update Request' : 'Add new Request')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}" />
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.wrong')
                <div class="col-12">
                    <div class="card">
                        @isset($restoration)
                            <form action="{{ route('restorations.update', ['restoration' => $restoration->id]) }}" method="POST">
                                @method('PUT')
                        @else
                            <form action="{{ route('restorations.store') }}" method="POST" enctype="multipart/form-data">
                                @endisset

                                @csrf
                                <div class="card-header">
                                    <h4>{{ isset($restoration) ? 'Update Request' : 'Add new Request' }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-5">
                                        <label>Customer </label>
                                        <select id="select-customer" class="@error('customer_id') is-invalid @enderror"
                                            name="customer_id">
                                            <option selected value="">Select customer name</option>
                                            @foreach ($customers as $customer)
                                                <option @if(isset($restoration) && $restoration->customer_id == $customer->id) selected @endif value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Weight</label>
                                        <input type="number" min="0" step="0.001" class="form-control @error('weight') is-invalid @enderror" @isset($restoration) value="{{ $restoration->weight }}" @endisset name="weight" />
                                        @error('weight')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Cost</label>
                                        <input type="number" min="0" step="0.001" class="form-control @error('cost') is-invalid @enderror" @isset($restoration) value="{{ $restoration->cost }}" @endisset name="cost" />
                                        @error('cost')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Paid Price (Default is 0)</label>
                                        <input type="number" min="0" step="0.001" value="0" class="form-control @error('deposit') is-invalid @enderror" @isset($restoration) value="{{ $restoration->deposit }}" @endisset name="deposit" />
                                        @error('deposit')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Details / Notices</label>
                                        <div class="col-sm-12 col-md-9">
                                            <textarea class="summernote-simple @error('notices') is-invalid @enderror" name="notices">@isset($restoration) {!! $restoration->notices !!} @endisset</textarea>
                                            @error('notices')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                                        <div class="col-sm-12 col-md-9">
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="pic" id="image-upload" />
                                            </div>
                                        </div>
                                    </div>
                                    @if(isset($restoration) && !$restoration->status)
                                        <div class="form-group">
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="status" class="custom-switch-input" />
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Mark as completed</span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-icon icon-left btn-success"><i
                                            class="fas fa-check"></i>{{ isset($restoration) ? 'Update' : 'Add' }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select2.js') }}"></script>
    <script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <!-- Page Specific JS File -->
    <script>
        //init nice select 
        NiceSelect.bind(document.getElementById("select-customer"), {
            searchable: true
        });

        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
@endpush
