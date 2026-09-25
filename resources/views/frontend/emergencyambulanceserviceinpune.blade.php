@extends('layout.frontend.app')

@section('title', 'Emergency Ambulance Service In Pune | 24/7 ICU & ALS Ambulance - Urgecare')

@section('meta')
<meta name="description" content="Get fast and reliable Emergency Ambulance Service in Pune with Urgecare.in. Our 24/7 ambulance supports ensures quick responses and safe transports across Pune.">
@endsection

@section('styles')
{{-- AOS CSS --}}
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
{{-- Google Font --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">

<style>
  .highlight { color: #FF3D00; }

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
  .card:hover { transform: translateY(-5px); }
  .card img { width: 100%; height: 180px; object-fit: cover; }
  .card-content { padding: 15px; }
  .card-content h3 { font-size: 1.2rem; margin-bottom: 10px; color: #1d3557; }
  .card-content p { font-size: 1rem; }
  @media (max-width: 768px) { .card { flex: 1 1 100%; } }

  /* Banner */
  .banner { width: 100%; overflow: hidden; height: 300px; margin-bottom: 40px; }
  .banner img { width: 100%; height: auto; object-fit: cover; display: block; }
  @media (max-width: 768px) {
    .banner { height: auto; max-height: 200px; margin-bottom: 40px; }
    .banner img { height: auto; }
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
    background-color: #000;
    animation: glow 1s infinite alternate;
    z-index: 100;
  }
  @keyframes glow {
    from { box-shadow: 0 0 5px -5px red; }
    to   { box-shadow: 0 0 5px 13px red; }
  }

  /* About section */
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
  .about-text { flex: 1; max-width: 600px; padding: 20px; }
  .about-text h1 { font-size: 32px; margin-bottom: 15px; color: #222; }
  .about-text p { font-size: 16px; color: #444; line-height: 1.6; }
  .about-image { flex: 1; text-align: center; padding: 20px; }
  .about-image img { max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
  @media (max-width: 768px) {
    .about-section { flex-direction: column; text-align: center; }
    .about-text h3 { font-size: 26px; }
    .about-text p  { font-size: 15px; }
  }

  /* Key points */
  .key-points { list-style: none; padding: 0; margin: 0; }
  .key-points li { margin-bottom: 10px; font-size: 16px; position: relative; padding-left: 25px; }
  .key-points li i { position: absolute; left: 0; color: #007bff; }
</style>
@endsection

@section('content')

{{-- Banner --}}
<div class="banner">
  <img src="{{ asset('Urgecare/images_webp/images/ambulance-banner.webp') }}" alt="Emergency Ambulance Service In Pune" />
</div>

<div class="container">

  {{-- Intro / About --}}
  <section class="about-section">
    <div class="about-text" data-aos="fade-right">
      <h1>Emergency Ambulance Service In Pune</h1>
      <p style="text-align:justify;">
        Looking for a reliable and fast
        <span class="highlight">
          <a title="Emergency Ambulance Service In Pune" href="https://en.wikipedia.org/wiki/Emergency_medical_services">Emergency Ambulance Service In Pune</a>
        </span>?
        Your search ends here. We offer 24×7 advanced ambulance services across Pune, equipped with ICU-level medical care,
        trained paramedics, and GPS-enabled vehicles to ensure you or your loved ones get immediate attention and care in critical moments.
      </p>
      <p style="text-align:justify;">
        Our services are designed to meet emergency needs round the clock. Whether it's a road accident, sudden illness,
        or patient transfer, our
        <span class="highlight">
          <a title="Emergency Ambulance Service In Pune" href="https://en.wikipedia.org/wiki/108_(emergency_telephone_number)">Emergency Ambulance Service In Pune</a>
        </span>
        is just a call away, equipped with all necessary medical equipment and trained professionals.
      </p>
    </div>
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/emergency-ambulance-service-in-pune.webp') }}"
           title="Emergency Ambulance Service In Pune"
           alt="Emergency Ambulance Service In Pune" />
    </div>
  </section>

  {{-- Types --}}
  <h2 style="margin-top:40px; text-align:center;">
    Types of
    <a title="Emergency Ambulance Service In Pune"
       href="https://www.reddit.com/r/pune/comments/w46tg6/people_whove_called_an_ambulance_at_home_what/"
       class="highlight">
      <strong>Emergency Ambulance Service In Pune</strong>
    </a>
  </h2>

  <div class="cards">
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/amb banner.webp') }}" alt="BLS Ambulance" title="Emergency Ambulance Service In Pune">
      <div class="card-content">
        <h3>Basic Life Support (BLS)</h3>
        <p>Our BLS units offer non-critical patient transport with trained EMTs for safe transfers within Pune.</p>
      </div>
    </div>

    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/key2c3.webp') }}" alt="ACLS Ambulance" title="Emergency Ambulance Service In Pune">
      <div class="card-content">
        <h3>Advanced Cardiac Life Support (ACLS)</h3>
        <p>Equipped for emergencies requiring defibrillators, cardiac monitors, and emergency medications.</p>
      </div>
    </div>

    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/road-ambulance.webp') }}" alt="Patient Transport" title="Emergency Ambulance Service In Pune">
      <div class="card-content">
        <h3>Patient Transport Ambulance</h3>
        <p>Designed for inter-hospital or home-to-hospital transfers for stable patients requiring care.</p>
      </div>
    </div>
  </div>

  {{-- Why Choose --}}
  <h3 style="margin-top:40px;">
    Why Choose Our
    <a title="Emergency Ambulance Service In Pune" href="https://simple.wikipedia.org/wiki/Emergency_medical_services">
      <strong>Emergency Ambulance Service In Pune?</strong>
    </a>
  </h3>
  <p>
    When every second counts, trust the most responsive
    <a title="Emergency Ambulance Service In Pune" href="{{ url('/services') }}">
      <strong>Emergency Ambulance Service In Pune</strong>
    </a>
    that ensures:
  </p>
  <ul class="key-points">
    <li><i class="fa fa-arrow-right"></i> <strong>Rapid Response Time:</strong> Our ambulances reach you within minutes across Pune city.</li>
    <li><i class="fa fa-arrow-right"></i> <strong>Fully Equipped Fleet:</strong> We provide Basic Life Support (BLS), Advanced Life Support (ALS), ICU ambulances, and neonatal care units.</li>
    <li><i class="fa fa-arrow-right"></i> <strong>Expert Medical Team:</strong> Trained doctors, nurses, and paramedics accompany every emergency call.</li>
    <li><i class="fa fa-arrow-right"></i> <strong>24×7 Availability:</strong> Day or night, rain or shine, our emergency ambulance services are always ready.</li>
  </ul>

  {{-- How to Book --}}
  <section class="about-section">
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/emergency-ambulance-service-in-pune1.webp') }}"
           title="Emergency Ambulance Service In Pune"
           alt="Emergency Ambulance Service In Pune" />
    </div>
    <div class="about-text" data-aos="fade-right">
      <h4>
        Book an
        <a title="Emergency Ambulance Service In Pune" href="{{ url('/contact-us') }}">
          <strong>Emergency Ambulance Service In Pune</strong>
        </a>
      </h4>
      <p style="text-align:justify;">Just call our 24×7 helpline or book online in seconds. We ensure:</p>
      <ul class="key-points">
        <li><i class="fa fa-arrow-right"></i> Fast GPS tracking and live ambulance status updates</li>
        <li><i class="fa fa-arrow-right"></i> Real-time coordination with hospitals</li>
        <li><i class="fa fa-arrow-right"></i> Cashless and insurance-based payment options</li>
      </ul>
      <p style="text-align:justify;">
        We provide the fastest air ambulance in Pune with smooth coordination between hospitals, doctors, and family
        members to ensure uninterrupted care during the journey.
      </p>
    </div>
  </section>

</div>{{-- /container --}}

{{-- Floating Call Button --}}
<a href="tel:+917888021021" class="stt">
  <i class="fa fa-phone fa-spin" style="font-size:35px; margin-top:11px; color:#fff;"></i>
</a>

@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1200 });
</script>
@endsection
