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
                            <li class="breadcrumb-item active">Property</li> 
                        </ol> 
                    @if(!empty($data[0]))
                        @foreach($data as $key=>$val)
                        <div class="card uicard" style="width: 18rem;">
                            <img class="card-img-top hg200" src="{{url('/uploads/property_images')}}{{'/'.$val->prop_id.'/'.$val->dImage}}" alt="Card image cap">
                            <div class="card-body" style="padding: 10px;">
                                <h5 class="card-title"><a href="{{url('/')}}/property/property-detail/{{$val->id}}">{{$val->title}}</a></h5>
                                <p class="card-text">{{ substr($val->description,0,50) }}... </p>
                            </div> 
                            <div class="card-body prices">
                                <a href="javascript:void(0)" class="card-link ablack">Price - <span class="farupee"><i class="fa fa-rupee-sign"></i>{{$val->price}} </span></a> 
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p>No Data Found</p>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('/') }}js/admin/scripts.js"></script>  
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script src="{{ URL::asset('/') }}js/admin/datatables-demo.js"></script> 
    </body>
</html>