<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Data Management System | Register</title>

        <link rel="shortcut icon" href="https://images.neosofttech.com/favicon.gif" type="image/gif" />
        <link href="{{ url('css/admin/style.css') }}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script language="javascript"> var baseUrl = '{{ url('/') }}'; </script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-4">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light " style="margin-top: 10px;"><img src="{{ asset('images/neosoft.svg') }}" style="height: 50px;"></h3>
                                    </div>
                                    <div class="card-body loginform">
                                        <p class="formError text-center hidden"></p>
                                        <p class="formSuccess text-center hidden"></p>
                                        <form action="javascript:void(0);" id="register" class="" method="post" name="login" autocomplete="off" style="margin-top: 15px;">
                                            <div class="form-group mb0">
                                                <label class="small mb-1" for="f_name">First Name</label>
                                                <input class="form-control fs12" name="f_name" id="f_name" type="text" placeholder="Enter Firstname" onkeypress="removeError()" />
                                                <span class="error" id="err_f_name"></span>
                                            </div>
                                            <div class="form-group mb0">
                                                <label class="small mb-1" for="l_name">Last Name</label>
                                                <input class="form-control fs12" name="l_name" id="l_name" type="text" placeholder="Enter Lastname" onkeypress="removeError()" />
                                                <span class="error" id="err_l_name"></span>
                                            </div>
                                            <div class="form-group mb0">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control fs12" name="email" id="inputEmailAddress" type="text" placeholder="Enter Email" onkeypress="removeError()" />
                                                <span class="error" id="err_email"></span>
                                            </div>
                                            <div class="form-group mb0">
                                                <label class="small mb-1" for="u_type">Role</label>
                                                <select class="form-control fs12" name="u_type" id="u_type" onchange="removeError()">
                                                    <option value="">--Select--</option>
                                                    <option value="2">Admin</option>
                                                    <option value="3">User</option>
                                                </select>  
                                                <span class="error" id="err_u_type"></span>
                                            </div>
                                            <div class="form-group mb0">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control fs12 security" name="password" id="inputPassword" type="text" placeholder="Enter Password" onkeypress="removeError()" />
                                                <span class="p-viewer">
                                                    <i class="fa fa-eye" aria-hidden="true" onclick="show_hide_pass()"></i>
                                                </span>
                                                <span class="p-viewer2">
                                                    <i class="fa fa-eye-slash" aria-hidden="true" onclick="show_hide_pass()"></i>
                                                </span>
                                                <span class="error" id="err_password"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="conf_pass">Confirm Password</label>
                                                <input class="form-control fs12 security" name="conf_pass" id="conf_pass" type="text" placeholder="Enter Password Again" onkeypress="removeError()" /> 
                                                <span class="error" id="err_conf_pass"></span>
                                            </div>
                                            
                                            <!-- <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                    <span class="errorclass" ></span>
                                                </div>
                                            </div> -->
                                            <div class="form-group text-center">
                                                <!-- <a class="small" href="password.php">Forgot Password?</a> -->
                                                <button type="submit" id="submit" name="submit" onclick="register();" class="btn btn-primary login_submit" href="javascript:void(0)" >Register</button>
                                                <button  id="process" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small" style="color: gray"> Already have an account? <a href="{{url('/')}}">Login</a></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class=" align-items-center small">
                            <div class="text-muted text-center">Copyright &copy; NeoSOFT - <?php echo date('Y'); ?></div>
                            <!-- <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div> -->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ url('js/admin/scripts.js') }}"></script> 
        <script>
            function register() {
                $("#register").submit(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var fname = $("#f_name").val();
                    var lname = $("#l_name").val();
                    var utype = $("#u_type").val();
                    var email = $("#inputEmailAddress").val();
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    var password = $("#inputPassword").val(); 
                    var cpassword = $("#conf_pass").val(); 
                    if(fname == '') {
                        $('#err_f_name').html('Firstname is required.');
                        $('#f_name').addClass('errorclass');
                    }else
                     if(lname == '') {
                        $('#err_l_name').html('Lastname is required.');
                        $('#l_name').addClass('errorclass');
                    }else if(email == '') {
                        $('#err_email').html('Email is required.');
                        $('#inputEmailAddress').addClass('errorclass');
                    }else if(!regex.test(email)){
                            $('#err_email').html('Email is invalid.');
                            $('#inputEmailAddress').addClass('errorclass');
                    }else if(utype == '') {
                        $('#err_u_type').html('User Type is required.');
                        $('#u_type').addClass('errorclass');
                    }else if (password == '') {
                        $('#err_password').html('Password is required.');
                        $('#inputPassword').addClass('errorclass');
                    }else if (cpassword == '') {
                        $('#err_conf_pass').html('Confirm Password is required.');
                        $('#inputPassword').addClass('errorclass');
                    }else if (password !== cpassword) {
                        $('#err_conf_pass').html('Confirm Password should match.');
                        $('#inputPassword').addClass('errorclass');
                    }else {
                         doRegister();
                    }
                });
            }
            function doRegister(){
                var formData = $("#register").serialize(); 
                //calling ajaxHeader() function to generate CSRF Token
                ajaxHeader(); 
                $.ajax({
                    url: "{{ url('/do_register') }}",
                    type: "POST",
                    data: formData,
                    dataType: 'json', 
                    beforeSend: function() {
                        showProcessing('submit'); //show processing before form success
                    },
                    success: function(result) { 
                        if(result.response_msg === 'success') { 
                            $("#register")[0].reset();
                            showSuccessMessage(result.message); //show success message
                            setTimeout(function(){
                                hideSuccessMessage(); //hide success message 
                                window.location.replace(baseUrl + result.data.redirect_url);
                            },2000);
                        }else if(result.response_msg === 'error') {  
                            showErrorMessage(result.message);
                            setTimeout(function() {
                                removeErrorAttr(); //remove error with attr
                            }, 3000);
                        } 
                        hideProcessing('submit'); //hide processing after form success
                    }
                });
            }
        </script>
    </body>
</html>
