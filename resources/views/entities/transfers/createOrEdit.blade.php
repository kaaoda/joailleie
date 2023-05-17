@extends('layouts.main')

@section('pageTitle', isset($branch) ? 'Update Branch' : 'Add new transfer request')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icon_font/css/icon_font.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.transfer.css') }}">
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.wrong')
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ isset($transfer) ? 'Update Transfer' : 'Create New Transfer' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Destination</label>
                                <select class="form-control" id="branch">
                                    @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr />
                            <label>Products</label>
                            <div id="transfer4" class="transfer-demo"></div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="button" id="saveBtn" class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i>{{ isset($transfer) ? 'Update' : 'Add' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageScripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.transfer.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Page Specific JS File -->
    <script>
        let data = JSON.parse('{!!$products!!}');

        const settings4 = {
            "dataArray": data,
            "itemName": "barcode",
            "valueName": "id"
        };

        const transfer = $("#transfer4").transfer(settings4);
        

        $("button#saveBtn").on("click", function(){
            // get selected items
            const items = transfer.getSelectedItems();
            const branch = $("select#branch").find(":selected").val();
            axios.post("{{route('transfers.store')}}",{
                branch_id:branch,
                products:items
            })
                .then(response => {
                    console.log(response);
                    iziToast.success({
                        title: 'Success',
                        message: response.data.success,
                        position: 'topRight'
                    });
                })
                .catch(err => {
                    console.log(err);
                    iziToast.warning({
                        title: 'Error!',
                        message: err.response.data.error,
                        position: 'topRight'
                    });
                })
        });
                
    </script>
@endpush
