<?php

namespace App\Http\Controllers\Admin\Category;
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
use App\Model\CategoryModel as Category; 


class CategoryController extends Controller
{
    private $environment;
    protected $adminModel;
    protected $now;
    protected $data;
    protected $categoryModel; 

    //constructor
    public function __construct(){
        $this->environment = App::environment(); //to access env variables
        $this->adminModel  = new AdminModel();
        $this->categoryModel = new Category();
        $this->now = Carbon::now();
        $this->data = [];
    }

    //category index
    public function index(){
        auth_check(); 
        return view('admin/category_management/category_index');
    }

    //get category
    public function getCategories(Request $request){
        $query = Category::select('id', 'title', DB::raw("case when status='1' then 'Active' else 'InActive' end as cstatus"), DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as cr_date") )
            ->where([ ['deleted_at',NULL] ])
            ->orderBy('id','DESC')
            ->get();
        return DataTables::of($query)->make(true);   
    }

    //add category
    public function addCategory(Request $request){ 
        $title = $request->input('ctitle'); 
        $isValid = $this->checkValidator($request->all(), [
            'ctitle' => 'required' 
        ]); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{   
            $this->categoryModel->title      =  $title;
            $this->categoryModel->created_at =  $this->now;
            if($this->categoryModel->save()){
                return $this->successResponse(['lastID'=>$this->categoryModel->id], 'Category Added successfully!', 200);  
            }else{
                return $this->errorResponse('Something went wrong', 202);  
            }
        }
    }

    //change category status
    public function changeCategoryStatus($id=0){
        $update = Category::where('id', '=', $id)->update( array('status' => DB::raw("case when status='1' then '0' else '1' end")) ); 
        if($update){
            return $this->successResponse(['id'=>$id], 'Status changed successfully!', 200); 
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    }

    //delete category
    public function deleteCategory($id=0){   
        $delete = Category::where('id',$id)->update(array('deleted_at' => $this->now));
        if($delete){
            return $this->successResponse($this->data, 'Category has been deleted successfully!', 200); 
        }else{
            return $this->errorResponse('Something went wrong', 202);  
        }
    } 

    //get category details on update
    public function getCategoryDetails($id=''){  
        $find = Category::find($id); //find by id(primary key)
        //$find->getOriginal() will return an array of the original attributes, or pass in a string with the attribute name 
        $this->data['info'] = $find->getOriginal();
        if(!empty($find->getOriginal())){
            return $this->successResponse(['id'=>$id,'body'=>view('admin.category_management.ajaxEditCategory',$this->data)->render()], 'Success', 200);
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    }

    //update category
    public function updateCategory(Request $request){ 
        $id = $request->input('cid');
        $c_title = $request->input('c_title'); 
        $isValid = $this->checkValidator($request->all(), [
            'cid' => 'required',
            'c_title' => 'required'
        ]); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);  
        }else{    
            $update = Category::where('id',$id)->update(array('title' => $c_title));
            return $this->successResponse($this->data, 'Category updated successfully!', 200);             
        }
    }





}
