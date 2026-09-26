@extends('layout.frontend.app')

@section('title', 'Pune Ambulance Number | 24/7 Emergency Ambulance – Call Now')

@section('meta')
<meta name="description" content="Looking for ambulance number in pune and nationwide. Call now for 24/7 emergency ambulance. ICU, oxygen & fast response within 15 minutes across Pune.">
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
    margin-bottom: 40px;
  }
  .banner img {
    width: 100%;
    height: auto;
    object-fit: cover;
    display: block;
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
  <img class="banner-img" src="{{ asset('Urgecare/images_webp/images/search-bg.webp') }}" alt="Pune Ambulance Number in Pune" />
</div>

@include('frontend.partials.location_access_button')

<div class="container">
  <h1>Pune Ambulance Number in Pune</h1>
  <p>
    In an emergency, having the <span class="highlight"><a title="Pune Ambulance Number in Pune" href="https://en.wikipedia.org/wiki/108_(emergency_telephone_number)">Pune Ambulance Number in Pune</a></span> can save lives. Our service ensures you're connected instantly with a nearby ambulance through our 24/7 hotline. Bookmark or save the <a title="Pune Ambulance Number in Pune" href="https://en.wikipedia.org/wiki/102_(ambulance_service)" class="highlight">Pune Ambulance Number in Pune</a> for quick access.
  </p>
  <p>
    Whether you need immediate support or scheduled transport, our helpline connects you with fully-equipped ambulances in real-time.
  </p>

  <h2>Key Points</h2>
  <ul class="key-points">
    <li><i class="fa fa-arrow-right"></i> <span class="highlight"><a title="Pune Ambulance Number in Pune" href="http://vbch.dnh.nic.in/content/emergency-medical-response-108-0">Pune Ambulance Number in Pune</a></span> active 24/7</li>
    <li><i class="fa fa-arrow-right"></i> Immediate dispatch on call</li>
    <li><i class="fa fa-arrow-right"></i> Single-window assistance for all ambulance types</li>
    <li><i class="fa fa-arrow-right"></i> Location-based service assignment</li>
    <li><i class="fa fa-arrow-right"></i> Support staff available to guide and assist</li>
  </ul>

  <h3 style="margin-top: 40px;">Our Related Services</h3>
  <h4 style="margin-top: 40px;">Call-Based Ambulance Services</h4>

  <div class="cards">
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/call-ambulance.webp') }}" alt="24x7 Helpline Support" title="Pune Ambulance Number in Pune">
      <div class="card-content">
        <h3>24x7 Helpline Support</h3>
        <p>Instant ambulance dispatch when you call the registered <a title="Ambulance Service In Pune" href="{{ url('/') }}"><strong>Pune ambulance number.</strong></a></p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/dispatch.avif') }}" alt="Smart Dispatch System" title="Pune Ambulance Number in Pune">
      <div class="card-content">
        <h3>Smart Dispatch System</h3>
        <p>Automatically assigns the nearest ambulance based on your location and case urgency.</p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/call.webp') }}" alt="Emergency Call Guidance" title="Pune Ambulance Number in Pune">
      <div class="card-content">
        <h3>Emergency Call Guidance</h3>
        <p>Trained phone operators assist with first-aid instructions until help arrives.</p>
      </div>
    </div>
  </div>

</div>

{{-- Floating Call Button --}}
<a href="tel:+917888021021" class="stt">
  <i class="fa fa-phone fa-spin" style="font-size: 35px; margin-top: 11px; color: #fff"></i>
</a>

@endsection
