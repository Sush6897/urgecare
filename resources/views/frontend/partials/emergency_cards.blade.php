@forelse($hospital as $hos)
<div class="col-md-4 mb-4 hospital-item">
    <div class="card h-100">
        <div class="card-body">
            <div class="card-title">
                <span class="hospital-name">{{$hos->hospital_name}}</span>
                <span class="location text-xs"><i class="fas fa-map"></i> {{$hos->area}}</span>
            </div>
            <ul class="features-list mb-3">
                @if(isset($hos->features1))
                <li><i class="fas fa-check-circle"></i> {{$hos->features1}}</li>
                @endif
                @if(isset($hos->features2))
                <li><i class="fas fa-check-circle"></i> {{$hos->features2}}</li>
                @endif
                @if(isset($hos->features3))
                <li><i class="fas fa-check-circle"></i> {{$hos->features3}}</li>
                @endif
                @if(isset($hos->features4))
                <li><i class="fas fa-check-circle"></i>{{$hos->features4}}</li>
                @endif
            </ul>
            <div class="controls">
             
                <button class="button call hidden-text" data-toggle="modal" data-target="#bookNowModal" data-hospital-id="{{$hos->id}}">
                    <span class="button-text">Book Now</span>
                    <span class="button-icon-only" data-hospital-id="{{$hos->id}}"> Book Now</span>
                </button>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center py-5">
    <div class="no-results-card p-5 shadow-sm rounded-lg bg-white">
        <i class="fas fa-ambulance fa-4x mb-3 text-muted"></i>
        <h3 class="font-weight-bold">No Emergency Ambulance Found</h3>
        <p class="text-muted">We couldn't find any emergency ambulance matching your criteria. Try adjusting your filters or search terms.</p>
    </div>
</div>
@endforelse
