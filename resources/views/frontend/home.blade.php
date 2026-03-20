@extends('layout.frontend.app')
@section('content')

<section class="search py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mx-auto">
                <h2 class="sec-title">Ambulance services to reach any hospital</h2>

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

<section class="hospitals py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <h1 class="sec-title text-center"></h1>
            </div>
            <div id="hospital-container" class="row">
                @include('frontend.partials.hospital_cards')
            </div>
            
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button id="load-more-btn" class="btn btn-primary" data-offset="3">Load More</button>
                    <div id="loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="bookNowModal" tabindex="-1" aria-labelledby="bookNowModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title " id="bookNowModalLabel">You will get a call back In one second</h5>
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

<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="locationModalLabel">Allow Location Access</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               Give access to your location for nearest ambulance
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="yesBtn">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>


<section class="about-us my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-sm-2">
                <h1 class="sec-title">One Search to Connect with Healthcare Near You</h1>
                <p class="text-justify">
                    Welcome to Urgecare, your trusted partner in emergency medical services in Pune, Maharashtra, India. We are
                    a leading ambulance aggregator platform dedicated to providing swift, reliable, and compassionate medical
                    transportation to individuals in need. Our mission is to bridge the gap in emergency care accessibility,
                    ensuring that timely and quality medical assistance reaches every corner of Pune.
                </p>
                <p class="text-justify">
                    At Urgecare, we understand that medical emergencies can be overwhelming and stressful. That's why we have
                    built a comprehensive network of top-quality ambulance service providers, equipped with state-of-the-art
                    technology and staffed by trained medical professionals.
                </p>
            </div>
            <div class="col-md-6 order-sm-1 about-image">
                <img src="{{asset('/frontend/assets/images/ambulance_pic.jpeg')}}" alt="About Us Image" height="500px" class="img-fluid">
            </div>
        </div>
    </div>
</section>



<script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>

<script>

    function clearSearch() {
        // alert("hii");
        document.getElementById('search').value = '';
        $('#searchForm').submit();
    }
    $(document).on('click', '.button.call', function() {
        // Replace with your logic to get the hospital_id
        var hospital_id = $(this).data('hospital-id'); // Get hospital_id from button's data attribute

        // Set the value to the input field
        $('#hospital_id').val(hospital_id);
    });


    document.addEventListener("DOMContentLoaded", function() {
        // Show the modal on page load
        $('#locationModal').modal('show');

        // Handle "Yes" button click
        document.getElementById('yesBtn').addEventListener('click', function() {
            // Always clear previous location data from localStorage
            localStorage.removeItem('latitude');
            localStorage.removeItem('longitude');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    // Save the new latitude and longitude to localStorage
                    localStorage.setItem('latitude', latitude);
                    localStorage.setItem('longitude', longitude);

                    // Optionally, submit the form or perform an action with the coordinates
                    $('#location-form input[name="latitude"]').val(latitude);
                    $('#location-form input[name="longitude"]').val(longitude);

                    // Submit the form if needed
                    $('#location-form').submit();
                }, function(error) {
                    // Handle errors
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            alert('User denied the request for Geolocation.');
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert('Location information is unavailable.');
                            break;
                        case error.TIMEOUT:
                            alert('The request to get user location timed out.');
                            break;
                        default:
                            alert('An unknown error occurred.');
                    }
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }

            // Close the modal after attempting to get the location
            $('#locationModal').modal('hide');
        });

        // Load More Logic
        $('#load-more-btn').on('click', function() {
            var btn = $(this);
            var offset = btn.data('offset');
            var search = $('#search').val();
            var loading = $('#loading');

            btn.hide();
            loading.show();

            $.ajax({
                url: "{{ route('load.more') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    offset: offset,
                    search: search
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

        // Initial check if load more should be visible (if less than 3 hospitals)
        if ($('.hospital-item').length < 3) {
            $('#load-more-btn').hide();
        }
    });


     

        
    
</script>

@endsection