<!-- New file -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> Real Estate Property Sell | Buy | Rent  </title>
        <link href="{{ URL::asset('css/admin/style.css') }}" rel="stylesheet" />
        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
        <!-- keep these resources in same order like below to avoid confliction -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
        <!-- datepicker -->
        <script src="{{ URL::asset('/') }}js/admin/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
        <!-- keep these resources in same order like above to avoid confliction -->
        <link rel="shortcut icon" href="{{ URL::asset('images/logo_prop.png') }}" type="image/gif" />
        <!-- sweetalert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- to show icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- @yield('style') -->
        <style type="text/css">
            .hidden{
                display: none;
            }
        </style>
        <script> var baseUrls = '{{ url('/') }}'+'/property/property-home'; </script>
       
    </head>
<body class="sb-nav-fixed">
        <?php $get_SessionData = Session::get('admin_session'); ?>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Real Estate</a>
            <!-- <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button> -->
             
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group hidden">
                    <input class="form-control hidden" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary " type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form> 
            <!-- Navbar -->
            @if(!empty($get_SessionData))
                <ul class="navbar-nav ml-auto ml-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" aria-haspopup="true" aria-expanded="false">Hello, {{$get_SessionData['name']}}</a>
                    </li> 
                    <li>
                        <a class="btn btn-link order-1 order-lg-0" href="{{ route('logout') }}" title="logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form> 
                    </li> 
                </ul>
                @else
                <ul class="navbar-nav ml-auto ml-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" aria-haspopup="true" aria-expanded="false">Hello, Guest!</a>
                    </li> 
                    <li>
                        <a class="btn btn-link order-1 order-lg-0" href="{{ route('login') }}" title="login" ><i class="fas fa-sign-in-alt"></i></a>  
                    </li> 
                </ul>
            @endif
        </nav>
        
        <div class="alert-box"> </div>
        <div id="layoutSidenav">
            <!-- sidebar starts -->
                <!-- @include('includes.sidebar') -->
            <!-- sidebar ends -->
            <div class="hidden loader" id="loader"><img src="{{ URL::asset('/') }}images/loader/loader.gif" /></div>
            <div id="layoutSidenav_content" class="main_site_data">
                <!-- @yield('content')  --> 
                <main>
                    <div class="container-fluid"> 
                        <ol class="breadcrumb mb-4 mt-4 onscrollFixed">
                            <li class="breadcrumb-item"><a href="{{ url('/property/property-home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ url('/property/property-home') }}">Property</a></li> 
                            <li class="breadcrumb-item active">Property Detail</li> 
                        </ol> 
                        
                        <?php //echo "<pre>"; print_r($data_prop); exit;?>
                        <!--Section: Block Content-->
                        @if(!empty($data_prop[0]))
                            <section class="mb-5">

                            <div class="row">
                            <div class="col-md-6 mb-4 mb-md-0">

                                <div id="mdb-lightbox-ui"></div>

                                <div class="mdb-lightbox">

                                <div class="row product-gallery mx-1">

                                    <div class="col-6 mb-0">
                                    <figure class="view overlay rounded z-depth-1 main-img">
                                        @foreach($data_images as $val)
                                            @if($val->isFeatured==1)
                                                <a href="{{url('/uploads/property_images')}}{{'/'.$val->prop_id.'/'.$val->image}}" data-size="710x823">
                                                    <img src="{{url('/uploads/property_images')}}{{'/'.$val->prop_id.'/'.$val->image}}" class="img-fluid z-depth-1">
                                                </a>
                                            @endif
                                        @endforeach
                                    </figure> 
                                    </div>
                                    <div class="col-12">
                                    <div class="row">

                                        @foreach($data_images as $val)
                                            @if($val->isFeatured==0) 
                                                <div class="col-3">
                                                    <div class="view overlay rounded z-depth-1 gallery-item">
                                                        <img src="{{url('/uploads/property_images')}}{{'/'.$val->prop_id.'/'.$val->image}}"
                                                        class="img-fluid">
                                                        <div class="mask rgba-white-slight"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                    </div>
                                    </div>
                                </div>

                                </div>

                            </div>
                            <div class="col-md-6">

                                <h5>{{$data_prop[0]->title}}</h5> 
                                <p><span class="mr-1"><strong><i class="fa fa-rupee-sign"></i>{{$data_prop[0]->price}}</strong></span></p>
                                <p class="pt-1">{{$data_prop[0]->description}}  </p>
                                <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                    <tr>
                                        <th class="pl-0 w-25" scope="row"><strong>Bedroom</strong></th>
                                        <td>{{$data_prop[0]->bedroom}}</td>
                                    </tr>
                                    <tr>
                                        <th class="pl-0 w-25" scope="row"><strong>Bathroom</strong></th>
                                        <td>{{$data_prop[0]->bathroom}}</td>
                                    </tr>
                                    <tr>
                                        <th class="pl-0 w-25" scope="row"><strong>Area Sq.ft.</strong></th>
                                        <td>{{$data_prop[0]->floor_area}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                            @if(!empty($get_SessionData))
                                <hr><button type="button" class="btn btn-light btn-md mr-1 mb-2" data-toggle="modal" data-target="#ProAddModel"><i class="fas fa-shopping-cart pr-2"></i>Connect</button>
                            @endif
                            </div>
                            </div>

                            </section>
                            <!--Section: Block Content-->
                        @else
                            <p>No data found</p>
                        @endif
                    </div>
                </main> 
  
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="text-center small">
                            <div class="text-muted">Copyright &copy; Real Estate - <?php echo date('Y'); ?></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!--  model open -->
        <div id="ProAddModel" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Send Query - {{$data_prop[0]->title}}</h4>
                    </div>
                    <!-- Modal body start-->
                    
                        <div class="modal-body modalBody" id="">
                            <div class="card-body loginform">
                                <p class="formError text-center hidden"></p>
                                <p class="formSuccess text-center hidden" style="color:green"></p>
                                <form action="javascript:void(0);" id="add_prod" class="" method="post" autocomplete="off">
                                    <input type="hidden" value="{{$get_SessionData['id']}}" name="uid" />
                                    <input type="hidden" value="{{$data_prop[0]->id}}" name="pid" />
                                    <input type="hidden" value="{{$get_SessionData['name']}}" name="username" />
                                    <input type="hidden" value="{{$data_prop[0]->title}}" name="prop_title" />
                                    <div class="form-group mb0">
                                        <label class="small mb-1" for="name">Name</label>
                                        <input class="form-control fs12" name="name" id="name"  type="text" placeholder="Enter Name" onkeypress="removeError()" />
                                        <span class="error" id="err_name"></span>
                                    </div> 
                                    <div class="form-group mb0">
                                        <label class="small mb-1" for="email">Email</label>
                                        <input class="form-control fs12" name="email" id="email"  type="text" placeholder="Enter Email" onkeypress="removeError()" />
                                        <span class="error" id="err_email"></span>
                                    </div> 
                                    <div class="form-group mb0">
                                        <label class="small mb-1" for="contact">Mobile</label>
                                        <input class="form-control fs12 numberonly" name="contact" id="contact"  type="text" placeholder="Enter Mobile" onkeypress="removeError()" />
                                        <span class="error" id="err_contact"></span>
                                    </div> 
                                    <div class="form-group mb-3">
                                        <label class="small mb-1" for="message">Message</label>
                                        <textarea class="form-control fs12" name="message" id="message" type="text" placeholder="Enter Message" onkeypress="removeError()" ></textarea>
                                        <span class="error" id="err_message"></span>
                                    </div>  
                                                    
                                    <div class="form-group text-center"> 
                                        <button type="submit" id="submit" name="submit" onclick="sendMessage();" class="btn btn-primary login_submit" href="javascript:void(0)" >Send</button>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('/') }}js/admin/scripts.js"></script>  
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script src="{{ URL::asset('/') }}js/admin/datatables-demo.js"></script> 
        <script>
            function sendMessage() {
            $("#add_prod").submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var name = $("#name").val(); 
                var email = $("#email").val();
                var contact = $("#contact").val();
                var message = $("#message").val();  
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                 
                if(name == '') {
                    $('#err_name').html('Name is required.');
                    $('#name').addClass('errorclass');
                }else if(email == '') {
                    $('#err_email').html('Email is required.');
                    $('#email').addClass('errorclass');
                }else if(!regex.test(email)){
                            $('#err_email').html('Email is invalid.');
                            $('#email').addClass('errorclass');
                }else if(contact == '') {
                    $('#err_contact').html('Mobile is required.');
                    $('#contact').addClass('errorclass');
                }else if(message == '') {
                    $('#err_message').html('Message is required.');
                    $('#message').addClass('errorclass');
                }else{
                    var formData = $('#add_prod').serialize(); 
                    //calling ajaxHeader() function to generate CSRF Token
                    ajaxHeader(); 
                    $.ajax({
                        url: "{{ url('/property/property-detail/message') }}",
                        type: "POST",
                        data: formData,
                        cache:false, 
                        dataType: 'json', 
                        beforeSend: function() {
                            showProcessing('submit'); //show processing before form success
                        },
                        success: function(result) { 
                            if(result.response_msg === 'success') { 
                                swal(result.message, { icon:"success", timer: 2000 });  
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
    </body>
</html>