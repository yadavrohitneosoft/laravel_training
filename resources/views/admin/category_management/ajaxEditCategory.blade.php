<div class="card-body loginform">
    <p class="regerror text-center hidden"></p>
    <p class="regsuccess text-center hidden" style="color:green"></p>
    <form action="javascript:void(0);" id="edit_cat" class="" method="post" autocomplete="off">
    <input name="cid" value="{{$info['id']}}" type="hidden" />
        <div class="form-group">
            <label class="small mb-1" for="ctitle">Title</label>
            <input class="form-control fs12" name="c_title" id="c_title" value="{{$info['title']}}"  type="text" placeholder="Enter Title" onkeypress="removeError()" />
            <span class="error" id="err_c_title"></span>
        </div>                                
        <div class="form-group text-center"> 
            <button type="submit" id="submit_edit" name="submit" onclick="UpdateCat();" class="btn btn-primary login_submit" href="javascript:void(0)" >Update</button>
            <button  id="process_edit" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
            <button type="button" id="close_model_edit" class="btn btn-danger login_submit" data-dismiss="modal">Close</button> 
        </div>
    </form>
</div>


<script>
            function UpdateCat() {
                $("#edit_cat").submit(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var c_title = $("#c_title").val();   
                    if(c_title == '') {
                        $('#err_c_title').html('Title is required.');
                        $('#c_title').addClass('errorclass');
                    }else {
                            var formData = $("#edit_cat").serialize(); 
                            //calling ajaxHeader() function to generate CSRF Token
                            ajaxHeader();
                            $.ajax({
                                url: "{{ url('/manage-category/do_update_category') }}",
                                type: "POST",
                                data: formData,
                                dataType: 'json', 
                                beforeSend: function() {
                                    $("#submit_edit").addClass('hidden');
                                    $("#process_edit").removeClass('hidden');
                                },
                                success: function(result) { 
                                    if(result.response_msg === 'success') { 
                                        swal(result.message, { icon:"success", timer: 2000 }); 
                                        $('#dataTable').DataTable().draw('full-hold'); 
                                        $("#CatEditModel").modal('toggle');
                                        $("#close_model_edit").trigger('click');
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
                                    $("#submit_edit").removeClass('hidden');
                                    $("#process_edit").addClass('hidden');
                                }
                            });
                    }
                });
            } 
        </script>