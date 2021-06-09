<?php

namespace App\Http\Controllers\Admin\Authentication;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\AdminModel;
use Session,DB; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash; 
use App\Model\UserModel as User; 
use Illuminate\Support\Str; 

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
                    $token = Str::random(50); //update token while login
                    $update = User::where('id',$find->id)->update(['remember_token'=>$token]);
                    $session_data = array(
                                    'isLoggedin' => '1', 
                                    'id' => $find->id,
                                    'name' => $find->name, 
                                    'email' => $find->email,
                                    'user_role' => $find->role_id,
                                    'token' => $find->remember_token, 
                                ); 
                    setSession($session_data); //set session 
                    if( $find->role_id==1){
                        return $this->successResponse(['redirect_url'=>'/dashboard/index'], 'Success', 200);
                    }else if($find->role_id==2){
                        return $this->successResponse(['redirect_url'=>'/property/property-home'], 'Success', 200);
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
        $email = $request->input('email');
        $utype = $request->input('u_type');
        $password = Hash::make($request->input('password')); 
        $isValid = $this->checkValidator($request->all(), [
            'f_name' => 'required|string|max:50', 
            'email' => 'required|email|unique:users',
            'u_type' => 'required',
            'password' => 'required|min:6'
        ]); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{   
            $save = User::create([
                'name' => $fname, 
                'email' => $email,
                'role_id' => $utype,
                'password' => $password, 
                'created_at' => $this->now
            ]);  
            if(!empty($save)){  
                return $this->successResponse(['redirect_url'=>'/login'], 'Account created successfully!', 200);
            }else{ 
                return $this->errorResponse('Something went wrong', 202); 
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