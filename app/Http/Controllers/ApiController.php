<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response;
use Auth,Crypt,Hash,Lang,JWTAuth,Input,Closure,URL;
use JWTExceptionTokenInvalidException;
use App\Helpers\Helper as Helper;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Vendors as Vendor;
use Modules\Admin\Models\Kyc;
use Modules\Admin\Models\Category;
use App\Models\Notification;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Dispatcher;
use Cookie;
use Modules\Admin\Models\Product;
use Modules\Admin\Models\ProductType;
use Modules\Admin\Models\ProductUnit;
use Modules\Admin\Models\VendorProduct;
class ApiController extends Controller
{
   /* @method : validateUser
    * @param : email,password,firstName,lastName
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : get
    */
    public    $sid      = "";
    public    $token    = "";
    public    $from     = "";
    public function __construct(Request $request) {
        if ($request->header('Content-Type') != "application/json")  {
            $request->headers->set('Content-Type', 'application/json');
        }
        $user_id =  $request->input('userId');
    }
    // deactive user
    public function deactivateUser($user_id=null)
    {
         $user = User::find($user_id);
        /** Return Error Message **/
        if (!$user) {
                    $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);
                    }
            return Response::json(array(
                'status' => 0,
                'code'=>500,
                'message' => 'Invalid User id',
                'data'  =>  $request->all()
                )
            );
        }
         $user->status=0;
         $user->save();
         return Response::json(array(
                'status' => 1,
                'code'=> 200,
                'message' => 'Account deativated',
                'data'  =>  []
                )
            );
    }
   /**
    * @method : register
    * @param : email,password,deviceID,firstName,lastName
    * @Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : post
    */
    public function register(Request $request,User $user)
    {
        // social media
        $authType  = $request->get('authType');
        // auth type
        if($authType=='google' || $authType=='facebook' || $authType=='twitter' || $authType=='linkedin'){
                //Server side valiation
                $validator = Validator::make($request->all(), [
                   'firstName' =>  'required',
                   'email'      =>  'required',
                   'providerId' =>  'required',
                   'loginType'  =>  'required',
                   'authType'   =>  'required'
                ]);
        }else{
            //Server side valiation
            $validator = Validator::make($request->all(), [
               'firstName' => 'required',
               'email'      => 'required|email|unique:users',
               'password'   => 'required',
               'loginType'  => 'required',
            ]);
        }
        /** Return Error Message **/
        if ($validator->fails()) {
            $error_msg  =  [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);
                    }
            return Response::json(array(
                'status' => 0,
                'code'=>201,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }
        $loginType  = $request->get('loginType');
        $role       = Config::get('role');
        $roleType   = (object)array_flip($role);
        $input['first_name']    = $request->get('firstName');
        $input['last_name']     = $request->get('lastName');
        $input['email']         = $request->get('email');
        $input['username']      = $request->get('username');
        $input['password']      = Hash::make($request->get('password'));
        $input['role_type']     = $roleType->$loginType;
        $input['user_type']     = $request->get('authType'); // social media
        $input['provider_id']   = $request->get('providerId');
        $helper = new Helper;
        /** --Create user-- **/
        $user = User::create($input);
        $subject = "Welcome to ventrega! Verify your email address to get started";
        $email_content = [
                'receipent_email'=> $request->get('email'),
                'subject'=>$subject,
                'greeting'=> 'Ventrega',
                'first_name'=> $request->get('firstName'),
                'first_name'=> $request->get('firstName')
                ];
        $verification_email = $helper->sendMailFrontEnd($email_content,'verification_link');
        //dd($verification_email);
        $notification = new Notification;
        $notification->addNotification('user_register',$user->id,$user->id,'User register','');
        return response()->json(
                            [
                                "status"    =>  1,
                                "code"      =>  200,
                                "message"   =>  "Thank you for registration.Verify your email address to get started",
                                'data'      => $request->all()
                            ]
                        );
    }

    public function createImage($base64)
    {
        try{
            $img  = explode(',',$base64);
            if(is_array($img) && isset($img[1])){
                $image = base64_decode($img[1]);
                $image_name= time().'.jpg';
                $path = storage_path() . "/image/" . $image_name;
                file_put_contents($path, $image);
                return url::to(asset('storage/image/'.$image_name));
            }else{
                if(starts_with($base64,'http')){
                    return $base64;
                }
                return false;
            }
        }catch(Exception $e){
            return false;
        }
    }
    public function userDetail($id=null)
    {
        $user = User::find($id);
        return Response::json(array(
                    'status' => ($user)?1:0,
                    'code' => ($user)?200:404,
                    'message' => ($user)?'User data found.':'Record not found!',
                    'data'  =>  $user
                    )
        );
    }
    public function updateKyc(Request $request, $userId){
        $document_name = ['adharCard','panCard','voterId','drivingLicense'];
        $vendor = Vendor::findOrNew(['user_id',$userId]);
        if(in_array($request->get('documentName'), $document_name)){
            $kyc    = Kyc::findOrNew(['vendor_id',$vendor->id,'document_name'=>$request->get('documentName')]);
        }else{
            $kyc    = Kyc::findOrNew(['vendor_id',$vendor->id]);
        }
        $kyc->document_name =  $request->get('documentName');
        $kyc->document_type =  $request->get('documentType');
        $kyc->vendor_id     =  $vendor->id;
        $kyc->is_verified   =  "No";
        $kyc->verified_by   =  "";
        $kyc->status        =  "Pending";
        return Response::json(array(
                    'status' => ($kyc)?1:0,
                    'code' => ($kyc)?200:404,
                    'message' => "Kyc updated and pending for review.",
                    'data'  => []
                    )
                );
    }
    // vendor update
    public function vendorUpdate(Request $request,$userId){
        $table_cname = \Schema::getColumnListing('vendors');
        $except = ['id','created_at','updated_at','shopType'];
        $vendor = Vendor::firstOrNew(['user_id'=>$userId]);
        $userId = User::find($userId);
        if($request->get('first_name') || $request->get('last_name')){
            $vendor->vendor_name = $request->get('first_name').' '.$request->get('last_name');
        }
        $vendor->type = $request->get('shopType');
        $vendor->role_type = $userId->role_type;
        if($request->get('profileImage')){
            $profile_image = $this->createImage($request->get('profileImage'));
            if($profile_image==false){
            }else{
                $vendor->profile_picture  = $profile_image;
            }
        }
        if($request->get('latitude')){
            $vendor->lat = $request->get('latitude');
        }
        if($request->get('longitude')){
            $vendor->lng = $request->get('longitude');
        }
        foreach ($table_cname as $key => $value) {
            if(in_array($value, $except )){
                continue;
            }
            if($request->get(camel_case($value))){
                $vendor->$value = $request->get(camel_case($value));
           }
        }
        try{
            $vendor->save();
            $status = 1;
            $code  = 200;
            $message ="Vendor Profile updated successfully";
        }catch(\Exception $e){
            $status = 0;
            $code  = 201;
            $message =$e->getMessage();
        }
        return response()->json(
                            [
                            "status" =>$status,
                            'code'   => $code,
                            "message"=> $message,
                            'data'=>[]
                            ]
                        );
    }
/* @method : update User Profile
    * @param : email,password,deviceID,firstName,lastName
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    * Calling Method : get
    */
    public function updateProfile(Request $request,$userId)
    {
        $user = User::find($userId);
        $role       = Config::get('role');
        if((User::find($userId))==null)
        {
            return Response::json(array(
                'status' => 0,
                'code' => 201,
                'message' => 'Invalid user Id!',
                'data'  =>  []
                )
            );
        }

        $table_cname = \Schema::getColumnListing('users');
        $except = ['id','created_at','updated_at','profile_image','modeOfreach','email'];
        foreach ($table_cname as $key => $value) {
           if(in_array($value, $except )){
                continue;
           }
            if($request->get($value)){
                $user->$value = $request->get($value);
            }
        }
        if($request->get('profilePicture')){
            $profile_image = $this->createImage($request->get('profilePicture'));
            if($profile_image==false){
                return Response::json(array(
                    'status' => 0,
                     'code' => 201,
                    'message' => 'Invalid Image format!',
                    'data'  =>  $request->all()
                    )
                );
            }
            $user->profile_image  = $profile_image;
        }
        try{
            $user->save();
            $status = 1;
            $code  = 200;
            $message ="Profile updated successfully";
        }catch(\Exception $e){
            $status = 0;
            $code  = 201;
            $message =$e->getMessage();
        }
        return response()->json(
                            [
                            "status" =>$status,
                            'code'   => $code,
                            "message"=> $message,
                            'data'=>[]
                            ]
                        );
    }
    // Validate user
    public function validateInput($request,$input){
        //Server side valiation
        $validator = Validator::make($request->all(), $input);
        /** Return Error Message **/
        if ($validator->fails()) {
            $error_msg      =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);
                    }
            if($error_msg){
               return array(
                    'status' => 0,
                    'code' => 500,
                    'message' => $error_msg[0],
                    'data'  =>  $request->all()
                    );
            }
        }
    }
   /* @method : login
    * @param : email,password and deviceID
    * Response : json
    * Return : token and user details
    * Author : kundan Roy
    */
    public function login(Request $request)
    {
        $input = $request->all();
        $user_type = $request->get('authType');
        // Validation
        $validateInput['email'] = 'required|email';
        $v = $this->validateInput($request,$validateInput);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'deviceDetails'=> 'required'
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
            $error_msg      =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);
                    }
            if($error_msg){
               return array(
                    'status' => 0,
                    'code' => 201,
                    'message' => $error_msg[0],
                    'data'  =>  $request->all()
                    );
            }
        }
        switch ($user_type) {
            case 'facebook':
                $token = JWTAuth::attempt(['email'=>$request->get('email'),'provider_id'=>$request->get('providerId')]);
                break;
            case 'google':
                $token = JWTAuth::attempt(['email'=>$request->get('email'),'provider_id'=>$request->get('providerId')]);
                break;
            case 'twitter':
                $token = JWTAuth::attempt(['email'=>$request->get('email'),'provider_id'=>$request->get('providerId')]);
                break;
            case 'linkedin':
                $token = JWTAuth::attempt(['email'=>$request->get('email'),'provider_id'=>$request->get('providerId')]);
                break;
            default:
                $token = JWTAuth::attempt(
                            [   'status'=>1,
                                'email'=>$request->get('email'),
                                'password'=>$request->get('password'),
                            ]);
                break;
        }
        if (!$token) {
            return response()->json([ "status"=>0,"code"=>201,"message"=>"Invalid email or password!" ,'data' => $input ]);
        }
        $user = JWTAuth::toUser($token);
        try{
            $user->deviceDetails = json_encode($request->get('deviceDetails'));
            $user->save();
            \DB::table('login_logs')->insert(['user_id'=>$user->id,'deviceDetails'=>$user->deviceDetails]);
            $data = ['userId'=>$user->id,'firstName'=>$user->first_name,'email'=>$user->email];
            return response()->json([ "status"=>1,"code"=>200,"code"=>200,"message"=>"Successfully logged in." ,'data' => $data,'token'=>$token ]);
        } catch (DecryptException $e) {
            return response()->json([ "status"=>0,"code"=>401,"message"=>$e->getMessage(),'data' => []]);
        }
    }
   /* @method : get user details
    * @param : Token and deviceID
    * Response : json
    * Return : User details
   */
    public function getUserDetails(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));
        return response()->json(
                [ "status"=>1,
                  "code"=>200,
                  "message"=>"success." ,
                  "data" => $user
                ]
            );
    }
   /* @method : Email Verification
    * @param : token_id
    * Response : json
    * Return :token and email
   */
    public function emailVerification(Request $request)
    {
        $verification_code = ($request->input('verification_code'));

        $email    = ($request->input('email'));

        if (Hash::check($email, $verification_code)) {
           $user = User::where('email',$email)->get()->count();
           if($user>0)
           {
              User::where('email',$email)->update(['status'=>1]);
           }else{
            echo "Verification link is Invalid or expire!"; exit();
                return response()->json([ "status"=>0,"message"=>"Verification link is Invalid!" ,'data' => '']);
           }
           echo "Email verified successfully."; exit();
           return response()->json([ "status"=>1,"message"=>"Email verified successfully." ,'data' => '']);
        }else{
            echo "Verification link is Invalid!"; exit();
            return response()->json([ "status"=>0,"message"=>"Verification link is invalid!" ,'data' => '']);
        }
    }

   /* @method : logout
    * @param : token
    * Response : "logout message"
    * Return : json response
   */
    public function logout(Request $request)
    {
        $token = $request->input('token');
        JWTAuth::invalidate($request->input('token'));
        return  response()->json([
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"You've successfully signed out.",
                    'data' => []
                    ]
                );
    }
   /* @method : forget password
    * @param : token,email
    * Response : json
    * Return : json response
    */
    public function forgetPassword(Request $request)
    {
        $email = $request->input('email');
        //Server side valiation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        $helper = new Helper;
        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);
                    }
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }
        $user =   User::where('email',$email)->first();
        if($user==null){
            return Response::json(array(
                'status' => 0,
                'code' => 201,
                'message' => "Oh no! The address you provided isn't in our system",
                'data'  =>  $request->all()
                )
            );
        }
        $user_data = User::find($user->id);
        $temp_password = Hash::make($email);
      // Send Mail after forget password
        $temp_password =  Hash::make($email);
        $email_content = array(
                        'receipent_email'   => $request->input('email'),
                        'subject'           => 'Your Ventrega Account Password',
                        'first_name'        => $user->first_name,
                        'temp_password'     => $temp_password,
                        'encrypt_key'       => Crypt::encrypt($email),
                        'greeting'          => 'Ventrega'
                    );
        $helper = new Helper;
        $email_response = $helper->sendMail(
                                $email_content,
                                'forgot_password_link'
                            );
       return   response()->json(
                    [
                        "status"=>1,
                        "code"=> 200,
                        "message"=>"Reset password link has sent. Please check your email.",
                        'data' => $request->all()
                    ]
                );
    }
    public function resetPassword(Request $request)
    {
        $encryptedValue = $request->get('key')?$request->get('key'):'';
        $method_name = $request->method();
        $token = $request->get('token');
       // $email = ($request->get('email'))?$request->get('email'):'';
        if($method_name=='GET')
        {
            try {
                $email = Crypt::decrypt($encryptedValue);
                if (Hash::check($email, $token)) {
                    return view('admin.auth.passwords.reset',compact('token','email'));
                }else{
                    return Response::json(array(
                        'status' => 0,
                        'message' => "Invalid reset password link!",
                        'data'  =>  ''
                        )
                    );
                }
            } catch (DecryptException $e) {
            //   return view('admin.auth.passwords.reset',compact('token','email'))
              //              ->withErrors(['message'=>'Invalid reset password link!']);
                return Response::json(array(
                        'status' => 0,
                        'message' => "Invalid reset password link!",
                        'data'  =>  ''
                        )
                    );
            }
        }else
        {
            try {
                $email = Crypt::decrypt($encryptedValue);
                if (Hash::check($email, $token)) {
                        $password =  Hash::make($request->get('password'));
                        $user = User::where('email',$email)->update(['password'=>$password]);
                        return Response::json(array(
                                'status' => 1,
                                'message' => "Password reset successfully.",
                                'data'  =>  []
                                )
                            );
                }else{
                    return Response::json(array(
                        'status' => 0,
                        'message' => "Invalid reset password link!",
                        'data'  =>  ''
                        )
                    );
                }
            } catch (DecryptException $e) {
                return Response::json(array(
                        'status' => 0,
                        'message' => "Invalid reset password link!",
                        'data'  =>  []
                        )
                    );
            }
        }
    }
   /* @method : change password
    * @param : token,oldpassword, newpassword
    * Response : "message"
    * Return : json response
   */
    public function changePassword(Request $request)
    {
        $email = $request->input('email');
        //Server side valiation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        $helper = new Helper;
        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);
                    }
            return Response::json(array(
                'status' => 0,
                "code" => 201,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }
        $user =   User::where('email',$email)->first();
        if($user==null){
            return Response::json(array(
                'status' => 0,
                'code' => 500,
                'message' => "The email address you provided isn't in our system",
                'data'  =>  $request->all()
                )
            );
        }
        
        $user = User::where('email',$request->get('email'))->first();
        $user_id = $user->id;
        $old_password = $user->password;
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6'
        ]);
        // Return Error Message
        if ($validator->fails()) {
            $error_msg  =   [];
            foreach ( $validator->messages()->all() as $key => $value) {
                        array_push($error_msg, $value);
                    }
            return Response::json(array(
                'status' => 0,
                'message' => $error_msg[0],
                'data'  =>  ''
                )
            );
        }
        if (Hash::check($request->input('oldPassword'),$old_password)) {
           $user_data =  User::find($user_id);
           $user_data->password =  Hash::make($request->input('newPassword'));
           $user_data->save();
           return  response()->json([
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"Password changed successfully.",
                    'data' => []
                    ]
                );
        }else
        {
            return Response::json(array(
                'status' => 0,
                "code"=> 500,
                'message' => "Old password mismatch!",
                'data'  =>  []
                )
            );
        }
    }
    /*SORTING*/
    public function array_msort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;
    }
    public function InviteUser(Request $request,InviteUser $inviteUser)
    {
        $user =   $inviteUser->fill($request->all());
        $user_id = $request->input('userID');
        $invited_user = User::find($user_id);
        $user_first_name = $invited_user->first_name ;
        $download_link = "http://google.com";
        $user_email = $request->input('email');
        $helper = new Helper;
        $cUrl =$helper->getCompanyUrl($user_email);
        $user->company_url = $cUrl;
        /** --Send Mail after Sign Up-- **/
        $user_data     = User::find($user_id);
        $sender_name     = $user_data->first_name;
        $invited_by    = $invited_user->first_name.' '.$invited_user->last_name;
        $receipent_name = "User";
        $subject       = ucfirst($sender_name)." has invited you to join";
        $email_content = array('receipent_email'=> $user_email,'subject'=>$subject,'name'=>'User','invite_by'=>$invited_by,'receipent_name'=>ucwords($receipent_name));
        $helper = new Helper;
        $invite_notification_mail = $helper->sendNotificationMail($email_content,'invite_notification_mail',['name'=> 'User']);
        $user->save();
        return  response()->json([
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"You've invited your colleague, nice work!",
                    'data' => ['receipentEmail'=>$user_email]
                   ]
                );
    }
    public function cDashboard(){
       // $cd = CategoryDashboard::all
        $image_url = env('IMAGE_URL',url::asset('storage/uploads/category/'));
        $categoryDashboard = CategoryDashboard::with('category')->limit(8)->get();
        $data = [];
        $category_data = [];
        foreach ($categoryDashboard as $key => $value) {
            if(isset($value->category)){
            $data['category_id']            = $value->category->id;
            $data['category_name']          = $value->category->category_name;
            $data['category_image']         = $image_url.'/'.$value->category->category_image;
            $data['group_id']               = $value->category->parent->id;
            $data['category_group_name']    = $value->category->parent->category_group_name;
            $data['category_group_image']   = $image_url.'/'.$value->category->category_group_image;
            $category_data[] = $data;
            }
        }
        if(count($data)){
            $status = 1;
            $code   = 200;
            $msg    = "Category dashboard list";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Category dashboard list not  found!";
        }
        return  response()->json([
                "status"=>$status,
                "code"=> $code,
                "message"=> $msg,
                'data' => $category_data
            ]
        );
    }
    public function groupCategory(Request $request)
    {
        $image_url  = env('IMAGE_URL',url::asset('storage/uploads/category/'));
        $catId      = null;
        $arr        = [];
        try{
            $categoryDashboard = Category::with(['groupCategory'=>function($q){
                 $q->select('id','category_name','category_image','description','parent_id');
            }])->where('parent_id','=',0)->get();
            $data = [];
            foreach ($categoryDashboard as $key => $value) {
                $data['group_id']               = $value->id;
                $data['category_group_name']    = $value->category_group_name;
                $data['category_group_image']   = $image_url.'/'.$value->category_group_image;
                $data['category']   = isset($value->groupCategory)?$value->groupCategory:[];
                $arr[]              = $data;
            }
        }catch(\Exception $e){
            $data = [];
            $status = 0;
            $code   = 500;
            $msg    = $e->getMessage();
        }
        if(count($data)){
            $status = 1;
            $code   = 200;
            $msg    = "Category list found";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Record not  found!";
        }
        return  response()->json([
                "status"=>$status,
                "code"=> $code,
                "message"=> $msg,
                'data' => $arr
            ]
        );
    }
    public function allCategory(Request $request)
    {
        $image_url  = env('IMAGE_URL',url::asset('storage/uploads/category/'));
        $catId      = null;
        $arr        = [];
        try{
            $categoryDashboard = Category::where('parent_id','!=',0)->get();
            $data = [];
            foreach ($categoryDashboard as $key => $value) {
                $data['category_id']   = $value->id;
                $data['category_name']   = $value->category_name;
                $data['category_image']   = $image_url.'/'.$value->category_image;
                $arr[]              = $data;
            }
        }catch(\Exception $e){
            $data = [];
            $status = 0;
            $code   = 500;
            $msg    = $e->getMessage();
        }
        if(count($data)){
            $status = 1;
            $code   = 200;
            $msg    = "Category list found";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Record not  found!";
        }
        return  response()->json([
                "status"=>$status,
                "code"=> $code,
                "message"=> $msg,
                'data' => $arr
            ]
        );
    }
    public function otherCategory(Request $request)
    {
        $image_url = env('IMAGE_URL',url::asset('storage/uploads/category/'));
        $catId = null;
        if($request->get('categoryId')){
            $catId      = $request->get('categoryId');
            $category   = Category::where('id',$catId)->first();
            $name       = 'otherCategory';
            $id         = $category->parent_id;
        }
        if($request->get('groupId')){
            $catId      = $request->get('groupId');
            $category   = Category::where('id',$catId)->first();
            $id         = $category->id;
            $name       = 'groupCategory';
        }
        try{
            $categoryDashboard = Category::where('parent_id',$id)->where('id','!=',$catId)->where('parent_id','!=',0)->get();
          //  $categoryDashboard = Category::where('parent_id',$id)->get();
            $data = [];
            $data['category_id']            = $category->id;
            $data['group_id']               = ($category->parent_id==0)?$category->id:$category->parent_id;
            $data['category_group_name']    = $category->category_group_name;
            $data['category_group_image']   = $image_url.'/'.$category->category_group_image;
            $data[$name]         = $categoryDashboard;
        }catch(\Exception $e){
            $data = [];
            $status = 0;
            $code   = 500;
            $msg    = "Id does not exist";
        }
        if(count($data)){
            $status = 1;
            $code   = 200;
            $msg    = "Category of other Category list";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Record not  found!";
        }
        return  response()->json([
                "status"=>$status,
                "code"=> $code,
                "message"=> $msg,
                'data' => $data
            ]
        );
    }
    public function category(){
       // $cd = CategoryDashboard::all
        $image_url = env('IMAGE_URL',url::asset('storage/uploads/category/'));
        $categoryDashboard = Category::with('children')->where('parent_id',0)->get();
        $data = [];
        $category_data = [];
        foreach ($categoryDashboard as $key => $value) {
            $data['group_id']               = $value->id;
            $data['category_group_name']    = $value->category_group_name;
            $data['category_group_image']   = $image_url.'/'.$value->category_group_image;
            foreach ($value->children as $key => $result) {
                $data2['category_id']      = $result->id;
                $data2['category_name']    = $result->category_name;
                $data2['category_image']   = $image_url.'/'.$result->category_image;
                $data2['category_group_id'] = $result->parent_id;
                $data2['category_group_name'] = $value->category_group_name;
                $data2['description'] = $result->description;
                $data['category'][] = $data2;
            }
            $category_data[] = $data;
        }
        if(count($data)){
            $status = 1;
            $code   = 200;
            $msg    = "Category dashboard list";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Category dashboard list not  found!";
        }
        return  response()->json([
                "status"=>$status,
                "code"=> $code,
                "message"=> $msg,
                'data' => $category_data
            ]
        );
    }
    public function sendMail()
    {
        $emails = ['kroy@mailinator.com'];
        Mail::send('emails.welcome', [], function($message) use ($emails)
        {
            $message->to($emails)->subject('This is test e-mail');
        });
        var_dump( Mail:: failures());
        exit;
    }
    //array_msort($array, $cols)
    public function addPersonalMessage(Request $request){
        $rs = $request->all();
        $validator = Validator::make($request->all(), [
            'taskId' => "required",
            'userId' => "required",
            'comments'=> "required"
        ]);
        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => $request->all()
                            )
            );
        }
        $input=[];
        foreach ($rs as $key => $val){
            $input[$key] = $val;
        }
        \DB::table('messges')->insert($input);
            return response()->json(
                        [
                            "status" =>1,
                            'code' => 200,
                            "message" => "Message added successfully.",
                            'data' => $input
                        ]
        );
    }
    public function getPersonalMessage(Request $request){
        $rs = $request->all();
        $validator = Validator::make($request->all(), [
            'taskId' => "required",
           // 'poster_userid' => "required"
        ]);
         if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => $request->all()
                            )
            );
        }
        $posteduserid   = $request->get('postedUserId');
        $doerUserid     = $request->get('doerUserid');
        $data = Messges::with('commentPostedUser')
                    ->with(['taskDetails'=> function($q)use($posteduserid,$doerUserid,$request){
                        if($doerUserid){
                            $q->where('taskDoerId',$doerUserid);
                        }if($posteduserid){
                            $q->where('taskOwnerId',$posteduserid);
                        }
                    }])
                    ->where('taskId',$request->get('taskId'))
                    ->where(function($q)use($posteduserid,$doerUserid,$request){
                        if($posteduserid){
                            $q->where('userId',$posteduserid);
                        }
                        if($doerUserid){
                            $q->where('userId',$doerUserid);
                        }
                    })->get();
        return response()->json(
                        [
                            "status" =>count($data)?1:0,
                            'code' => count($data)?200:404,
                            "message" =>count($data)?"Message found":"Message not found",
                            'data' => $data
                        ]
        );
    }

    public function generateOtp(Request $request){
        $rs = $request->all();
        $validator = Validator::make($request->all(), [
            'userId' => "required",
            'mobileNumber' => 'required'
        ]);
         if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => $request->all()
                            )
            );
        }
        $otp = mt_rand(100000, 999999);
        $data['otp'] = $otp;
        $data['userId'] = $request->get('userId');
        $data['timezone'] = config('app.timezone');
        $data['mobile'] = $request->get('mobileNumber');

        \DB::table('mobile_otp')->insert($data);

        $this->sendSMS($request->get('mobileNumber'),$otp);

        return response()->json(
                        [
                            "status"    =>  count($data)?1:0,
                            'code'      =>  count($data)?200:401,
                            "message"   =>  count($data)?"Otp generated":"Something went wrong",
                            'data'      =>  $data
                        ]
        );
    }

    public function verifyOtp(Request $request){
        $rs = $request->all();
        $validator = Validator::make($request->all(), [
            'otp' => "required",
            'userId' => 'required'
        ]);
         if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => $request->all()
                            )
            );
        }
        $data = \DB::table('mobile_otp')
                    ->where('otp',$request->get('otp'))
                        ->where('userId',$request->get('userId'))->first();
        if($data){
             \DB::table('mobile_otp')
                    ->where('otp',$request->get('otp'))
                        ->where('userId',$request->get('userId'))->update(['is_verified'=>1]);
            \DB::table('users')
                        ->where('id',$request->get('userId'))
                        ->update(['phone'=>$data->mobile]);
        }
            return response()->json(
                            [
                                "status"    =>  count($data)?1:0,
                                'code'      =>  count($data)?200:500,
                                "message"   =>  count($data)?"Otp Verified":"Invalid Otp",
                                'data'      =>  $request->all()
                            ]
                );
    }

    public function sendSMS($mobileNumber=null,$otp=null)
    {
        $curl = curl_init();
            $modelNumber = $mobileNumber;
            $message = "Your verification OTP is : ".$otp;
            $authkey = "224749Am2kvmYg75b4092ed";
            curl_setopt_array($curl, array(
              CURLOPT_URL => "http://control.msg91.com/api/sendotp.php?template=&otp_length=6&authkey=$authkey&message=$message&sender=YTASKR&mobile=$modelNumber&otp=$otp&otp_expiry=&email=kroy@mailinator.com",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "",
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              return false;
            } else {
              return true;
            }
    }

    public function getCategoryById($id){
        $url =  Category::where('id',$id)->first();
        return  $url->slug.'/';
    }

    public function AddVendorProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productTitle' => 'required',
            'storePrice' => 'required',
            'productCategory' => 'required',
            'photo' => 'mimes:jpeg,bmp,png,gif,jpg,PNG',
        ]);
        if ($validator->fails()) {
            $error_msg  =  [];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                'status' => 0,
                'code'=>201,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }
        $cat_url    = $this->getCategoryById($request->get('productCategory'));
        $pro_slug   = str_slug($request->get('productTitle'));
        $url        = $cat_url.$pro_slug;
        $product = new Product;
        $product->slug  = $pro_slug ;
        $product->url   = $url;
        try {
            \DB::beginTransaction();
            $table_cname = \Schema::getColumnListing('products');
            $except = ['id','created_at','updated_at','deleted_at','additional_images','btn_name'];
            foreach ($table_cname as $key => $value) {
                
               if(in_array($value, $except )){
                    continue;
               }

               if($request->get(camel_case($value))){
                  $product->$value = $request->get(camel_case($value));
                }
            }
            $product->save();
            // vendor
            $vendorProduct =  VendorProduct::firstOrNew(
                [
                    'vendor_id'=> $request->get('vendorId'),
                    'product_id'=>$product->id
                ]
            );
            $vendorProduct->vendor_id = $request->get('vendorId');
            $vendorProduct->product_id = $product->id;
            $vendorProduct->save();
            \DB::commit();
            $msg = 'New Product was successfully created !';

        } catch (\Exception $e) {
             \DB::rollback();
            $msg = $e->getMessage();
        }
        return response()->json(
            [
                "status"    =>  1,
                "code"      =>  200,
                "message"   =>  $msg,
                'data'      => $request->all()
            ]
        );
    }

    public function destroy(Request $request) {

        $validator = Validator::make($request->all(), [
            'productId' => 'required',
            'vendorId' => 'required'
        ]);

        if ($validator->fails()) {
            $error_msg  =  [];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                'status' => 0,
                'code'=>201,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }

        $product = VendorProduct::where('vendor_id',$request->get('vendorId'))
        ->where('product_id',$request->get('productId'))
        ->delete();

        $msg = 'Product was successfully deleted !';

        return response()->json(
            [
                "status"    =>  1,
                "code"      =>  200,
                "message"   =>  $msg,
                'data'      => $request->all()
            ]
        );
    }

    public function getProductUnit(){
        $productunits =  ProductUnit::where('status', 1)->pluck('id','name');
        if(count($productunits)){
            $status = 1;
            $code   = 200;
            $msg    = "Product Unit list.";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Product Unit list not found!";
        }
        return  response()->json([
                "status"=>$status,
                "message"=> $msg,
                'data' => $productunits
            ]
        );
    }

    public function getProductType(){
        $producttypes =  ProductType::where('status', 1)->pluck('id','name');
        if(count($producttypes)){
            $status = 1;
            $code   = 200;
            $msg    = "Product Type list.";
        }else{
            $status = 0;
            $code   = 404;
            $msg    = "Product Type list not found!";
        }
        return  response()->json([
                "status"=>$status,
                "message"=> $msg,
                'data' => $producttypes
            ]
        );
    }

    public function addDefaultProducts( Request $request ){
        $validator = Validator::make($request->all(), [
            'productId' => 'required',
            'vendorId' => 'required',
         ]);
        if ($validator->fails()) {
            $error_msg  =  [];
            foreach ( $validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                'status' => 0,
                'code'=>201,
                'message' => $error_msg[0],
                'data'  =>  $request->all()
                )
            );
        }
        try {
            \DB::beginTransaction();
            $vendorProduct =  VendorProduct::firstOrNew(
                [
                    'vendor_id'=>  $request->get('vendorId'),
                    'product_id'=> $request->get('productId')
                ]
            );
            $vendorProduct->vendor_id = $request->get('vendorId');
            $vendorProduct->product_id = $request->get('productId');
            $vendorProduct->save();
            \DB::commit();
            $msg = 'New Product was successfully created !';

        } catch (\Exception $e) {
             \DB::rollback();
            $msg = $e->getMessage();
        }
        return response()->json(
            [
                "status"    =>  1,
                "code"      =>  200,
                "message"   =>  $msg,
                'data'      =>  $request->all()
            ]
        );
    }


    public function generateEmailOtp(Request $request){

        $rs = $request->all();

        $validator = Validator::make($request->all(), [
            'userId' => "required",
            'emailAddress' => 'required|email'
        ]);

        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => $request->all()
                    )
            );
        }

        $user =   User::where('email',$request->get('emailAddress'))
        ->where('id',$request->get('userId'))
        ->first();

        if($user==null){
            return Response::json(array(
                'status' => 0,
                'code' => 500,
                'message' => "The email address or User ID you provided isn't in our system",
                'data'  =>  $request->all()
                )
            );
        }

        $otp = mt_rand(1000, 9999);
        $data['otp'] = $otp;
        $data['userId'] = $user->id;
        $data['timezone'] = config('app.timezone');
        $data['mobile'] = $user->email;

        \DB::table('mobile_otp')->insert($data);

        $email_content = array(
            'receipent_email'   => $user->email,
            'first_name'        => $user->first_name.' '.$user->last_name,
            'subject'           => 'Otp Email Verification',
            'otp'               => $otp,
            'greeting'          => 'Ventrega Team'
        );

        $helper = new Helper;
        $email_response = $helper->sendMail(
                    $email_content,
                    'otp_mail'
                );

           return   response()->json(
                [
                    "status"=>1,
                    "code"=> 200,
                    "message"=>"Otp has sent. Please check your email.",
                    'data' => $request->all()
                ]
            );
    }


    public function verifyEmailOtp(Request $request){

        $rs = $request->all();

        $validator = Validator::make($request->all(), [
            'otp' => "required",
            'userId' => 'required'
        ]);

        if ($validator->fails()) {
            $error_msg = [];
            foreach ($validator->messages()->all() as $key => $value) {
                array_push($error_msg, $value);
            }
            return Response::json(array(
                        'status' => 0,
                        'code' => 500,
                        'message' => $error_msg[0],
                        'data' => $request->all()
                    )
            );
        }

        $data = \DB::table('mobile_otp')
                    ->where('otp',$request->get('otp'))
                        ->where('userId',$request->get('userId'))->first();
                        
        if($data){
             \DB::table('mobile_otp')
                    ->where('otp',$request->get('otp'))
                        ->where('userId',$request->get('userId'))->update(['is_verified'=>1]);
            \DB::table('users')
                        ->where('id',$request->get('userId'))
                        ->update(['email'=>$data->mobile]);
        }
            return response()->json(
                            [
                                "status"    =>  count($data)?1:0,
                                'code'      =>  count($data)?200:500,
                                "message"   =>  count($data)?"Otp Verified":"Invalid Otp",
                                'data'      =>  $request->all()
                            ]
                );
    }


}
