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
                    <h4 class="card-title">Update Patient Details</h4>
                    <form class="forms-sample" id = "update-patient" action = "{{ route('hospital.patient.update') }}" method = "post">
                    	@csrf

                      
                        
                        <input type = "hidden" name = "id" value = "{{ $patient_details['id'] }}">

                        <div class="form-group">
                            <div class = "row">
                              <div class = "col-md-6">
                                <label for="exampleInputPassword4">Email</label>
                                <input type="email" name = "email" class="form-control" id="email" placeholder="Email" value = "{{ $patient_details['email'] }}">
                              </div>

                              <div class = "col-md-6">
                                <label for="exampleInputPassword4">Name</label>
                                <input type="test" name = "name" class="form-control" id="name"  placeholder="Name" value = "{{ $patient_details['name'] }}">
                              </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class = "row">
                              <div class = "col-md-6">
                                <label for="exampleInputPassword4">Age</label>
                                <input type="text" name = "age" class="form-control" id="age"  placeholder="Age" value = "{{ $patient_details['age'] }}">
                              </div>

                              <div class = "col-md-6">
                                <label for="exampleInputPassword4">Mobile</label>
                                <input type="text" name = "mobile" class="form-control" id="mobile" placeholder="Mobile" value = "{{ $patient_details['mobile'] }}">
                              </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class = "row">
                              <div class = "col-md-6">
                                <label for="exampleInputPassword4">Gender</label>
                                <select class="form-select" name = "gender" id="exampleFormControlSelect2">
                                  <option value = "">--Select Gender--</option>
                                  <option value = "M" @if($patient_details['Gender'] == 'M') selected = 'selected' @endif>Male</option>
                                  <option value = "F" @if($patient_details['Gender'] == 'F') selected = 'selected' @endif>Female</option>
                                  <option value = "O" @if($patient_details['Gender'] == 'O') selected = 'selected' @endif>Other</option>
                                </select>
                              </div>
                            </div>
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