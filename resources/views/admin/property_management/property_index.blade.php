<?php $get_SessionData = Session::get('admin_session'); ?>
    <main>
        <div class="container-fluid">
            <!-- <h1 class="mt-4">Leads </h1> -->
          
             <ol class="breadcrumb mb-4 mt-4 onscrollFixed">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard/index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Property</li>
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
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="city">City</label>
                                <input type="text"  id="city" name="city" value="" placeholder="City" class="form-control">
                            </div>
                        </div> 
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="bedroom">Bedrooms</label>
                                <input type="text"  id="bedroom" name="bedroom" value="" placeholder="Bedroom" class="form-control numberonly">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label" for="bathroom">Bathroom</label>
                                <input type="text"  id="bathroom" name="bathroom" value="" placeholder="Bathroom" class="form-control allow_decimal">
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
            <a class="add_x" data-toggle="modal" href="#ProAddModel">+ Add Property</a> 
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Floor Area (sq.ft.)</th>
                                    <th>Price</th> 
                                    <th>Bedroom</th> 
                                    <th>Bathroom</th> 
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Near By Place</th>
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

    <!--  model open -->
        <div id="ProAddModel" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Property</h4>
                    </div>
                    <!-- Modal body start-->
                    
                        <div class="modal-body modalBody" id="">
                            <div class="card-body loginform">
                                <p class="formError text-center hidden"></p>
                                <p class="formSuccess text-center hidden" style="color:green"></p>
                                <form action="javascript:void(0);" id="add_prod" class="" method="post" autocomplete="off" enctype="multipart/form-data">

                                <div class="first-column">
                                    <div class="form-group mb0">
                                            <label class="small mb-1" for="ptitle">Title</label>
                                            <input class="form-control fs12" name="ptitle" id="ptitle"  type="text" placeholder="Enter Title" onkeypress="removeError()" />
                                            <span class="error" id="err_ptitle"></span>
                                        </div> 
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="desc">Description</label>
                                            <textarea class="form-control fs12" name="desc" id="desc" type="text" placeholder="Enter Description" onkeypress="removeError()" ></textarea>
                                            <span class="error" id="err_desc"></span>
                                        </div>  
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="pprice">Price</label>
                                            <input class="form-control fs12 allow_decimal" name="pprice" id="pprice"  type="text" placeholder="Enter Price" onkeypress="removeError()" />
                                            <span class="error" id="err_pprice"></span>
                                        </div>
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="pfloor_area">Floor Area(in sq.ft)</label>
                                            <input class="form-control fs12 allow_decimal" name="pfloor_area" id="pfloor_area"  type="text" placeholder="Enter Floor Area e.g. 10" onkeypress="removeError()" />
                                            <span class="error" id="err_pfloor_area"></span>
                                        </div>
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="pbedroom">Bedroom</label>
                                            <input class="form-control fs12 numberonly" name="pbedroom" id="pbedroom"  type="text" placeholder="Enter Bedroom" onkeypress="removeError()" />
                                            <span class="error" id="err_pbedroom"></span>
                                        </div>
                                        
                                </div>
                                <div class="second-column">
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="pbathroom">Bathroom</label>
                                            <input class="form-control fs12 numberonly" name="pbathroom" id="pbathroom"  type="text" placeholder="Enter Bathroom" onkeypress="removeError()" />
                                            <span class="error" id="err_pbathroom"></span>
                                        </div>
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="pcity">City</label>
                                            <input class="form-control fs12" name="pcity" id="pcity"  type="text" placeholder="Enter city" onkeypress="removeError()" />
                                            <span class="error" id="err_pcity"></span>
                                        </div> 
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="paddress">Address</label>
                                            <textarea class="form-control fs12" name="paddress" id="paddress" type="text" placeholder="Enter Address" onkeypress="removeError()" ></textarea>
                                            <span class="error" id="err_paddress"></span>
                                        </div> 
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="pnearby">Near By</label>
                                            <input class="form-control fs12" name="pnearby" id="pnearby"  type="text" placeholder="Enter Nearby Place" onkeypress="removeError()" />
                                            <span class="error" id="err_pnearby"></span>
                                        </div>  
                                        <div class="form-group mb0">
                                            <label class="small mb-1" for="pnearby">Property Images</label>
                                            <input class="form-control fs12" type="file" name="files[]" multiple id="files" /> 
                                            <span class="error" id="err_files"></span>
                                        </div>
                                </div>
                                    
                                      
                                                               
                                    <div class="form-group text-center"> 
                                        <button type="submit" id="submit" name="submit" onclick="AddProp();" class="btn btn-primary login_submit" href="javascript:void(0)" >Add</button>
                                        <button type="button" id="process" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
                                        <button type="button" id="close_model" class="btn btn-primary login_submit" data-dismiss="modal">Close</button> 
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
                        return ' <td class="text-center"><a onclick="property_detail(this);" href="#property-detail/'+full['id'] +'" data-option="/manage-property/property-detail~property_detail~'+full['id'] +'" data-id="'+full['id'] +'">'+full['id']+' <i class="fa fa-angle-right"></i></a></td>';
                    }
                }, 
                 
            ],
            ajax: {
              url: '{!! URL::asset('manage-property/getProperty') !!}',  
                //beforeSend:function(){ beforeSend(); },
            },
            //initComplete:function(){ afterSend(); },
            columns : [  
                        { data: 'id', name: 'id' },
                        { data: 'title', name: 'title' },
                        { data: 'description', name: 'description' },
                        { data: 'price', name: 'price' },
                        { data: 'floor_area', name: 'floor_area' }, 
                        { data: 'bedroom', name: 'bedroom' }, 
                        { data: 'bathroom', name: 'bathroom' },
                        { data: 'city', name: 'city' },
                        { data: 'address', name: 'address' },
                        { data: 'nearby', name: 'nearby' },
                        { data: 'cr_date', name: 'cr_date' },
                           
            ],
        }); 
    });

     
      
    function resetFilter(){
        $('#search_filter')[0].reset();
        loadhtmlView('/manage-property','page');
    }
    $("#title").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(1).search($(this).val()).draw(); 
    }); 
    $("#city").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(7).search($(this).val()).draw(); 
    }); 
    $("#bedroom").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(5).search($(this).val()).draw(); 
    }); 
    $("#bathroom").on('keyup', function() {
        var table = $('#dataTable').DataTable();
        table.column(6).search($(this).val()).draw(); 
    }); 

    function searchFilter(){
        var dataTable = $('#dataTable').DataTable();
        var title  = $('#title').val(); 
        var city  = $('#city').val(); 
        var bedroom  = $('#bedroom').val(); 
        var bathroom  = $('#bathroom').val();    
        dataTable.draw();
    }

    
function property_detail(thisattr, id = '') { 
    if (thisattr != '/manage-property/property-detail') {
        var fields = $(thisattr).data('option').split('~'); 
        var page = fields[0];
        var pagetype = fields[1];
        var id = fields[2];
    } else {
        var page = thisattr; 
        var id = id;
    }
    ajaxHeader();
    $.ajax({
        type: "POST",
        data: { "id": id },
        url: baseUrl + page,
        cache: 'FALSE', 
        success: function(html) { 
            //ajax_property_detail(id);
            $('.main_site_data').html(html);
        }
    });
}



       function AddProp() {
            $("#add_prod").submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var formData = new FormData(); 

                var ptitle = $("#ptitle").val(); 
                var desc = $("#desc").val();
                var pprice = $("#pprice").val();
                var pfloor_area = $("#pfloor_area").val();
                var pbedroom = $("#pbedroom").val();
                var pbathroom = $("#pbathroom").val();
                var pcity = $("#pcity").val();
                var paddress = $("#paddress").val();
                var pnearby = $("#pnearby").val(); 
                let totalImages = $('#files')[0].files.length; 
                let propImages = $('#files')[0];  
                 
                if(ptitle == '') {
                    $('#err_ptitle').html('Title is required.');
                    $('#ptitle').addClass('errorclass');
                }else if(desc == '') {
                    $('#err_desc').html('Description is required.');
                    $('#desc').addClass('errorclass');
                }else if(pprice == '') {
                    $('#err_pprice').html('Price is required.');
                    $('#pprice').addClass('errorclass');
                }else if(pfloor_area == '') {
                    $('#err_pfloor_area').html('Floor Area is required.');
                    $('#pfloor_area').addClass('errorclass');
                }else if(pbedroom == '') {
                    $('#err_pbedroom').html('No. of Bedroom is required.');
                    $('#pbedroom').addClass('errorclass');
                }else if(pbathroom == '') {
                    $('#err_pbathroom').html('No. of Bathroom is required.');
                    $('#pbathroom').addClass('errorclass');
                }else if(pcity == '') {
                    $('#err_pcity').html('City is required.');
                    $('#pcity').addClass('errorclass');
                }else if(paddress == '') {
                    $('#err_paddress').html('Address is required.');
                    $('#paddress').addClass('errorclass');
                }else if(pnearby == '') {
                    $('#err_pnearby').html('Near By is required.');
                    $('#pnearby').addClass('errorclass');
                }else if(totalImages <= 0){
                    $('#err_files').html('Images is required.');
                    $('#files').addClass('errorclass');
                }else{
                    
                    for(let i = 0; i < totalImages; i++) {
                        formData.append('files[]', propImages.files[i]);
                    }
                    formData.append('totalImages', totalImages);
                    formData.append('ptitle', ptitle);
                    formData.append('desc', desc);
                    formData.append('pprice', pprice);
                    formData.append('pfloor_area', pfloor_area);
                    formData.append('pbedroom', pbedroom);
                    formData.append('pbathroom', pbathroom);
                    formData.append('pcity', pcity);
                    formData.append('paddress', paddress);
                    formData.append('pnearby', pnearby);
                    
                    //calling ajaxHeader() function to generate CSRF Token
                    ajaxHeader(); 
                    $.ajax({
                        url: "{{ url('/manage-property/add_property') }}",
                        type: "POST",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        dataType: 'json', 
                        beforeSend: function() {
                            showProcessing('submit'); //show processing before form success
                        },
                        success: function(result) { 
                            if(result.response_msg === 'success') { 
                                swal(result.message, { icon:"success", timer: 2000 }); 
                                $('#dataTable').DataTable().draw('full-hold'); 
                                $("#ProAddModel").modal('toggle');
                                $("#close_model").trigger('click');
                                $("#add_prod")[0].reset();
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
    
$(document).ready(function () {    
    //allow only numeric
    $('.numberonly').keypress(function (e) {    
    var charCode = (e.which) ? e.which : event.keyCode    
    if (String.fromCharCode(charCode).match(/[^0-9]/g))    
        return false;                        
    });  
    //allow numeric with decimal
    $(".allow_decimal").keypress(function(evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
        {
            evt.preventDefault();
        }
    });

});
     
 

</script>

