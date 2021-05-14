<?php $get_SessionData = Session::get('admin_session'); ?>
    <main>
        <div class="container-fluid">
            <!-- <h1 class="mt-4">Leads </h1> -->
          
             <ol class="breadcrumb mb-4 mt-4 onscrollFixed">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard/index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active">Category</li>
            </ol>

            <div class="breadcrumb mb-4 mt-4 onscrollFixed">
                <form id="search_filter" action="javascript:void(0);"> 
                    <div class="row flex__box"> 
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="title">Title</label>
                                <input type="text"  id="title" name="title" value="" placeholder="Title" class="form-control">
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
            
            <a class="add_x" data-toggle="modal" href="#CatAddModel">+ Add Category </a> 
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Status</th>  
                                    <th>Action </td>   
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
        <div id="CatEditModel" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Category</h4>
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
        <div id="CatAddModel" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Category</h4>
                    </div>
                    <!-- Modal body start-->
                        <div class="modal-body modalBody" id="">
                            <div class="card-body loginform">
                                <p class="regerror text-center hidden"></p>
                                <p class="regsuccess text-center hidden" style="color:green"></p>
                                <form action="javascript:void(0);" id="add_cat" class="" method="post" autocomplete="off">
                                    <div class="form-group">
                                        <label class="small mb-1" for="ctitle">Title</label>
                                        <input class="form-control fs12" name="ctitle" id="ctitle"  type="text" placeholder="Enter Title" onkeypress="removeError()" />
                                        <span class="error" id="err_ctitle"></span>
                                    </div>                                
                                    <div class="form-group text-center"> 
                                        <button type="submit" id="submit" name="submit" onclick="AddCat();" class="btn btn-primary login_submit" href="javascript:void(0)" >Add</button>
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
                        return '<td>' + full['id'] + '</td>';
                    }
                }, 
                
                {
                    "aTargets": [3],
                    "width": 100,
                <?php if($get_SessionData['user_role']==1 || $get_SessionData['user_role']==2) { ?>
                    "className": "text-center", 
                    "mRender": function(data, type, full){
                        var action = '<td><button data-toggle="modal" data-target="#CatEditModel" onclick="editCat('+full['id']+')" type="button" title="Edit" style="background:none;border:none"><i class="fas fa-edit" style="font-size: 15px;color:green;"></i></button> |';
                        if(full['cstatus']=='Active'){
                            action += '<button onclick="changeCatStatus('+full['id']+')" type="button" title="Active" style="background:none;border:none"><i class="fas fa-eye" style="font-size: 15px;color:green;"></i></button>';
                        }else{
                            action += '<button onclick="changeCatStatus('+full['id']+')" type="button" title="inActive" style="background:none;border:none"><i class="fas fa-eye-slash" style="font-size: 15px;color:red;"></i></button>';
                        }
                        action += '| <button onclick="deleteCategory('+full['id']+')" type="button" title="Delete" style="background:none;border:none"><i class="fas fa-trash-alt" style="font-size: 15px;color:red;"></i></button></td>';
                        return action;
                    }
                    <?php }else{ ?> 
                        "visible":false,
                    <?php } ?>
                }
                
            ],
            ajax: {
              url: '{!! URL::asset('manage-category/getCategories') !!}',  
                //beforeSend:function(){ beforeSend(); },
            },
            //initComplete:function(){ afterSend(); },
            columns : [  
                        { data: 'id', name: 'id' },
                        { data: 'title', name: 'title' }, 
                        { data: 'cstatus', name: 'cstatus' }, 
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
        loadhtmlView('/manage-category','page');
    }
    $("#title").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(1).search($(this).val()).draw(); 
    }); 
 

    function searchFilter(){
        var dataTable = $('#dataTable').DataTable();
        var title  = $('#title').val();    
        dataTable.draw();
    }

    function deleteCategory(id){ 
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
            url: baseUrl+'/manage-category/deleteCategory/'+id,
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

    function changeCatStatus(id){
        $.ajax({
            type: 'get',
            url: baseUrl+'/manage-category/changeCatStatus/'+id,
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

        function AddCat() {
                $("#add_cat").submit(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var title = $("#ctitle").val();   
                    if(title == '') {
                        $('#err_ctitle').html('Title is required.');
                        $('#ctitle').addClass('errorclass');
                    }else {
                        var formData = $("#add_cat").serialize(); 
                        //calling ajaxHeader() function to generate CSRF Token
                        ajaxHeader();
                        $.ajax({
                            url: "{{ url('/manage-category/add_category') }}",
                            type: "POST",
                            data: formData,
                            cache: false,
                            dataType: 'json', 
                            beforeSend: function() {
                                $("#submit").addClass('hidden');
                                $("#process").removeClass('hidden');
                            },
                            success: function(result) { 
                                if(result.response_msg === 'success') { 
                                    swal(result.message, { icon:"success", timer: 2000 }); 
                                    $('#dataTable').DataTable().draw('full-hold'); 
                                    $("#CatAddModel").modal('toggle');
                                    $("#close_model").trigger('click');
                                    $("#add_cat")[0].reset();
                                }else if(result.response_msg === 'error') {  
                                    $(".regerror").html(result.message);
                                    $(".regerror").addClass('error');
                                    $(".regerror").removeClass('hidden');
                                    setTimeout(function() {
                                        $(".regerror").html('');
                                        $(".regerror").addClass('hidden');
                                        $(".regerror").removeClass('error');
                                    }, 3000);
                                } 
                                $("#submit").removeClass('hidden');
                                $("#process").addClass('hidden');
                            }
                        });
                    }
                });
            } 

    function editCat(id){ 
        $.ajax({
            type: 'get',
            url: baseUrl + '/manage-category/getCatDetails/' + id, 
            dataType: 'json',
            beforeSend:function(){ beforeSend(); },
            success: function(res) {
                afterSend();  
                if(res.response_msg==='success'){
                    $('#modalBody').html(res.data.body);
                }else if(res.response_msg==='error'){ 
                    swal(res.message,{ icon:"error", timer:2000 });
                }
            }
        });
    }
 

     
 

</script>

