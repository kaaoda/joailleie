@if (session()->has('success'))
    <div class="col-12">
        <div class="alert alert-success alert-has-icon">
            <div class="alert-icon"><i class="fas fa-check"></i></div>
            <div class="alert-body">
                <div class="alert-title">Success</div>
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif
