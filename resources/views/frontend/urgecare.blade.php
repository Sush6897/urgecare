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