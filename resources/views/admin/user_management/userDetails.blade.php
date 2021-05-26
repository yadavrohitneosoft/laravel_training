@extends('includes.template')
@section('content')

<?php $get_SessionData = Session::get('admin_session'); ?>

<main>
    <div class="container-fluid"> 
        <ol class="breadcrumb mb-4 mt-4 onscrollFixed">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard/index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Account</li>
        </ol>
        <!-- profile image start -->
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-4">
                    <div class="card-body loginform">
                        <p class="formErrorImage text-center hidden"></p>
                        <p class="formSuccessImage text-center hidden"></p>
                            <!-- <div class="form-group mb0">  -->
                                <!-- <img src="{{ URL::asset('/images/demo-user.jpg') }}" width="200"  alt="" class="ds__logo profile_logo"> -->
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url('{{ URL::asset('/images/demo-user.jpg') }}');">
                                        </div>
                                    </div>
                                </div>    
                            <!-- </div>  -->
                    </div> 
                </div> 
            </div>
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-4">
                    <div class="card-body loginform">
                        <h3 class="text-center">Account Update</h3>
                        <p class="formError text-center hidden"></p>
                        <p class="formSuccess text-center hidden"></p>
                        <form action="javascript:void(0);" id="profile_update" class="" method="post" autocomplete="off" style="margin-top: 15px;">
                            <input type="hidden" value="{{$userInfo['id']}}" name="uid" >   
                            <div class="form-group mb0">
                                <label class="small mb-1" for="f_name">First Name</label>
                                <input class="form-control fs12" value="{{$userInfo['firstname']}}" name="fname" id="fname" type="text" placeholder="Enter Firstname" onkeypress="removeError()" />
                                <span class="error" id="err_fname"></span>
                            </div>
                            <div class="form-group mb0">
                                <label class="small mb-1" for="l_name">Last Name</label>
                                <input class="form-control fs12" value="{{$userInfo['lastname']}}" name="lname" id="lname" type="text" placeholder="Enter Lastname" onkeypress="removeError()" />
                                <span class="error" id="err_lname"></span>
                            </div>      
                            <div class="form-group text-center">
                                <!-- <a class="small" href="password.php">Forgot Password?</a> -->
                                <button type="submit" id="submit" name="submit" onclick="profileUpdate();" class="btn btn-primary login_submit" href="javascript:void(0)" >Update</button>
                                <button  id="process" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
                            </div>
                        </form>
                    </div> 
                </div> 
            </div>
            <!-- profile image end -->
        </div>
    </div>
</main> 

<script>

    // function readURL(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();
    //         reader.onload = function(e) {
    //             $('#imagePreview').css('background-image', 'url('+e.target.result +')');
    //             $('#imagePreview').hide();
    //             $('#imagePreview').fadeIn(650);
    //         }
    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }
    // $("#imageUpload").change(function() {
    //     readURL(this);
    // });

        //registration
        function profileUpdate() {
                $("#profile_update").submit(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var fname = $("#fname").val();
                    var lname = $("#lname").val(); 
                    if(fname == '') {
                        $('#err_fname').html('Firstname is required.');
                        $('#fname').addClass('errorclass'); return;
                    }else if(lname == '') {
                        $('#err_lname').html('Lastname is required.');
                        $('#lname').addClass('errorclass'); return;
                    }else{
                        var formData = $("#profile_update").serialize(); 
                        //calling ajaxHeader() function to generate CSRF Token
                        ajaxHeader(); 
                        $.ajax({
                            url: "{{ url('/manage-users/profile-update') }}",
                            type: "POST",
                            data: formData,
                            dataType: 'json', 
                            beforeSend: function() {
                                showProcessing('submit'); //show processing before form success
                            },
                            success: function(result) { 
                                if(result.response_msg === 'success') {  
                                    showSuccessMessage(result.message); //show success message
                                    setTimeout(function(){
                                        hideSuccessMessage(); //hide success message 
                                        location.reload(); //reload window
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
                });
            }
            
</script>
     
@endsection