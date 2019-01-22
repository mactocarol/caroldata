<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Input;
use Modules\Admin\Http\Requests\ProductTypeRequest;
use Modules\Admin\Models\ProductType;
use Route;
use URL;
use View;

/**
 * Class AdminController
 */
class ProductTypeController extends Controller
{
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('admin');
        View::share('viewPage', 'Product');
        View::share('helper', new Helper);
        View::share('heading', 'Product Types');
        View::share('route_url', route('product-type'));

        $this->record_per_page = Config::get('app.record_per_page');
    }


    /*
     * Dashboard
     * */

    public function index(ProductType $producttype, Request $request)
    {
        $page_title  = 'Product Type';

        $page_action = 'View Product Type';

        if ($request->ajax()) {
            $id           = $request->get('id');
            $status       = $request->get('status');
            $s            = ($status == 1) ? $status=0:$status=1;
            $producttype  = ProductType::find($id);
            $producttype->status = $s;
            $producttype->save();
            echo $s;
            exit;
        }

        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');

        if ((isset($search) && !empty($search))) {
            $search = isset($search) ? Input::get('search') : '';

            $producttypes = ProductType::where(function ($query) use ($search,$status) {
                if (!empty($search)) {
                    $query->Where('name', 'LIKE', "%$search%");
                }
            })->orderBy('id', 'DESC')->Paginate($this->record_per_page);
        } else {
            $producttypes = ProductType::orderBy('id', 'ASC')->Paginate($this->record_per_page);
        }


        return view('admin::type.index', compact('producttypes','page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(ProductType $producttype)
    {
        $page_title  = 'Edit Product Type';
        $page_action = 'Edit Product Type';
        return view('admin::type.create', compact('producttype','page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(Request $request, ProductType $producttype)
    {
        $request->validate([
             'name'  => 'required|unique:product_types,name',  
        ]);

       $table_cname = \Schema::getColumnListing('product_types');
            $except = ['id','created_at','updated_at','deleted_at'];
            
            foreach ($table_cname as $key => $value) {
               
               if(in_array($value, $except )){
                    continue;
               } 
               if($request->get($value)){
                    $producttype->$value = $request->get($value);
               }
        }
 
        $producttype->save();

        return Redirect::to(route('product-type'))
            ->with('flash_alert_notice', 'New Product type  successfully created !');
    }

    /*
     * Edit Group method
     * @param
     * object : $category
     * */

    public function edit(Request $request, $producttype)
    {
        $page_title  = 'Edit Product Type';
        $page_action = 'Edit Product Type';

        return view('admin::type.edit', compact('producttype' ,'page_title', 'page_action'));
    }

    public function update(ProductTypeRequest $request, $producttype)
    {
        $request->validate([
             'name'  => 'required|unique:product_types,name,'.$producttype->id,  
        ]);

         $table_cname = \Schema::getColumnListing('product_types');
            $except = ['id','created_at','updated_at','deleted_at'];
            
            foreach ($table_cname as $key => $value) {
               
               if(in_array($value, $except )){
                    continue;
               } 
               if($request->get($value)){
                    $producttype->$value = $request->get($value);
               }
        }
 
        $producttype->save();

        return Redirect::to(route('product-type'))
            ->with('flash_alert_notice', 'Product type  successfully updated.');
    }
    /*
     * Category category
     * @param ID
     *
     */
    public function destroy(Request $request, $producttype)
    {
        $count = ProductType::where('id',$producttype->id)->first();

        $producttype->delete();

        return Redirect::to(route('product-type'))
            ->with('flash_alert_notice', 'Product type  successfully deleted.');
    }

    // public function show(Category $category)
    // {
    // }
}
