@extends('layout.frontend.app')

@section('title', 'Air Ambulance Service in Pune | 24/7 Emergency Medical Flight - Urgecare')

@section('meta')
<meta name="description" content="Urgecare offers reliable and fast Air Ambulance Service in Pune, providing 24/7 emergency medical support, Transport, and critical care when every second counts.">
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
  <img src="{{ asset('Urgecare/images_webp/images/Air-Ambulance.webp') }}" alt="Air Ambulance Service in Pune" />
</div>

<div class="container">

  {{-- Intro Section --}}
  <section class="about-section">
    <div class="about-text" data-aos="fade-right">
      <h1>Air Ambulance Service in Pune</h1>
      <p style="text-align: justify;">
        <span class="highlight"><a title="Air Ambulance Service in Pune" href="https://simple.wikipedia.org/wiki/Air_ambulances"><strong>Air Ambulance Service in Pune</strong></a></span> offers the fastest way to transport critical patients across long distances. Our 
        <a title="Air Ambulance Service in Pune" href="{{ url('/') }}" class="highlight"><strong>Air Ambulance Service in Pune</strong></a> is equipped with ICU-level care and expert medical staff to ensure patient safety during flight.
      </p>
      <p style="text-align: justify;">
        We operate both helicopters and fixed-wing aircraft, providing end-to-end medical transport in emergency scenarios requiring swift action.
      </p>
    </div>
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/air.webp') }}" title="Air Ambulance Service in Pune" alt="Air Ambulance Service in Pune" />
    </div>
  </section>

  {{-- What We Offer --}}
  <h2 style="margin-top: 40px; text-align:center;">What We Offer – Best <a title="Air Ambulance Service in Pune" href="https://www.reddit.com/user/poojaairrescuers/comments/18xdjj5/air_ambulance_services_in_pune/" class="highlight"><strong>Air Ambulance Service in Pune</strong></a></h2>
  
  <div class="cards">
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/aircraft-icu.webp') }}" alt="Emergency Air Transfer" title="Air Ambulance Service in Pune">
      <div class="card-content">
        <h3>Emergency Air Transfer</h3>
        <p style="text-align: justify;">When every second counts, our <a title="Air Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/The_Air_Ambulance_Service"><strong>Air Ambulance Service in Pune</strong></a> offers rapid airlifting of patients from remote or crowded areas to top-tier hospitals within or outside Pune.</p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/air-paramedics.webp') }}" alt="Neonatal and Pediatric Transport" title="Air Ambulance Service in Pune">
      <div class="card-content">
        <h3>Neonatal and Pediatric Transport</h3>
        <p style="text-align: justify;">We offer safe air transportation for infants and children with special care by pediatric specialists and neonatal equipment.</p>
      </div>
    </div>
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/airport-coordination.webp') }}" alt="International Medical Evacuation" title="Air Ambulance Service in Pune">
      <div class="card-content">
        <h3>International Medical Evacuation</h3>
        <p style="text-align: justify;">We provide international <a title="Air Ambulance Service in Pune" href="https://www.reddit.com/user/poojaairrescuers/comments/18xdjj5/air_ambulance_services_in_pune/"><strong>air ambulance service from Pune</strong></a>, handling all logistics including visas, air permits, and in-flight medical support.</p>
      </div>
    </div>
  </div>

  {{-- Who Needs Air Ambulance --}}
  <h3 style="margin-top: 40px;">Who Needs <a title="Air Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/The_Air_Ambulance_Service"><strong>Air Ambulance in Pune?</strong></a></h3>
  <ul class="key-points"> 
    <li><i class="fa fa-arrow-right"></i> Critical ICU patients needing transfer to specialized hospitals</li>
    <li><i class="fa fa-arrow-right"></i> Accident victims requiring urgent airlift</li>
    <li><i class="fa fa-arrow-right"></i> Elderly patients unable to travel by road</li>
    <li><i class="fa fa-arrow-right"></i> Patients needing quick intercity or interstate transfer</li>
    <li><i class="fa fa-arrow-right"></i> International repatriation or medical tourism cases</li>
  </ul>
  
  {{-- Why Choose Us --}}
  <section class="about-section">
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/air3.webp') }}" title="Air Ambulance Service in Pune" alt="Air Ambulance Service in Pune" />
    </div>
    <div class="about-text" data-aos="fade-right">
      <h4>Why Choose Our <a title="Air Ambulance Service in Pune" href="{{ url('/contact-us') }}"><strong>Air Ambulance in Pune?</strong></a></h4>
      <p style="text-align: justify;">
        <span class="highlight"><a title="Air Ambulance Service in Pune" href="https://simple.wikipedia.org/wiki/Air_ambulances"><strong>Our Air Ambulance Service in Pune stands out because of our:</strong></a></span> offers the fastest way to transport critical patients across long distances. Our 
        <a title="Air Ambulance Service in Pune" href="{{ url('/services') }}" class="highlight"><strong>Air Ambulance Service in Pune</strong></a> is equipped with ICU-level care and expert medical staff to ensure patient safety during flight.
      </p>
      <ul class="key-points"> 
        <li><i class="fa fa-arrow-right"></i> 24x7 Availability for critical emergencies</li>
        <li><i class="fa fa-arrow-right"></i> Highly Experienced Medical Team on board</li>
        <li><i class="fa fa-arrow-right"></i> ICU-Equipped Aircraft with ventilator, oxygen, defibrillator, and monitors</li>
        <li><i class="fa fa-arrow-right"></i> Pan India & International Reach</li>
        <li><i class="fa fa-arrow-right"></i> Fast Ground-to-Air Coordination</li>
      </ul>
      <p style="text-align: justify;">
        We provide the fastest <a title="Air Ambulance Service in Pune" href="https://simple.wikipedia.org/wiki/Air_ambulance"><strong>air ambulance in Pune</strong></a> with smooth coordination between hospitals, doctors, and family members to ensure uninterrupted care during the journey.
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
