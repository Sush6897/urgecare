@extends('layout.frontend.app')

@section('title', 'Train Ambulance Service in Pune | ICU Train Transfer 24/7')

@section('meta')
<meta name="description" content="Book train ambulance service in Pune and nationwide for long-distance patient transfer. ICU setup, doctor support & 24/7 assistance. Call now for fast arrangement.">
@endsection

@section('styles')
{{-- Google Font --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">

<style>
  .highlight {
    color: #FF3D00;
  }

  /* Cards */
  .cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 40px;
  }
  .card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    overflow: hidden;
    flex: 1 1 calc(33.333% - 40px);
    max-width: 300px;
    transition: transform 0.3s ease;
  }
  .card:hover {
    transform: translateY(-5px);
  }
  .card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }
  .card-content {
    padding: 15px;
  }
  .card-content h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: #1d3557;
  }
  .card-content p {
    font-size: 1rem;
  }
  @media (max-width: 768px) {
    .card {
      flex: 1 1 100%;
    }
  }

  /* Banner */
  .banner {
    width: 100%;
    overflow: hidden;
    height: 300px;
    margin-bottom: 40px;
  }
  .banner img {
    width: 100%;
    height: auto;
    object-fit: cover;
    display: block;
  }
  @media (max-width: 768px) {
    .banner {
      height: auto;
      max-height: 200px;
      margin-bottom: 40px;
    }
    .banner img {
      height: auto;
    }
  }
  .banner-img {
    width: 100%;
    height: 40vh;
  }
  @media (max-width: 1023px) {
    .banner-img {
      width: 100%;
    }
  }

  /* Floating call button */
  .stt {
    border-radius: 30px;
    border: 2px solid #fff;
    text-align: center;
    height: 60px;
    position: fixed;
    width: 60px;
    bottom: 20px;
    right: 30px;
    background-color: #000000;
    animation: glow 1s infinite alternate;
    z-index: 100;
  }
  @keyframes glow {
    from {
      box-shadow: 0 0 5px -5px red;
    }
    to {
      box-shadow: 0 0 5px 13px red;
    }
  }

  /* Key points */
  .key-points {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .key-points li {
    margin-bottom: 10px;
    font-size: 16px;
    position: relative;
    padding-left: 25px;
  }
  .key-points li i {
    position: absolute;
    left: 0;
    color: #007bff;
  }
</style>
@endsection

@section('content')

{{-- Banner --}}
<div class="banner">
  <img class="banner-img" src="{{ asset('Urgecare/images_webp/images/trinbanner.webp') }}" alt="Train ambulance service in Pune" />
</div>

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


<div class="container">
  <h1>Train Ambulance Service in Pune</h1>
  <p>
    <span class="highlight"><a title="Train Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/Hospital_train">Train Ambulance Service in Pune</a></span> is ideal for long-distance patient transport where cost-effectiveness and stability are crucial. Our <a title="Train Ambulance Service in Pune" href="{{ url('/about-us') }}" class="highlight">Train Ambulance Service in Pune</a> ensures a safe and monitored journey with medical supervision.
  </p>
  <p>
    We arrange medical escorts, equipment, and coordination with rail authorities for a smooth transfer, making us a trusted choice for intercity or interstate patient movement.
  </p>

  <h2>Key Points</h2>
  <ul class="key-points">
    <li><i class="fa fa-arrow-right"></i> <span class="highlight"><a title="Train Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/Rail_ambulance">Train Ambulance Service in Pune</a></span> available for intercity transfer</li>
    <li><i class="fa fa-arrow-right"></i> Cost-effective alternative to air ambulances</li>
    <li><i class="fa fa-arrow-right"></i> Full medical setup during transit</li>
    <li><i class="fa fa-arrow-right"></i> Medical escort with every patient</li>
    <li><i class="fa fa-arrow-right"></i> Coordination with hospital teams and stations</li>
  </ul>

  <h3 style="margin-top: 40px;">
    <a title="Train Ambulance Service in Pune" href="https://www.reddit.com/r/indianrailways/comments/1g9bya5/train_ambulance/"><strong>Train Ambulance Features</strong></a>
  </h3>

  <div class="cards">
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/stretcher.webp') }}" alt="Train stretcher setup" title="Train Ambulance Service in Pune">
      <div class="card-content">
        <h3>Stretcher & Berth Setup</h3>
        <p>Special berth arrangements with stretchers and support gear for long-distance travel.</p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/escort team.webp') }}" alt="Medical Escort" title="Train Ambulance Service in Pune">
      <div class="card-content">
        <h3>Medical Escort Team</h3>
        <p>Doctor and nurse team accompany patients for full-time monitoring in transit.</p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/train.webp') }}" alt="Rail coordination" title="Train Ambulance Service in Pune">
      <div class="card-content">
        <h3>Railway Coordination</h3>
        <p>End-to-end arrangements with railway authorities to ensure seamless medical transport.</p>
      </div>
    </div>
  </div>

</div>

{{-- Floating Call Button --}}
<a href="tel:+917888021021" class="stt">
  <i class="fa fa-phone fa-spin" style="font-size: 35px; margin-top: 11px; color: #fff"></i>
</a>

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
