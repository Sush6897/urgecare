<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:53 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Urgecare - Reset Password</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/backend/assets/img/favicon1.png')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('/backend/assets/css/bootstrap.min.css')}}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('/backend/assets/css/font-awesome.min.css')}}">

    <!-- Main CSS -->
    <!-- Main CSS -->

    <link rel="stylesheet" href="{{asset('/backend/assets/css/izitoast.min.css')}}">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{asset('/backend/assets/css/style.css')}}">


</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="{{asset('/frontend/assets/images/download.png')}}" alt="Logo" width="100" height="100">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Reset Password</h1>
                            <p class="account-subtitle">Enter your email and new password for Hospital Portal</p>

                            <!-- Form -->
                            <form action="{{route('hospital.password.update')}}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $passwordReset->token }}">

                                <div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="registerName">Email</label>
                                            <input type="email" readonly class="form-control" id="registerName" name="email" value="{{ $passwordReset->email }}" required placeholder="Enter email">
                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input type="password" class="form-control" id="registerName" name="password" value="" required placeholder="Enter Password">
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
										<button class="btn btn-primary btn-block" type="submit">Reset Password</button>
									</div>
                            </form>
                            <!-- /Form -->

                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('/backend/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('/backend/assets/js/bootstrap.min.js')}}"></script>

    <!-- Custom JS -->
    <script src="{{asset('/backend/assets/js/script.js')}}"></script>

    <script src="{{asset('/backend/assets/js/izitoast.min.js')}}"></script>
    <script src="{{asset('/backend/assets/js/bootbox.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(Session::has('error'))
            iziToast.error({
                title: 'error',
                message: '{{ Session::get("error") }}',
                backgroundColor: '#f70400', // Set the background color to black
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
                backgroundColor: '#40a7a3', // Set the background color to black
                titleColor: 'white', // Set the title color to white for better visibility
                messageColor: 'white', // Set the message color to white for better visibility
                icon: 'mdi mdi-check', // MDI information icon
                iconColor: 'white',
            });
            @endif
        });
    </script>
</body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:53 GMT -->

</html>
