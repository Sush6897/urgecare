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
          <div class="connecting-status">FETCHING NEARBY HOSPITALS<span class="dots-loader"></span></div>
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

</body>


</html>