@extends('layouts.master') 

@section('seo_title', 'Login')



@section('body_content')

	<div class="main-panel">

		<div class="content-wrapper">
			 <div class="col-lg-12 grid-margin stretch-card">
                <div class="card" style = "overflow-x:auto;">
                  <div class="card-body">
                    <h4 class="card-title">Department List <button type="button" class = "btn btn-primary create-query">Add New Query</button></h4>
                    </p>
                    <table class="table table-hover" id = "example">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($query_list as $key => $query) { ?>
                        <tr>
                          <td>{{ $key+1 }}</td>
                          <td>{{ $query['name'] }}</td>
                          <td><label class="badge badge-danger delete-query" data-id = "{{ $query['id'] }}">Delete</label>&nbsp;<label class="badge badge-primary update-query" data-id = "{{ $query['id'] }}" data-name = "{{ $query['name'] }}">Edit</label></td>
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

    $('.create-query').click(function(){
     $('#add_query').modal('show');  
   });


  $('#save_query').click(function(){

    
    let name = $('#name').val();

    if(name == ''){
      alert("Please enter name");
      return false;
    }


  $.ajax({
         url: "{{ url('hospital/query/create') }}",
         type: "POST",
         data:{
         name:name
         },
         dataType: 'json',
         beforeSend: function(){
          // $('#invite-agent').attr('disabled','disabled');
          // $('#invite-agent').hide();
          // $('.fa-spin').css('font-size','24px');
          // $('.fa-spin').show();
         },
         success: function (data) {
          $('#add_query').modal('hide');
            if(data.status == true){



            swal({
              title: 'Success',
              text: 'Query has been added successfully..',
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
          $('#add_query').modal('hide');
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

  $(['#add_query','#update_query']).modal('hide');


 });

// update query

$('.update-query').click(function(){

  let query_id = $(this).attr('data-id');
  let query_name = $(this).attr('data-name');


  $('#query_id').val(query_id);
  $('#query_name').val(query_name);

  $('#update_query').modal('show');

});

$('#update_query_save').click(function(e){
  let query_id = $('#query_id').val();
  let query_name = $('#query_name').val();


  $.ajax({
         url: "{{ url('hospital/query/update') }}",
         type: "POST",
         data:{
          query_id:query_id,query_name:query_name
         },
         dataType: 'json',
         beforeSend: function(){
          // $('#invite-agent').attr('disabled','disabled');
          // $('#invite-agent').hide();
          // $('.fa-spin').css('font-size','24px');
          // $('.fa-spin').show();
         },
         success: function (data) {
          $('#update_query').modal('hide');
            if(data.status == true){



            swal({
              title: 'Success',
              text: 'Query has been updated.',
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
          $('#update_query').modal('hide');
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

// end update query


// Delete query

$('.delete-query').click(function(){
  let query_id = $(this).attr('data-id');
  swal({
        title: "Are you sure?",
      text: "Your will not be able to recover this record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },

    function(isConfirm) {
        if (isConfirm) {
            delete_query(query_id);
        }
    });
})

  function delete_query(id){
  
    $.ajax({
      url: "{{ url('hospital/query/delete') }}",
          type: "POST",
      data:{id:id},
      success:function(resp){
        if(resp.status==true){
          swal({
                  title: 'Success',
                  text: 'Record has been deleted.',
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
          },
           function(isConfirm) {
                if (isConfirm) {
                   location.reload();
                }
           });

                
             } else {
                 console.log(jqXHR.responseText);
             }
         }
    })
  }

</script>
@endsection