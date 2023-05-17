<div class="card">
    <div class="card-body card-type-3">
        <div class="row">
            <div class="col">
                <h6 class="text-muted mb-0">{{$title}}</h6>
                <span class="font-weight-bold mb-0">{{ $counter->newNumber }}</span>
            </div>
            <div class="col-auto">
                <div class="card-circle {{$color}} text-white">
                    <i class="{{$icon}}"></i>
                </div>
            </div>
        </div>
        <p class="mt-3 mb-0 text-muted text-sm">
            @if ($counter->percent === 'N/A')
                <span class="text-secondary mr-2"><i class="fas fa-ban"></i> N/A</span>
            @elseif ($counter->percent > 0)
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $counter->percent }}</span>
            @else
                <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{ $counter->percent }}</span>
            @endif
            <span class="text-nowrap">Since last month</span>
        </p>
    </div>
</div>