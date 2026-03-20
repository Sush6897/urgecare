@extends('layout.hospital.app')
@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome {{auth('hospital')->user()->hospital_name ?? 'Hospital'}} !</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-primary border-primary">
                            <i class="mdi mdi-hospital"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{auth('hospital')->user()->hospital_name}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Name</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success">
                            <i class="fe fe-mail"></i>
                        </span>
                        <div class="dash-count">
                            <h3 style="font-size: 1.2rem;">{{auth('hospital')->user()->email}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Email</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-warning border-warning">
                            <i class="fe fe-phone"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{auth('hospital')->user()->contact}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Contact</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
 

</div>
<script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>
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
@endsection
