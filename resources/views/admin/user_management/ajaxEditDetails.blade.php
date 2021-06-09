<div class="card-body loginform">
    <p class="formError text-center hidden"></p>
    <p class="formSuccess text-center hidden" style="color:green"></p>
    <form action="javascript:void(0);" id="update_user" class="" method="post" autocomplete="off" enctype="multipart/form-data">
    <input name="uid" value="{{$info['id']}}" id="uid" type="hidden" />
        <div class="form-group mb0">
            <label class="small mb-1" for="f_name_edit">Name</label>
            <input class="form-control fs12" name="f_name" id="f_name_edit" value="{{$info['name']}}" type="text" placeholder="Enter Firstname" onkeypress="removeError()" />
            <span class="error" id="err_f_name_edit"></span>
        </div> 
        <div class="form-group mb0">
            <label class="small mb-1" for="inputEmailAddress_edit">Email</label>
            <input class="form-control fs12" name="email" id="inputEmailAddress_edit" value="{{$info['email']}}" type="text"  />
            <span class="error" id="err_email"></span>
        </div>
        <div class="form-group">
            <label class="small mb-1" for="inputPassword_edit">New Password</label>
            <input class="form-control fs12" name="password" id="inputPassword_edit" type="password" placeholder="Enter Password" onkeypress="removeError()" />
            <span class="p-viewer">
                <i class="fa fa-eye" aria-hidden="true" onclick="show_hide_pass()"></i>
            </span>
            <span class="p-viewer2">
                <i class="fa fa-eye-slash" aria-hidden="true" onclick="show_hide_pass()"></i>
            </span>
            <span class="error" id="err_password_edit"></span>
        </div> 
        <div class="form-group mb0">
            <label class="small mb-1" for="pnearby">Profile Image</label>
            <input class="form-control fs12" type="file" name="file" id="file" />  
        </div>
         
        <div class="form-group text-center"> 
            <button type="submit" id="submit_edit" name="submit" onclick="UpdateUser();" class="btn btn-primary login_submit" href="javascript:void(0)" >Update</button>
            <button type="button" id="process_edit" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
            <button type="button" id="close_model_edit" class="btn btn-primary login_submit" data-dismiss="modal">Close</button> 
        </div>
    </form>
</div>

<script>
            function UpdateUser() {
                $("#update_user").submit(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var uid = $("#uid").val(); 
                    //alert(uid); return true;
                    var fname = $("#f_name_edit").val(); 
                    var email = $("#inputEmailAddress_edit").val(); 
                    var password = $("#inputPassword_edit").val();
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                      
                    if(fname == '') {
                        $('#err_f_name_edit').html('Name is required.');
                        $('#f_name_edit').addClass('errorclass');
                    }else if(email == '') {
                        $('#err_email').html('Email is required.');
                        $('#inputEmailAddress_edit').addClass('errorclass');
                    }else if(!regex.test(email)){
                            $('#err_email').html('Email is invalid.');
                            $('#inputEmailAddress').addClass('errorclass');
                    }else { 
                        var formData = new FormData();
                        let totalImage = $('#file')[0].files.length; 
                        let profileImage = $('#file')[0];
                        for(let i = 0; i < totalImage; i++) {
                            formData.append('files[]', profileImage.files[i]);
                        } 
                        formData.append('totalImage', totalImage);
                        formData.append('f_name', fname);
                        formData.append('email', email);
                        formData.append('password', password);
                        formData.append('uid', uid); 
                        ajaxHeader();
                            $.ajax({
                                url: "{{ url('manage-users/do_update_user') }}",
                                type: "POST",
                                data: formData,
                                cache:false,
                                contentType: false,
                                processData: false,
                                dataType: 'json', 
                                beforeSend: function() {
                                    showProcessing('update'); //show processing before form success
                                },
                                success: function(result) { 
                                    if(result.response_msg === 'success') { 
                                        swal(result.message, { icon:"success", timer: 2000 }); 
                                        $('#dataTable').DataTable().draw('full-hold'); 
                                        $("#UserModel").modal('toggle');
                                        $("#close_model_edit").trigger('click');
                                    }else if(result.response_msg === 'error') {  
                                        showErrorMessage(result.message); //show error message
                                        setTimeout(function() {
                                            removeErrorAttr(); //remove error with attr
                                        }, 3000);
                                    }  
                                    hideProcessing('update'); //hide processing after form success
                                }
                            });
                    }
                });
            }
            
        </script>