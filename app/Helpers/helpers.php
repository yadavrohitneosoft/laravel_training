<?php 

//authentication check
function auth_check(){
    $get_SessionData = Session::get('admin_session'); 
    if(empty($get_SessionData)){ 
        //check if session not set or otp not verified then redirect to login
        return redirect()->to('/login')->send();
    }else if(!empty($get_SessionData) && $get_SessionData['user_role']==2){
        return redirect()->to('/login')->send();
    }
}

//site auth check 
function site_auth_check(){
    $get_SessionData = Session::get('admin_session'); 
    if(empty($get_SessionData)){ 
        //check if session not set or otp not verified then redirect to login
        //return redirect()->to('/login')->send();
    }else if(!empty($get_SessionData) && $get_SessionData['user_role']==1){
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
 

//debugging the output
function pa($array = []){
    echo "<pre>";
    print_r($array);
    exit;
}

//store image
function imageStore($file = [], $uploadData = []){
    $fileNameWithExtension = $file->getClientOriginalName(); //get file name with extension
    $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME); //filename
    $getExtension = $file->getClientOriginalExtension(); //get file extension
    $fileNameToStore = time().'_'.uniqid().'.'.$getExtension; //change final image name
    $finalName = str_replace(' ','',$fileNameToStore); //remove space in name
    Storage::disk('public')->put($uploadData['destinationPath'].$finalName, fopen($file, 'r+')); //store in disk
    return array('ImageName' => $finalName);
}


?>