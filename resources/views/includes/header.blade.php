<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Real Estate</a>
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
            <a class="nav-link" aria-haspopup="true" aria-expanded="false">Hello, {{$get_SessionData['name']}}</a>
        </li> 
        <li>
            <a class="btn btn-link order-1 order-lg-0" href="{{ route('logout') }}" title="logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form> 
        </li> 
    </ul>
</nav>
 