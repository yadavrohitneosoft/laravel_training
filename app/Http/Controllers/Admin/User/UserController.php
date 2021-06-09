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
use App\Model\UserModel as User;  
use Auth;
use Illuminate\Support\Str;

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
        $uid = $request->input('userId');
        $arr = [$uid];
        $baseImage = url('/uploads/user_profile.png');
        $query = User::select('id', 'name', 'email', DB::raw("case when role_id='2' then 'Customer' when role_id='1' then 'Admin' else '' end as urole"),'image', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as cr_date") )
            ->where([ ['deleted_at',NULL] ])
            ->whereNotIn('id',$arr) 
            // ->whereNotIn('role_id',[1]) 
            ->orderBy('id','DESC')
            ->get();  
        $tableData = Datatables::of($query)->make(true);  
        return $tableData; 
    }

    //get user details while updating
    public function getUserDetails($id=''){ 
        $find = User::find($id); //find by id(primary key)
        //$find->getOriginal() will return an array of the original attributes, or pass in a string with the attribute name 
        $this->data['info'] = $find->getOriginal();  
        if(!empty($find->getOriginal())){
            return $this->successResponse(['body'=>view('admin.user_management.ajaxEditDetails',$this->data)->render()], 'Data retrieved successfully!', 200);
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    }

    //get user account view 
    public function myAccount($token=''){ 
        auth_check();
        $find = User::where('remember_token', $token)->first();
        if(!empty($find)){
            $this->data['userInfo'] = $find->getOriginal();
            if(!empty($find->getOriginal())){
                return view('admin.user_management.userDetails',$this->data);
            }else{
                return view('admin.404'); 
            }
        }else{
            return view('admin.404'); 
        }
    }

    //profile update 
    public function updateUser(Request $request){
        $id = $request->input('uid');
        $fname = $request->input('f_name');
        $email = $request->input('email');
        $pass =  $request->input('password');
        $password = Hash::make($pass); 
        $find = User::find($id); 
        $uemail = $find->getOriginal('email');
        $arr = [];
        if($uemail === $email){
            $arr = [
                'uid' => 'required',
                'f_name' => 'required|string|max:50',   
            ];  
        }else{
            $arr = [
                'uid' => 'required',
                'f_name' => 'required|string|max:50',
                'email' => 'required|unique:users',   
            ];
        }
        $isValid = $this->checkValidator($request->all(), $arr); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{  
            $finalName = ''; 
            $destinationPath = '/uploads/user_images/'.$id.'/'; 
            if($request->hasFile('files')){ //check file 
                foreach($request->File('files') as $image){
                    $fileNameWithExtension = $image->getClientOriginalName(); //get file name with extension
                    $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME); //filename
                    $getExtension = $image->getClientOriginalExtension(); //get file extension
                    $fileNameToStore = time().'_'.uniqid().'.'.$getExtension; //change final image name
                    $finalName = str_replace(' ','',$fileNameToStore); //remove space in name
                    $image->move(public_path().$destinationPath, $finalName); //move file to destination
                }
            } 
            $data_update = [];
            if($pass != ''){
                $data_update = array(
                    'name' => $fname,
                    'email' => $email,
                    'image' => $finalName,
                    'password' => $password
                ); 
            }else{
                $data_update = array(
                    'name' => $fname,
                    'email' => $email,
                    'image' => $finalName
                ); 
            }
            $update = User::where('id',$id)->update($data_update);   
            return $this->successResponse($this->data, 'Profile Updated Successfully!', 200); 
        }
    }

    //upload picture
    public function uploadPicture(Request $request){
        $isValid = $this->checkValidator($request->all(), [
            'uid' => 'required'  
        ]); 
        if($isValid->fails()) {
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{
            $uid = $request->input('uid');
            $destinationPath = '/uploads/user_images/'.$uid.'/';
            $uploadData = ['destinationPath'=>$destinationPath,'image_name'=>'user_image'];
            if($request->hasFile('Image')){ //check file
                $arrImage = imageStore($request->file('Image'), $uploadData);
                // $test = explode('.', $_FILES["Image"]["name"]);
                // $ext = end($test);
                // $name = Str::random(15).time().'.'.$ext; //create random image name
                pa($arrImage);
                // $location = './upload/' . $name; 
                // $update = User::where('id',$uid)->update(array('image' => $name)); 
                // move_uploaded_file($_FILES["Image"]["tmp_name"], $location); 
            }else{
                return $this->errorResponse('Something went wrong', 202);
            }
        } 
    }
    
    
 


}
