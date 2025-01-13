@extends('layouts.master') 

@section('seo_title', 'Login')



@section('body_content')


	<div class="main-panel">

		<div class="content-wrapper">
			 <div class="col-lg-12 grid-margin stretch-card table-responsive">
                <div class="card" style = "overflow-x:auto;">
                  <div class="card-body">
                    <h4 class="card-title">Patient Queries</h4>
                    <!-- <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <table class="table table-hover" id = "example">
                      <thead>
                        <tr>
                          <!-- <th>Patient Id</th> -->
                          <th>Image</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Message</th>
                          <th>Department</th>
                          <th>Admin Reply</th>
                          <!-- <th>Reply</th> -->
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($query_list as $query)
                        <tr>
                          
                          <td>
                            @if($query->image)
                              <img src="{{ asset('storage/' . $query->image) }}" alt="Uploaded Image" width="300">
                            @else
                              -
                            @endif
                          </td>
                          <td>{{ ucfirst($query->name) }}</td>
                          <td>{{ $query->email }}</td>
                          <td>{{ $query->mobile }}</td>
                          <td>{{ $query->message }} {{ $query->query_type_id }}</td>
                          <td>
                            <select class="form-select" name = "query_type_sel" class = "query_type_sel" style="width: 150px;" onchange="updateDepartment('{{$query->id}}',this)">
                              <option value="">Please select</option>
                              @foreach($query_types as $types)
                              <option value="{{ $types['id'] }}" 
                                @if($query->query_type_id == $types['id'])
                                  selected = 'selected' 
                                @endif
                                >{{ $types['name'] }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>{{ !empty($query->message_reply_by_admin) ? $query->message_reply_by_admin : '-' }}</td>
                          {{--
                          @if($query->is_reply == 'no')
                          <td><label class="badge badge-danger">No</label></td>
                          @else
                          <td><label class="badge badge-success">Yes</label></td>
                          @endif
                          --}}
                          @if($query->is_reply == 'no')
                          <td><label class="badge badge-danger give-reply" data-id = "{{ $query->id }}" data-mob = "{{ $query->mobile }}" data-msg = "{{$query->message}}">Pending</label></td>
                          @else
                          <td><label class="badge badge-success">Replied</label></td>
                          @endif
                        </tr>
                        @endforeach
                
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
  new DataTable('#example');
 $('.give-reply').click(function(){

  $('#patient_reply').modal('show');
  $('#id').val($(this).attr('data-id'));
  $('#mob').val($(this).attr('data-mob'));
  $("textarea#patient_msg").val($(this).attr('data-msg'));
  $('#patient_msg').prop('disabled', true);

   });

  $('#reply_by_admin').click(function(e){

    let id = $('#id').val();
    let message = $('#message').val();
    let query_type_id = $('#query_type').val();
    let mob = $('#mob').val();

    if(message == ''){
      alert("Please enter message");
      return false;
    }

    if(query_type_id == ''){
      alert("Please select query type");
      return false;
    }


  $.ajax({
         url: "{{ url('hospital/reply') }}",
         type: "POST",
         data:{
          id:id,message:message,query_type_id:query_type_id,mob:mob
         },
         dataType: 'json',
         beforeSend: function(){
          // $('#invite-agent').attr('disabled','disabled');
          // $('#invite-agent').hide();
          // $('.fa-spin').css('font-size','24px');
          // $('.fa-spin').show();
         },
         success: function (data) {
          $('#patient_reply').modal('hide');
            if(data.status == true){



            swal({
              title: 'Success',
              text: 'Reply has been sent.',
              type: 'success',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
              closeOnConfirm: true
          },
           function(isConfirm) {
                if (isConfirm) {
                   location.reload();
                }
           });
               

             

            }else{
            
              swal({
              title: 'Oops..',
              text: 'Something went wrong!',
              type: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
              closeOnConfirm: true
          });

            }
         },
         error: function (jqXHR, textStatus, errorThrown) {
          $('#patient_reply').modal('hide');
             if (jqXHR.status == 500) {


        swal({
              title: 'Oops..',
              text: "Something went wromg.",
              type: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
              closeOnConfirm: true
          });

                
             } else {
                 console.log(jqXHR.responseText);
             }
         }
     });

  });
 




 $('.cancel').click(function(){

  $('#patient_reply').modal('hide');


 });

function updateDepartment(feedback_id,el){

  let dept_id = el.value

  $.ajax({
         url: "{{ url('hospital/update-dept') }}",
         type: "POST",
         data:{
          feedback_id:feedback_id,dept_id:dept_id
         },
         dataType: 'json',
         beforeSend: function(){
         },
         success: function (data) {
         
            if(data.status == true){



            swal({
              title: 'Success',
              text: data.msg,
              type: 'success',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
              closeOnConfirm: true
          },
           function(isConfirm) {
                if (isConfirm) {
                   location.reload();
                }
           });
               

             

            }else{
            
              swal({
              title: 'Oops..',
              text: 'Something went wrong!',
              type: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
              closeOnConfirm: true
          });

            }
         },
         error: function (jqXHR, textStatus, errorThrown) {
             if (jqXHR.status == 500) {


        swal({
              title: 'Oops..',
              text: "Something went wromg.",
              type: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
              closeOnConfirm: true
          });

                
             } else {
                 console.log(jqXHR.responseText);
             }
         }
     });

}
</script>
@endsection