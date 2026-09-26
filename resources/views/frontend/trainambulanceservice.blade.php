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

@include('frontend.partials.location_access_button')

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
