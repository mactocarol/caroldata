<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Controllers;
    
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Input; 
use Modules\Admin\Models\Roles;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Vendor;
use Modules\Admin\Helpers\Helper;
use Route;
use View;
use Session;

/**
 * Class SingleUsersController
 */
class VendorController extends Controller
{
    /**
     * @var  Repository
     */
    public $helper;
    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('admin');
        View::share('viewPage', 'Vendor');
        View::share('helper', new Helper);
        View::share('heading', 'Store Vendors');
        View::share('route_url', route('vendor'));

        $this->record_per_page = Config::get('app.record_per_page');
        $this->indexUrl     = 'admin::vendor.index';
        $this->createUrl    = 'admin::vendor.create';
        $this->editUrl      = 'admin::vendor.edit';
        $this->defaultUrl   = route('vendor');
        $this->createMessage = 'Record created successfully.';
        $this->updateMessage = 'Record updated successfully.';
        $this->deleteMessage =  'Record deleted successfully.';

        $this->helper = new Helper; 

    }

    protected $users;

    /*
     * Dashboard
     * */

    public function index(Vendor $vendor, Request $request)
    {
        
        $page_title  = ucfirst(Route::currentRouteName());
        $page_action = 'View '.ucfirst(Route::currentRouteName());

        if ($request->ajax()) {
            $id           = $request->get('id');
            $status       = $request->get('status');
            $vendor         = Vendor::find($id);
            $s            = ($status == 1) ? $status=2:$status=1;
            $vendor->status = $s;
            $vendor->save(); 
            exit();
        }
        // Search by name ,email and group
        $search    = Input::get('search');
        $status    = Input::get('status'); 

        if ((isset($search) && !empty($search))) {
            $search = isset($search) ? Input::get('search') : '';

            $vendors = Vendor::where(function ($query) use ($search,$status) {
                if (!empty($search)) {
                    $query->Where('vendor_name', 'LIKE', "%$search%") 
                        ->orWhere('mobile', 'LIKE', "%$search%") 
                        ->orWhere('shop_name', 'LIKE', "%$search%") 
                        ->OrWhere('email', 'LIKE', "%$search%");
                }

                if (!empty($status)) {
                    
                    $status =  ($status == 'active')?1:0;
                    $query->Where('status', $status);
                }
 
            })->where('role_type', '=', 2)->Paginate($this->record_per_page);
        } else {
            $vendors = Vendor::orderBy('id', 'desc')->where('role_type', '=', 2)->Paginate($this->record_per_page);
        }
        $roles = config('role');
 
        return view($this->indexUrl, compact('roles', 'status', 'vendors', 'page_title', 'page_action', 'roles', 'role_type'));
    }

    /*
     * create Group method
     * */

    public function create(Vendor $vendor)
    {
        $page_title  =  str_replace(['.','create'],'', ucfirst(Route::currentRouteName()));
        $page_action =  str_replace('.',' ', ucfirst(Route::currentRouteName()));
        $roles       = config('role');
        $role_id     = 2;


        return view($this->createUrl, compact('role_id', 'roles', 'vendor', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(Request $request, Vendor $vendor)
    {
        $request->validate([
            'first_name' => 'required', 
            'last_name' => 'required',
            'mobile' => 'required', 
            'email' => 'required|email|unique:vendors,email',
            'password' => 'required',
            'shop_name' => 'required',
             'address' => 'required', 
            'pincode' => 'required',
        ]);

        try {
            \DB::beginTransaction(); 

            $table_cname = \Schema::getColumnListing('vendors');
            $except = ['id','created_at','updated_at','deleted_at','password'];
            
            foreach ($table_cname as $key => $value) {
               
               if(in_array($value, $except )){
                    continue;
               } 
               if($request->file($value)){
                    $vendor->$value = Vendor::uploadImage($request, 'vendor' ,$value);
               }else if($request->get($value)){
                    $vendor->$value = $request->get($value);
               }
            }
            $vendor->user_id = Helper::userCreateOrUpdate($request, $user_id=null);;
            $vendor->vendor_name = $request->get('first_name').' '.$request->get('last_name');
            $vendor->save(); 

            $user = User::find($vendor->user_id);
            if($user){
                $user->profile_image = $vendor->profile_picture;
                $user->save();
            }

            \DB::commit();

            try {

                $email_content['first_name'] =  $request->get('first_name');
                $email_content['email'] = $request->get('email');
                $email_content['message'] = "<br>Thank yor for choosing ventrega.<br>Your temprary username and password is :<br><br>
                                <b> Username:</b>". $request->get('email') ."<br>
                                <b>Password:</b>". $request->get('first_name') ."</br>";
                $email_content['greeting'] = "Team Ventrega";
                $email_content['subject'] = "Welcome to Ventrega!";
                $email_content['receipent_email'] = $request->get('email');

            $this->helper->sendMail($email_content, 'welcome');

            }catch(\Exception $e){
                //
            }
            

        } catch (\Exception $e) { 
            \DB::rollback();  
        } 
        
        return Redirect::to($this->defaultUrl)
            ->with('flash_alert_notice', $this->createMessage);
    }

    /*
     * Edit Group method
     * @param
     * object : $user
     * */

    public function edit(Vendor $vendor)
    {
        $page_title  =  str_replace(['.','edit'],'', ucfirst(Route::currentRouteName()));
        $page_action =  str_replace('.',' ', ucfirst(Route::currentRouteName()));

        $role_id     = $vendor->role_type;
        $roles       = config('role');
        $user = Helper::getUser($vendor->user_id);
        $vendor->first_name = $user->first_name??'';
        $vendor->last_name = $user->last_name??'';
       
        return view($this->editUrl, compact( 'role_id', 'roles', 'vendor', 'page_title', 'page_action'));
    }

    public function update(Request $request, $vendor)
    {   
         $request->validate([
            'first_name' => 'required', 
            'last_name' => 'required',
            'mobile' => 'required', 
            'email' => 'required|email', 
            'shop_name' => 'required',
            'address' => 'required', 
            'pincode' => 'required',
        ]);


        try {
            \DB::beginTransaction(); 

            $table_cname = \Schema::getColumnListing('vendors');
            $except = ['id','created_at','updated_at','deleted_at'];
            
            foreach ($table_cname as $key => $value) {
               
               if(in_array($value, $except )){
                    continue;
               } 
               if($request->file($value)){
                    $vendor->$value = Vendor::uploadImage($request, 'vendor' ,$value);
               }else if($request->get($value)){
                    $vendor->$value = $request->get($value);
               }
            }
            $vendor->user_id = Helper::userCreateOrUpdate($request, $vendor->user_id);
            $vendor->vendor_name = $request->get('first_name').' '.$request->get('last_name');
            
            $vendor->save(); 


            $user = User::find($vendor->user_id);
            if($user){
                $user->profile_image = $vendor->profile_picture;
                $user->save();
            }

            \DB::commit();
        } catch (\Exception $e) {  
            \DB::rollback(); 
           
        }  

        return Redirect::to($this->defaultUrl)
            ->with('flash_alert_notice', $this->updateMessage);
    }
    /*
     *Delete User
     * @param ID
     *
     */
    public function destroy(Request $request, $vendor)
    {
         $vendor->delete();
        return Redirect::to($this->defaultUrl)
            ->with('flash_alert_notice', $this->deleteMessage);
    }

    public function show(User $user)
    {
    }
}
