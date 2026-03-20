<div class="header">

      <div class="header-left">
        <a href="{{route('hospital.dashboard')}}" class="logo">
          <img src="{{asset('/frontend/assets/images/download.png')}}" alt="Logo">
        </a>
        <a href="{{route('hospital.dashboard')}}" class="logo logo-small">
          <img src="{{asset('/backend/assets/img/favicon1.png')}}" alt="Logo" width="30" height="30">
        </a>
      </div>


      <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
      </a>

   


      <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
      </a>

      <ul class="nav user-menu">

   
        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow">
          <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <span class="user-img"><img class="rounded-circle" src="{{asset('/backend/assets/img/profiles/avatar-01.jpg')}}" width="31" alt="Ryan Taylor"></span>
          </a>
          <div class="dropdown-menu">
            <div class="user-header">
              <div class="avatar avatar-sm">
                <img src="{{asset('/backend/assets/img/profiles/avatar-01.jpg')}}" alt="User Image" class="avatar-img rounded-circle">
              </div>
              <div class="user-text">
                <h6>{{auth('hospital')->user()->hospital_name ?? 'Hospital'}}</h6>
                <p class="text-muted mb-0">Hospital Partner</p>
              </div>
            </div>

            <form id="logout-form" action="{{ route('hospital.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="dropdown-item" href="{{ route('hospital.profile') }}">My Profile</a>
            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
          </div>
        </li>
        <!-- /User Menu -->

      </ul>


    </div>
