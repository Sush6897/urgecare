@extends('layout.frontend.app')
@section('content')

<section class="page-title py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Frequently Asked Questions</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="faq my-4">
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="accordion" id="accordionColumn1">
                        <!-- FAQ Item 1 -->
                        <div class="card">
                            <div class="card-header" id="heading1">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        What is Urgecare?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse1" class="collapse" aria-labelledby="heading1"
                                data-parent="#accordionColumn1">
                                <div class="card-body">
                                    Urgecare is an ambulance aggregator platform based in Pune, Maharashtra, India. We
                                    provide reliable
                                    and efficient emergency and non-emergency medical transportation services. Our goal
                                    is to bridge the
                                    gap in emergency care accessibility and ensure timely medical assistance reaches
                                    those in need.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 2 -->
                        <div class="card">
                            <div class="card-header" id="heading2">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                        What types of ambulance services does Urgecare offer?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse2" class="collapse" aria-labelledby="heading2"
                                data-parent="#accordionColumn1">
                                <div class="card-body">
                                    Urgecare offers a range of ambulance services to cater to different medical needs.
                                    We provide basic
                                    life support (BLS) ambulances, advanced life support (ALS) ambulances, and critical
                                    care units (CCU)
                                    equipped with advanced medical equipment and staffed by trained medical
                                    professionals.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 3 -->
                        <div class="card">
                            <div class="card-header" id="heading3">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                        How can I request an ambulance through Urgecare?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse3" class="collapse" aria-labelledby="heading3"
                                data-parent="#accordionColumn1">
                                <div class="card-body">
                                    To request an ambulance, you can contact our 24/7 helpline number or visit our
                                    website. Our dedicated
                                    team will assist you in arranging the appropriate ambulance based on your medical
                                    requirements.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 4 -->
                        <div class="card">
                            <div class="card-header" id="heading4">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                        Does Urgecare offer non-emergency medical transportation services?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse4" class="collapse" aria-labelledby="heading4"
                                data-parent="#accordionColumn1">
                                <div class="card-body">
                                    Yes, Urgecare provides non-emergency medical transportation services. Whether you
                                    need transportation
                                    for medical appointments, hospital discharges, or intercity transfers, we ensure a
                                    comfortable and
                                    seamless experience.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 5 -->
                        <div class="card">
                            <div class="card-header" id="heading5">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                        How does Urgecare ensure patient comfort during transportation?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse5" class="collapse" aria-labelledby="heading5"
                                data-parent="#accordionColumn1">
                                <div class="card-body">
                                    At Urgecare, we prioritize patient comfort. Our ambulances are equipped with
                                    features like comfortable
                                    seating, proper ventilation, temperature control, and noise reduction measures. We
                                    strive to create a
                                    safe and comfortable environment for patients throughout their journey.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 6 -->
                        <div class="card">
                            <div class="card-header" id="heading6">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
                                        Does Urgecare provide specialized care for patients with unique medical needs?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse6" class="collapse" aria-labelledby="heading6"
                                data-parent="#accordionColumn1">
                                <div class="card-body">
                                    Yes, we offer specialized care for patients with disabilities, elderly individuals,
                                    and those
                                    requiring additional assistance during transportation. Our medical staff undergo
                                    specific training to
                                    handle special cases and ensure patients receive personalized care, comfort, and
                                    support.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 7 -->
                        <div class="card">
                            <div class="card-header" id="heading7">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                                        Can Urgecare arrange medical escorts for travel by commercial flights?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse7" class="collapse" aria-labelledby="heading7"
                                data-parent="#accordionColumn1">
                                <div class="card-body">
                                    Absolutely. We provide medical escort services for patients requiring medical
                                    support during travel by
                                    commercial flights. Our experienced medical professionals accompany patients,
                                    ensuring their safety,
                                    comfort, and continuity of care throughout the journey.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 8 -->
                        <div class="card">
                            <div class="card-header" id="heading8">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse8" aria-expanded="true" aria-controls="collapse8">
                                        Does Urgecare offer event medical coverage services?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse8" class="collapse" aria-labelledby="heading8"
                                data-parent="#accordionColumn1">
                                <div class="card-body">
                                    Yes, Urgecare offers comprehensive event medical coverage services for public
                                    gatherings, sports
                                    events, concerts, and festivals. We deploy a team of medical professionals equipped
                                    with mobile
                                    medical units to provide on-site emergency medical services during events.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading11">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse11" aria-expanded="true" aria-controls="collapse11">
                                        Does Urgecare provide air ambulance services?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse11" class="collapse" aria-labelledby="heading11"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    Yes, in critical situations that require immediate transportation over long
                                    distances, Urgecare
                                    provides air ambulance services. We work closely with leading air ambulance
                                    providers to facilitate
                                    swift and efficient air transportation for patients. Our air ambulance services
                                    include arranging
                                    medical staff, specialized equipment, and ensuring a smooth transition from ground
                                    to air
                                    transportation, prioritizing the well-being and safety of the patient.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading12">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse12" aria-expanded="true" aria-controls="collapse12">
                                        How can I rent medical equipment from Urgecare?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse12" class="collapse" aria-labelledby="heading12"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    Urgecare provides medical equipment rental services, allowing individuals to
                                    temporarily access
                                    essential medical equipment. You can contact us to inquire about the availability
                                    and rental process
                                    for equipment such as wheelchairs, crutches, and other medical aids.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FAQ Column 2 -->
                <div class="col-md-12">
                    <div class="accordion" id="accordionColumn2">
                        <!-- FAQ Item 11 -->

                        <!-- FAQ Item 12 -->

                        <!-- FAQ Item 13 -->
                        <div class="card">
                            <div class="card-header" id="heading13">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse13" aria-expanded="true" aria-controls="collapse13">
                                        Are the ambulance services available 24/7?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse13" class="collapse" aria-labelledby="heading13"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    Yes, Urgecare operates 24/7, ensuring that assistance is available whenever you need
                                    it. Our helpline
                                    is accessible round the clock for ambulance requests, inquiries, and any other
                                    assistance you may
                                    require.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 14 -->
                        <div class="card">
                            <div class="card-header" id="heading14">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse14" aria-expanded="true" aria-controls="collapse14">
                                        Are the medical professionals at Urgecare trained and certified?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse14" class="collapse" aria-labelledby="heading14"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    Yes, all our medical professionals, including paramedics and nurses, are trained and
                                    certified. They
                                    possess the necessary qualifications and experience to provide quality medical care
                                    during
                                    transportation.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 15 -->
                        <div class="card">
                            <div class="card-header" id="heading15">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse15" aria-expanded="true" aria-controls="collapse15">
                                        How is the privacy of patients maintained during transportation?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse15" class="collapse" aria-labelledby="heading15"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    Urgecare takes patient privacy seriously. We adhere to strict confidentiality
                                    protocols and ensure
                                    that all patient information remains confidential and secure during transportation
                                    and consultations.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 16 -->
                        <div class="card">
                            <div class="card-header" id="heading16">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse16" aria-expanded="true" aria-controls="collapse16">
                                        How are the ambulance crews selected at Urgecare?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse16" class="collapse" aria-labelledby="heading16"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    We have a rigorous selection process for our ambulance crews. They undergo thorough
                                    background checks,
                                    possess the required certifications, and have a proven track record in the medical
                                    field. We
                                    prioritize professionalism and competence when selecting our staff.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 17 -->
                        <div class="card">
                            <div class="card-header" id="heading17">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse17" aria-expanded="true" aria-controls="collapse17">
                                        What safety measures are in place to protect patients during transportation?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse17" class="collapse" aria-labelledby="heading17"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    Urgecare places a strong emphasis on patient safety. Our ambulances are equipped
                                    with safety features
                                    such as seat belts, secure medical equipment storage, and adherence to strict
                                    infection control
                                    protocols. Our medical professionals are trained in emergency procedures to handle
                                    any unforeseen
                                    circumstances during transportation.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 18 -->
                        <div class="card">
                            <div class="card-header" id="heading18">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse18" aria-expanded="true" aria-controls="collapse18">
                                        How are the prices for ambulance services determined?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse18" class="collapse" aria-labelledby="heading18"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    The prices for our ambulance services are determined based on several factors,
                                    including the type of
                                    ambulance required, the distance of transportation, and any additional services or
                                    equipment needed.
                                    We strive to provide transparent pricing and ensure that our services are affordable
                                    and value-driven.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 19 -->
                        <div class="card">
                            <div class="card-header" id="heading19">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse19" aria-expanded="true" aria-controls="collapse19">
                                        Can Urgecare handle medical transportation for patients with specific medical
                                        conditions?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse19" class="collapse" aria-labelledby="heading19"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    Yes, we can handle medical transportation for patients with specific medical
                                    conditions. Our medical
                                    staff is trained to provide specialized care and ensure the safety and well-being of
                                    patients with
                                    various medical conditions, including cardiac issues, respiratory conditions, and
                                    other critical
                                    illnesses.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 20 -->
                        <div class="card">
                            <div class="card-header" id="heading20">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse20" aria-expanded="true" aria-controls="collapse20">
                                        What should I do in case of a medical emergency?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse20" class="collapse" aria-labelledby="heading20"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    In case of a medical emergency, call our helpline number immediately. Our team will
                                    guide you on the
                                    necessary steps to take, provide medical advice if possible, and dispatch an
                                    ambulance to your
                                    location promptly.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 21 -->
                        <div class="card">
                            <div class="card-header" id="heading21">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse21" aria-expanded="true" aria-controls="collapse21">
                                        Is Urgecare recognized by insurance providers?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse21" class="collapse" aria-labelledby="heading21"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    Yes, Urgecare is recognized by various insurance providers. We work with insurance
                                    companies to
                                    facilitate direct billing and claim processing, making it convenient for patients to
                                    utilize their
                                    insurance coverage for medical transportation services.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item 22 -->
                        <div class="card">
                            <div class="card-header" id="heading22">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left" type="button" data-toggle="collapse"
                                        data-target="#collapse22" aria-expanded="true" aria-controls="collapse22">
                                        How can I provide feedback or make a complaint about Urgecare's services?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse22" class="collapse" aria-labelledby="heading22"
                                data-parent="#accordionColumn2">
                                <div class="card-body">
                                    We value feedback from our customers as it helps us improve our services. You can
                                    provide feedback or
                                    make a complaint by reaching out to our customer support team through our helpline
                                    or email. We will
                                    address your concerns promptly and take appropriate action.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



@endsection