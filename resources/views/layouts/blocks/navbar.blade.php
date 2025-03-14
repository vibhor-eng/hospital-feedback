
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <!-- <div class="nav-profile-image">
                  <img src="../../assets/images/faces/face1.jpg" alt="profile" />
                  <span class="login-status online"></span>
                  change to offline or busy as needed
                </div> -->
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">{{ ucfirst(Auth::user()->name) }}</span>
                  <!-- <span class="text-secondary text-small">Patient</span> -->
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
             @if(Auth::user()->user_type == 'user')
            <li class="nav-item <?php if(Request::segment(2) == 'dashboard') { echo 'active'; } ?>">
              <a class="nav-link" href="{{ route('patient.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <!-- <li class="nav-item <?php //if(Request::segment(2) == 'feedback') { echo 'active'; } ?>">
              <a class="nav-link" href="{{ route('patient.feedback') }}">
                <span class="menu-title">Feedback</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li> -->
            @else
            <li class="nav-item <?php if(Request::segment(2) == 'dashboard') { echo 'active'; } ?>">
              <a class="nav-link" href="{{ route('hospital.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            @endif

             @if(Auth::user()->user_type == 'admin')

             <!-- Patient -->
             <li class="nav-item <?php if(Request::segment(2) == 'patient-list' || Request::segment(2) == 'patient-queries' || Request::segment(2) == 'patient-reset-password') { echo 'active'; } ?>">
              <a class="nav-link collapsed" data-bs-toggle="collapse" href="#forms" aria-expanded="<?php if(Request::segment(2) == 'patient-list' || Request::segment(2) == 'patient-queries' || Request::segment(2) == 'patient-reset-password') { echo 'true'; } ?>" aria-controls="forms">
                <span class="menu-title">Patient</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
              </a>
              <div class="collapse <?php if(Request::segment(2) == 'patient-list' || Request::segment(2) == 'patient-queries' || Request::segment(2) == 'patient-reset-password') { echo 'show'; } ?>" id="forms" style="">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link <?php if(Request::segment(2) == 'patient-list') { echo 'active'; } ?>" href="{{ route('hospital.patient.list') }}">Patient List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if(Request::segment(2) == 'patient-queries') { echo 'active'; } ?>" href="{{ route('hospital.patient.queries') }}">Patient Queries</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if(Request::segment(2) == 'patient-reset-password') { echo 'active'; } ?>" href="{{ route('hospital.reset-password') }}">Patient Reset Password</a>
                  </li>
                </ul>
              </div>
            </li>

            

            <!-- ##Queries Type -->

            <li class="nav-item <?php if(Request::segment(2) == 'query') { echo 'active'; } ?>">
              <a class="nav-link collapsed" data-bs-toggle="collapse" href="#query" aria-expanded="<?php if(Request::segment(2) == 'query') { echo 'true'; } ?>" aria-controls="forms">
                <span class="menu-title">Query</span>
                <i class="mdi mdi-table-large menu-icon"></i>
              </a>
              <div class="collapse <?php if(Request::segment(3) == 'list' || Request::segment(3) == 'create') { echo 'show'; } ?>" id="query" style="">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link <?php if(Request::segment(3) == 'list') { echo 'active'; } ?>" href="{{ route('hospital.query.list') }}">Query List</a>
                  </li>
                 


                </ul>
              </div>
            </li>
         
            @endif
  
          </ul>
        </nav>
        
   