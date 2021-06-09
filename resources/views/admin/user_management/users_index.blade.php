<?php $get_SessionData = Session::get('admin_session'); ?>
    <main>
        <div class="container-fluid">
            <!-- <h1 class="mt-4">Leads </h1> -->
          
             <ol class="breadcrumb mb-4 mt-4 onscrollFixed">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard/index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>

            <div class="breadcrumb mb-4 mt-4 onscrollFixed">
                <form id="search_filter" action="javascript:void(0);"> 
                    <div class="row flex__box"> 
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="fullname">Name</label>
                                <input type="text"  id="fullname" name="fullname" value="" placeholder="Name" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="email">Email</label>
                                <input type="text"  id="email" name="email" value="" placeholder="Email" class="form-control">
                            </div>
                        </div>  
                        <div class="col mt-31 ">
                            <div class="form-group" >  
                                <button type="button" class="btn  btn-secondary active searchbtn" onclick="searchFilter();" style="width: 70px;" >Search</button>
                                <input type="submit" class="btn  btn-secondary clearbtn" onclick="resetFilter();" style="width: 70px;" value="Clear"> 
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>Profile Image</th> 
                                    <th>Created At</th>
                                    <th>Action</td>  
                                </tr>
                            </thead> 
                            <tbody><!-- Data will come from datatables by AJAX --></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
   
        
    <!--  model open -->
        <div id="UserModel" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit User Details</h4>
                    </div>
                    <!-- Modal body start-->
                        <div class="modal-body modalBody" id="modalBody">
                            <!-- data will come by ajax -->
                        </div>
                    <!-- Modal body end-->
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>
    <!--  model end -->   

<script type="text/javascript"> 
    $(document).ready(function() {
        $(window).scroll(function(){
            if ($(window).scrollTop() >= 50) { 
                //$('.onscrollFixed').addClass('fixed-header'); 
            }
            else {
                //$('.onscrollFixed').removeClass('fixed-header'); 
            }
        });
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 20,
            retrieve: true, 
            responsive: true,
            fixedHeader: true, 
            scrollY: "300px",
            scrollCollapse: true,
            
            // language: { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
            //aaSorting: [[ 0, 'desc' ]], 
            ordering: false, //disable order asc or desc
            pageLength: 8,
            columnDefs: [  
                {
                    "aTargets": [0], 
                    "mRender": function(data, type, full){
                        return '<td>#'+full['id']+'</td>';
                    }
                }, 
                {
                    "aTargets": [4], 
                    "mRender": function(data, type, full){
                        var action = '';
                        if(full['image']){
                            action += '<td><img height="50" src="<?php echo url('/uploads/user_images').'/';?>'+full['id']+"/"+full['image']+'"/></td>';
                        }else{
                            action += '<td><img height="50" src="<?php echo url('/uploads/user_images').'/user_profile.png';?>"/></td>';
                        }
                        return action;
                    }
                },
                {
                    "aTargets": [6],
                    "width": 100,
                    "className": "text-center",  
                    "mRender": function(data, type, full){
                        var action = '<td><button onclick="editDetails('+full['id']+')" type="button" data-toggle="modal" data-target="#UserModel" title="Edit" style="background:none;border:none"><i class="fas fa-edit" style="font-size: 15px;color:green;"></i></button>';
                        // if(full['ustatus']=='Active'){
                        //     action += '<button onclick="changeStatus('+full['id']+')" type="button" title="Active" style="background:none;border:none"><i class="fas fa-eye" style="font-size: 15px;color:green;"></i></button>';
                        // }else{
                        //     action += '<button onclick="changeStatus('+full['id']+')" type="button" title="inActive" style="background:none;border:none"><i class="fas fa-eye-slash" style="font-size: 15px;color:red;"></i></button>';
                        // }
                        // action += '| <button onclick="deleteUser('+full['id']+')" type="button" title="Delete" style="background:none;border:none"><i class="fas fa-trash-alt" style="font-size: 15px;color:red;"></i></button></td>';
                        return action;
                    }   
                }
            ],
            ajax: {
              url: '{!! URL::asset('manage-users/getUsers') !!}',
              data: function ( d ) {
                    d.userId = '<?php echo $get_SessionData["id"]; ?>'
                }  
                //beforeSend:function(){ beforeSend(); },
            },
            //initComplete:function(){ afterSend(); },
            columns : [  
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'urole', name: 'urole' }, 
                        { data: 'image', name: 'image' },
                        { data: 'cr_date', name: 'cr_date' },  
                         
            ],
        }); 
    });

    $( ".datepick" ).datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 0, //disable future dates in calender
        changeMonth: true,
        changeYear: true,
    });
      
    function resetFilter(){
        $('#search_filter')[0].reset();
        loadhtmlView('/manage-users','page');
    }
    $("#fullname").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(1).search($(this).val()).draw(); 
    });
    $("#email").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(2).search($(this).val()).draw(); 
    }); 

    function searchFilter(){
        var dataTable = $('#dataTable').DataTable();
        var fullname  = $('#fullname').val();
        var email     = $('#email').val();     
        dataTable.draw();
    }
 

    function editDetails(id){ 
        $.ajax({
            type: 'get',
            url: baseUrl + '/manage-users/getUserDetails/' + id, 
            dataType: 'json',
            beforeSend:function(){ beforeSend(); },
            success: function(res) {
                afterSend();  
                if(res.response_msg==='success'){
                    $('#modalBody').html(res.data.body);
                }else if(res.response_msg==='error'){ 
                    swal("Something went wrong!",{ icon:"error", timer:2000 });
                }
            }
        });
    }


</script>

