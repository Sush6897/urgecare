@extends('layout.frontend.app')

@section('title', 'Private Ambulance Service Near Me in Pune | 24/7 Medical Transport - Urgecare')

@section('meta')
<meta name="description" content="Get fast and reliable Private Ambulance Service Near Me in Pune with Urgecare.in. Our emergency medical transports ensures safety, speeds, and expert care 24/7.">
@endsection

@section('styles')
{{-- AOS CSS --}}
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
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

  /* About Section */
  .about-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 60px 20px;
    margin-top: 50px;
    margin-bottom: 50px;
    flex-wrap: wrap;
    background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
  }
  .about-text {
    flex: 1;
    max-width: 600px;
    padding: 20px;
  }
  .about-text h1 {
    font-size: 32px;
    margin-bottom: 15px;
    color: #222;
  }
  .about-text p {
    font-size: 16px;
    color: #444;
    line-height: 1.6;
  }
  .about-image {
    flex: 1;
    text-align: center;
    padding: 20px;
  }
  .about-image img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }
  @media (max-width: 768px) {
    .about-section {
      flex-direction: column;
      text-align: center;
    }
    .about-text h3 {
      font-size: 26px;
    }
    .about-text p {
      font-size: 15px;
    }
  }

  /* Key Points */
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
  <img src="{{ asset('Urgecare/images_webp/images/amb banner.webp') }}" alt="Private Ambulance Service Near Me in Pune" />
</div>

<div class="container">

  {{-- Intro Section --}}
  <section class="about-section">
    <div class="about-text" data-aos="fade-right">
      <h1>Private Ambulance Service Near Me in Pune</h1>  
      <p style="text-align: justify;">
        Looking for a reliable <span class="highlight"><a title="Private Ambulance Service Near Me in Pune" href="https://en.wikipedia.org/wiki/Ambulance">Private Ambulance Service Near Me in Pune</a></span>? Whether it's an emergency or non-emergency medical transfer, our <a title="Private Ambulance Service Near Me in Pune" href="https://www.reddit.com/r/pune/comments/101ogjc/wheelchairaccessible_cabambulance_services_for/"><strong>private ambulance services in Pune</strong></a> are available 24x7 to ensure fast, safe, and comfortable transportation for patients. With highly trained paramedics, ICU-equipped vehicles, and GPS-enabled tracking, we are the trusted name for emergency medical support in and around Pune.
      </p>
      <p style="text-align: justify;">
        Our private ambulances are available 24/7 and are equipped with advanced medical equipment. Rely on our trained professionals and high standards of hygiene for a safe medical journey.
      </p>
    </div>
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/private-ambulance-service-near-me-in-pune.webp') }}" alt="Private Ambulance Service Near Me in Pune" title="Private Ambulance Service Near Me in Pune" />
    </div>
  </section>

  {{-- What We Offer --}}
  <h2 style="margin-top: 40px; text-align:center;">What We Offer – Best <a title="Private Ambulance Service Near Me in Pune" href="https://www.reddit.com/r/AskUK/comments/1bv15w5/how_do_private_ambulances_work/" class="highlight"><strong>Private Ambulance Options</strong></a></h2>
  
  <div class="cards">
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/vip.webp') }}" alt="VIP Ambulance Vans" title="Private Ambulance Service Near Me in Pune">
      <div class="card-content">
        <h3>VIP Ambulance Vans</h3>
        <p>Spacious and fully sanitized vans offering privacy and care for patients.</p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/img32.webp') }}" alt="Dedicated Medical Escorts" title="Private Ambulance Service Near Me in Pune">
      <div class="card-content">
        <h3>Dedicated Medical Escorts</h3>
        <p>Trained attendants available for every trip to ensure complete medical supervision.</p>
      </div>
    </div>
    <div class="card"> 
      <img src="{{ asset('Urgecare/images_webp/images/img33.webp') }}" alt="On-Demand Booking" title="Private Ambulance Service Near Me in Pune">
      <div class="card-content">
        <h3>On-Demand Booking</h3>
        <p>Private ambulances available at short notice through our customer service or app.</p>
      </div>
    </div>
  </div>

  {{-- 24x7 Emergency & Non-Emergency --}}
  <h3 style="margin-top: 40px;">24x7 Emergency & Non-Emergency Ambulance Service</h3>
  <p>Our <span class="highlight"><a title="Private Ambulance Service Near Me in Pune" href="https://www.reddit.com/r/NewToEMS/comments/1jg4shk/working_for_a_private_ambulance_service_vs_public/"><strong>Private Ambulance Service Near Me in Pune</strong></a></span> caters to both emergency and planned patient transfers. We ensure rapid response time and prioritize patient comfort and medical safety during every ride.</p>
  
  <ul class="key-points"> 
    <li><i class="fa fa-arrow-right"></i> ICU & Ventilator Ambulance</li>
    <li><i class="fa fa-arrow-right"></i> Cardiac Ambulance</li>
    <li><i class="fa fa-arrow-right"></i> Dead Body Freezer Ambulance</li>
    <li><i class="fa fa-arrow-right"></i> Patient Transfer to Hospital/Residence</li>
    <li><i class="fa fa-arrow-right"></i> Event Medical Support</li>
  </ul>
  
  {{-- Why Choose Us --}}
  <section class="about-section">
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/private-ambulance-service-near-me-in-pune1.webp') }}" alt="Private Ambulance Service Near Me in Pune" title="Private Ambulance Service Near Me in Pune" />
    </div>
    <div class="about-text" data-aos="fade-right">
      <h4>Why Choose Our <a title="Private Ambulance Service Near Me in Pune" href="{{ url('/contact-us') }}"><strong>Private Ambulance Service Near Me in Pune</strong></a></h4>
      <p style="text-align: justify;">
        We stand out because of our commitment to quality, hygiene, punctuality, and trained personnel. Here's why thousands trust our  
        <span class="highlight"><a title="Private Ambulance Service Near Me in Pune" href="https://simple.wikipedia.org/wiki/Air_ambulances"><strong>Private Ambulance Service Near Me in Pune:</strong></a></span>
      </p>
      <ul class="key-points"> 
        <li><i class="fa fa-arrow-right"></i> Fast Response Time</li>
        <li><i class="fa fa-arrow-right"></i> Trained Paramedical Team</li>
        <li><i class="fa fa-arrow-right"></i> Affordable and Transparent Pricing</li>
        <li><i class="fa fa-arrow-right"></i> Clean & Sanitized Vehicles</li>
        <li><i class="fa fa-arrow-right"></i> Hospital & Home Pick-up/Drop</li>
      </ul>
      <p style="text-align: justify;">
        Whether it's a hospital transfer or intercity medical travel, our <span class="highlight"><a title="Private Ambulance Service Near Me in Pune" href="https://simple.wikipedia.org/wiki/Air_ambulances"><strong>Private Ambulance Service Near Me in Pune:</strong></a></span> ensures a smooth journey with expert medical supervision.
      </p>
    </div>
  </section>

</div>

{{-- Floating Call Button --}}
<a href="tel:+917888021021" class="stt">
  <i class="fa fa-phone fa-spin" style="font-size: 35px; margin-top: 11px; color: #fff"></i>
</a>

@endsection

@section('scripts')
{{-- AOS Animation JS --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1200,
  });
</script>
@endsection
