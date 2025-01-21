@extends('layouts.master') 

@section('seo_title', 'Login')

@section('header_custom_css')

<style>
  /*
	Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
table {
  border-collapse: collapse;
}

table, th, td {
  border: 1px solid black;
}
	
</style>

@endsection

@section('body_content')

	<div class="main-panel">

		<div class="content-wrapper">
			 <div class="col-lg-12 grid-margin stretch-card table-responsive">
                <div class="card" style = "overflow-x:auto;">
                  <div class="card-body">
                    <h4 class="card-title">Patient List</h4>
                    <!-- <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <table class="table table-hover" id = "example">
                      <thead>
                        <tr>
                          <!-- <th>Patient Id</th> -->
                          <th>Email</th>
                          <th>Name</th>
                          <!-- <th>Age</th> -->
                          <th>Mobile</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($patients_list as $patient) { ?>
                        <tr>
                          {{-- <td>{{ $patient['patient_id'] }}</td> --}}
                          <td>{{ $patient['email'] }}</td>
                          <td>{{ ucfirst($patient['name']) }}</td>
                          {{-- <td>{{ $patient['age'] }}</td> --}}
                          <td>{{ $patient['mobile'] }}</td>
                          <td><label class="badge badge-success show-patient-details" data-patient = "{{$patient['patient_id']}}" data-email = "{{$patient['email']}}" data-name = "{{ucfirst($patient['name'])}}" data-age = "{{$patient['age']}}" data-mobile = "{{$patient['mobile']}}" data-gender = "{{$patient['Gender']}}" data-created = "{{date('jS \of F Y',strtotime($patient['created_at']))}}">View</label>&nbsp;<a href = "{{url('hospital/patient/update/'.$patient['id'])}}"><label class="badge badge-success">Edit</label></a></td>
                        </tr>
                    <?php } ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
		</div>


		@include('layouts.blocks.footer')
	</div>

@endsection

@section('footer_custom_js')
<script type="text/javascript">
	// $('table').dataTable();

new DataTable('#example');

</script>
<script type="text/javascript">
  $('.show-patient-details').click(function(){

    $('#patient_id').text($(this).attr('data-patient'))
    $('#patient_name').text($(this).attr('data-name'))
    $('#patient_email').text($(this).attr('data-email'))
    $('#patient_age').text($(this).attr('data-age'))
    $('#patient_mobile').text($(this).attr('data-mobile'))
    if($(this).attr('data-gender') == 'M'){
      $('#patient_gender').text("Male")
    }
    if($(this).attr('data-gender') == 'F'){
      $('#patient_gender').text("Female")
    }
    if($(this).attr('data-gender') == 'O'){
      $('#patient_gender').text("Other")
    }
    $('#patient_created').text($(this).attr('data-created'))
    

    $('#patient_details').modal('show');
  })

  $('.cancel').click(function(){
    $('#patient_details').modal('hide');
  })
</script>
@endsection