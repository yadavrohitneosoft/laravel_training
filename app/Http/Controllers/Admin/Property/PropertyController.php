<?php

namespace App\Http\Controllers\Admin\Property;
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
use App\Model\PropertyModel as Property; 
use App\Model\PropertyImagesModel as PropertyImages; 
use App\Model\UserQueryModel as UserQuery;


class PropertyController extends Controller
{
    private $environment; 
    protected $now;
    protected $data;
    protected $propertyModel;
    protected $propertyImagesModel; 
    protected $queryModel;
    //constructor
    public function __construct(){
        $this->environment = App::environment(); //to access env variables 
        $this->propertyModel = new Property();
        $this->propertyImagesModel = new PropertyImages(); 
        $this->queryModel = new UserQuery();
        $this->now = Carbon::now();
        $this->data = [];
    }

    //Property index
    public function index(){
        auth_check(); 
        return view('admin/property_management/property_index');
    }

    //get Property
    public function getProperty(Request $request){
        $query = Property::select('id', 'title', 'description','price', 'floor_area','bedroom','bathroom','city','address','nearby', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as cr_date") )
            ->where([ ['deleted_at',NULL] ])
            ->orderBy('id','DESC')
            ->get();
        return DataTables::of($query)->make(true);   
    }

    //add Property
    public function add_property(Request $request){  
        $title = $request->input('ptitle');
        $desc = $request->input('desc');
        $price = $request->input('pprice'); 
        $floor_area = $request->input('pfloor_area');
        $bedroom = $request->input('pbedroom');
        $bathroom = $request->input('pbathroom');
        $city = $request->input('pcity');
        $address = $request->input('paddress');
        $nearby = $request->input('pnearby');
        $total = $request->input('totalImages');

        $isValid = $this->checkValidator($request->all(), [
            'ptitle' => 'required',
            'desc' => 'required',
            'pprice' => 'required',
            'pfloor_area' => 'required',
            'pbedroom' => 'required',
            'pbathroom' => 'required',
            'pcity' => 'required',
            'paddress' => 'required',
            'pnearby' => 'required',
        ]); 
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202);
        }else{    
            $this->propertyModel->title      =  $title;
            $this->propertyModel->price      =  $price;
            $this->propertyModel->description      =  $desc;
            $this->propertyModel->floor_area      =  $floor_area;
            $this->propertyModel->bedroom      =  $bedroom;
            $this->propertyModel->bathroom      =  $bathroom;
            $this->propertyModel->city      =  $city;
            $this->propertyModel->address      =  $title;
            $this->propertyModel->nearby      =  $nearby;
            $this->propertyModel->created_at =  $this->now;
             
            if($this->propertyModel->save()){
                $pid = $this->propertyModel->id;
                $destinationPath = '/uploads/property_images/'.$pid.'/'; 
                if($request->hasFile('files')){ //check file
                    foreach($request->File('files') as $image){
                        $fileNameWithExtension = $image->getClientOriginalName(); //get file name with extension
                        $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME); //filename
                        $getExtension = $image->getClientOriginalExtension(); //get file extension
                        $fileNameToStore = time().'_'.uniqid().'.'.$getExtension; //change final image name
                        $finalName = str_replace(' ','',$fileNameToStore); //remove space in name
                        $image->move(public_path().$destinationPath, $finalName); //move file to destination
                        array_push($this->data, $finalName); // store images name into array
                    }
                    
                }  
                $arrId = [];
                if(!empty($this->data)){
                    foreach($this->data as $key=>$val){
                        $this->propertyImagesModel = new PropertyImages();
                        $this->propertyImagesModel->prop_id = $pid;
                        $this->propertyImagesModel->image = $this->data[$key];
                        $this->propertyImagesModel->created_at = $this->now; 
                        $this->propertyImagesModel->save();
                        if($key==0){
                            array_push($arrId,$this->propertyImagesModel->id);
                        }
                    } 
                    if(!empty($arrId)){
                        $update = PropertyImages::where('id',$arrId[0])->update(array(
                            'isFeatured' => '1'
                        ));  
                    }
                     
                }
                  
               return $this->successResponse(array('images'=>$this->data), 'property Added successfully!', 200);  
            }else{
                return $this->errorResponse('Something went wrong', 202);  
            }
        }
    }

    
    public function property_detail(Request $request){ 
        auth_check();
        $baseUrl = URL::to('/');
        $pid = $request->input('id');
       // DB::raw("CONCAT($baseUrl,'/uploads/property_images/',CONCAT($pid,'/','image')) as images")
        $query = PropertyImages::select('id','prop_id','image', 'isFeatured', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as cr_date") )
            ->where([ ['prop_id',$pid] ])
            ->orderBy('id','DESC')
            ->get(); 
        $this->data['prop_images'] = $query;
        return view('admin/property_management/property_details', $this->data);
    }

    //Property Site 
    public function property_home(){
        site_auth_check(); 
        $query = Property::select("property.*", "property_images.prop_id","property_images.image as dImage")
        ->leftJoin("property_images",function($join){
            $join->on("property_images.prop_id","=","property.id")->where('property_images.isFeatured', '=', '1');
        })
        ->get(); 
        $this->data['data'] = $query;
        return view('site.property.property_site_index', $this->data);
    }
    //Property Site 
    public function site_property_details($id){
        site_auth_check(); 
        $findProp = Property::where([ ['id',$id] ])
            ->orderBy('id','DESC')
            ->get();  
        $findImages = PropertyImages::where([ ['prop_id',$id] ])
            ->orderBy('id','DESC')
            ->get();
        $this->data['data_prop'] = $findProp;
        $this->data['data_images'] = $findImages;
        return view('site.property.property_site_details', $this->data);
    }
    
    //send user query
    public function message(Request $request){
        $uid = $request->input('uid');
        $pid = $request->input('pid');
        $name = $request->input('name');
        $email = $request->input('email'); 
        $contact = $request->input('contact'); 
        $message = $request->input('message');
        $username = $request->input('username');
        $prop_title = $request->input('prop_title'); 
        $isValid = $this->checkValidator($request->all(), [
            'uid' => 'required',
            'pid' => 'required',
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'message' => 'required',
            'username' => 'required',
            'prop_title' => 'required'
        ]);
        if($isValid->fails()) { 
            return $this->errorResponse($isValid->messages()->first(), 202); 
        }else{    
            $save = UserQuery::create([
                'user_id'       =>  $uid,
                'prop_id'       =>  $pid,
                'name'          =>  $name,
                'email'         =>  $email,
                'contact'       =>  $contact,
                'message'       =>  $message,
                'username'      =>  $username,
                'prop_title'    =>  $prop_title,
                'created_at'    =>  $this->now
            ]);  
            if(!empty($save)){   
                return $this->successResponse($this->data, 'Query has been sent successfully!', 200); 
            }else{
                return $this->errorResponse('Something went wrong', 202); 
            }
        }
    }
 





}
