@extends('layouts.main')

@section('pageTitle', 'Currencies')

@push('cssPageDependencies')
    <link rel="stylesheet" href="{{ asset('assets/bundles/izitoast/css/iziToast.min.css') }}" />
@endpush

@section('mainContent')
    <section class="section">
        <div class="section-body">
            <div class="row">
                @include('components.alerts.success')
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Currencies</h4>
                            <a href="{{ route('currencies.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                    class="fa fa-plus"></i> Add Currency</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Exchange Rate</th>
                                            <th>Main</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $currency)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $currency->name }}</td>
                                                <td>{{ $currency->code }}</td>
                                                <td id="{{$currency->id}}" class="editMe">{{ $currency->exchange_rate }}</td>
                                                <td>
                                                    <label class="custom-switch">
                                                        <input id="{{$currency->id}}" type="radio" name="option"
                                                            class="custom-switch-input" @if($currency->main) checked @endif />
                                                        <span class="custom-switch-indicator"></span>
                                                    </label></td>
                                                <td>
                                                    <button
                                                        onclick="deleteModel('{{ route('currencies.destroy', ['currency' => $currency->id]) }}', $(this).parent('td').parent('tr'))"
                                                        class="btn btn-icon btn-sm btn-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                    <a href="{{ route('currencies.edit', ['currency' => $currency->id]) }}"
                                                        class="btn btn-icon btn-sm btn-primary"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a href="{{ route('currencies.show', ['currency' => $currency->id]) }}"
                                                        class="btn btn-icon btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageScripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/js/deleteModel.js') }}"></script>
    <script src="{{ asset('assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/SimpleTableCellEditor.js') }}"></script>
    <script>
        $(function(){
            function updateCurrency(data, id)
            {
                    axios.put("{{url('currencies')}}/"+id,data)
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
            }
            const editor = new SimpleTableCellEditor("table-1");
            editor.SetEditableClass("editMe");
            $('#table-1').on("cell:edited", function (event) {
                console.log(`'${event.oldValue}' changed to '${event.newValue}'`);
                const id = event.element.id;
                updateCurrency({
                    exchange_rate:event.newValue
                },id)
            });

            $("input[name='option']").on("change", function(event){
                if(event.target.checked)
                {
                    const id = event.target.id;
                    updateCurrency({main:true},id)
                }
            });
        });
    </script>
@endpush
