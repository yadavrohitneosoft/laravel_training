<?php

namespace App\Http\Controllers\Admin\Product;
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
use App\Model\ProductModel as Product; 
use App\Model\CategoryModel as Category; 

class ProductController extends Controller
{
    private $environment;
    protected $adminModel;
    protected $now;
    protected $data; 
    protected $productModel;

    //constructor
    public function __construct(){
        $this->environment = App::environment(); //to access env variables
        $this->adminModel  = new AdminModel();
        $this->productModel = new Product();
        $this->now = Carbon::now();
        $this->data = [];
    }

    //products index
    public function index(){
        auth_check();  
        $cat = Category::where([ ['status','1'],['deleted_at',NULL] ])
            ->orderBy('id','DESC')
            ->get();  
        $this->data['category'] = !empty($cat) ? $cat : array();
        return view('admin/product_management/product_index', $this->data);
    }

    //get products
    public function getProducts(Request $request){
        $query = Product::select('id', 'title', 'description', 'category', DB::raw("case when status='1' then 'Active' else 'InActive' end as pstatus"), DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as cr_date") )
            ->where([ ['deleted_at',NULL] ])
            ->orderBy('id','DESC')
            ->get();   
        return Datatables::of($query)->make(true);   
    }

    //add product
    public function addProduct(Request $request){
        $catid = $request->input('p_cat');
        $title = $request->input('ptitle'); 
        $desc = $request->input('desc'); 
        $isValid = $this->checkValidator($request->all(), [
            'p_cat' => 'required',
            'ptitle' => 'required',
            'desc' => 'required'
        ]);
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202); 
        }else{   
            $find = Category::find($catid); 
            $catname = $find->getOriginal('title');
            $save = Product::create([
                'title'       =>  $title,
                'description' =>  $desc,
                'category'    =>  $catname,
                'category_id' =>  $catid,
                'created_at'  =>  $this->now
            ]);  
            if(!empty($save)){   
                return $this->successResponse($this->data, 'Product added successfully!', 200); 
            }else{
                return $this->errorResponse('Something went wrong', 202); 
            }
        }
    }

    //edit product
    public function editProductDetails($id=''){  
        $cat = Category::where([ ['status','1'],['deleted_at',NULL] ])
            ->orderBy('id','DESC')
            ->get();  
        $this->data['category'] = !empty($cat) ? $cat : array();
        $find = Product::find($id); //find by id(primary key)
        //$find->getOriginal() will return an array of the original attributes, or pass in a string with the attribute name 
        $this->data['info'] = $find->getOriginal();
        if(!empty($find->getOriginal())){  
            return $this->successResponse(['body'=>view('admin.product_management.ajaxEditProduct',$this->data)->render()], 'Success', 200); 
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    }

    //update product
    public function updateProduct(Request $request){
        $id = $request->input('pid');
        $cat_id = $request->input('p_cat_id');
        $title = $request->input('ptitle'); 
        $desc = $request->input('desc');
        $isValid = $this->checkValidator($request->all(), [
            'pid' => 'required',
            'p_cat_id' => 'required',
            'ptitle' => 'required',
            'desc' => 'required' 
        ]);
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);  
        }else{  
            $find = Category::find($cat_id); 
            $catname = $find->getOriginal('title');
            $update = Product::where('id',$id)->update(array(
                'title' => $title,
                'category' => $catname,
                'description' => $desc,
                'category_id' => $cat_id
            ));      
            return $this->successResponse($this->data, 'Product updated successfully!', 200); 
        }
    }

    //delete product
    public function deleteProduct($id=0){    
        $delete = Product::where('id',$id)->update(array('deleted_at' => $this->now));
        if($delete){ 
            return $this->successResponse(['id'=>$id], 'Product has been deleted successfully!', 200);  
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    }

    //change product status
    public function changeProductStatus($id=0){ 
        $update = Product::where('id', '=', $id)->update( array('status' => DB::raw("case when status='1' then '0' else '1' end")) ); 
        if($update){ 
            return $this->successResponse(['id'=>$id], 'Status changed successfully!', 200);  
        }else{
            return $this->errorResponse('Something went wrong', 202); 
        }
    }


}
