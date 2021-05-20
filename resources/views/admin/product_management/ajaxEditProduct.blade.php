<div class="card-body loginform">
    <p class="formError text-center hidden"></p>
    <p class="formSuccess text-center hidden" style="color:green"></p>
    <form action="javascript:void(0);" id="edit_prod" class="" method="post" autocomplete="off">
    <input class="form-control fs12" name="pid" value="{{$info['id']}}"  type="hidden"/>
        <div class="form-group mb0">
            <label class="small mb-1" for="p_cat">Category</label>
            <select class="form-control fs12" name="p_cat_id" id="p_cat_edit" onchange="removeError()">
                <option value="">--Select--</option> 
                @foreach($category as $val)
                    <option <?php if($val->id === $info['category_id']){ echo 'selected'; } ?> value="{{$val->id}}">{{$val->title}}</option> 
                @endforeach
            </select>  
            <span class="error" id="err_p_cat_edit"></span>
        </div>
        <div class="form-group mb0">
            <label class="small mb-1" for="ptitle">Title</label>
            <input class="form-control fs12" name="ptitle" id="ptitle_edit" value="{{$info['title']}}"  type="text" placeholder="Enter Title" onkeypress="removeError()" />
            <span class="error" id="err_ptitle_edit"></span>
        </div>
        <div class="form-group ">
            <label class="small mb-1" for="desc">Description</label>
            <textarea class="form-control fs12" name="desc" id="desc_edit" type="text" placeholder="Enter Description" onkeypress="removeError()" >{{$info['description']}}</textarea>
            <span class="error" id="err_desc_edit"></span>
        </div>                                
        <div class="form-group text-center"> 
            <button type="submit" id="submit_edit" name="submit" onclick="UpdateProd();" class="btn btn-primary login_submit" href="javascript:void(0)" >Update</button>
            <button  id="process_edit" class="btn btn-primary hidden login_process" href="javascript:void(0)" >Processing...</button>
            <button type="button" id="close_model_edit" class="btn btn-danger login_submit" data-dismiss="modal">Close</button> 
        </div>
    </form>
</div>


<script>
    function UpdateProd() {
        $("#edit_prod").submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var cat = $("#p_cat_edit").val();
                var title = $("#ptitle_edit").val(); 
                var desc = $("#desc_edit").val();  
                if(cat == '') {
                    $('#err_p_cat_edit').html('Category is required.');
                    $('#p_cat_edit').addClass('errorclass');
                }else if(title == '') {
                    $('#err_ptitle_edit').html('Title is required.');
                    $('#ptitle_edit').addClass('errorclass');
                }else if(desc == '') {
                    $('#err_desc_edit').html('Description is required.');
                    $('#desc_edit').addClass('errorclass');
                }else {
                    var formData = $("#edit_prod").serialize(); 
                    //calling ajaxHeader() function to generate CSRF Token
                    ajaxHeader();
                    $.ajax({
                        url: "{{ url('/manage-products/do_update_product') }}",
                        type: "POST",
                        data: formData,
                        dataType: 'json', 
                        beforeSend: function() {
                            showProcessing('update'); //show processing before form success
                        },
                        success: function(result) { 
                            if(result.response_msg === 'success') { 
                                swal(result.message, { icon:"success", timer: 2000 }); 
                                $('#dataTable').DataTable().draw('full-hold'); 
                                $("#EditProductModel").modal('toggle');
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