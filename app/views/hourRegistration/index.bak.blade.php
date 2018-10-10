@extends('layouts.layout')
@section('content')  
<?php
if (isset($_GET['page'])) {
    if ($_GET['page'] >= 2) {
        $start = 1 + (10 * ($_GET['page'] - 1));
        //echo $start; die;
    } else {
        $start = 1;
    }
} else {
    $start = 1;
}
?>  


            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Hour registration's</h4>
<!--                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
                                <div class="table-responsive m-t-40">
                                    <table id="users_datatables" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Worker</th>
                                                <th>Project</th>
                                                <th>Date</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Break( in hour)</th>
                                                <th>Worked Hour</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->

<script>


function changeStatus(id)
{
    $.ajax({
        url: '{{route('projects.status')}}',
        type: 'POST',
        data:{user_id:id},
        headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          $("#status_"+id).html(response);
        }
    });
}

  $(function() {
    var table = $('#users_datatables').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, "desc" ]],
    "ajax":{
    "url": '{!! route('hour-registration.datatables') !!}',
    "dataType": "json",
    "type": "POST",

    "data":{ _token: "{{csrf_token()}}"}
    },
    columns: [ 
      { data: 'id', name: 'id', orderable:true },
      { data: 'worker', name: 'worker', orderable:true  },
      { data: 'project', name: 'project', orderable:true},      
      { data: 'date', name: 'date', orderable:true},
      { data: 'start_time', name: 'start_time', orderable:false },
      { data: 'end_time', name: 'end_time', orderable:false},
      { data: 'break', name: 'break', orderable:false},
      { data: 'total_hours', name: 'total_hours', orderable:false},
      { data: 'action', name: 'action', orderable:false }  
    ],
    "columnDefs": [
    { "searchable": false, "targets": 0 }
    ]
    ,language: {
        searchPlaceholder: "Search by id,full name or email"
    }
    });    
  });
  
function confirm_click(e){
    var r = confirm("Are you sure want to delete!");
    if (r == true) {
        $(e).closest('form').submit();
    } 
}
</script>

@endsection