<?php

namespace App\Http\Controllers\Admin\Mailbox;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use View;
use Session;
use Redirect,Response,DB,URL;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;  
use App\Model\MailboxModel as Mailbox;  

class MailboxController extends Controller
{
    private $environment; 
    protected $now;
    protected $data;
    protected $mailboxModel; 
    //constructor
    public function __construct(){
        $this->environment = App::environment(); //to access env variables 
        $this->mailboxModel = new Mailbox();   
        $this->now = Carbon::now();
        $this->data = [];
    }

    //Property index
    public function index(){
        auth_check(); 
        return view('admin/mailbox_management/mailbox_index');
    }

    //get mailbox
    public function getMailbox(Request $request){
        $query = Mailbox::select('id', 'name', 'email','contact', 'message','username','prop_title', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as cr_date") )
            ->where([ ['deleted_at',NULL] ])
            ->orderBy('id','DESC')
            ->get();
        return DataTables::of($query)->make(true);   
    }
 
 

}
