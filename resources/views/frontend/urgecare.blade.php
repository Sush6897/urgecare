@extends('layout.frontend.app')

@section('content')

<section class="page-title py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Urgecare Services</h1>
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

<section class="py-5">
    <div class="container">

        <div class="row">

            <!-- Emergency Ambulance -->

            <div class="single-service col-md-5">

                <img src="{{ asset('/frontend/assets/images/emergecy.jpg') }}"
                     class="img-fluid mb-3"
                     width="500"
                     height="400"
                     alt="Emergency Ambulance">

                <h2 class="sec-title">Emergency Ambulance</h2>

                <a href="{{ setting('is_emergency_link') ? route('home') : 'tel:' . setting('emergency_number') }}"
                   class="btn btn-primary">
                    {{ setting('is_emergency_link') ? 'Find Nearest Ambulance' : 'Call Now' }}
                </a>

            </div>


            <!-- Spacer -->

            <div class="col-md-2"></div>


            <!-- Non Emergency Ambulance -->

            <div class="single-service col-md-5">

                <img src="{{ asset('/frontend/assets/images/non-emergency.jpg') }}"
                     width="500"
                     height="400"
                     class="img-fluid mb-3"
                     alt="Non-Emergency Ambulance">

                <h2 class="sec-title">Non-Emergency Ambulance</h2>

                <a href="tel:{{ setting('non_emergency_number') }}"
                   class="btn btn-primary">

                    Call Now

                </a>

            </div>

        </div>

    </div>
</section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(!Session::has('success'))
        $('#locationModal').modal('show');
        @endif

        var yesBtn = document.getElementById('yesBtn');
        if (yesBtn) {
            yesBtn.addEventListener('click', function() {
                $('#global-loader').removeClass('fade-out');

                localStorage.removeItem('latitude');
                localStorage.removeItem('longitude');
                $('#location-form input[name="redirect"]').val(window.location.pathname + window.location.search);

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        localStorage.setItem('latitude', latitude);
                        localStorage.setItem('longitude', longitude);

                        $('#location-form input[name="latitude"]').val(latitude);
                        $('#location-form input[name="longitude"]').val(longitude);
                        $('#location-form').submit();
                    }, function(error) {
                        $('#global-loader').addClass('fade-out');
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
                    $('#global-loader').addClass('fade-out');
                    alert('Geolocation is not supported by this browser.');
                }

                $('#locationModal').modal('hide');
            });
        }
    });
</script>
@endsection