<script type="text/javascript">
    
    $(document).ready(function() { 
        var hash = window.location.hash;
        //var hash = window.location.hash;
        var res = hash.split("/");   
        if(res=='#users')
        {
            loadhtmlView('/manage-users','users');
        }
        if(res=='#category')
        {
            loadhtmlView('/manage-category','category');
        }
        if(res=='#products')
        {
            loadhtmlView('/manage-products','products');
        }
        if(res=='#updatePassword'){
            loadhtmlView('/changePassword','page');
        }
 
        $("#layoutSidenav_nav .sb-sidenav a").each(function(){
            var path = $(this).attr('href');
            if (hash === path) { 
                $("#layoutSidenav_nav .sb-sidenav a.nav-link").removeClass("active");
                $(this).addClass("active");
            } 
        });

        // Toggle the side navigation
        $("#sidebarToggle").on("click", function(e) {
            e.preventDefault();
            $("body").toggleClass("sb-sidenav-toggled");
        });
            
 
    }); 

    
   
</script>

<?php $get_SessionData = Session::get('admin_session'); ?>
 
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav" id="side-menu">
                <div class="sb-sidenav-menu-heading">Admin</div>
                    <a class="nav-link active"  href="{{ url('/dashboard/index')}}" >
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                <div class="sb-sidenav-menu-heading">Category Management</div>
                    <a class="nav-link" href="#category" onclick="loadhtmlView('/manage-category','page')">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Category
                    </a>
                <div class="sb-sidenav-menu-heading">Product Management</div>
                    <a class="nav-link" href="#products" onclick="loadhtmlView('/manage-products','page')">
                        <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                        Product
                    </a> 
                <div class="sb-sidenav-menu-heading">User Management</div>
                    <a class="nav-link" href="#users" onclick="loadhtmlView('/manage-users','page')">
                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                        Users
                    </a> 
                <!-- <div class="sb-sidenav-menu-heading">Auth</div>
                    <a class="nav-link" href="{{ url('/logout') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                        Logout
                    </a>  -->
                    
                <!-- <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Authentication
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="login.php">Login</a>
                                <a class="nav-link" href="register.php">Register</a>
                                <a class="nav-link" href="password.php">Forgot Password</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                            Error
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.php">401 Page</a>
                                <a class="nav-link" href="404.php">404 Page</a>
                                <a class="nav-link" href="500.php">500 Page</a>
                            </nav>
                        </div>
                    </nav>
                </div> -->
                <!-- <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a> -->
                <!-- <a class="nav-link" href="tables.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a> -->


            </div>
        </div>
        <div class="sb-sidenav-footer">
        @if($get_SessionData['user_role']==1)
            <div ><span class="small">Logged in as: </span><br>Super Admin</div>
            @elseif($get_SessionData['user_role']==2)
            <div ><span class="small">Logged in as: </span><br>Admin</div>
            @else
            <div ><span class="small">Logged in as: </span><br>User</div>
        @endif
        </div>
    </nav>
</div>