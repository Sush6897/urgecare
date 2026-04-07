<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <title>Urgecare - Dashboard</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('/backend/assets/img/favicon1.png')}}">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{asset('/backend/assets/css/bootstrap.min.css')}}">

  <!-- Fontawesome CSS -->
  <link rel="stylesheet" href="{{asset('/backend/assets/css/font-awesome.min.css')}}">

  <!-- Feathericon CSS -->
  <link rel="stylesheet" href="{{asset('/backend/assets/css/feathericon.min.css')}}">

  <link rel="stylesheet" href="{{asset('/backend/assets/plugins/morris/morris.css')}}">
  <link rel="stylesheet" href="{{asset('/backend/assets/plugins/datatables/datatables.min.css')}}">

  <link rel="stylesheet" href="{{asset('/backend/assets/css/style.css')}}">

  <link rel="stylesheet" href="{{asset('/backend/assets/css/izitoast.min.css')}}">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

</head>

<body>

  <!-- Main Wrapper -->
  <div class="main-wrapper">

    @include('layout.backend.header')

   @include('layout.backend.sidebar')
   
    <div class="page-wrapper">

      @yield('content')
    </div>
   

  </div>
 
  <script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>

  <!-- Bootstrap Core JS -->
  <script src="{{asset('/backend/assets/js/popper.min.js')}}"></script>
  <script src="{{asset('/backend/assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('/backend/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('/backend/assets/plugins/raphael/raphael.min.js')}}"></script>
  <script src="{{asset('/backend/assets/plugins/morris/morris.min.js')}}"></script>
  <script src="{{asset('/backend/assets/js/chart.morris.js')}}"></script>
	<script src="{{asset('/backend/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('/backend/assets/plugins/datatables/datatables.min.js')}}"></script>

  <script src="{{asset('/backend/assets/js/script.js')}}"></script>
  <script src="{{asset('/backend/assets/js/izitoast.min.js')}}"></script>
  <script src="{{asset('/backend/assets/js/bootbox.min.js')}}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(Session::has('error'))
        iziToast.error({
            title: 'Error',
            message: '{{ Session::get("error") }}',
            position: 'topRight',
            backgroundColor: '#f70400',
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
            position: 'topRight',
            backgroundColor: '#40a7a3',
            titleColor: 'white',
            messageColor: 'white',
            icon: 'mdi mdi-check',
            iconColor: 'white',
        });
        @endif
    });
  </script>
</body>


</html>