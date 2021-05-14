<?php

namespace App\Http\Controllers\Admin\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminModel; 
use View;
use Session;
use Redirect,Response,DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator; 
use App\Model\UserModel as User;  

class UserController extends Controller
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

    //user index view
    public function index(){
        auth_check(); 
        return view('admin/user_management/users_index', $this->data);
    }

    //get user details
    public function getUsers(Request $request){ 
        $query = User::select('id', DB::raw("concat(firstname,' ',lastname) as fullname"), 'email', DB::raw("case when user_type='2' then 'Admin' when user_type='3' then 'User' else '' end as urole"), DB::raw("case when status='1' then 'Active' else 'InActive' end as ustatus"), DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as cr_date, 'remember_token'") )
            ->where([ ['deleted_at',NULL] ])
            ->whereNotIn('user_type',['1'])
            ->orderBy('id','DESC')
            ->get();  
        $tableData = Datatables::of($query)->make(true);  
        return $tableData; 
    }

    //add users
    public function addUser(Request $request){ 
        $fname = $request->input('f_name');
        $lname = $request->input('l_name');
        $email = $request->input('email');
        $utype = $request->input('u_type');
        $password = Hash::make($request->input('password')); 
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string|max:50',
            'l_name' => 'required|string|max:50', 
            'email' => 'required|email|unique:users',
            'u_type' => 'required',
            'password' => 'required|min:6'
        ]); 
        if($validator->fails()) { 
            return $this->errorResponse($validator->messages()->first(), 202); 
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
                return $this->successResponse($this->data, 'User created successfully!', 200);
            }else{
                return $this->errorResponse('Something went wrong', 202); 
            }
        }
    }

    //change user status
    public function changeUserStatus($id=0){
        $update = User::where('id', '=', $id)->update( array('status' => DB::raw("case when status='1' then '0' else '1' end")) ); 
        if($update){ 
            return $this->successResponse($this->data, 'Status changed successfully!', 200);
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    }

    //get user details while updating
    public function getUserDetails($id=''){ 
        $find = User::find($id); //find by id(primary key)
        //$find->getOriginal() will return an array of the original attributes, or pass in a string with the attribute name 
        $this->data['info'] = $find->getOriginal();  
        if(!empty($find->getOriginal())){
            return $this->successResponse(['body'=>view('admin.user_management.ajaxEditDetails',$this->data)->render()], 'Product updated successfully!', 200);
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    }

    //delete user
    public function deleteUser($id=0){
        $delete = User::where('id',$id)->update(array('deleted_at' => $this->now));
        if($delete){ 
            return $this->successResponse($this->data, 'User has been deleted successfully!', 200);
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    } 

    //update user
    public function updateUser(Request $request){
        $id = $request->input('uid');
        $fname = $request->input('f_name');
        $lname = $request->input('l_name');
        $utype = $request->input('u_type');
        $password = Hash::make($request->input('password')); 
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'f_name' => 'required|string|max:50',
            'l_name' => 'required|string|max:50',  
            'u_type' => 'required', 
        ]); 
        if($validator->fails()) { 
            return $this->errorResponse($validator->messages()->first(), 202);
        }else{   
            $update = User::where('id',$id)->update(array(
                'firstname' => $fname,
                'lastname' => $lname,
                'user_type' => $utype,
                'password' => $password
            ));  
            if($update){ 
                return $this->successResponse($this->data, 'Account updated successfully!', 200);
            }else{
                return $this->errorResponse('Something went wrong', 202); 
            }
        }
    }
 


}
