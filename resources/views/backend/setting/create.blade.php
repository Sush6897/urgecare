@extends('layout.backend.app')

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('setting.index') }}">Settings</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="card">
        <div class="card-header">
            <h1>Edit Global Settings</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('setting.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $setting->email ?? '') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $setting->contact_number ?? '') }}">
                        @error('contact_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6" id="emergency_number_container">
                        <label for="emergency_number">Emergency Number</label>
                        <input type="text" class="form-control" id="emergency_number" name="emergency_number" value="{{ old('emergency_number', $setting->emergency_number ?? '') }}">
                        @error('emergency_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="non_emergency_number">Non-Emergency Number</label>
                        <input type="text" class="form-control" id="non_emergency_number" name="non_emergency_number" value="{{ old('non_emergency_number', $setting->non_emergency_number ?? '') }}">
                        @error('non_emergency_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6" id="whatsapp_number_container">
                        <label for="whatsapp_number">WhatsApp Number</label>
                        <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number ?? '') }}">
                        @error('whatsapp_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="secondary_call_number">Secondary Call Number</label>
                        <input type="text" class="form-control" id="secondary_call_number" name="secondary_call_number" value="{{ old('secondary_call_number', $setting->secondary_call_number ?? '') }}">
                        @error('secondary_call_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4" id="emergency_link_container">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_emergency_link" id="is_emergency_link" value="1" {{ old('is_emergency_link', $setting->is_emergency_link ?? 0) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_emergency_link">
                                Show Emergency Link
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_call_icon" id="is_call_icon" value="1" {{ old('is_call_icon', $setting->is_call_icon ?? 0) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_call_icon">
                                Show Call Icon
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-4" id="whatsapp_icon_container">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_whatsapp_icon" id="is_whatsapp_icon" value="1" {{ old('is_whatsapp_icon', $setting->is_whatsapp_icon ?? 0) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_whatsapp_icon">
                                Show WhatsApp Icon
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function toggleSettings() {
            // Emergency Logic (Mutually Exclusive)
            var hasEmergencyNumber = $('#emergency_number').val().trim() !== '';
            var isEmergencyLinkChecked = $('#is_emergency_link').is(':checked');

            if (hasEmergencyNumber) {
                $('#emergency_link_container').hide();
            } else {
                $('#emergency_link_container').show();
            }

            if (isEmergencyLinkChecked) {
                $('#emergency_number_container').hide();
            } else {
                $('#emergency_number_container').show();
            }

            // WhatsApp Logic (Dependency: Number appears when Icon is checked)
            var isWhatsappIconChecked = $('#is_whatsapp_icon').is(':checked');

            if (isWhatsappIconChecked) {
                $('#whatsapp_number_container').show();
            } else {
                $('#whatsapp_number_container').hide();
                // Optionally clear the value if hidden? User didn't ask but usually better.
                // $('#whatsapp_number').val(''); 
            }
            
            // Note: Since number depends on icon, the icon container should always be visible 
            // unless there's another rule.
            $('#whatsapp_icon_container').show(); 
        }

        // Initial check on page load
        toggleSettings();

        // Listen for changes
        $('#emergency_number').on('input', function() {
            toggleSettings();
        });

        $('#whatsapp_number').on('input', function() {
            // No hide logic for icon based on number anymore for WhatsApp
        });

        $('#is_emergency_link, #is_whatsapp_icon').change(function() {
            toggleSettings();
        });
    });
</script>
@endsection
