<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Data Management System | OTP </title>

        <link rel="shortcut icon" href="https://images.neosofttech.com/favicon.gif" type="image/gif" />
        <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script language="javascript"> var baseUrl = '{{ url('/') }}'; </script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                <?php $get_SessionData = Session::get('admin_session'); ?>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4"><img src="{{ asset('images/neosoft.svg') }}" style="height: 50px;"></h3></div>
                                    <div class="card-body loginform" id="otpProcess">
                                        <p class="formError text-center hidden"></p>
                                        <p class="formSuccess  text-center hidden"></p>
                                        <form action="javascript:void(0);" id="otp_verify" class="" method="post" name="otp_verify" autocomplete="off">
                                        <input name="uid" type="hidden" value="{{$get_SessionData['id']}}" />
                                            <div class="form-group">
                                                <label class="small mb-1" for="otp">OTP</label>
                                                <input class="form-control fs12" name="otp" id="otp" type="text" placeholder="Enter OTP" onkeypress="removeError()" />
                                                <span class="error" id="err_otp"></span>
                                            </div> 
                                            <div class="form-group text-center"> 
                                                <button type="submit" id="submit" name="submit" onclick="otpVerify();" class="btn btn-primary login_submit" href="javascript:void(0)" >Verify</button>
                                                <button  id="process" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Please wait...</button>
                                            </div>
                                        </form>
                                        <div class="form-group text-center">
                                            <div class="">
                                                <span style="color: gray" class="small">Didn't get it? &nbsp;&nbsp;</span>
                                            </div> 
                                            <div class="" id="timerShow">
                                                Resend in: <span id="timer"></span> 
                                            </div> 
                                            <div class="hidden" id="ResendButton">
                                                <a href="javascript:void(0)" style="margin-left:-12px" onclick='resendOTP("{{$get_SessionData["id"]}}")'><span>Resend</span></a> 
                                            </div>  
                                        </div> 
                                    </div>
                                    <div class="card-body hidden" id="otpSuccess">
                                        <p class="formSuccess text-center ">OTP Validation Successfull</p>
                                        <p class="text-center please_w">Please wait...</p>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small" style="color: gray"><a href="{{url('/logout')}}">Logout</a></div>
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
            $(document).ready(function(){
                startTimer();
            })
            function otpVerify() {
                $("#otp_verify").submit(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var otp = $("#otp").val(); 
                    if(otp == '') {
                        $('#err_otp').html('OTP is required.');
                        $('#otp').addClass('errorclass'); 
                    }else{
                        var formData = $("#otp_verify").serialize(); 
                        //calling ajaxHeader() function to generate CSRF Token
                        ajaxHeader();
                        $.ajax({
                            url: "{{ url('/otpVerify') }}",
                            type: "POST",
                            data: formData,
                            dataType: 'json', 
                            beforeSend: function() {
                                showProcessing('submit'); //show processing before form success
                            },
                            success: function(result) {  
                                if(result.response_msg === 'success') { 
                                    $("#otp_verify")[0].reset();
                                    $("#submit").prop('disabled',true);
                                    $("#otpSuccess").removeClass('hidden');
                                    $("#otpProcess").addClass('hidden');
                                    showSuccessMessage(result.data.valid_msg); 
                                    setTimeout(function() {
                                        hideSuccessMessage();
                                        window.location.replace(baseUrl + result.data.redirect_url);
                                    }, 2000);
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
                });
            } 

            //timer start
            function startTimer(){ 
                var timeleft = 31;
                var timer = setInterval(function(){
                    timeleft--;
                    $("#timer").html(timeleft + ' sec'); 
                    if(timeleft <= 0){
                        $("#timerShow").addClass('hidden');
                        $("#ResendButton").removeClass('hidden');
                        $("#timer").html('');
                        clearInterval(timer);
                    }
                },1000);
            }

            //otp resend
            function resendOTP(id){
                ajaxHeader();
                $.ajax({
                    type:"POST",
                    url: "{{ url('/otpResend') }}",
                    data: { 'uid':id },
                    dataType: "json",
                    cache: false,
                    success:function(result){
                        if(result.response_msg === 'success') { 
                            showSuccessMessage(result.message);
                            setTimeout(function() {
                                hideSuccessMessage();
                            }, 2000);
                            $("#timerShow").removeClass('hidden');
                            $("#ResendButton").addClass('hidden');
                            startTimer();
                        }else if(result.response_msg === 'error') { 
                            showErrorMessage(result.message);
                            setTimeout(function() {
                                //remove error with attr
                                removeErrorAttr();
                            }, 2000);
                        } 
                    }
                })
            }
        </script>
    </body>
</html>
