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
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form class="pt-3" id = "register_patient_form" method = "post" action = "{{ route('patient.register') }}">
                  @csrf
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name = "name" id="name" placeholder="Name">
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" name = "email" id="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name = "password" id="password" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name = "confirm_password" id="confirm_password" placeholder="Confirm Password">
                  </div>
                  <div class="form-group">
                    <input type="number" class="form-control form-control-lg" name = "age" id="age" placeholder="Age">
                  </div>
                  <div class="form-group">
                    <input type="number" class="form-control form-control-lg" id="mobile" name = "mobile" placeholder="Mobile">
                  </div>
                  <div class="form-group">
                    <input type="number" class="form-control form-control-lg" name = "ip_number" id="ip_number" placeholder="IP Number">
                  </div>
                  <div class="form-group">
                    <select class="form-select form-select-lg" name = "gender" id="exampleFormControlSelect2">
                      <option value = "">--Select Gender--</option>
                      <option value = "M">Male</option>
                      <option value = "F">Female</option>
                      <option value = "O">Other</option>
                    </select>
                  </div>
                  
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions </label>
                    </div>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type = "submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="{{ route('patient.login.form') }}" class="text-primary">Login</a>
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


      $('#register_patient_form').validate({ // initialize the plugin
          rules: {
              email: {
                  required: true,
                  email: true,
              },
              password:{
                required:true,
                minlength:6,
                maxlength:8,
              },
              password:{
                required:true,
                minlength:6,
                maxlength:8,
              },
              confirm_password: {
                required: true,
                equalTo: "#password",  // Use the custom method for password confirmation
              },
              name: {
                  required: true,
              },
              age: {
                  required: true,
                  number:true,
              },
              mobile: {
                  required: true,
                  number:true,
                  minlength:10,
                  maxlength:12,
              },
              ip_number: {
                  required: true,
                  number:true,
                  minlength:12,
                  maxlength:15,
              },
              gender: {
                  required: true,
              },
          },
          submitHandler: function(form) {
            alert("Form is valid and ready for submission.");
            form.submit(); // Submit the form if valid
          }
      });

  });

  </script>

@endsection