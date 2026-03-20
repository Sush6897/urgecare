@extends('layout.frontend.app')
@section('content')

<section class="page-title py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Contact us</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Map Section -->
               
                <!-- Contact Details Section -->
                <div class="col-md-4 contact-details mb-3">
                    <p class="text-light p-2">Reach out to us anytime, we're here to help you with prompt and
                        personalized support.
                    </p>
                    <div class="single-detail d-flex align-items-center mb-3">
                        <i class="fa fa-map-marker-alt fa-2x mr-2"></i>
                        <div>
                            <h5 class="mb-0">Address</h5>
                            <p class="mb-0">Kumar Palms Flat No : B-302 Near Somji Bus Stop, Kondhwa (Budruk),Pune - 411048</p>
                        </div>
                    </div>
                    <hr>
                    <div class="single-detail d-flex align-items-center mb-3">
                        <i class="fa fa-phone-alt fa-2x mr-2"></i>
                        <div>
                            <h5 class="mb-0">Phone</h5>
                            <p class="mb-0"><a href="tel:+917888021021" style="color:#fff;">+917888021021</a></p>
                        </div>
                    </div>
                    <hr>
                    <div class="single-detail d-flex align-items-center mb-3">
                        <i class="fa fa-envelope fa-2x mr-2"></i>
                        <div>
                            <h5 class="mb-0">Email</h5>
                            <p class="mb-0"><a href="mailto:urgecarecommunications@gmail.com" style="color:#fff;">urgecarecommunications@gmail.com</a></p>
                        </div>
                    </div>
                    <hr>
                    <div class="single-detail d-flex align-items-center">
                        <i class="fa fa-clock fa-2x mr-2"></i>
                        <div>
                            <h5 class="mb-0">Hours</h5>
                            <p class="mb-0">24/7 Availability</p>
                        </div>
                    </div>
                </div>
                 <div class="col-md-8 p-0 mb-3">
                    <div class="map-container">
                        <!-- Embed Google Map (replace the src with your actual map URL) -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.570057919604!2d-122.4206486846825!3d37.77902697975819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808b4b19d79b%3A0x9b54907df3709f4c!2sSan%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1633326434642!5m2!1sen!2sus"
                            width="100%" height="530" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h1 class="sec-title mb-3">Contact Us</h1>
            <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
                @csrf
                <div class="row">
                    <!-- Name Field -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control " 
                                name="name" placeholder="Name" value="{{ old('name') }}" >
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Email Field -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <input type="email" class="form-control " 
                                name="email" placeholder="Email" value="{{ old('email') }}" >
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Phone Field -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <input type="tel" class="form-control " 
                                name="phone" placeholder="Phone" value="{{ old('phone') }}" >
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Subject Field -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control " 
                                name="subject" placeholder="Subject" value="{{ old('subject') }}" >
                            @error('subject')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Message Field -->
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <textarea class="form-control " 
                                    name="message" rows="4" placeholder="Your Message" >{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

   

@endsection