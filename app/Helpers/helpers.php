<?php
//helper starts here

//authentication check
function auth_check(){
    $get_SessionData = Session::get('admin_session');
    if(empty($get_SessionData)){ 
        return redirect()->to('/login')->send();
    }
}

//debugging the output
function pa($array = []){
    echo "<pre>";
    print_r($array);
    exit;
}

//send emails
function sendMail($arrContent = []){  
    Mail::send($arrContent['view_template'], $arrContent, function($message) use ($arrContent) {
        $message->to($arrContent['to_email'], $arrContent['to_name'])
        ->subject($arrContent['subject']);
        $message->from('no-reply@neosoftmail.com','Stock Management Portal');
    }); 
}


?>