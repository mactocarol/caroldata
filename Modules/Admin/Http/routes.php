<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
 
 Route::post('delete/all', 'AdminController@deleteAll');

   Route::match(['get','post'],'upload', function(Illuminate\Http\Request $request){
     echo "<pre>";
      print_r($request->all());
   });


    // Login
    Route::post('login', function (Illuminate\Http\Request $request, App\Admin $user) {
        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];

        $admin_auth = auth()->guard('admin');
        $user_auth =  auth()->guard('web'); //Auth::attempt($credentials);
        if ($admin_auth->attempt($credentials)) {
            return Redirect::to('admin');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['message' => 'Invalid email or password. Try again!']);
        }
    });


    //basic routes
    //Route::get('/', 'AdminController@index');
    Route::get('/', 'AuthController@index');
    Route::get('/login', 'AuthController@index');
    Route::get('/forgot-password', 'AuthController@forgetPassword');
    Route::post('password/email', 'AuthController@sendResetPasswordLink');
    Route::get('password/reset', 'AuthController@resetPassword');
    Route::get('logout', 'AuthController@logout')->name('logout');

    
    Route::post('/post_login', 'AdminLoginController@post_login');
    Route::get('/logout', 'AdminLoginController@logout');
    Route::get('/CheckLogin', 'AdminLoginController@CheckLogin');
    Route::get('/404', 'AdminLoginController@not_found');
    
     /* logged admin user opertaions */
    Route::group(['middleware' =>  'admin'], function(){
              
      Route::get('/', 'AdminLoginController@dashboard'); 
       //       module
        Route::get('/module', 'ModuleController@index'); 
        Route::get('/module/create', 'ModuleController@create');
        Route::post('/module/store', 'ModuleController@store'); 
       
      Route::bind('language', function ($value, $route) {
           return Modules\Admin\Models\Language::find($value);
       });

       Route::resource(
           'language',
           'LanguageController',
           [
               'names' => [
                   'edit'    => 'language.edit',
                   'show'    => 'language.show',
                   'destroy' => 'language.destroy',
                   'update'  => 'language.update',
                   'store'   => 'language.store',
                   'index'   => 'language',
                   'create'  => 'language.create',
               ],
           ]
       );


       Route::bind('role', function ($value, $route) {
            return Modules\Admin\Entities\Role::find($value);
        });

        Route::resource(
            'roles',
            'RoleController',
            [
                'names' => [
                    'edit'    => 'role.edit',
                    'show'    => 'role.show',
                    'destroy' => 'role.destroy',
                    'update'  => 'role.update',
                    'store'   => 'role.store',
                    'index'   => 'role',
                    'create'  => 'role.create',
                ],
            ]
        );
       
       /*------------User Model and controller---------*/

        Route::bind('user', function ($value, $route) {
            return Modules\Admin\Models\User::find($value);
        });

        Route::resource(
            'user',
            'UsersController',
            [
                'names' => [
                    'edit'    => 'user.edit',
                    'show'    => 'user.show',
                    'destroy' => 'user.destroy',
                    'update'  => 'user.update',
                    'store'   => 'user.store',
                    'index'   => 'user',
                    'create'  => 'user.create',
                ],
            ]
        );


        Route::bind('adminUser', function ($value, $route) {
            return Modules\Admin\Models\User::find($value);
        });

       Route::resource(
            'adminUser',
            'AdminUserController',
            [
                'names' => [
                    'edit'    => 'adminUser.edit',
                    'show'    => 'adminUser.show',
                    'destroy' => 'adminUser.destroy',
                    'update'  => 'adminUser.update',
                    'store'   => 'adminUser.store',
                    'index'   => 'adminUser',
                    'create'  => 'adminUser.create',
                ],
            ]
        );


        // Route::bind('singleUser', function ($value, $route) {
        //     return Modules\Admin\Models\User::find($value);
        // });

        // Route::resource(
        //     'singleUser',
        //     'SingleUsersController',
        //     [
        //         'names' => [
        //             'edit'    => 'singleUser.edit',
        //             'show'    => 'singleUser.show',
        //             'destroy' => 'singleUser.destroy',
        //             'update'  => 'singleUser.update',
        //             'store'   => 'singleUser.store',
        //             'index'   => 'singleUser',
        //             'create'  => 'singleUser.create',
        //         ],
        //     ]
        // );

        // Route::bind('advertiser', function ($value, $route) {
        //     return Modules\Admin\Models\User::find($value);
        // });

        // Route::resource(
        //     'advertiser',
        //     'AdvertiserController',
        //     [
        //         'names' => [
        //             'edit'    => 'advertiser.edit',
        //             'show'    => 'advertiser.show',
        //             'destroy' => 'advertiser.destroy',
        //             'update'  => 'advertiser.update',
        //             'store'   => 'advertiser.store',
        //             'index'   => 'advertiser',
        //             'create'  => 'advertiser.create',
        //         ],
        //     ]
        // );


        Route::bind('vendor', function ($value, $route) {
            return Modules\Admin\Models\Vendor::find($value);
        });

        Route::resource(
            'vendor',
            'VendorController',
            [
                'names' => [
                    'edit'    => 'vendor.edit',
                    'show'    => 'vendor.show',
                    'destroy' => 'vendor.destroy',
                    'update'  => 'vendor.update',
                    'store'   => 'vendor.store',
                    'index'   => 'vendor',
                    'create'  => 'vendor.create',
                ],
            ]
        );

       
       

        
        /*------------User Category and controller---------*/

        Route::bind('category', function ($value, $route) {
            return Modules\Admin\Models\Category::find($value);
        });

        Route::resource(
                'category',
                'CategoryController',
                [
                    'names' => [
                        'edit'      => 'category.edit',
                        'show'      => 'category.show',
                        'destroy'   => 'category.destroy',
                        'update'    => 'category.update',
                        'store'     => 'category.store',
                        'index'     => 'category',
                        'create'    => 'category.create',
                    ],
                ]
            );
        /*---------End---------*/


        /*------------User Category and controller---------*/

         Route::bind('sub-category', function($value, $route) {
             return Modules\Admin\Models\Category::find($value);
         });

         Route::resource('sub-category', 'SubCategoryController', [
             'names' => [
                 'edit' => 'sub-category.edit',
                 'show' => 'sub-category.show',
                 'destroy' => 'sub-category.destroy',
                 'update' => 'sub-category.update',
                 'store' => 'sub-category.store',
                 'index' => 'sub-category',
                 'create' => 'sub-category.create',
             ]
                 ]
         );


         /*------------ Product Type and controller---------*/

        Route::bind('product-type', function ($value, $route) {
            return Modules\Admin\Models\ProductType::find($value);
        });

        Route::resource(
                'product-type',
                'ProductTypeController',
                [
                    'names' => [
                        'index'     => 'product-type',
                        'create'    => 'product-type.create',
                        'store'     => 'product-type.store',
                        'destroy'   => 'product-type.destroy',
                        'edit'      => 'product-type.edit',
                        'update'    => 'product-type.update',
                    ],
                ]
            );
        /*---------End---------*/

        /*------------ Product Type and controller---------*/

        Route::bind('product-unit', function ($value, $route) {
            return Modules\Admin\Models\ProductUnit::find($value);
        });

        Route::resource(
                'product-unit',
                'ProductUnitController',
                [
                    'names' => [
                        'index'     => 'product-unit',
                        'create'    => 'product-unit.create',
                        'store'     => 'product-unit.store',
                        'destroy'   => 'product-unit.destroy',
                        'edit'      => 'product-unit.edit',
                        'update'    => 'product-unit.update',
                    ],
                ]
            );


         // product

        Route::bind('product', function ($value, $route) {
            return Modules\Admin\Models\Product::find($value);
        });

        Route::resource(
                'product',
                'ProductController',
                [
                    'names' => [
                        'edit'      => 'product.edit',
                        'show'      => 'product.show',
                        'destroy'   => 'product.destroy',
                        'update'    => 'product.update',
                        'store'     => 'product.store',
                        'index'     => 'product',
                        'create'    => 'product.create',
                    ],
                ]
            );
        // product

        Route::bind('vendorProduct', function ($value, $route) {
            return Modules\Admin\Models\Product::find($value);
        });

        Route::resource(
                'vendorProduct',
                'VendorProductController',
                [
                    'names' => [
                        'edit'      => 'vendorProduct.edit',
                        'show'      => 'vendorProduct.show',
                        'destroy'   => 'vendorProduct.destroy',
                        'update'    => 'vendorProduct.update',
                        'store'     => 'vendorProduct.store',
                        'index'     => 'vendorProduct',
                        'create'    => 'vendorProduct.create',
                    ],
                ]
            );
        
        /*---------End---------*/
        // wensite settings

        Route::bind('setting', function ($value, $route) {
            return Modules\Admin\Models\Settings::find($value);
        });

        Route::resource(
            'setting',
            'SettingsController',
            [
                'names' => [
                    'edit'      => 'setting.edit',
                    'show'      => 'setting.show',
                    'destroy'   => 'setting.destroy',
                    'update'    => 'setting.update',
                    'store'     => 'setting.store',
                    'index'     => 'setting',
                    'create'    => 'setting.create',
                ],
            ]
        );
       // category
       
    });
});
