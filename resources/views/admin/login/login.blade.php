<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Login | Real Estate Property Management</title>

        <link rel="shortcut icon" href="{{ URL::asset('images/logo.png') }}" type="image/gif"  />
        <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet" />
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
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4"><img src="{{ asset('images/logo_prop.png') }}" style="height: 50px;"></h3></div>
                                    <div class="card-body loginform">
                                        <p class="formError text-center hidden"></p>
                                        <p class="formSuccess text-center hidden"></p>
                                        <form action="javascript:void(0);" id="login" class="" method="post" name="login" autocomplete="off" style="margin-top: 15px;">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Username/Email</label>
                                                <input class="form-control fs12" name="email" id="inputEmailAddress" type="text" placeholder="Enter Username/Email" onkeypress="removeError()" />
                                                <span class="error" id="err_email"></span>
                                            </div>
                                            <div class="form-group">
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
                                            <div class="form-group text-center">
                                                <!-- <a class="small" href="password.php">Forgot Password?</a> -->
                                                <button type="submit" id="submit" name="submit" onclick="dologin();" class="btn btn-primary login_submit" href="javascript:void(0)" >Login</button>
                                                <button  id="process" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small" style="color: gray"> Don't have an account? <a href="{{url('/register')}}">Register</a></div>
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
                            <div class="text-muted text-center">Copyright &copy; Real Estate - <?php echo date('Y'); ?></div>
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
            function dologin() {
                $("#login").submit(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var email = $("#inputEmailAddress").val();
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    var password = $("#inputPassword").val(); 
                    if(email == '') {
                        $('#err_email').html('Username is required.');
                        $('#inputEmailAddress').addClass('errorclass');
                        // }else if(!regex.test(email)){
                        //     $('#err_email').html('Email is invalid.');
                        //     $('#inputEmailAddress').addClass('errorclass');
                    }else if (password == '') {
                        $('#err_password').html('Password is required.');
                        $('#inputPassword').addClass('errorclass');
                    }else {
                        login();
                    }
                });
            }
            function login(){
                var formData = $("#login").serialize();
                //calling ajaxHeader() function to generate CSRF Token
                ajaxHeader();
                $.ajax({
                    url: "{{ url('/post_login') }}",
                    type: "POST",
                    data: formData,
                    dataType: 'json', 
                    beforeSend: function() {
                        showProcessing('submit'); //show processing before form success
                    },
                    success: function(result) {  
                        if(result.response_msg === 'success') {
                            window.location.replace(baseUrl + result.data.redirect_url);
                        }else if(result.response_msg === 'error') { 
                            showErrorMessage(result.message);
                            setTimeout(function() {
                                removeErrorAttr(); //remove error with attr
                            }, 2000);
                        }   
                        hideProcessing('submit'); //hide processing after form success
                    }
                });
            }
        </script>
    </body>
</html>
