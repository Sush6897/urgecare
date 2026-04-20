@extends('layout.frontend.app')
@section('content')

<section class="page-title py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Terms & Conditions</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <p class="text-justify">Please read these Terms and Conditions carefully before accessing our website or
                utilizing our services. By using our website and services, you agree to comply with and be bound by
                these Terms and Conditions.</p>
            <h2 class="sec-title mb-3">1. Service Provision</h2>
            <p class="text-justify">Urgecare provides ambulance transportation services and medical equipment rental
                services subject to the terms and conditions outlined herein. Our services are provided based on
                availability, medical necessity, and our professional judgment.</p>
            <h2 class="sec-title mb-3">2. User Responsibilities</h2>
            <p class="text-justify">By using our website or services, you agree to provide accurate, complete, and
                up-to-date information during the process of requesting our services or interacting with our website.
                You also agree to comply with all applicable laws, regulations, and ethical standards while using our
                services or accessing our website.</p>
            <h2 class="sec-title mb-3">3. Pricing and Payment</h2>
            <p class="text-justify">The prices for our services are clearly stated on our website and are subject to
                change without prior notice. Payment for services is required at the time of booking or as otherwise
                agreed upon. We accept various payment methods as specified on our website. You are responsible for
                ensuring that all payments are made promptly and in full accordance with the agreed terms.</p>
            <h2 class="sec-title mb-3">4. Limitation of Liability</h2>
            <p class="text-justify">Urgecare and its affiliates shall not be liable for any direct, indirect,
                incidental, special, consequential, or punitive damages arising out of or related to the use of our
                services or website. We make no representations or warranties regarding the availability, accuracy,
                reliability, or completeness of the information, content, or services provided.</p>
            <h2 class="sec-title mb-3">5. Intellectual Property</h2>
            <p class="text-justify">All content, logos, trademarks, and intellectual property displayed on our website
                are the property of Urgecare and are protected by applicable intellectual property laws. Unauthorized
                use or reproduction is strictly prohibited.</p>
            <h2 class="sec-title mb-3">6. Termination</h2>
            <p class="text-justify">We reserve the right to terminate or suspend your access to our services or website
                at any time, without prior notice, for any reason, including but not limited to violations of our Terms
                and Conditions or any applicable laws or regulations.</p>
            <h2 class="sec-title mb-3">7. Governing Law and Jurisdiction</h2>
            <p class="text-justify">These Terms and Conditions shall be governed by and construed in accordance with the
                laws of India. Any disputes arising out of or related to these terms shall be subject to the exclusive
                jurisdiction of the courts located in Pune, Maharashtra.</p>
            <p class="text-justify">Please read and review these documents carefully before using our website or
                services. If you have any questions, concerns, or requests related to your privacy or our terms and
                conditions, please contact us using the provided contact information. Your satisfaction and trust are
                our utmost priorities, and we are committed to providing you with exceptional services while ensuring
                the privacy and security of your information.</p>
            <p><strong>Email:</strong> {{ $setting->email ?? 'urgecarecommunications@gmail.com' }}<br>
               <strong>Phone:</strong> {{ $setting->contact_number ?? '+91 7888021021' }}</p>
        </div>
    </section>



@endsection