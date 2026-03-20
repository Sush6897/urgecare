@extends('layout.frontend.app')
@section('content')

<section class="page-title py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Our Services</h1>
                </div>
            </div>
        </div>
    </section>



    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('/frontend/assets/images/emergecy.jpg')}}" class="img-fluid" alt="Emergency Ambulance Services">
                </div>
                <div class="col-md-6">
                    <h2 class="sec-title mb-3">Emergency Ambulance Services</h2>
                    <p class="text-justify">At Urgecare, we provide prompt and reliable emergency ambulance services in
                        Pune. Our fleet of
                        well-equipped ambulances, staffed by trained medical professionals, ensures swift response and
                        safe transportation during critical situations. We offer various types of ambulances, including
                        basic life support (BLS), advanced life support (ALS), and critical care units (CCU), tailored
                        to meet different medical needs.</p>
                </div>
                
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <img src="{{asset('/frontend/assets/images/non-emergency.jpg')}}" class="img-fluid"
                        alt="Non-Emergency Medical Transportation">
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="sec-title mb-3">Non-Emergency Medical Transportation</h2>
                    <p class="text-justify">We understand that not all medical transportation needs are emergencies.
                        That's why we also offer
                        non-emergency medical transportation services. Whether it's transportation for medical
                        appointments, hospital discharges, or intercity transfers, our team ensures a comfortable and
                        seamless experience. Our non-emergency ambulances are equipped with necessary medical equipment
                        and staffed by trained personnel to cater to non-critical medical transportation requirements.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('/frontend/assets/images/patient-care.jpg')}}" class="img-fluid" alt="Specialized Patient Care">
                </div>
                <div class="col-md-6">
                    <h2 class="sec-title mb-3">Specialized Patient Care</h2>
                    <p class="text-justify">Urgecare is committed to providing specialized patient care for individuals
                        with unique medical
                        needs. We offer personalized services for patients with disabilities, elderly individuals, and
                        those requiring additional assistance during transportation. Our medical staff undergo specific
                        training to handle special cases, ensuring that patients receive the utmost care, comfort, and
                        support throughout the journey.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <img src="{{asset('/frontend/assets/images/medical-escorts.jpg')}}" class="img-fluid" alt="Medical Escort Services">
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="sec-title mb-3">Medical Escort Services</h2>
                    <p class="text-justify">For patients requiring medical support during travel, we provide medical
                        escort services. Our
                        experienced medical professionals accompany patients during commercial flights, ensuring their
                        safety, comfort, and continuity of care throughout the journey. From administering medications
                        to monitoring vital signs, our medical escorts ensure that patients receive the necessary
                        medical attention and support.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('/frontend/assets/images/event-medical.jpg')}}" class="img-fluid" alt="Event Medical Coverage">
                </div>
                <div class="col-md-6">
                    <h2 class="sec-title mb-3">Event Medical Coverage</h2>
                    <p class="text-justify">Urgecare offers comprehensive event medical coverage services for public
                        gatherings, sports
                        events, concerts, and festivals. We deploy a team of medical professionals, equipped with mobile
                        medical units, to provide on-site emergency medical services. Our goal is to ensure the safety
                        and well-being of attendees by promptly responding to any medical emergencies that may arise
                        during the event.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <img src="{{asset('/frontend/assets/images/Medical-Equip-Rent.jpg')}}" class="img-fluid" alt="Medical Equipment Rental">
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="sec-title mb-3">Medical Equipment Rental</h2>
                    <p class="text-justify">Urgecare offers medical equipment rental services, providing individuals
                        with temporary access to
                        essential medical equipment. Whether it's a wheelchair, crutches, or other medical aids, we
                        ensure that patients have the necessary equipment to improve mobility and enhance their quality
                        of life during the recovery process.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('/frontend/assets/images/train-plane.jpg')}}" class="img-fluid" alt="Train/Rail Ambulance Services">
                </div>
                <div class="col-md-6">
                    <h2 class="sec-title mb-3">Train/Rail Ambulance Services</h2>
                    <p class="text-justify">Understanding the need for long-distance medical transportation, Urgecare
                        also offers train
                        ambulance services. We arrange for comfortable and safe transportation of patients requiring
                        medical assistance over long distances. Our dedicated medical team, equipped with necessary
                        medical equipment, accompanies patients during the train journey, ensuring their well-being and
                        providing any required medical care along the way.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <img src="{{asset('/frontend/assets/images/air-amb.jpg')}}" class="img-fluid" alt="Air Ambulance Services">
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="sec-title mb-3">Air Ambulance Services</h2>
                    <p class="text-justify">In critical situations that require immediate transportation over long
                        distances, Urgecare
                        provides air ambulance services. We work closely with leading air ambulance providers to
                        facilitate swift and efficient air transportation for patients. Our air ambulance services
                        include arranging medical staff, specialized equipment, and ensuring a smooth transition from
                        ground to air transportation, prioritizing the well-being and safety of the patient.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('/frontend/assets/images/dead-body-transfer.jpg')}}" class="img-fluid" alt="Dead Body Transfer Services">
                </div>
                <div class="col-md-6">
                    <h2 class="sec-title mb-3">Dead Body Transfer Services</h2>
                    <p class="text-justify">We transfer dead bodies to the cremation point with utmost care.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <img src="{{asset('/frontend/assets/images/freezer.jpg')}}" class="img-fluid" alt="Freezer Box for Dead Body Storage">
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="sec-title mb-3">Freezer Box for Dead Body Storage</h2>
                    <p class="text-justify">We provide freezer boxes with equipped standards so the dead body can be
                        stored in order to
                        prevent further decay until the final religious rituals are performed.</p>
                </div>
            </div>
        </div>
    </section>



@endsection