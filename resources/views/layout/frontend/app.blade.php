<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Urgecare Ambulance Service in Pune</title>
  <link href="{{asset('/frontend/assets/style.css')}}" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/backend/assets/img/favicon1.png')}}">
    <link rel="stylesheet" href="{{asset('/backend/assets/css/izitoast.min.css')}}">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>
  <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11032053469"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'AW-11032053469');
      
       gtag('event', 'ads_conversion_Contact_Us_Page_1', {
    // <event_parameters>
  });
  gtag('event', 'page_view', {
    // <event_parameters>
  });
   gtag('event', 'conversion', {'send_to': 'AW-11032053469/FQCBCMzW35sZEN2Nv4wp'});
    </script>
  <!-- Font Awesome -->
</head>
<body>
  @include('layout.frontend.header')

  <!-- Global Loader -->
  <div id="global-loader" class="fade-out">
      <div class="network-container">
          <!-- Vessels with flowing ambulances -->
          <div class="vessel v1"><i class="fas fa-ambulance flowing-ambulance"></i><div class="hospital-node"><i class="fas fa-plus"></i></div></div>
          <div class="vessel v2"><i class="fas fa-ambulance flowing-ambulance"></i><div class="hospital-node"><i class="fas fa-plus"></i></div></div>
          <div class="vessel v3"><i class="fas fa-ambulance flowing-ambulance"></i><div class="hospital-node"><i class="fas fa-plus"></i></div></div>
          <div class="vessel v4"><i class="fas fa-ambulance flowing-ambulance"></i><div class="hospital-node"><i class="fas fa-plus"></i></div></div>
          <div class="vessel v5"><i class="fas fa-ambulance flowing-ambulance"></i><div class="hospital-node"><i class="fas fa-plus"></i></div></div>
          
          <!-- Central Heart Core -->
          <div class="urge-heart">
              <i class="fas fa-heartbeat"></i>
          </div>
      </div>

      <div class="urge-text-container">
          <div class="brand-text">URGE<span>CARE</span></div>
          <div class="connecting-status">FETCHING NEARBY AMBULANCE<span class="dots-loader"></span></div>
      </div>
  </div>

  @yield('content')
  <form id="location-form" action="{{route('set.coordinates')}}" method="get">
    
    <input type="hidden" id="latitude" name="latitude" value="">
    <input type="hidden" id="longitude" name="longitude" value="">
</form>

  @include('layout.frontend.footer')


  <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="{{asset('/backend/assets/js/izitoast.min.js')}}"></script>
  <script src="{{asset('/backend/assets/js/bootbox.min.js')}}"></script>
  
  <script>
 
    document.querySelectorAll('.button').forEach(button => {
      const buttonText = button.querySelector('.button-text');
      const buttonIconOnly = button.querySelector('.button-icon-only');

      if (buttonText.scrollWidth > button.clientWidth) {
        button.classList.add('hidden-text');
      } else {
        button.classList.remove('hidden-text');
      }
    });
   
    function getLocationAndSubmitForm() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                // Start 1-hour live patient tracking session
                if (window.startPatientTracking) {
                    window.startPatientTracking(latitude, longitude);
                }
                // Set latitude and longitude values to the form inputs
                $('#location-form' + ' input[name="latitude"]').val(latitude);
                $('#location-form' + ' input[name="longitude"]').val(longitude);
                // Submit the form
                $('#location-form').submit();

            }, function(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        alert('User denied the request for Geolocation.');
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert('Location information is unavailable.');
                        break;
                    case error.TIMEOUT:
                        alert('The request to get user location timed out.');
                        break;
                    default:
                        alert('An unknown error occurred.');
                }
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    }
  </script>
      <script>
    $(document).ready(function() {
        // Show loader on form submission (only for non-AJAX/standard forms)
        $('form').not('#searchForm, #filterForm, #bookNowModal form, #location-form').on('submit', function() {
            $('#global-loader').removeClass('fade-out');
        });

        // Specific handling for location form (which triggers a full page refresh/redirect)
        $('#location-form').on('submit', function() {
            $('#global-loader').removeClass('fade-out');
        });

        @if(Session::has('error'))
        iziToast.error({
            title: 'Error',
            message: '{{ Session::get("error") }}',
            backgroundColor: '#40a7a3',
            titleColor: 'white',
            messageColor: 'white',
            icon: 'mdi mdi-close',
            iconColor: 'white',
        });
        @endif

        @if(Session::has('success'))
        iziToast.success({
            title: 'Success',
            message: '{{ Session::get("success") }}',
            backgroundColor: '#f70400',
            titleColor: 'white',
            messageColor: 'white',
            icon: 'mdi mdi-check',
            iconColor: 'white',
        });
        @endif

        // Global handler to set Hospital ID when any 'Book Now' button is clicked
        $(document).on('click', '[data-target="#bookNowModal"]', function() {
            var hospitalId = $(this).attr('data-hospital-id');
            $('#bookNowModal #hospital_id').val(hospitalId);
        });

        // Global AJAX handler for 'Book Now' form
        $(document).on('submit', '#bookNowModal form', function(e) {
            e.preventDefault();
            var form = $(this);
            var modal = $('#bookNowModal');
            var submitBtn = form.find('button[type="submit"]');
            var contact = form.find('input[name="contact"]').val();

            // 10-digit validation
            if (contact.length !== 10 || !/^[6-9][0-9]{9}$/.test(contact)) {
                iziToast.warning({ title: 'Validation', message: 'Please enter a valid 10-digit mobile number.', position: 'topRight' });
                return false;
            }

            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Starting call...');

            $.ajax({
                url: form.attr('action'),
                method: "POST",
                data: form.serialize(),
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(response) {
                    modal.modal('hide');
                    submitBtn.prop('disabled', false).text('Submit');
                    form.trigger('reset'); // Clear form fields
                    iziToast.success({ title: 'Success', message: response.message || 'Call initiated successfully!', position: 'topRight' });
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).text('Submit');
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to initiate call.';
                    iziToast.error({ title: 'Error', message: msg, position: 'topRight' });
                }
            });
        });
    });
    </script>

    <!-- Patient Live Location Tracking Widget & Engine (1-Hour Auto Window) -->
    <div id="patient-location-widget" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 99999; background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(10px); color: #fff; border-radius: 12px; padding: 12px 18px; box-shadow: 0 8px 24px rgba(0,0,0,0.3); font-family: sans-serif; font-size: 13px; border: 1px solid rgba(255,255,255,0.15); transition: all 0.3s ease;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span id="pts-pulse-dot" style="width: 10px; height: 10px; background-color: #10B981; border-radius: 50%; display: inline-block; box-shadow: 0 0 10px #10B981; animation: ptsPulse 1.5s infinite;"></span>
            <div>
                <div style="font-weight: 600; color: #F8FAFC; display: flex; align-items: center; gap: 8px;">
                    <span>Live Location Sharing</span>
                    <span id="pts-status-badge" style="background: rgba(16, 185, 129, 0.2); color: #34D399; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 500;">Stopped</span>
                </div>
                <div style="font-size: 11px; color: #94A3B8; margin-top: 2px;">
                    Time Remaining: <span id="pts-timer" style="color: #60A5FA; font-weight: 600;">59m 59s</span> | <span id="pts-speed">0.0 km/h</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes ptsPulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1.1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>

    <script>
    (function() {
        var trackingInterval = null;
        var watchId = null;
        var timerCountdownInterval = null;
        var expiresAtTimestamp = 0;

        function updateWidgetTimer() {
            if (!expiresAtTimestamp) return;
            var now = new Date().getTime();
            var remainingMs = expiresAtTimestamp - now;

            if (remainingMs <= 0) {
                stopTrackingSession('Tracking period completed (1 hour limit)');
                return;
            }

            var totalSec = Math.floor(remainingMs / 1000);
            var mins = Math.floor(totalSec / 60);
            var secs = totalSec % 60;
            $('#pts-timer').text(mins + 'm ' + (secs < 10 ? '0' : '') + secs + 's');
        }

        function stopTrackingSession(reason) {
            if (trackingInterval) clearInterval(trackingInterval);
            if (timerCountdownInterval) clearInterval(timerCountdownInterval);
            if (watchId !== null && navigator.geolocation) navigator.geolocation.clearWatch(watchId);
            
            localStorage.removeItem('pts_session_token');
            localStorage.removeItem('pts_expires_at');
            
            $('#patient-location-widget').fadeOut();
            console.log('[Patient Tracking]', reason || 'Tracking stopped');
        }

        function initTrackingSession(latitude, longitude) {
            var existingToken = localStorage.getItem('pts_session_token');
            var existingExpires = localStorage.getItem('pts_expires_at');
            var now = new Date().getTime();

            if (existingToken && existingExpires && parseInt(existingExpires) > now) {
                expiresAtTimestamp = parseInt(existingExpires);
                $('#patient-location-widget').fadeIn();
                startPeriodicUpdates(existingToken);
                return;
            }

            // Start new session on backend
            $.ajax({
                url: '{{ route("patient.location.start") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    latitude: latitude,
                    longitude: longitude
                },
                success: function(res) {
                    if (res.status === 'success') {
                        localStorage.setItem('pts_session_token', res.session_token);
                        var expMs = new Date(res.expires_at).getTime();
                        localStorage.setItem('pts_expires_at', expMs);
                        expiresAtTimestamp = expMs;

                        $('#patient-location-widget').fadeIn();
                        updateWidgetTimer();
                        startPeriodicUpdates(res.session_token);
                    }
                },
                error: function(err) {
                    console.error('[Patient Tracking] Start session error:', err);
                }
            });
        }

        function startPeriodicUpdates(sessionToken) {
            if (timerCountdownInterval) clearInterval(timerCountdownInterval);
            timerCountdownInterval = setInterval(updateWidgetTimer, 1000);

            function sendLocationPing(lat, lng, speed, accuracy) {
                $.ajax({
                    url: '{{ route("patient.location.update") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        session_token: sessionToken,
                        latitude: lat,
                        longitude: lng,
                        speed: speed || 0,
                        accuracy: accuracy || 0
                    },
                    success: function(res) {
                        if (res.status === 'expired') {
                            stopTrackingSession('Session expired on server');
                            return;
                        }

                        if (res.status === 'success') {
                            var isWalking = (res.movement_status === 'walking');
                            $('#pts-status-badge')
                                .text(isWalking ? '🚶 Walking' : '🛑 Stopped')
                                .css({
                                    'background': isWalking ? 'rgba(59, 130, 246, 0.2)' : 'rgba(16, 185, 129, 0.2)',
                                    'color': isWalking ? '#60A5FA' : '#34D399'
                                });
                            
                            $('#pts-speed').text((res.speed || 0).toFixed(1) + ' km/h');
                        }
                    }
                });
            }

            // Continuous Geolocation Watch
            if (navigator.geolocation) {
                watchId = navigator.geolocation.watchPosition(function(pos) {
                    sendLocationPing(pos.coords.latitude, pos.coords.longitude, pos.coords.speed, pos.coords.accuracy);
                }, function(err) {
                    console.warn('[Patient Tracking] watchPosition error:', err.message);
                }, {
                    enableHighAccuracy: true,
                    maximumAge: 5000,
                    timeout: 10000
                });
            }

            // Fallback Interval Ping every 10 seconds
            if (trackingInterval) clearInterval(trackingInterval);
            trackingInterval = setInterval(function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(pos) {
                        sendLocationPing(pos.coords.latitude, pos.coords.longitude, pos.coords.speed, pos.coords.accuracy);
                    });
                }
            }, 10000);
        }

        // Expose function globally to start tracking when permission is granted
        window.startPatientTracking = initTrackingSession;

        // Auto-resume or auto-start 1-hour tracking session on page load
        $(document).ready(function() {
            var token = localStorage.getItem('pts_session_token');
            var expires = localStorage.getItem('pts_expires_at');
            var now = new Date().getTime();

            // Extract latitude and longitude from URL parameters or session
            var urlParams = new URLSearchParams(window.location.search);
            var paramLat = urlParams.get('latitude') || '{{ session("latitude") }}';
            var paramLng = urlParams.get('longitude') || '{{ session("longitude") }}';

            var hasValidParams = paramLat && paramLng && !isNaN(parseFloat(paramLat)) && !isNaN(parseFloat(paramLng));

            if (hasValidParams) {
                initTrackingSession(parseFloat(paramLat), parseFloat(paramLng));
            } else if (token && expires && parseInt(expires) > now) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(pos) {
                        initTrackingSession(pos.coords.latitude, pos.coords.longitude);
                    });
                }
            } else if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    initTrackingSession(pos.coords.latitude, pos.coords.longitude);
                }, function(err) {
                    console.log('[Patient Tracking] Awaiting location permission grant');
                });
            }
        });
    })();
    </script>
</body>

</html>