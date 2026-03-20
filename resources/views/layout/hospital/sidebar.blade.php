<style>
    .hospital-sidebar .sidebar-menu ul li.active a {
        background-color: #bae6fd !important; /* Lighter sky blue for active */
        color: #0369a1 !important; /* Softer blue text */
        border-radius: 5px;
    }
    .hospital-sidebar .sidebar-menu ul li a:hover {
        background-color: #e0f2fe !important; /* Very light sky blue for hover */
        color: #0369a1 !important;
        border-radius: 5px;
    }
    .hospital-sidebar .sidebar-menu ul li.active a i,
    .hospital-sidebar .sidebar-menu ul li a:hover i {
        color: #0369a1 !important; /* Softer blue icon color */
    }
</style>
 <div class="sidebar hospital-sidebar" id="sidebar">
      <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
          <ul>
            <li class="menu-title">
              <span>Main</span>
            </li>
            <li class="{{ Request::is('hospital/dashboard*') ? 'active' : '' }}">
              <a href="{{route('hospital.dashboard')}}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('hospital/enquiry*') ? 'active' : '' }}">
              <a href="{{route('hospital.enquiry')}}"><i class="mdi mdi-hospital-box-outline"></i> <span>Enquiry</span></a>
            </li>
            <li class="{{ Request::is('hospital/profile*') ? 'active' : '' }}">
              <a href="{{route('hospital.profile')}}"><i class="fe fe-user"></i> <span>Profile</span></a>
            </li>
          </ul>
        </div>
      </div>
    </div>