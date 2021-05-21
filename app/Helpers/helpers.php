<?php 

//authentication check
function auth_check(){
    $get_SessionData = Session::get('admin_session'); 
    if(!empty($get_SessionData)){ 
        if($get_SessionData['isOtpVerified'] == 0){
            return redirect()->to('/login')->send(); 
        }else{
            //
        }   
    }else{
        //check if session not set or otp not verified then redirect to login
        return redirect()->to('/login')->send();
    }
}

//set session
function setSession($arrContent = []){
    Session::put('admin_session', $arrContent); 
}

//remove session
function removeSession($arrContent = []){
    Session::flush('admin_session'); 
}

//generate otp
function createOTP(){
    return mt_rand(10000,99999); //generate 5 digit random number
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
        $message->from('no-reply@neosoftmail.com','Data Management Portal');
    }); 
}


?>