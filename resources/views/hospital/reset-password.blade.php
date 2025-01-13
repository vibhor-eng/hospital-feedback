@extends('layouts.master') 

@section('seo_title', 'Login')



@section('body_content')

<!-- partial -->
        <div class="main-panel">
        	
	          <div class="content-wrapper">
	            
	         <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  	@include('layouts.blocks.error')
                	@include('layouts.blocks.success')
                    <h4 class="card-title">Reset Password For Patient</h4>
                    <form class="forms-sample" id = "reset-password" action = "{{ route('hospital.reset-password') }}" method = "post">
                    	@csrf
                      
                    <div class="form-group">
                        <label for="exampleInputPassword4">Email</label>
                        <input type="email" name = "email" class="form-control" id="email" placeholder="Email">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword4">Password</label>
                        <input type="password" name = "password" class="form-control" id="password" placeholder="Password">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword4">Confirm Password</label>
                        <input type="password" name = "confirm_password" class="form-control" id="confirm_password" placeholder="Password">
                      </div>
                      
                      
                      
                      <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    </form>
                  </div>
                </div>
              </div>

	          </div>
	          
	          @include('layouts.blocks.footer')
          
        </div>
        

@endsection

@section('footer_custom_js')

  <script type="text/javascript">
    
    $(document).ready(function () {


      $('#reset-password').validate({ // initialize the plugin
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
              confirm_password: {
                required: true,
                equalTo: "#password",  // Use the custom method for password confirmation
              },
          },
          submitHandler: function(form) {
            form.submit(); // Submit the form if valid
          }
      });

  });

  </script>

@endsection