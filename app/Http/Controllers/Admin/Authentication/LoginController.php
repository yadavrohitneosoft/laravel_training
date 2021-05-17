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
        $find = User::where('email', '=', $email)->first();  
        if($find){   
            if(Hash::check($pass, $find->password)){
                if($find->status == 0){
                    return $this->errorResponse('Your account is InActive, Please contact to administrator', 202); 
                }else{
                    $session_data = array(
                                        'isLoggedin' => '1',
                                        'id' => $find->id,
                                        'firstname' => $find->firstname,
                                        'lastname' => $find->lastname,
                                        'email' => $find->email,
                                        'user_role' => $find->user_type
                                        );
                    Session::put('admin_session', $session_data); 
                    return $this->successResponse(['redirect_url'=>'/dashboard/index'], 'Success', 200);
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
                'status' => '1',
                'created_at' => $this->now
            ]);  
            if(!empty($save)){  
                //send email after registration
                $subject = 'Registration confirmation | '.$fname.' ' .$lname;
                sendMail(array('to_email'=>$email,'to_name'=>$fname,'subject'=>$subject,'view_template'=>'admin.emails.email'));
                return $this->successResponse(['redirect_url'=>'/login'], 'Account created successfully!', 200);
            }else{ 
                return $this->errorResponse('Something went wrong', 202); 
            }
        }
    }


    
}