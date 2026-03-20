@extends('layout.frontend.app')
@section('content')

<section class="search-emergency py-3" id="searchEmergency">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <form class="form" id="searchForm" method="get">
                    <label for="search">
                        <input name="search" autocomplete="off"
                            placeholder="Search with Hospital name, Location or Pincode..." id="search" type="text" value="{{ request()->input('search', '') }}">
                        <div class="icon">
                            <svg stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="swap-on">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linejoin="round"
                                    stroke-linecap="round"></path>
                            </svg>
                            <svg stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="swap-off">
                                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linejoin="round"
                                    stroke-linecap="round"></path>
                            </svg>
                        </div>
                        <button type="reset" class="close-btn" onclick="clearSearch()">
                            <svg viewBox="0 0 20 20" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    fill-rule="evenodd"></path>
                            </svg>
                        </button>
                    </label>
                </form>
            </div>
        </div>
    </div>
</section>




<!-- Hospital Cards -->
<section class="hospitals py-5">
    <!-- Filter Button -->
    <div class="container mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="search-results mb-2 mb-md-0">

            </div>
            <div class="filters d-flex flex-wrap">
                <button type="button" class="btn btn-primary mr-2 mb-2 mb-md-0" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-filter"></i> Filter Hospitals
                </button>

                <button type="button" class="btn btn-secondary mb-2 mb-md-0">
                    <i class="fa fa-search" aria-hidden="true"></i> Search
                </button>
            </div>
        </div>

    </div>


    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="filterForm" method="get">
                        <div class="form-row">
                            <!-- Features Filter -->
                            <div class="form-group col-md-6">
                                <label for="featuresFilter">Features</label>
                                @php

                                $selectedFeatures = request()->input('feature', []);
                                @endphp
                                @foreach ($features as $feature)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="feature[]" id="{{ $feature }}" value="{{ $feature }}" @if(in_array($feature, $selectedFeatures)) checked @endif>
                                    <label class="form-check-label" for="{{ $feature }}">{{ ucfirst(str_replace('_', ' ', $feature)) }}</label>
                                </div>
                                @endforeach
                            </div>
                            <!-- Distance Filter -->
                            <div class="form-group col-md-6">
                                <label for="distanceFilter">Distance</label>
                                <select id="distanceFilter" name="distance" class="form-control">
                                    <option value="">Select Distance</option>
                                    <option value="1" {{ request()->input('distance') == 1 ? 'selected' : '' }}>Within 1 km</option>
                                    <option value="2" {{ request()->input('distance') == 2 ? 'selected' : '' }}>Within 2 km</option>
                                    <option value="5" {{ request()->input('distance') == 5 ? 'selected' : '' }}>Within 5 km</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
                    </form>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="hospital-container" class="row">
            <!-- Hospital Cards -->
            @include('frontend.partials.emergency_cards')
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <button id="load-more-btn" class="btn btn-primary" data-offset="3" @if(count($hospital) < 3) style="display: none;" @endif>Load More</button>
                <div id="loading" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Loading...
                </div>
            </div>
        </div>
                
        </div>

        <!-- Modal -->
        <div class="modal fade" id="bookNowModal" tabindex="-1" aria-labelledby="bookNowModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="bookNowModalLabel">You will get a call back In one second </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('call')}}">
                            @csrf
                            <input type="hidden" class="form-control" id="hospital_id" name="hospital_id" value="" placeholder="Enter patient name">
                            <div class="form-group">
                                <label for="patientName">Patient Name</label>
                                <input type="text" class="form-control" id="patientName" name="patient_name" placeholder="Enter patient name" required>
                            </div>
                            <div class="form-group">
                                <label for="contactNumber">Contact Number</label>
                                <input type="number" class="form-control" id="contactNumber" name="contact" placeholder="Enter contact number" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>




<!-- Sticky Button -->

<script src="{{asset('/frontend/assets/script.js')}}"></script>
<script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>

<script>
    function clearSearch() {
        // alert("hii");
        document.getElementById('search').value = '';
        $('#searchForm').submit();
    }


    $(document).on('click', '.button.call', function() {
        var hospital_id = $(this).data('hospital-id'); 
        $('#hospital_id').val(hospital_id);
    });

    $(document).ready(function() {
        $('#load-more-btn').on('click', function() {
            var btn = $(this);
            var offset = btn.data('offset');
            var search = $('#search').val();
            var distance = $('#distanceFilter').val();
            var features = [];
            $('input[name="feature[]"]:checked').each(function() {
                features.push($(this).val());
            });
            var loading = $('#loading');

            btn.hide();
            loading.show();

            $.ajax({
                url: window.location.href,
                method: "GET",
                data: {
                    offset: offset,
                    search: search,
                    distance: distance,
                    feature: features
                },
                success: function(response) {
                    loading.hide();
                    if (response.html) {
                        $('#hospital-container').append(response.html);
                        btn.data('offset', offset + 3);
                        if (response.hasMore) {
                            btn.show();
                        } else {
                            btn.hide();
                        }
                    } else {
                        btn.hide();
                    }
                },
                error: function() {
                    loading.hide();
                    btn.show();
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    });
</script>

@endsection