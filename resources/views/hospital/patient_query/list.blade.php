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
td img{
      width: 300px;
    }
	@media
	  only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {

		/* Force table to not be like tables anymore */
		table, thead, tbody, th, td, tr {
			display: block;
		}

    td img{
      width: 50px;
    }

		/* Hide table headers (but not display: none;, for accessibility) */
		thead tr {
			position: absolute;
			top: -9999px;
			left: -9999px;
		}

    tr {
      margin: 0 0 1rem 0;
    }
      
    tr:nth-child(odd) {
      background: #ccc;
    }
    
		td {
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee;
			position: relative;
			padding-left: 50%;
		}

		td:before {
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 0;
			left: 6px;
			width: 45%;
			padding-right: 10px;
			white-space: nowrap;
		}

		/*
		Label the data
    You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
		*/
		td:nth-of-type(1):before { content: "Image"; }
		td:nth-of-type(2):before { content: "Name"; }
		td:nth-of-type(3):before { content: "Email"; }
		td:nth-of-type(4):before { content: "Mobile"; }
		td:nth-of-type(5):before { content: "Department"; }
		td:nth-of-type(6):before { content: "Action"; }
	}
</style>

@endsection


@section('body_content')


	<div class="main-panel">

		<div class="content-wrapper">
			 <div class="col-lg-12 grid-margin stretch-card table-responsive">
                <div class="card" style = "overflow-x:auto;">
                  <div class="card-body">
                    <h4 class="card-title">Patient Queries</h4>
                    <!-- <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <table class="table table-hover" id = "example" role="table">
                      <thead role="rowgroup">
                        <tr role="row">
                          <!-- <th>Patient Id</th> -->
                          <th role="columnheader">Image</th>
                          <th role="columnheader">Name</th>
                          <th role="columnheader">Email</th>
                          <th role="columnheader">Mobile</th>
                          <!-- <th>Message</th> -->
                          <th role="columnheader">Department</th>
                          <!-- <th>Admin Reply</th> -->
                          <!-- <th>Reply</th> -->
                          <th role="columnheader">Action</th>
                        </tr>
                      </thead>
                      <tbody role="rowgroup">
                        @foreach($query_list as $query)
                        <tr role="row">
                          
                          <td role="cell">
                            @if($query->image)
                              <img src="https://cubedigital.tech/storage/images/7pVHfsrLE70vFqhc2JRfoCfSh7ph9ZCCMSdXrCGw.jpg" alt="Uploaded Image">
                            @else
                              -
                            @endif
                          </td>
                          <td role="cell">{{ ucfirst($query->name) }}</td>
                          <td role="cell">{{ $query->email }}</td>
                          <td role="cell">{{ $query->mobile }}</td>
                          {{--<td>{{ $query->message }} {{ $query->query_type_id }}</td>--}}
                          <td role="cell">
                            <select class="form-select" name = "query_type_sel" class = "query_type_sel" onchange="updateDepartment('{{$query->id}}',this)">
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
                          {{--<td>{{ !empty($query->message_reply_by_admin) ? $query->message_reply_by_admin : '-' }}</td>--}}
                          {{--
                          @if($query->is_reply == 'no')
                          <td role="cell"><label class="badge badge-danger">No</label></td>
                          @else
                          <td role="cell"><label class="badge badge-success">Yes</label></td>
                          @endif
                          --}}
                          @if($query->is_reply == 'no')
                          <td role="cell"><label class="badge badge-danger give-reply" data-id = "{{ $query->id }}" data-mob = "{{ $query->mobile }}" data-msg = "{{$query->message}}">Pending</label></td>
                          @else
                          <td role="cell"><label class="badge badge-success">Replied</label></td>
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


// on change screen sise add and remove class
  $(window).resize(() => {
    if (window.matchMedia('(max-width: 767px)').matches) {
      $('table').removeClass('table table-hover dataTable');
    } else {
      $('table').addClass('table table-hover dataTable');
    }
  })


  


</script>
@endsection