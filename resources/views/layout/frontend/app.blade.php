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

  @yield('content')
  <form id="location-form" action="{{route('set.coordinates')}}" method="get">
    
    <input type="hidden" id="latitude" name="latitude" value="">
    <input type="hidden" id="longitude" name="longitude" value="">
</form>
  @include('layout.frontend.footer')

  <script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>

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
        document.addEventListener('DOMContentLoaded', function() {
            @if(Session::has('error'))
            iziToast.error({
                title: 'error',
                message: '{{ Session::get("error") }}',
                backgroundColor: '#40a7a3', // Set the background color to black
                titleColor: 'white', // Set the title color to white for better visibility
                messageColor: 'white', // Set the message color to white for better visibility
                icon: 'mdi mdi-close', // MDI information icon
                iconColor: 'white',
            });
            @endif

            @if(Session::has('success'))
            iziToast.success({
                title: 'Success',
                message: '{{ Session::get("success") }}',
                backgroundColor: '#f70400', // Set the background color to black
                titleColor: 'white', // Set the title color to white for better visibility
                messageColor: 'white', // Set the message color to white for better visibility
                icon: 'mdi mdi-check', // MDI information icon
                iconColor: 'white',
            });
            @endif
        });
    </script>

</body>


</html>