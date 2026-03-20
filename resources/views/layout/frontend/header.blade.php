<header>
  <!-- Desktop Header -->
  <div class="container d-none d-md-block">
    <div class="row">
      <!-- First column: Logo -->
      <div class="col-md-2">
        <a class="navbar-brand p-2" href="{{url('/')}}">
          <img src="{{asset('frontend/assets/images/Logo.jpg')}}" class="img-fluid" width="80" alt="Logo" />
        </a>
      </div>

      <!-- Second column: Topbar and Main Menu -->
      <div class="col-md-10">
        <div class="container">
          <!-- Topbar -->
          <div class="row">
            <div class="col">
              <ul class="nav justify-content-end">
                <li class="nav-item">
                  <a class="nav-link" href="{{url('/privacy-policy')}}">Privacy Policy</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('/partner-with-us')}}">Partner with Us</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('/contact-us')}}">Contact Us</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{url('urgecare-services')}}">Urgecare Services</a>
                </li>
              </ul>
            </div>
          </div>

          <!-- Main Menu with Buttons -->
          <div class="row">
            <div class="col">
              <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="{{url('/about-us')}}">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> About Us
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('nonemergency')}}">
                        <i class="fa fa-ambulance" aria-hidden="true"></i> Emergency Ambulance
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{url('/services')}}">
                        <i class="fa fa-cogs" aria-hidden="true"></i> Services
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{url('/faq')}}">
                        <i class="fa fa-question-circle" aria-hidden="true"></i> FAQ
                      </a>
                    </li>
                    <div class="action-btn d-flex">
                      
                      <li class="nav-item">
                        <a class="nav-link btn btn-primary mr-2" onclick="getLocationAndSubmitForm()" href="#"> <i class="fa fa-map-marker-alt"
                            aria-hidden="true"></i> {{session()->has('city') ? session()->get('city') :'Allow Location'}}</a>
                      </li>
                      
                      <li class="nav-item">
                        <a class="btn btn-secondary" href="tel:+917888021021">
                          <i class="fa fa-phone-alt" aria-hidden="true"></i> Call Now
                        </a>
                      </li>
                    </div>
                  </ul>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Header -->
  <div class="container d-block d-md-none">
    <div class="row">
      <!-- Mobile Header: Logo and Toggler -->
      <div class="col-12">
        <nav class="navbar navbar-light">
          <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{asset('/frontend/assets/images/Logo.jpg')}}" class="img-fluid" width="80" alt="Logo" />
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobileNavbar"
            aria-controls="mobileNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mobileNavbar">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link"  href="{{url('/about-us')}}">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="{{route('nonemergency')}}">Emergency Ambulance</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"href="{{url('/services')}}">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="{{url('/faq')}}">FAQ</a>
              </li>
              <div class="mobile-btn d-flex">
                <li class="nav-item">
                  <a class="nav-link btn btn-primary mr-2" onclick="getLocationAndSubmitForm()" href="#"> <i class="fa fa-map-marker-alt"
                      aria-hidden="true"></i>  {{session()->has('city') ? session()->get('city') :'Allow Location'}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn btn-secondary" href="tel:+917888021021"> <i class="fa fa-phone-alt" aria-hidden="true"></i>
                    Call Now</a>
                </li>
              </div>
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </div>
</header>
