<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminModel;
use App\Model\UserModel;
use View;
use Session;
use Redirect,Response,DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;   

class Administrator extends Controller
{

    private $environment;
    protected $adminModel;
    private $data;
    private $now; 

    public function __construct(){
        $this->environment = App::environment();
        $this->adminModel  = new AdminModel();
        $this->now = Carbon::now();
        $this->data = [];
    }

    //index
    public function index(){ 
        $this->data['title'] = 'Stock Management System | Login';
        //passing data to view by with method
        return view('admin.login.login')->with('arrContent', $this->data);
    }

    //user model data
    public function getData(){     
        $check = UserModel::all();
        return $check;
    }
    
    //dashboard home
    public function home(){
        auth_check();  
        return view('admin/dashboard/dashboard', $this->data);
    }

    //logout
    public function logout(){
        // The forget method will remove a piece of data from the session. 
        // If you would like to remove all data from the session, you may use the flush method: 
        // Session::forget('admin_session');
        Session::flush();
        return redirect()->to('/login');
    }

    






}
