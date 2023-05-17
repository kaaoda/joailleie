@if ($errors->has('error'))
    <div class="col-12">
        <div class="alert alert-danger alert-has-icon">
            <div class="alert-icon"><i class="fas fa-times"></i></div>
            <div class="alert-body">
                <div class="alert-title">Error</div>
                {{ $errors->first('error') }}
            </div>
        </div>
    </div>
@endif
