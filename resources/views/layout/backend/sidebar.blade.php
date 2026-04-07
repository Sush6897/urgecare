 <div class="sidebar" id="sidebar">
      <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
          <ul>
            <li class="menu-title">
              <span>Main</span>
            </li>
            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
              <a href="{{route('dashboard')}}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('hospital*') ? 'active' : '' }}">
              <a href="{{Route('hospital.index')}}"><i class="mdi mdi-hospital"></i> <span>Hospital</span></a>
            </li>
            <li class="{{ Request::is('partners*') ? 'active' : '' }}">
              <a href="{{Route('partners.create')}}"><i class="mdi mdi-handshake"></i> <span>Partner</span></a>
            </li>
            <li class="{{ Request::is('contact/*') ? 'active' : '' }}">
              <a href="{{Route('contact.create')}}"><i class="fe fe-mail"></i> <span>Contact</span></a>
            </li>
            <li class="{{ Request::is('enquiry*') ? 'active' : '' }}">
              <a href="{{Route('enquiry.index')}}"><i class="mdi mdi-hospital-box-outline"></i> <span>Enquiry</span></a>
            </li>
            <li class="{{ Request::is('user-visits*') ? 'active' : '' }}">
              <a href="{{Route('user-visits.index')}}"><i class="fe fe-users"></i> <span>User Visits</span></a>
            </li>
           
            <li class="{{ Request::is('profile*') ? 'active' : '' }}">
              <a href="{{route('profile')}}"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
            </li>
            <li class="{{ Request::is('setting*') ? 'active' : '' }}">
              <a href="{{route('setting.index')}}"><i class="fe fe-vector"></i> <span>Settings</span></a>
            </li>
          </ul>
        </div>
      </div>
    </div>