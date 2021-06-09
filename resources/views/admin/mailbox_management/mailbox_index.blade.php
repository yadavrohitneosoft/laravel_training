<?php $get_SessionData = Session::get('admin_session'); ?>
    <main>
        <div class="container-fluid">
            <!-- <h1 class="mt-4">Leads </h1> -->
          
             <ol class="breadcrumb mb-4 mt-4 onscrollFixed">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard/index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Mailbox</li>
            </ol> 
            <div class="breadcrumb mb-4 mt-4 onscrollFixed">
                <form id="search_filter" action="javascript:void(0);"> 
                    <div class="row flex__box"> 
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="title">Name</label>
                                <input type="text"  id="name" name="name" value="" placeholder="Name" class="form-control">
                            </div>
                        </div> 
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="email">Email</label>
                                <input type="text"  id="email" name="email" value="" placeholder="Email" class="form-control">
                            </div>
                        </div> 
                        <!-- <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="property">Property Title</label>
                                <input type="text"  id="property" name="property" value="" placeholder="Property" class="form-control numberonly">
                            </div>
                        </div>  -->
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
                                    <th>Mobile</th>
                                    <th>Message</th> 
                                    <th>Username</th> 
                                    <th>Property title</th> 
                                    <th>Created At</th> 
                                </tr>
                            </thead> 
                            <tbody><!-- Data will come from datatables by AJAX --></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main> 

     

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
                    "visible" : true,
                }, 
                 
            ],
            ajax: {
              url: '{!! URL::asset('mailbox/getMailbox') !!}',  
            },
            //initComplete:function(){ afterSend(); },
            columns : [  
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'contact', name: 'contact' },
                        { data: 'message', name: 'message' }, 
                        { data: 'username', name: 'username' }, 
                        { data: 'prop_title', name: 'prop_title' }, 
                        { data: 'cr_date', name: 'cr_date' },
                           
            ],
        }); 
    });

     
      
    function resetFilter(){
        $('#search_filter')[0].reset();
        loadhtmlView('/mailbox/mailbox-home','page');
    }
    $("#name").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(1).search($(this).val()).draw(); 
    }); 
    $("#email").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(2).search($(this).val()).draw(); 
    }); 
    $("#property").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(7).search($(this).val()).draw(); 
    }); 

    function searchFilter(){
        var dataTable = $('#dataTable').DataTable();
        var name  = $('#name').val(); 
        var email  = $('#email').val(); 
        var property  = $('#property').val();     
        dataTable.draw();
    }

         
 

</script>

