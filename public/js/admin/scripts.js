// const { type } = require("jquery");

//call function before ajax success
function beforeSend() {
    $("#loader").show();
    $("#layoutSidenav_content").addClass('opacityPoint5');
}

//call function after ajax success
function afterSend() {
    $("#loader").hide();
    $("#layoutSidenav_content").removeClass('opacityPoint5');
}

// below we are instructing a library like jQuery to automatically add the token to all request headers. 
//This provides simple, convenient CSRF protection for your AJAX based applications using legacy JavaScript technology:
function ajaxHeader(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
}

//load views by ajax call from sidebar menus
function loadhtmlView(page, pageType = '') {
    $.ajax({
        type: "GET",
        url: baseUrl + page,
        cache: 'FALSE',
        beforeSend: function() {
            beforeSend();
        },
        success: function(html) {
            afterSend();
            $('#layoutSidenav_content').html(html);
        }
    });
}

function showMessage(type, message) {
    //$("div.success").fadeIn(300).delay(50000000).fadeOut(400);
    var htmlAlert = '<div class="alert alert-' + type + '">' + message + '</div>';
    // Prepend so that alert is on top, could also append if we want new alerts to show below instead of on top.
    $(".alert-box").prepend(htmlAlert);
    // Since we are prepending, take the first alert and tell it to fade in and then fade out.
    // Note: if we were appending, then should use last() instead of first()
    $(".alert-box .alert").first().hide().slideDown(500).delay(2000).slideUp(500, function() { $(this).remove(); });
}


(function($) {
    "use strict";
    // Add active state to sidbar nav links
    //  var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    //  $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
    //      if (this.href === path) {
    //          $(this).addClass("active");
    //      }
    //  });
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").click(function() {
        // remove classes from all
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").removeClass("active");
        // add class to the one we clicked
        $(this).addClass("active");
    });

    //  // Toggle the side navigation
    //  $("#sidebarToggle").on("click", function(e) {
    //      e.preventDefault();
    //      $("body").toggleClass("sb-sidenav-toggled");
    //  });

})(jQuery);


function removeError() {
    $('.error').html('');
    //$('.errorclass').css('border','1px solid #ced4da');     
}

//show-hide password section
$(".p-viewer").addClass('hidden');

function show_hide_pass() {
    var x = document.getElementById("inputPassword");
    // if (x.type === "password") {
    //     x.type = "text";
    //     $(".p-viewer2").addClass('hidden');
    //     $(".p-viewer").removeClass('hidden');
    // } else {
    //     x.type = "password";
    //     $(".p-viewer").addClass('hidden');
    //     $(".p-viewer2").removeClass('hidden');
    // }

    if($("#inputPassword").hasClass('security')==true){
        $("#inputPassword").removeClass('security');
        $(".p-viewer2").addClass('hidden');
        $(".p-viewer").removeClass('hidden');
    } else {
        $("#inputPassword").addClass('security');
        $(".p-viewer").addClass('hidden');
        $(".p-viewer2").removeClass('hidden');
    }
}

//to show the process button before form success
function showProcessing(type){   
    if(type==='submit'){
        $("#submit").addClass('hidden');
        $("#process").removeClass('hidden');
    }else if(type==='update'){
        $("#submit_edit").addClass('hidden');
        $("#process_edit").removeClass('hidden');
    }
}

//to hide process button after form success
function hideProcessing(type){  
    if(type==='submit'){
        $("#submit").removeClass('hidden');
        $("#process").addClass('hidden');
    }else if(type==='update'){
        $("#submit_edit").removeClass('hidden');
        $("#process_edit").addClass('hidden');
    }  
}

//function to show success message
function showSuccessMessage(message=''){    
    $(".formSuccess").removeClass('hidden');
    $(".formSuccess").html(message);
}

//function to hide success message
function hideSuccessMessage(){    
    $(".formSuccess").addClass('hidden');
    $(".formSuccess").html('');
}

//function to show error message
function showErrorMessage(message=''){
    $(".formError").removeClass('hidden');
    $(".formError").html(message);
    //$(".formError").addClass('error');
}

//function to remove error class and message
function removeErrorAttr(){
    $(".formError").addClass('hidden');
    $(".formError").html('');
    //$(".formError").removeClass('error');
}
 