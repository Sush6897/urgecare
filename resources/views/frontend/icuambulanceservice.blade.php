@extends('layout.frontend.app')

@section('title', 'ICU Ambulance Service in Pune | Ventilator & Critical Care 24/7')

@section('meta')
<meta name="description" content="Need ICU ambulance service in Pune and nationwide. Call now for ventilator-equipped ambulance with doctor support & fast response within 15 minutes. 24/7 available.">
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
    height: 370px;
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

  /* CTA Section */
  .cta-section {
    padding: 40px 20px;
    text-align: center;
    background-color: #f1f3f5;
    border-radius: 8px;
    margin-bottom: 40px;
  }
  .cta-section h2 {
    font-size: 1.8rem;
    color: #0066cc;
    font-weight: 600;
    margin-bottom: 20px;
  }
  .cta-section p {
    font-size: 1.1rem;
    color: #000;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.6;
  }
  @media (min-width: 768px) {
    .cta-section h2 {
      font-size: 2rem;
    }
    .cta-section p {
      font-size: 1.2rem;
    }
  }
</style>
@endsection

@section('content')

{{-- Banner --}}
<div class="banner"> 
  <img src="{{ asset('Urgecare/images_webp/images/7 banner.webp') }}" title="ICU Ambulance Service in Pune" alt="Ambulance Service In Pune" />
</div>

@include('frontend.partials.location_access_button')

<div class="container">

  {{-- Intro Section --}}
  <section class="about-section">
    <div class="about-text" data-aos="fade-right">
      <h1>Reliable and Trusted <a title="ICU Ambulance Service in Pune" href="{{ url('/services') }}" class="highlight"><strong>ICU Ambulance Service in Pune</strong></a></h1>
      <p>When emergencies strike, every second counts. Whether it's a critical accident, a medical emergency, or the need for hospital transfers, having access to a dependable 
      <a title="ICU Ambulance Service in Pune" href="{{ url('/services') }}"><strong>ICU Ambulance Service in Pune</strong></a> can save lives. Pune, being a rapidly growing city, requires 
      advanced and efficient emergency services – and this is where ICU ambulances come into the picture.</p>
    </div>
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/icu-ambulance-service-in-pune.webp') }}" title="ICU Ambulance Service in Pune" alt="ICU Ambulance Service In Pune" />
    </div>
  </section>

  {{-- Benefits / Cards Section --}}
  <h2 style="margin-top: 40px; text-align:center;">Benefits of Choosing <a title="ICU Ambulance Service in Pune" href="{{ url('/services') }}" class="highlight"><strong>ICU Ambulance Service in Pune?</strong></a></h2>
  
  <div class="cards">
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/Version-2.webp') }}" alt="Round-the-Clock Availability" title="Ambulance Service In Pune">
      <div class="card-content">
        <h3>Round-the-Clock Availability</h3>
        <p>Emergencies don’t follow a schedule, and that’s why <a title="ICU Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/Ambulance"><strong>ICU Ambulance Service in Pune</strong></a> is available 24/7. Day or night, weekday or holiday – trained professionals are always ready to respond quickly and efficiently.</p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/key1c2.webp') }}" alt="Advanced Medical Equipment" title="Ambulance Service In Pune">
      <div class="card-content">
        <h3>Advanced Medical Equipment</h3>
        <p>The ambulances are furnished with state-of-the-art medical equipment to handle any emergency with precision. With facilities that mirror hospital ICUs, <a title="ICU Ambulance Service in Pune" href="https://www.reddit.com/r/india/comments/w0k81k/how_do_deal_with_the_ambulance_mafia/"><strong>ICU Ambulance Service in Pune</strong></a> ensures the patient receives uninterrupted critical care.</p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/road-ambulance.webp') }}" alt="Expert Medical Team" title="Ambulance Service In Pune">
      <div class="card-content">
        <h3>Expert Medical Team</h3>
        <p>Another major benefit of <a title="ICU Ambulance Service in Pune" href="https://www.reddit.com/r/ems/comments/1irhws6/comparison_of_ambulance_services/"><strong>ICU Ambulance Service in Pune</strong></a> is the presence of an expert medical team onboard. These professionals are well-equipped to handle complex medical conditions, administer emergency treatment, and monitor vitals en route.</p>
      </div>
    </div>
  </div>

  {{-- When Should You Call --}}
  <h3 style="margin-top: 40px; text-align:center;">When Should You Call an <a title="ICU Ambulance Service in Pune" href="{{ url('/services') }}"><strong>ICU Ambulance Service in Pune</strong></a></h3>
  <p style="text-align:center;">You should consider calling an <a title="ICU Ambulance Service in Pune" href="{{ url('/services') }}"><strong>ICU Ambulance Service in Pune</strong></a> in the following situations:</p>
  
  <ul class="key-points"> 
    <li><i class="fa fa-arrow-right"></i> When a patient is unconscious or unresponsive.</li>
    <li><i class="fa fa-arrow-right"></i> In case of severe trauma or head injuries.</li>
    <li><i class="fa fa-arrow-right"></i> For patients on ventilators or needing continuous oxygen support.</li>
    <li><i class="fa fa-arrow-right"></i> During heart attacks, strokes, or other life-threatening conditions.</li>
    <li><i class="fa fa-arrow-right"></i> When transferring critically ill patients between hospitals.</li>
  </ul>
  
  {{-- How to Book Section --}}
  <section class="about-section">
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/icu-ambulance-service-in-pune1.webp') }}" title="ICU Ambulance Service in Pune" alt="Ambulance Service In Pune" />
    </div>
    <div class="about-text" data-aos="fade-right">
      <h4 style="margin-top: 40px;">How to Book an <a title="ICU Ambulance Service in Pune" href="{{ url('/contact-us') }}"><strong>ICU Ambulance Service in Pune</strong></a></h4>
      <p>Many emergency providers in Pune now allow easy booking of ICU ambulances via phone calls or online forms. To book a trusted <a title="ICU Ambulance Service in Pune" href="{{ url('/contact-us') }}"><strong>ICU Ambulance Service in Pune</strong></a>, keep the following information ready:</p>
      <ul class="key-points"> 
        <li><i class="fa fa-arrow-right"></i> Patient details and condition</li>
        <li><i class="fa fa-arrow-right"></i> Pickup and drop location</li>
        <li><i class="fa fa-arrow-right"></i> Preferred hospital (if any)</li>
        <li><i class="fa fa-arrow-right"></i> Any special instructions</li> 
      </ul>
    </div>
  </section>

  {{-- CTA Section --}}
  <div class="cta-section">
    <h2>Conclusion: Choose the Best <a title="ICU Ambulance Service in Pune" href="{{ url('/services') }}" class="highlight"><strong>ICU Ambulance Service in Pune</strong></a></h2>
    <p>When it comes to medical emergencies, time and quality of care are critical. By choosing a reliable <a title="ICU Ambulance Service in Pune" href="{{ url('/services') }}"><strong>ICU Ambulance Service in Pune</strong></a>, you're ensuring that your loved ones receive the best possible care during transit. It's more than just a vehicle – it's a lifeline on wheels. Don't compromise in emergencies – keep contact numbers of <a title="ICU Ambulance Service in Pune" href="{{ url('/services') }}"><strong>ICU Ambulance Service in Pune</strong></a> handy at all times. It might make all the difference when seconds matter most.</p>
  </div>

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
