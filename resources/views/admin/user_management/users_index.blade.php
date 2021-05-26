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
            <a class="add_x" data-toggle="modal" href="#UserAddModel">+ Add User</a> 
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th> 
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

    <!--  model open -->
        <div id="UserAddModel" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add User</h4>
                    </div>
                    <!-- Modal body start-->
                        <div class="modal-body modalBody" id="">
                            <div class="card-body loginform">
                                <p class="formError text-center hidden"></p>
                                <p class="formSuccess text-center hidden" style="color:green"></p>
                                <form action="javascript:void(0);" id="add_user" class="" method="post" name="login" autocomplete="off">
                                    <div class="form-group mb0">
                                        <label class="small mb-1" for="f_name">First Name</label>
                                        <input class="form-control fs12" name="f_name" id="f_name" type="text" placeholder="Enter Firstname" onkeypress="removeError()" />
                                        <span class="error" id="err_f_name"></span>
                                    </div>
                                    <div class="form-group mb0">
                                        <label class="small mb-1" for="l_name">Last Name</label>
                                        <input class="form-control fs12" name="l_name" id="l_name" type="text" placeholder="Enter Lastname" onkeypress="removeError()" />
                                        <span class="error" id="err_l_name"></span>
                                    </div>
                                    <div class="form-group mb0">
                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                        <input class="form-control fs12" name="email" id="inputEmailAddress" onblur="accountCheck();removeError()"  type="text" placeholder="Enter Email"  />
                                        <span class="error" id="err_email"></span>
                                        <span class="hidden" id="email_exists"></span>
                                    </div>
                                    <div class="form-group mb0">
                                        <label class="small mb-1" for="u_type">Role</label>
                                        <select class="form-control fs12" name="u_type" id="u_type" onchange="removeError()">
                                            <option value="">--Select--</option>
                                            <option value="2">Admin</option>
                                            <option value="3">User</option>
                                        </select>  
                                        <span class="error" id="err_u_type"></span>
                                    </div>
                                    <div class="form-group mb0">
                                        <label class="small mb-1" for="inputPassword">Password</label>
                                        <input class="form-control fs12 security" name="password" id="inputPassword" type="text" placeholder="Enter Password" onkeypress="removeError()" />
                                        <span class="p-viewer">
                                            <i class="fa fa-eye" aria-hidden="true" onclick="show_hide_pass()"></i>
                                        </span>
                                        <span class="p-viewer2">
                                            <i class="fa fa-eye-slash" aria-hidden="true" onclick="show_hide_pass()"></i>
                                        </span>
                                        <span class="error" id="err_password"></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="small mb-1" for="conf_pass">Confirm Password</label>
                                        <input class="form-control fs12 security" name="conf_pass" id="conf_pass" type="text" placeholder="Enter Password Again" onkeypress="removeError()" /> 
                                        <span class="error" id="err_conf_pass"></span>
                                    </div>
                                    
                                    <!-- <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                            <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                            <span class="errorclass" ></span>
                                        </div>
                                    </div> -->
                                    <div class="form-group text-center">
                                        <!-- <a class="small" href="password.php">Forgot Password?</a> -->
                                        <button type="submit" id="submit" name="submit" onclick="add_user();" class="btn btn-primary login_submit" href="javascript:void(0)" >Register</button>
                                        <button  id="process" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
                                        <button type="button" id="close_model" class="btn btn-danger login_submit" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
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
                    "aTargets": [6],
                    "width": 100,
                    "className": "text-center", 
                    <?php if($get_SessionData['user_role']==1 || $get_SessionData['user_role']==2) { ?>
                    "mRender": function(data, type, full){
                        var action = '<td><button onclick="editDetails('+full['id']+')" type="button" data-toggle="modal" data-target="#UserModel" title="Edit" style="background:none;border:none"><i class="fas fa-edit" style="font-size: 15px;color:green;"></i></button> |';
                        if(full['ustatus']=='Active'){
                            action += '<button onclick="changeStatus('+full['id']+')" type="button" title="Active" style="background:none;border:none"><i class="fas fa-eye" style="font-size: 15px;color:green;"></i></button>';
                        }else{
                            action += '<button onclick="changeStatus('+full['id']+')" type="button" title="inActive" style="background:none;border:none"><i class="fas fa-eye-slash" style="font-size: 15px;color:red;"></i></button>';
                        }
                        action += '| <button onclick="deleteUser('+full['id']+')" type="button" title="Delete" style="background:none;border:none"><i class="fas fa-trash-alt" style="font-size: 15px;color:red;"></i></button></td>';
                        return action;
                    }
                    <?php }else{ ?> 
                        "visible":false,
                    <?php } ?>   
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
                        { data: 'fullname', name: 'fullname' },
                        { data: 'email', name: 'email' },
                        { data: 'urole', name: 'urole' },
                        { data: 'ustatus', name: 'ustatus' }, 
                        { data: 'cr_date', name: 'cr_date' }, 
                        { data: 'remember_token', name: 'remember_token' }, 
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
    $("#phone").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(3).search($(this).val()).draw(); 
    });

    $(".datepick").change(function(){
        var startDate = new Date($('#fromDate').val());
        var endDate   = new Date($('#toDate').val());
        if(startDate > endDate){
            alert('Start date should be greater than end date.');
            $("#toDate").val('');
            return;
        }
        
        // $('#fromDate').datepicker({
        //     dateFormat: 'yy-mm-dd', 
        //     onSelect: function(){ 
		//         $('#dataTable').DataTable().column(7).search( $("#fromDate").val() ).draw(); 
        //     }, 
        //     changeMonth: true,
        //     changeYear: true, onClose: function(){  }
	    // });
    })

    function searchFilter(){
        var dataTable = $('#dataTable').DataTable();
        var fullname  = $('#fullname').val();
        var email     = $('#email').val();   
        // dataTable.column(1).search(fullname).draw();
        // dataTable.column(2).search(email).draw(); 
        dataTable.draw();
    }

    function deleteUser(id){ 
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isDelete) => {
                if(isDelete) {
                    deleteData(id);
                } else {
                    //swal("Your imaginary file is safe!");
                }
            }); 
    }

    function deleteData(id){
        $.ajax({
            type: 'get',
            url: baseUrl+'/manage-users/deleteUser/'+id,
            dataType:'json',
            beforeSend: function(){ beforeSend(); },
            success: function(res){ 
                afterSend();
                if(res.response_msg==='success'){ 
                    //full-hold or false means table pagination will not be change
                    $('#dataTable').DataTable().draw('full-hold'); 
                    swal(res.message, { icon:"success", timer: 2000 });
                }
                if(res.response_msg==='error'){
                    swal(res.message,{ icon:"error", timer:2000 });
                }
            },
            error: function(){
                swal("Something went wrong!",{ icon:"error", timer:2000 });
            }
        })
    }

    function changeStatus(id){
        $.ajax({
            type: 'get',
            url: baseUrl+'/manage-users/changeStatus/'+id,
            dataType:'json',
            beforeSend: function(){  },
            success: function(res){  
                if(res.response_msg==='success'){ 
                    //full-hold or false means table pagination will not be change
                    $('#dataTable').DataTable().draw('full-hold'); 
                    swal(res.message, { icon:"success", timer: 2000 });
                }
                if(res.response_msg==='error'){
                    swal(res.message,{ icon:"error", timer:2000 });
                }
            },
            error: function(){
                swal("Something went wrong!",{ icon:"error", timer:2000 });
            }
        })
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

    //Add New User
    function add_user() {
        $("#add_user").submit(function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            var fname = $("#f_name").val();
            var lname = $("#l_name").val();
            var utype = $("#u_type").val();
            var email = $("#inputEmailAddress").val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var password = $("#inputPassword").val(); 
            var cpassword = $("#conf_pass").val(); 
            if(fname == '') {
                $('#err_f_name').html('Firstname is required.');
                $('#f_name').addClass('errorclass');
            }else
                if(lname == '') {
                $('#err_l_name').html('Lastname is required.');
                $('#l_name').addClass('errorclass');
            }else if(email == '') {
                $('#err_email').html('Email is required.');
                $('#inputEmailAddress').addClass('errorclass');
            }else if(!regex.test(email)){
                    $('#err_email').html('Email is invalid.');
                    $('#inputEmailAddress').addClass('errorclass');
            }else if(utype == '') {
                $('#err_u_type').html('User Type is required.');
                $('#u_type').addClass('errorclass');
            }else if (password == '') {
                $('#err_password').html('Password is required.');
                $('#inputPassword').addClass('errorclass');
            }else if (cpassword == '') {
                $('#err_conf_pass').html('Confirm Password is required.');
                $('#inputPassword').addClass('errorclass');
            }else if (password !== cpassword) {
                $('#err_conf_pass').html('Confirm Password should match.');
                $('#inputPassword').addClass('errorclass');
            }else if ($("#email_exists").hasClass('notAllOK')==true) {
                    return false;
            }else {
                var formData = $("#add_user").serialize(); 
                //calling ajaxHeader() function to generate CSRF Token
                ajaxHeader();
                $.ajax({
                    url: "{{ url('/manage-users/add_user') }}",
                    type: "POST",
                    data: formData,
                    dataType: 'json', 
                    beforeSend: function() {
                        showProcessing('submit'); //show processing before form success
                    },
                    success: function(result) { 
                        if(result.response_msg === 'success') { 
                            swal(result.message, { icon:"success", timer: 2000 }); 
                            $('#dataTable').DataTable().draw('full-hold'); 
                            $("#add_user")[0].reset(); 
                            $("#UserAddModel").modal('toggle');
                            $("#close_model").trigger('click');
                            showSuccessMessage(result.message); //show success message 
                            setTimeout(function(){
                                hideSuccessMessage(); //hide success message  
                            },2000);   
                        }else if(result.response_msg === 'error') {  
                            showErrorMessage(result.message); //show error message
                            setTimeout(function() {
                                removeErrorAttr(); //remove error with attr
                            }, 3000);
                        } 
                        hideProcessing('submit'); //hide processing after form success
                    }
                });
            }
        });
    } 

     
 

</script>

