<script type="text/javascript">
    
    $(document).ready(function() { 
        var hash = window.location.hash;
        //var hash = window.location.hash;
        var res = hash.split("/");  
        if(res=='#property')
        {
            loadhtmlView('/manage-property','property');
        } 
        if(res=='#mailbox')
        {
            loadhtmlView('/mailbox/mailbox-home','property');
        } 
        if(res=='#users')
        {
            loadhtmlView('/manage-users','users');
        }
        if(res[0]=='#userDetails'){
            loadhtmlView('/manage-users/userDetails/'+res[1],'page');
        }
        if(res[0]=='#property-detail'){
           // alert(res[1]);
           manage_prop_detail('/manage-property/property-detail',res[1]);
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
                <div class="sb-sidenav-menu-heading">Property Management</div>
                    <a class="nav-link" href="#property" onclick="loadhtmlView('/manage-property','page')">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Property
                    </a> 
                <div class="sb-sidenav-menu-heading">Mailbox</div>
                    <a class="nav-link" href="#mailbox" onclick="loadhtmlView('/mailbox/mailbox-home','page')">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        User Queries
                    </a> 
                <div class="sb-sidenav-menu-heading">User Management</div>
                    <a class="nav-link" href="#users" onclick="loadhtmlView('/manage-users','page')">
                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                        Users
                    </a> 
            </div>
        </div> 
    </nav>
</div>