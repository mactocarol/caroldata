<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Route;
use View;
use Modules\Admin\Models\Settings;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //date format
        $date_format = "d-m-Y";
        View::share('date_format', $date_format);
        //
        $controllers = [];
        $menu = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();
            

            if (array_key_exists('controller', $action)) {

                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                if (str_contains($action['controller'], '@index')) {
                    $step1 = str_replace('Modules\Admin\Http\Controllers', '', $action['controller']);
                    $step2 = str_replace('@index', '', $step1);
                    $step3 = str_replace('Controller', '', $step2);

                    $notArr = ['AdminLogin','Auth','Role','Language','Module','Users','Modules\Website\Http\s\Website'];

                    if (in_array(ltrim($step3, '"\"'), $notArr)) {
                        continue;
                    } else {
                        $controllers[] = ltrim($step3, '"\"');
                    }
                    
                }
            }
        }
        $module = array_unique($controllers);
      //  $module = array_pop($module);

        View::share('menus', $this->menu());
        View::share('controllers', $module);
        //  
        $setting = $this->setting();
        View::share('setting', $setting);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function menu()
    {
        //date format
        $controllers = [];
        $menu = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();
            
            if (array_key_exists('controller', $action)) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                if (str_contains($action['controller'], '@index')) {
                    $step1 = str_replace('Modules\Admin\Http\Controllers', '', $action['controller']);
                    $step2 = str_replace('@index', '', $step1);
                    $step3 = str_replace('Controller', '', $step2);

                    $notArrMenu = ['AdminLogin','Auth','Language','Module','Modules\Website\Http\s\Website'];

                    if (in_array(ltrim($step3, '"\"'), $notArrMenu)) {
                        continue;
                    } else {
                        $menu[] = $action;
                    }
                    
                }
            }
        }
        $mainMenu = [];
        foreach ($menu as $key => $menus) {
          $data = (object)$menus;
            $mainMenu[$data->as] = route($data->as);
        }

        return $mainMenu;
       
    }

    public function setting(){

        $setting     = Settings::first();
        $web_setting =  Settings::all();

        if ($setting) {
            $setting->id;
        } else {
            return Redirect::to(route('setting.create'));
        }
        foreach ($web_setting as $key => $value) {
            $key_name           = $value->field_key;
            $setting->$key_name = $value->field_value;
        }

        return $setting;

        

    }
}
