<?php

namespace App\Http\Controllers\Admin\Authentication;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\AdminModel;
use Session,DB; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash; 
use App\Model\UserModel as User;  

class LoginController extends Controller
{   
    protected $adminModel;
    protected $now;
    protected $data; 
    protected $userModel; 

    public function __construct(){
        $this->adminModel = new AdminModel();
        $this->now = Carbon::now();
        $this->data = [];
        $this->userModel = new User(); 
    }

    //index
    public function index(Request $request){
        // The only method returns all of the key / value pairs that you request; however, 
        // it will not return key / value pairs that are not present on the request.
        $req = $request->only('email','password');
        $pass = $req['password'];
        $email = $req['email']; 
        $find = User::where('email', $email)->first();  
        if($find){   
            if(Hash::check($pass, $find->password)){
                if($find->status == 0){
                    return $this->errorResponse('Your account is InActive, Please contact to administrator', 202); 
                }else{
                    $expired_time = Carbon::now()->addMinutes(10); //otp will expire in 10 minutes
                    $otp = createOTP(); //generate 5 digit OTP
                    $update = User::where('id',$find->id)->update(['otp'=>$otp, 'otp_expired_at'=>$expired_time]);
                    //send email for OTP verification
                    $subject = 'OTP for login session | Data Management System';
                    sendMail(array('otp'=>$otp,'to_email'=>$email,'to_name'=>$find->firstname,'subject'=>$subject,'view_template'=>'admin.otpVerification.otp'));
                    $session_data = array(
                                    'isLoggedin' => '1',
                                    'isOtpVerified' => '0',
                                    'id' => $find->id,
                                    'firstname' => $find->firstname,
                                    'lastname' => $find->lastname,
                                    'email' => $find->email,
                                    'user_role' => $find->user_type
                                ); 
                    setSession($session_data); //set session 
                    return $this->successResponse(['redirect_url'=>'/otp_verification'], 'Success', 200);
                }
            }else{
                return $this->errorResponse('Invalid Password', 202); 
            }
        }else{
            return $this->errorResponse('Account does not exists', 202); 
        } 
    }

    //load registration view
    public function register(Request $request){
        return view('admin.register.register');
    }

    //save registration
    public function doRegister(Request $request){  
        $fname = $request->input('f_name');
        $lname = $request->input('l_name');
        $email = $request->input('email');
        $utype = $request->input('u_type');
        $password = Hash::make($request->input('password')); 
        $isValid = $this->checkValidator($request->all(), [
            'f_name' => 'required|string|max:50',
            'l_name' => 'required|string|max:50', 
            'email' => 'required|email|unique:users',
            'u_type' => 'required',
            'password' => 'required|min:6'
        ]); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{   
            $save = User::create([
                'firstname' => $fname,
                'lastname' => $lname,
                'email' => $email,
                'user_type' => $utype,
                'password' => $password, 
                'created_at' => $this->now
            ]);  
            if(!empty($save)){  
                //send confirmation email after registration
                $subject = 'Registration confirmation | Data Management System';
                sendMail(array('to_email'=>$email,'to_name'=>$fname,'subject'=>$subject,'view_template'=>'admin.emails.email'));
                return $this->successResponse(['redirect_url'=>'/login'], 'Account created successfully!', 200);
            }else{ 
                return $this->errorResponse('Something went wrong', 202); 
            }
        }
    }

    //send OTP after login submit
    public function otp_verification(Request $request){  
        return view('admin.login.otpVerify');
    }

    //verify OTP
    public function otpVerify(Request $request){ 
        $isValid = $this->checkValidator($request->all(), [ 
            'uid' => 'required', 
            'otp' => 'required'
        ]); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{
            $find = User::where('id',$request->input('uid'))->first();
            if($find->otp == $request->input('otp')){  
                //compare otp expiration time
                if($this->now->lessThan($find->otp_expired_at)){
                    //update otp column after successful otp validation
                    Session::flush(); //remove the previous session
                    $session_data = array(
                        'isLoggedin' => '1',
                        'isOtpVerified' => '1',
                        'id' => $find->id,
                        'firstname' => $find->firstname,
                        'lastname' => $find->lastname,
                        'email' => $find->email,
                        'user_role' => $find->user_type
                        );
                    Session::put('admin_session', $session_data); //set session again 
                    $update = User::where('id',$find->id)->update(array('otp' => NULL,'otp_expired_at' => NULL)); 
                    return $this->successResponse(['redirect_url'=>'/dashboard/index','valid_msg'=>'OTP Validation Successful'], 'Success', 200);
                 }else{
                    return $this->errorResponse('OTP has expired', 202);  
                }
            }else{
                return $this->errorResponse('OTP is Incorrect', 202); 
            }
        }        
    }

    //resend OTP
    public function otpResend(Request $request){ 
        $isValid = $this->checkValidator($request->all(), [ 
            'uid' => 'required',
        ]); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{  
            $find = User::where('id', $request->input('uid'))->first(); 
            if($find){
                $expired_time = Carbon::now()->addMinutes(10); //otp will expire in 10 minutes
                $otp = createOTP(); //generate 5 digit OTP
                //update columns after resend otp 
                $update = User::where('id',$find->id)->update(['otp'=>$otp, 'otp_expired_at'=>$expired_time]);
                //send email for OTP verification
                $subject = 'OTP for login session | Data Management System';
                sendMail(array('otp'=>$otp,'to_email'=>$find->email,'to_name'=>$find->firstname,'subject'=>$subject,'view_template'=>'admin.otpVerification.otp'));
                return $this->successResponse($this->data, 'OTP sent successfully!', 200);
            }else{
                return $this->errorResponse('Something went wrong!', 202); 
            }
        }        
    }

    //user email existance check
    public function checkUserAccount(Request $request){
        $email = $request->input('email');
        $isValid = $this->checkValidator($request->all(), [ 
            'email' => 'required',
        ]); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{  
            $find = User::where('email', $email)->first(); 
            if($find){ 
                return $this->errorResponse('An account already exists with this Email ID', 202);
            }else{
                return $this->successResponse($this->data, 'No account exists with this Email', 200);
            }
        }
    }


    
}