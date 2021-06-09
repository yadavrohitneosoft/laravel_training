<!-- New file -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> Real Estate Property Management </title>
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
        @yield('style')
        <style type="text/css">
            .hidden{
                display: none;
            }
        </style>
        <script> var baseUrl = '{{ url('/') }}'; </script>
       
    </head>
<body class="sb-nav-fixed">
        
        @include('includes.header')
        <div class="alert-box"> </div>
        <div id="layoutSidenav">
            <!-- sidebar starts -->
                @include('includes.sidebar')
            <!-- sidebar ends -->
            <div class="hidden loader" id="loader"><img src="{{ URL::asset('/') }}images/loader/loader.gif" /></div>
            <div id="layoutSidenav_content" class="main_site_data">
                @yield('content') 
                @include('includes.footer')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('/') }}js/admin/scripts.js"></script>  
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script src="{{ URL::asset('/') }}js/admin/datatables-demo.js"></script> 
        @yield('script')
    </body>
</html>