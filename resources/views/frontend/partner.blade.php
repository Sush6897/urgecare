@extends('layout.frontend.app')
@section('content')
<section class="page-title py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Partner with us</h1>
            </div>
        </div>
    </div>
</section>

<section class="partner py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="sec-title">Join Us for Premier Ambulance Services</h2>
                <p>At Urgecare, we are committed to delivering exceptional ambulance services that prioritize
                    patient safety and comfort. We believe that collaboration is key to expanding our reach and
                    enhancing the quality of care we provide. We invite businesses and individuals who share our
                    dedication to join us in making a difference.</p>
                <form class="contact-form" method="POST" action="{{ route('partners.store') }}">
                    @csrf
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control " id="firstName" name="firstName"
                                    placeholder="Enter first name" value="{{ old('firstName') }}" >
                                @error('firstName')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control " id="lastName" name="lastName"
                                    placeholder="Enter last name" value="{{ old('lastName') }}" >
                                @error('lastName')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control " id="businessName" name="businessName"
                                    placeholder="Enter your business name" value="{{ old('businessName') }}" >
                                @error('businessName')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="tel" class="form-control " id="contact" name="contact"
                                    placeholder="Enter contact number" value="{{ old('contact') }}" >
                                @error('contact')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="email" class="form-control " id="email" name="email"
                                    placeholder="Enter your email" value="{{ old('email') }}" >
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control " id="address" name="address" rows="3"
                                    placeholder="Enter your address" >{{ old('address') }}</textarea>
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</section>

@endsection