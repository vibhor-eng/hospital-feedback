@extends('layouts.master') 

@section('seo_title', 'Login')



@section('body_content')
    
<div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{ asset('assets/images/logo.png') }}">
                </div>
                @include('layouts.blocks.error')
                @include('layouts.blocks.success')
                <h4>Patient Login</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form class="pt-3" id = "login_patient_form" method = "post" action = "{{ route('patient.login') }}">
                    @csrf
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="email" name = "email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="password" placeholder="Password" name = "password">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type = "submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                  </div>
                  <!-- <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                    </div>
                    <a href="#" class="auth-link text-primary">Forgot password?</a>
                  </div> -->
                  <!-- <div class="mb-2 d-grid gap-2">
                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                      <i class="mdi mdi-facebook me-2"></i>Connect using facebook </button>
                  </div> -->
                  <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="{{ route('patient.register.form') }}" class="text-primary">Create</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

@endsection

@section('footer_custom_js')

  <script type="text/javascript">
    
    $(document).ready(function () {


      $('#login_patient_form').validate({ // initialize the plugin
          rules: {
              email: {
                  required: true,
                  email: true,
              },
              password:{
                required:true,
              },
          },
          submitHandler: function(form) {
            form.submit(); // Submit the form if valid
          }
      });

  });

  </script>

@endsection