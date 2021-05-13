<?php
//helper starts here

function auth_check(){

    $get_SessionData = Session::get('admin_session');
    if(empty($get_SessionData)){ 
        return redirect()->to('/login')->send();
    }
}

function pa($array = []){
    echo "<pre>";
    return print_r($array);
}



?>