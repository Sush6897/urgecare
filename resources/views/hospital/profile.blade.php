@extends('layout.hospital.app')

@section('content')

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Profile</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('hospital.dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Profile</li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif


    <div class="row">
        <div class="col-md-12">

            <!-- Profile Header -->

            <div class="profile-header">

                <div class="row align-items-center">

                    <div class="col-auto profile-image">
                        <img class="rounded-circle"
                             src="{{asset('/backend/assets/img/profiles/avatar-01.jpg')}}">
                    </div>

                    <div class="col ml-md-n2 profile-user-info">

                        <h4 class="user-name mb-0">
                            {{auth('hospital')->user()->hospital_name}}
                        </h4>

                        <h6 class="text-muted">
                            {{auth('hospital')->user()->email}}
                        </h6>

                        <p class="mb-0">
                            <i class="fe fe-phone mr-1"></i>

                            {{ auth('hospital')->user()->contacts->pluck('contact')->implode(', ') }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- Profile Menu -->

            <div class="profile-menu">
                <ul class="nav nav-tabs nav-tabs-solid">

                    <li class="nav-item">
                        <a class="nav-link active"
                           data-toggle="tab"
                           href="#per_details_tab">
                           Hospital Details
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           data-toggle="tab"
                           href="#password_tab">
                           Password
                        </a>
                    </li>

                </ul>
            </div>

            <div class="tab-content profile-tab-cont">

                <!-- Hospital Details -->

                <div class="tab-pane fade show active" id="per_details_tab">

                    <div class="card">

                        <div class="card-body">

                            <h5 class="card-title d-flex justify-content-between">

                                <span>Hospital Details</span>

                                <a class="edit-link"
                                   data-toggle="modal"
                                   href="#edit_hospital_details">

                                    <i class="fa fa-edit mr-1"></i>Edit

                                </a>

                            </h5>


                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">Hospital Name</p>
                                <p class="col-sm-9">{{auth('hospital')->user()->hospital_name}}</p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">Email</p>
                                <p class="col-sm-9">{{auth('hospital')->user()->email}}</p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">Contacts</p>
                                <p class="col-sm-9">
                                    {{ auth('hospital')->user()->contacts->pluck('contact')->implode(', ') }}
                                </p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">Address</p>
                                <p class="col-sm-9">{{auth('hospital')->user()->address}}</p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">Area</p>
                                <p class="col-sm-9">{{auth('hospital')->user()->area}}</p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">City</p>
                                <p class="col-sm-9">{{auth('hospital')->user()->city}}</p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">State</p>
                                <p class="col-sm-9">{{auth('hospital')->user()->state}}</p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">Country</p>
                                <p class="col-sm-9">{{auth('hospital')->user()->country}}</p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3 text-muted text-sm-right">Pincode</p>
                                <p class="col-sm-9">{{auth('hospital')->user()->pincode}}</p>
                            </div>


                            <!-- Type -->

                            <div class="row">

                                <p class="col-sm-3 text-muted text-sm-right">Type</p>

                                <p class="col-sm-9">

                                    @if(auth('hospital')->user()->emergency)
                                        <span class="badge badge-danger">Emergency</span>
                                    @endif

                                    @if(auth('hospital')->user()->nonemergency)
                                        <span class="badge badge-info">Non-Emergency</span>
                                    @endif

                                </p>

                            </div>


                            <!-- Features -->

                            @if(auth('hospital')->user()->features1 || auth('hospital')->user()->features2 || auth('hospital')->user()->features3 || auth('hospital')->user()->features4)

                            <div class="row">

                                <p class="col-sm-3 text-muted text-sm-right">Features</p>

                                <p class="col-sm-9">

                                    @if(auth('hospital')->user()->features1)
                                        <span class="badge badge-light">{{auth('hospital')->user()->features1}}</span>
                                    @endif

                                    @if(auth('hospital')->user()->features2)
                                        <span class="badge badge-light">{{auth('hospital')->user()->features2}}</span>
                                    @endif

                                    @if(auth('hospital')->user()->features3)
                                        <span class="badge badge-light">{{auth('hospital')->user()->features3}}</span>
                                    @endif

                                    @if(auth('hospital')->user()->features4)
                                        <span class="badge badge-light">{{auth('hospital')->user()->features4}}</span>
                                    @endif

                                </p>

                            </div>

                            @endif


                        </div>

                    </div>

                </div>


                <!-- Password Tab -->

                <div id="password_tab" class="tab-pane fade">

                    <div class="card">

                        <div class="card-body">

                            <h5 class="card-title">Change Password</h5>

                            <form method="POST"
                                  action="{{ route('hospital.password.change') }}">

                                @csrf

                                <div class="form-group">

                                    <label>New Password</label>

                                    <input type="password"
                                           name="new_password"
                                           class="form-control"
                                           required>

                                </div>


                                <div class="form-group">

                                    <label>Confirm Password</label>

                                    <input type="password"
                                           name="new_password_confirmation"
                                           class="form-control"
                                           required>

                                </div>


                                <button class="btn btn-primary">
                                    Update Password
                                </button>

                            </form>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>


    <!-- Edit Hospital Details Modal -->
    <div class="modal fade" id="edit_hospital_details" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hospital Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('hospital.profile.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Hospital Name</label>
                                <input type="text" name="hospital_name" class="form-control @error('hospital_name') is-invalid @enderror" value="{{ old('hospital_name', $hospital->hospital_name) }}" required>
                                @error('hospital_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $hospital->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label>Hospital Contacts</label>
                                <div id="contact-wrapper">
                                    @foreach($hospital->contacts as $contact)
                                        <div class="row contact-row mb-2">
                                            <div class="col-md-10">
                                                <input type="text" name="contacts[]" class="form-control contact-input" maxlength="10" pattern="\d{10}" title="Please enter a 10-digit phone number" value="{{ $contact->contact }}" placeholder="Enter Contact Number" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-contact">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($hospital->contacts->isEmpty())
                                        <div class="row contact-row mb-2">
                                            <div class="col-md-10">
                                                <input type="text" name="contacts[]" class="form-control contact-input" maxlength="10" pattern="\d{10}" title="Please enter a 10-digit phone number" placeholder="Enter Contact Number" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-contact">Remove</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" id="add-contact" class="btn btn-success mt-2">+ Add Contact</button>
                                @error('contacts')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label>Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $hospital->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Area</label>
                                <input type="text" name="area" class="form-control @error('area') is-invalid @enderror" value="{{ old('area', $hospital->area) }}" required>
                                @error('area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Google Map Link</label>
                                <input type="text" id="gmap" name="gmap" class="form-control @error('gmap') is-invalid @enderror" value="{{ old('gmap', $hospital->gmap) }}" required>
                                @error('gmap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>City</label>
                                <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $hospital->city) }}" readonly required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>State</label>
                                <input type="text" id="state" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state', $hospital->state) }}" readonly required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>Country</label>
                                <input type="text" id="country" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', $hospital->country) }}" readonly required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Pincode</label>
                                <input type="text" id="pincode" name="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode', $hospital->pincode) }}" required>
                                @error('pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label>Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $hospital->latitude) }}" readonly required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label>Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $hospital->longitude) }}" readonly required>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Features</label>
                                <div class="mb-2">
                                    <input type="text" name="features[features1]" class="form-control mb-1" placeholder="Feature 1" value="{{ old('features.features1', $hospital->features1) }}">
                                    <input type="text" name="features[features2]" class="form-control mb-1" placeholder="Feature 2" value="{{ old('features.features2', $hospital->features2) }}">
                                    <input type="text" name="features[features3]" class="form-control mb-1" placeholder="Feature 3" value="{{ old('features.features3', $hospital->features3) }}">
                                    <input type="text" name="features[features4]" class="form-control mb-1" placeholder="Feature 4" value="{{ old('features.features4', $hospital->features4) }}">
                                </div>
                                @error('features')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Hospital Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" value="emergency" id="edit_emergency" {{ $hospital->emergency ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_emergency">Emergency</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" value="non-emergency" id="edit_nonemergency" {{ $hospital->nonemergency ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_nonemergency">Non-Emergency</label>
                                </div>
                                @error('type')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Add Contact
        $('#add-contact').click(function() {
            var newRow = `
                <div class="row contact-row mb-2">
                    <div class="col-md-10">
                        <input type="text" name="contacts[]" class="form-control contact-input" placeholder="Enter Contact Number" maxlength="10" pattern="\d{10}" title="Please enter a 10-digit phone number" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-contact">Remove</button>
                    </div>
                </div>`;
            $('#contact-wrapper').append(newRow);
        });

        // Remove Contact
        $(document).on('click', '.remove-contact', function() {
            if ($('.contact-row').length > 1) {
                $(this).closest('.contact-row').remove();
            } else {
                alert('At least one contact number is required.');
            }
        });

        // Fetch Coordinates
        $('#gmap').on('focusout', function() {
            var mapLink = $(this).val();
            if (!mapLink) return;

            // Clear coordinate fields
            $('#city, #pincode, #country, #state, #latitude, #longitude').val('');

            $.ajax({
                url: '{{ route("fetchCoordinates") }}',
                type: 'GET',
                dataType: 'json',
                data: { gmap: mapLink },
                success: function(response) {
                    if (response.latitude && response.longitude) {
                        $('#city').val(response.city);
                        $('#pincode').val(response.pincode);
                        $('#country').val(response.country);
                        $('#state').val(response.state);
                        $('#latitude').val(response.latitude);
                        $('#longitude').val(response.longitude);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching coordinates:', error);
                }
            });
        });
        
        // Restrict Contact inputs to numbers only and max 10 digits
        $(document).on('input', '.contact-input', function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10); // Enforce max 10
            }
        });

        // Open modal if validation fails
        @if ($errors->any())
            $('#edit_hospital_details').modal('show');
        @endif
    });
</script>

@endsection