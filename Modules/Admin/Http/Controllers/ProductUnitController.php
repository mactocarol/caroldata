<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helper; 
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Config; 
use Illuminate\Support\Facades\Redirect; 
use Input; 
use Modules\Admin\Http\Requests\ProductUnitRequest; 
use Modules\Admin\Models\ProductUnit; 
use Route; 
use URL; 
use View;

/**
 * Class AdminController
 */
class ProductUnitController extends Controller
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

        View::share('heading', 'Product Units');

        View::share('route_url', route('product-unit'));

        $this->record_per_page = Config::get('app.record_per_page');
    }


    /*
     * Dashboard
     * */

    public function index(ProductUnit $productunit, Request $request)
    {
        $page_title  = 'Product Unit';

        $page_action = 'Add Product Unit';

        if ($request->ajax()) {
            $id           = $request->get('id');
            $status       = $request->get('status');
            $s            = ($status == 1) ? $status=0:$status=1;
            $productunit  = ProductUnit::find($id);
            $productunit->status = $s;
            $productunit->save();
            echo $s;
            exit;
        }

        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');

        if ((isset($search) && !empty($search))) {
            $search = isset($search) ? Input::get('search') : '';

            $productunits = ProductUnit::where(function ($query) use ($search,$status) {
                if (!empty($search)) {
                    $query->Where('name', 'LIKE', "%$search%");
                }
            })->orderBy('id', 'DESC')->Paginate($this->record_per_page);
        } else {
            $productunits = ProductUnit::orderBy('id', 'ASC')->Paginate($this->record_per_page);
        }

        return view('admin::unit.index', compact('productunits','page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(ProductUnit $productunit)
    {
        $page_title  = 'Create Product Unit';

        $page_action = 'Create Product Unit';

        return view('admin::unit.create', compact('productunit','page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(Request $request, ProductUnit $productunit)
    {
       $request->validate([
             'name'  => 'required|unique:product_units,name',  
        ]);

        $table_cname = \Schema::getColumnListing('product_units');
            $except = ['id','created_at','updated_at','deleted_at'];
            
            foreach ($table_cname as $key => $value) {
               
               if(in_array($value, $except )){
                    continue;
               } 
               if($request->get($value)){
                    $productunit->$value = $request->get($value);
               }
        }

        $productunit->save();

        return Redirect::to(route('product-unit'))
            ->with('flash_alert_notice', 'New Product unit  successfully created !');
    }

    /*
     * Edit Group method
     * @param
     * object : $category
     * */

    public function edit(Request $request, $productunit)
    {
        $page_title  = 'Edit Product Unit';
        $page_action = 'Edit Product Unit';

        return view('admin::unit.edit', compact('productunit' ,'page_title', 'page_action'));
    }

    public function update(Request $request, $productunit)
    {

        $request->validate([
             'name'  => 'required|unique:product_units,name,'.$productunit->id,  
        ]);

        $table_cname = \Schema::getColumnListing('product_units');
            $except = ['id','created_at','updated_at','deleted_at'];
            
            foreach ($table_cname as $key => $value) {
               
               if(in_array($value, $except )){
                    continue;
               } 
               if($request->get($value)){
                    $productunit->$value = $request->get($value);
               }
        }

        $productunit->save();

        return Redirect::to(route('product-unit'))
            ->with('flash_alert_notice', 'Product unit  successfully updated.');
    }

    // /*
    //  * Category category
    //  * @param ID
    //  *
    //  */

    public function destroy(Request $request, $productunit)
    {
        $productunit = ProductUnit::where('id',$productunit->id)->first();

        $productunit->delete();

        return Redirect::to(route('product-unit'))
            ->with('flash_alert_notice', 'Product unit  successfully deleted.');
    }

    // public function show(Category $category)
    // {
    // }
}
