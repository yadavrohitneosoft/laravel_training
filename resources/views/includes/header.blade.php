<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="#">NeoSOFT</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <?php $get_SessionData = Session::get('admin_session'); ?>
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
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
       
        <a class="nav-link" href="javascript:void()" > Welcome {{$get_SessionData['firstname']}}! </a>
            <!-- <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome To Admin </a> -->
            <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown"> -->
                <!-- <a class="dropdown-item" href="#">Settings</a> -->
                <!-- <div class="dropdown-divider"></div>  
                <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a> -->
            <!-- </div> -->
        </li>
        <li><a class="btn btn-link order-1 order-lg-0" href="{{ url('/logout') }}" title="logout"><i class="fas fa-sign-out-alt"></i></a></li>
    </ul>
</nav>