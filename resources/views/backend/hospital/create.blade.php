@extends('layout.backend.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Hospital</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="card">
        <div class="card-header">
            <h1>Add Hospital</h1>
        </div>
        <div class="card-body">
          

            <form action="{{ route('hospital.store') }}" method="POST" >
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="hospital_name">Hospital Name</label>
                        <input type="text" class="form-control" id="hospital_name" name="hospital_name" value="{{ old('hospital_name') }}" required>
                        @error('hospital_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Hospital Contacts</label>

                        <div id="contact-wrapper">

                            <div class="row contact-row mb-2">

                                <div class="col-md-10">
                                    <input type="text" name="contacts[]" class="form-control contact-input" maxlength="10" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" required placeholder="Enter Contact Number">
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-contact">
                                        Remove
                                    </button>
                                </div>

                            </div>

                        </div>

                        <button type="button" id="add-contact" class="btn btn-success mt-2">
                            + Add Contact
                        </button>

                        @error('contacts')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
               
                    <div class="form-group col-md-6">
                        <label for="country">Country</label>
                        <input type="text" readonly class="form-control" id="country" name="country" value="{{ old('country') }}" required>
                        @error('country')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="state">State</label>
                        <input type="text" readonly class="form-control" id="state" name="state" value="{{ old('state') }}" required>
                        @error('state')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
               
                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <input type="text" readonly class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="form-group col-md-6">
                        <label for="country">Area</label>
                        <input type="text"  class="form-control" id="area" name="area" value="{{ old('area') }}" required>
                        @error('area')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pincode">Pincode</label>
                        <input type="text"  class="form-control" id="pincode" name="pincode" value="{{ old('pincode') }}" required>
                        @error('pincode')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    
                   
                    <div class="form-group col-md-6">
                        <label for="gmap">Google Map Link</label>
                        <input type="text" class="form-control" id="gmap" name="gmap" value="{{ old('gmap') }}" required>
                        @error('gmap')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly required>
                        @error('longitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group col-md-6">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly required>

                        @error('latitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="Enter Price">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="type">Type</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emergency" name="type[]" value="emergency" {{ is_array(old('type')) && in_array('emergency', old('type')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="emergency">Emergency</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="non-emergency" name="type[]" value="non-emergency" {{ is_array(old('type')) && in_array('non-emergency', old('type')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="non-emergency">Non-Emergency</label>
                            </div>
                        </div>
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
<script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}">        // Restrict Contact inputs to numbers only and max 10 digits
        $(document).on('input', '.contact-input', function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10); // Enforce max 10
            }
        });
</script>

<script>
    $('#gmap').on('focusout', function(){
        var mapLink = $(this).val();
        $('#city').val('');
        $('#pincode').val('');
        $('#country').val('');
        $('#state').val('');
        $('#latitude').val('');
        $('#longitude').val('');
        $.ajax({
            url: '/fetch-coordinates',
            type: 'GET',
            dataType: 'json',
            data: {
                gmap: mapLink
            },
            success: function(response) {
                if (response.latitude && response.longitude) {
            // Set the values in the input fields
                    $('#city').val(response.city);
                    $('#pincode').val(response.pincode);
                    $('#country').val(response.country);
                    $('#state').val(response.state);
                    $('#latitude').val(response.latitude);
                    $('#longitude').val(response.longitude);
                } else {
                    // Handle error if latitude or longitude is not present
                    $('#coordinates').html('Error: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                $('#coordinates').html('An error occurred: ' + xhr.responseText);
            }
        });
    });


$('#add-contact').click(function(){

    $('#contact-wrapper').append(`

        <div class="row contact-row mb-2">

            <div class="col-md-10">
                <input type="text" name="contacts[]" class="form-control contact-input" maxlength="10" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" required placeholder="Enter Contact Number">
            </div>

            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-contact">
                    Remove
                </button>
            </div>

        </div>

    `);

});


$(document).on('click','.remove-contact',function(){

    $(this).closest('.contact-row').remove();

});
        // Restrict Contact inputs to numbers only and max 10 digits
        $(document).on('input', '.contact-input', function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10); // Enforce max 10
            }
        });
</script>
@endsection
