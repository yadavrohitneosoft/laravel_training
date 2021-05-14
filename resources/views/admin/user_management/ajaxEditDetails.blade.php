<div class="card-body loginform">
    <p class="regerror text-center hidden"></p>
    <p class="regsuccess text-center hidden" style="color:green"></p>
    <form action="javascript:void(0);" id="update_user" class="" method="post" autocomplete="off">
    <input name="uid" value="{{$info['id']}}" type="hidden" />
        <div class="form-group mb0">
            <label class="small mb-1" for="f_name">First Name</label>
            <input class="form-control fs12" name="f_name" id="f_name" value="{{$info['firstname']}}" type="text" placeholder="Enter Firstname" onkeypress="removeError()" />
            <span class="error" id="err_f_name"></span>
        </div>
        <div class="form-group mb0">
            <label class="small mb-1" for="l_name">Last Name</label>
            <input class="form-control fs12" name="l_name" id="l_name" value="{{$info['lastname']}}" type="text" placeholder="Enter Lastname" onkeypress="removeError()" />
            <span class="error" id="err_l_name"></span>
        </div>
        <div class="form-group mb0">
            <label class="small mb-1" for="inputEmailAddress">Email</label>
            <input class="form-control fs12 readonly" name="email" id="inputEmailAddress" value="{{$info['email']}}" type="text" readonly />
        </div>
        
        <div class="form-group mb0">
            <label class="small mb-1" for="u_type">Role</label>
            <select class="form-control fs12" name="u_type" id="u_type" onchange="removeError()">
                <option value="">--Select--</option>
                <option value="2" <?php if($info['user_type']==2) echo 'selected'; ?> >Admin</option>
                <option value="3" <?php if($info['user_type']==3) echo 'selected'; ?> >User</option>
            </select>  
            <span class="error" id="err_u_type"></span>
        </div>
        <div class="form-group">
            <label class="small mb-1" for="inputPassword">New Password</label>
            <input class="form-control fs12" name="password" id="inputPassword" type="password" placeholder="Enter Password" onkeypress="removeError()" />
            <span class="p-viewer">
                <i class="fa fa-eye" aria-hidden="true" onclick="show_hide_pass()"></i>
            </span>
            <span class="p-viewer2">
                <i class="fa fa-eye-slash" aria-hidden="true" onclick="show_hide_pass()"></i>
            </span>
            <span class="error" id="err_password"></span>
        </div> 
         
        <div class="form-group text-center"> 
            <button type="submit" id="submit" name="submit" onclick="UpdateUser();" class="btn btn-primary login_submit" href="javascript:void(0)" >Update</button>
            <button  id="process" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
            <button type="button" id="close_model" class="btn btn-danger login_submit" data-dismiss="modal">Close</button> 
        </div>
    </form>
</div>

<script>
            function UpdateUser() {
                $("#update_user").submit(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var fname = $("#f_name").val();
                    var lname = $("#l_name").val();
                    var utype = $("#u_type").val(); 
                    var password = $("#inputPassword").val();  
                    if(fname == '') {
                        $('#err_f_name').html('Firstname is required.');
                        $('#f_name').addClass('errorclass');
                    }else
                     if(lname == '') {
                        $('#err_l_name').html('Lastname is required.');
                        $('#l_name').addClass('errorclass');
                    }else if(utype == '') {
                        $('#err_u_type').html('User Type is required.');
                        $('#u_type').addClass('errorclass');
                    }else {
                        //console.log(fname+'--'+lname+'--'+utype+'--'+email+'--'+password+'--'+cpassword);
                        doUpdate();
                    }
                });
            }
            function doUpdate(){
                var formData = $("#update_user").serialize(); 
                //calling ajaxHeader() function to generate CSRF Token
                ajaxHeader();
                $.ajax({
                    url: "{{ url('manage-users/do_update_user') }}",
                    type: "POST",
                    data: formData,
                    dataType: 'json', 
                    beforeSend: function() {
                        $("#submit").addClass('hidden');
                        $("#process").removeClass('hidden');
                    },
                    success: function(result) { 
                        if(result.response_msg === 'success') { 
                            swal(result.message, { icon:"success", timer: 2000 }); 
                            $('#dataTable').DataTable().draw('full-hold'); 
                            $("#UserModel").modal('toggle');
                            $("#close_model").trigger('click');
                        }else if(result.response_msg === 'error') {  
                            $(".regerror").html(result.message);
                            $(".regerror").addClass('error');
                            $(".regerror").removeClass('hidden');
                            setTimeout(function() {
                                $(".regerror").html('');
                                $(".regerror").addClass('hidden');
                                $(".regerror").removeClass('error');
                            }, 3000);
                        } 
                        $("#submit").removeClass('hidden');
                        $("#process").addClass('hidden');
                    }
                });
            }
        </script>