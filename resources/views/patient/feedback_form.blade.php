@extends('layouts.master') 

@section('seo_title', 'Login')

@section('header_custom_css')

<style type="text/css">
input:read-only {
  border: 0;
  box-shadow: none;
  background-color: #ddd;
}


.btn-file {
    position: relative;
    overflow: hidden;
}

/*.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
.input-group {
margin-bottom: 30px;
}

#img-upload{
    width: 150px;
    height: 150px;
}

.as-console-wrapper {
display: none !important;
}*/
</style>

@endsection


@section('body_content')

<!-- partial -->
        <div>

        	
	          <div class="content-wrapper">
	            
	         <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  	@include('layouts.blocks.error')
                	@include('layouts.blocks.success')
                    <h4 class="card-title text-center">Patient Feedback Form</h4>
                    <div class="brand-logo text-center">
                        <img src="{{ asset('assets/images/logo.png') }}" style = "width:75px;">
                    </div>
                <form class="forms-sample" id = "feedback-form" action = "{{ route('patient.feedback') }}" method = "post" enctype="multipart/form-data">
                    @csrf

                    

        		    <div class="form-group">
                        <div class = "row">
                            <div class = "col-md-6">
                		        <label>Upload Image</label>
                                <input type="file" id="imageUpload" class="form-control" name = "feedback_img" accept="image/*">
                            </div>
                            <div class = "col-md-6">
                                <label for="exampleInputPassword4">Name</label>
                                <input type="text" value = "{{ $name }}" name = "name" id = "name" class="form-control" readonly>

                                <input type="hidden" value = "{{ $patient_id }}" name = "patient_id" id = "patient_id" class="form-control" readonly>
                            </div>
                        </div>
        		    </div>

                    <div class="form-group">
                        <div class = "row">
                            <div class = "col-md-6">
                                <label for="exampleInputPassword4">Email</label>
                                <input type="email" value = "{{ $email }}" name = "email" id = "email" class="form-control" readonly>
                            </div>
                            <div class = "col-md-6">
                                <label for="exampleInputPassword4">Age</label>
                                <input type="text" value = "{{ $age }}" name = "age" id = "age" class="form-control" readonly>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class = "row">
                            <div class = "col-md-6">
                                <label for="exampleInputPassword4">Mobile</label>
                                <input type="text" value = "{{ $mobile }}" name = "mobile" id = "mobile" class="form-control" readonly>
                            </div>
                            <div class = "col-md-6">
                                <label for="exampleTextarea1">Message</label>
                                <textarea class="form-control" id="message" name = "message" rows="4"></textarea>
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


      $('#feedback-form').validate({ // initialize the plugin
          rules: {
              email: {
                  required: true,
                  email: true,
              },
              message: {
                  required: true,
              },
              
          },
          submitHandler: function(form) {
            form.submit(); // Submit the form if valid
          }
      });

  });

    $(document).ready( function() {
         // Get the input element and the preview image element
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('imagePreview');

        // Event listener to handle the image upload
        imageUpload.addEventListener('change', function(event) {
            const file = event.target.files[0];

            const filename = file.name;

            const extension = filename.split('.').pop().toLowerCase(); 

            if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'gif'){
            
                // Check if a file is selected
                if (file) {
                    const reader = new FileReader();

                    // When the file is loaded, set the preview image source
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';  // Show the image
                    }

                    // Read the image file as a data URL
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none'; // Hide the image if no file is selected
                }
            }else{
                alert("Please upload only images.")
                $('#imageUpload').val('');
                return false;
            }
        });     
    });

  </script>

@endsection