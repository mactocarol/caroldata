<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//use Redirect;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, auth-token');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Origin: *");
/*
* Rest API Request , auth  & Route
*/
Route::group([
	    'prefix' => 'v1'
	], function()
    {
        Route::match(['post','get'],'member/login', 'ApiController@login');
		Route::match(['post','get'],'member/signup', 'ApiController@register');
		Route::match(['post','get'],'member/updateProfile/{id}', 'ApiController@updateProfile');

        Route::match(['post','get'],'email_verification','ApiController@emailVerification');

        Route::match(['post','get'],'user/forgotPassword','ApiController@forgetPassword');

        Route::match(['post','get'],'password/reset','ApiController@resetPassword');
    // get account
        Route::match(['post','get'],'member/account/{userId}', 'ApiController@myAccount');
        Route::match(['post','get'],'vendor/account/{userId}', 'ApiController@myAccount');
        Route::match(['post','get'],'deliveryBoy/account/{userId}', 'ApiController@myAccount');

        //Rajendra Singh
        
        Route::match(['post','get'],'member/account/{userId}', 'ApiController@userDetail');

        Route::match(['post','get'],'member/account/myprofile', 'ApiController@getUserDetails');

        Route::match(['post','get'],'vendore/addproduct', 'ApiController@AddVendorProduct');

        Route::match(['post','get'],'vendore/product/delete', 'ApiController@destroy');

        Route::match(['post','get'],'product/unit', 'ApiController@getProductUnit');

        Route::match(['post','get'],'product/type', 'ApiController@getProductType');

        Route::match(['post','get'],'vendore/addDefaultProduct', 'ApiController@addDefaultProducts');

        Route::match(['get','post'],'generateEmailOtp',[
            'as' => 'generateEmailOtp',
            'uses' => 'ApiController@generateEmailOtp'
        ]);

        Route::match(['get','post'],'verifyEmailOtp',[
            'as' => 'verifyEmailOtp',
            'uses' => 'ApiController@verifyEmailOtp'
        ]);


        // update profile
        Route::match(['post','get'],'vendor/updateProfile/{userId}', 'ApiController@vendorUpdate');
        Route::match(['post','get'],'vendor/updateKyc/{userId}', 'ApiController@updateKyc');

        Route::match(['post','get'],'customer/updateProfile/{userId}', 'ApiController@updateProfile');
        Route::match(['post','get'],'deliveryBoy/updateProfile/{userId}', 'ApiController@updateProfile');


        Route::match(['post','get'],'email_verification','ApiController@emailVerification');

        //date : 06/12/2018

       // get category
        Route::match(['post','get'],'vendor/product/getCategory','VendorController@allCategory');
       // search sub categoryby categoryId
        Route::match(['post','get'],'vendor/product/getSubCategoryById/{categoryId}','VendorController@subCategory');
        // get product by id
        Route::match(['post','get'],'vendor/getProductByVendorId/{vendorId}','VendorController@getProduct');

        Route::match(['post','get'],'vendor/showDefaultProducts','VendorController@showDefaultProducts');


        // Route::match(['post','get'],'user/forgotPassword','ApiController@forgetPassword');
        // Route::match(['post','get'],'password/reset','ApiController@resetPassword');
        Route::group(['middleware' => 'jwt-auth'], function ()
        {
        	Route::match(['post','get'],'testing',function(){
            	die('test');
            });



        });

        Route::match(['get','post'],'generateOtp',[
            'as' => 'generateOtp',
            'uses' => 'ApiController@generateOtp'
        ]);

        Route::match(['get','post'],'verifyOtp',[
            'as' => 'verifyOtp',
            'uses' => 'ApiController@verifyOtp'
        ]);

 
        // if route not found
	    Route::any('{any}', function(){
				$data = [
							'status'=>0,
							'code'=>400,
							'message' => 'Bad request'
						];
				return \Response::json($data);

		});
});
