@extends('layout.frontend.app')

@section('title', 'Ambulance Service in Pune | 24/7 ICU & Emergency Ambulance')

@section('meta')
<meta name="description" content="Urgecare offers 24/7 ambulance service in Pune and nationwide. ICU, oxygen & emergency ambulance available within 15 minutes. Call now. Including air, train, ICU, private and emergency ambulance services with dedicated ambulance number.">
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

  /* CTA */
  .cta-section { padding: 40px 20px; text-align: center; background-color: #ccc; }
  .cta-section h2 { font-size: 1.8rem; color: #0066cc; font-weight: 600; margin-bottom: 20px; }
  .cta-section p { font-size: 1.1rem; color: #000; max-width: 800px; margin: 0 auto; line-height: 1.6; }
  @media (min-width: 768px) {
    .cta-section h2 { font-size: 2rem; }
    .cta-section p  { font-size: 1.2rem; }
  }
</style>
@endsection

@section('content')

{{-- Banner --}}
<div class="banner">
  <img src="{{ asset('Urgecare/images_webp/images/search-bg.webp') }}" alt="Ambulance Service In Pune" />
</div>

@include('frontend.partials.location_access_button')

<div class="container">

  {{-- About / Intro --}}
  <section class="about-section">
    <div class="about-text" data-aos="fade-right">
      <h1>🚑 Reliable and Fast
        <a title="Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/Ambulance" class="highlight">
          <strong>Ambulance Service In Pune</strong>
        </a>
      </h1>
      <p>
        Looking for a trustworthy and quick response
        <a title="Ambulance Service in Pune" href="{{ url('/services') }}"><strong>Ambulance Service In Pune?</strong></a>
        When it comes to medical emergencies, every second counts. Having access to a professional and well-equipped
        <a title="Ambulance Service in Pune" href="{{ url('/urgecare-services') }}" class="highlight"><strong>Ambulance Service In Pune</strong></a>
        can make a life-saving difference. Whether it's a road accident, a critical illness, or patient transport,
        choosing the right ambulance service ensures timely care and peace of mind.
      </p>
    </div>
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/ambulance-service-in-pune1.webp') }}"
           title="Ambulance Service in Pune"
           alt="Ambulance Service In Pune" />
    </div>
  </section>

  {{-- Why Choose --}}
  <h2 style="margin-top:40px; text-align:center;">
    Why Choose a Professional
    <a title="Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/102_(ambulance_service)" class="highlight">
      <strong>Ambulance Service in Pune?</strong>
    </a>
  </h2>
  <p style="text-align:center;">
    In a city like Pune, where traffic congestion and long distances can delay medical help, a reliable
    <a title="Ambulance Service in Pune" href="{{ url('/emergency-ambulance') }}" class="highlight">
      <strong>Ambulance Service in Pune</strong>
    </a> is vital.
    <br>Here are some reasons to opt for a trusted provider:
  </p>

  {{-- Cards --}}
  <div class="cards">
    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/Version-2.webp') }}" alt="BLS Ambulance" title="Ambulance Service In Pune">
      <div class="card-content">
        <h3>24/7 Availability</h3>
        <p>
          Emergencies don't follow a schedule. A professional
          <a title="Ambulance Service In Pune" href="https://en.wikipedia.org/wiki/102_(ambulance_service)">
            <strong>Ambulance Service In Pune</strong>
          </a>
          is available round the clock, ensuring help is just a call away—anytime, anywhere.
        </p>
      </div>
    </div>

    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/key1c2.webp') }}" alt="ACLS Ambulance" title="Ambulance Service In Pune">
      <div class="card-content">
        <h3>Trained Medical Staff</h3>
        <p>
          Top
          <a title="Ambulance Service In Pune" href="https://www.reddit.com/r/pune/comments/qysq5x/ambulance_fares_in_pune/">
            <strong>ambulance services in Pune</strong>
          </a>
          have paramedics and doctors on board who can provide immediate life support,
          basic first aid, or advanced cardiac care.
        </p>
      </div>
    </div>

    <div class="card">
      <img src="{{ asset('Urgecare/images_webp/images/road-ambulance.webp') }}" alt="Patient Transport" title="Ambulance Service In Pune">
      <div class="card-content">
        <h3>GPS Enabled &amp; Fast Response</h3>
        <p>
          Modern ambulances come equipped with GPS tracking systems, enabling fast and efficient routing to your location.
          A well-equipped
          <a title="Ambulance Service In Pune" href="https://simple.wikipedia.org/wiki/Air_ambulances">
            <strong>Ambulance Service In Pune</strong>
          </a>
          ensures minimum response time.
        </p>
      </div>
    </div>
  </div>

  {{-- Types --}}
  <h3 style="margin-top:40px; text-align:center;">
    Types of
    <a title="Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/Emergency_medical_services">
      <strong>Ambulance Service in Pune</strong>
    </a>
  </h3>
  <p style="text-align:center;">
    Different situations demand different types of ambulances. Reputed
    <a title="Ambulance Service In Pune" href="https://www.reddit.com/r/pune/comments/qysq5x/ambulance_fares_in_pune/">
      <strong>Ambulance Service in Pune</strong>
    </a>
    providers offer:
  </p>
  <br>
  <ul class="key-points">
    <li><i class="fa fa-arrow-right"></i> <strong>Basic Life Support (BLS) Ambulance:</strong> Ideal for non-critical patient transport with essentials like a stretcher, oxygen cylinder, and first-aid kit.</li>
    <li><i class="fa fa-arrow-right"></i> <strong>Advanced Life Support (ALS) Ambulance:</strong> Equipped with ventilators, defibrillators, and ICU setups, suitable for patients in critical condition.</li>
    <li><i class="fa fa-arrow-right"></i> <strong>Neonatal and Pediatric Ambulance:</strong> Specially designed for infants and young children, these ambulances offer customized medical support.</li>
    <li><i class="fa fa-arrow-right"></i> <strong>Dead Body Freezer Van:</strong> Used for respectfully transporting deceased persons with temperature control.</li>
  </ul>

  {{-- How to Book --}}
  <section class="about-section">
    <div class="about-image" data-aos="fade-left">
      <img src="{{ asset('Urgecare/images_webp/images/ambulance-service-in-pune.webp') }}" alt="Ambulance Service In Pune" />
    </div>
    <div class="about-text" data-aos="fade-right">
      <h4 style="margin-top:40px;">
        How to Book an
        <a title="Ambulance Service in Pune" href="https://www.reddit.com/r/ems/comments/1irhws6/comparison_of_ambulance_services/">
          <strong>Ambulance Service in Pune</strong> Instantly?
        </a>
      </h4>
      <p>
        Booking a reliable
        <a title="Ambulance Service in Pune" href="{{ url('/contact-us') }}"><strong>Ambulance Service in Pune</strong></a>
        is now simple and quick. Most services offer:
      </p>
      <ul class="key-points">
        <li><i class="fa fa-arrow-right"></i> 24/7 helpline numbers</li>
        <li><i class="fa fa-arrow-right"></i> Easy online booking portals</li>
        <li><i class="fa fa-arrow-right"></i> Quick mobile app access</li>
        <li><i class="fa fa-arrow-right"></i> Instant location-based dispatch</li>
      </ul>
    </div>
  </section>

  {{-- Top Features --}}
  <h2 style="margin-top:40px; text-align:center;">
    Top Features to Look For in a Trusted
    <a title="Ambulance Service in Pune" href="https://en.wikipedia.org/wiki/108_(emergency_telephone_number)">
      <strong>Ambulance Service in Pune</strong>
    </a>
  </h2>
  <p style="text-align:center;">When selecting an ambulance, make sure it has:</p>
  <br>
  <ul class="key-points">
    <li><i class="fa fa-arrow-right"></i> Trained medical professionals</li>
    <li><i class="fa fa-arrow-right"></i> Onboard medical equipment</li>
    <li><i class="fa fa-arrow-right"></i> Oxygen supply and ventilators (if needed)</li>
    <li><i class="fa fa-arrow-right"></i> Clean, hygienic interiors</li>
    <li><i class="fa fa-arrow-right"></i> Affordable and transparent pricing</li>
    <li><i class="fa fa-arrow-right"></i> Insurance tie-ups (where applicable)</li>
  </ul>

</div>{{-- /container --}}

<br>

{{-- CTA --}}
<div class="cta-section">
  <h2>Affordable Emergency Medical Support in Pune</h2>
  <p>
    A good
    <a title="Ambulance Service In Pune" href="{{ url('/partner-with-us') }}">
      <strong>Ambulance Service in Pune</strong>
    </a>
    doesn't have to be expensive. Many providers offer budget-friendly packages or tie-ups with hospitals and NGOs
    for reduced costs, ensuring every patient gets timely help regardless of their financial background.
  </p>
</div>

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
