<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\SubCategoryRequest;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\SubCategory;
//use App\Category;
use Input;
use Validator;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
use Hash;
use View;
use URL;
use Lang;
use Session;
use DB;
use Route;
use Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher;
use App\Helpers\Helper;

/**
 * Class AdminController
 */
class SubCategoryController extends Controller {

    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() {
        $this->middleware('admin');
        View::share('viewPage', 'Product');
        View::share('helper',new Helper);
        View::share('heading','Store Sub Categories');
        $this->record_per_page = Config::get('app.record_per_page');
        View::share('route_url',route('sub-category'));

    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(Category $category, Request $request)
    {
        $page_title = 'Sub Categories';
        $sub_page_title = 'Sub Categories'; 
        if ($request->ajax()) {
            $id = $request->get('id');
            $category = Category::find($id);
            $category->status = $s;
            $category->save();
            echo $s;
            exit();
        }

        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        if ((isset($search) && !empty($search))) {

            $search = isset($search) ? Input::get('search') : '';

            $categories = Category::with('parentCategory','products')->where(function($query) use($search,$status) {
                        if (!empty($search)) {
                            $query->Where('sub_category_name', 'LIKE', "%$search%")
                                    ->OrWhere('category_name', 'LIKE', "%$search%");
                        }

                    })->where('parent_id','!=',0)->Paginate($this->record_per_page);
        } else {
            $categories = Category::with('parentCategory','products')->where('parent_id','!=',0)
            ->Paginate($this->record_per_page);
        }
 

        return view('admin::sub_category.index', compact('sub_page_title','result_set','categories','data', 'page_title', 'page_action','html'));
    }

    /*
     * create Group method
     * */

    public function create(Category $category)
    {

        $sub_categories = Category::attr(['name' => 'category_name','class'=>'select-search'])
                        ->renderAsDropdown();

        $page_title = 'Sub Category';
        $page_action = 'Create Sub Category';
        $categories = Category::where('parent_id',0)->get();

        return view('admin::sub_category.create', compact('sub_categories','categories', 'html','category', 'page_title', 'page_action'))->withInput(Input::all());
    }

    /*
     * Save Sub category
     * */

    public function store(SubCategoryRequest $request, Category $category)
    {

        $main_category = Category::find($request->get('category_name'));

        $parent_id = $request->get('category_name');

        $category->url  =  'category/' . strtolower(str_slug($request->get('category_name')));
        $category->slug = str_slug($request->get('sub_category_name'));
        // create Images
        if ($request->file('sub_category_image')) {
            $category_image = Category::createImage($request, 'sub_category_image');
            $request->merge(['sub_category_image' => $category_image]);
            $category->sub_category_image = $request->get('sub_category_image');
        }

        $category->parent_id      =  $request->get('category_name');
        //$category->category_name  =  $main_category->category_name;
        $category->category_name  =  $request->get('sub_category_name');
        $category->sub_category_name  =  $request->get('sub_category_name');
        $category->category_image =  $main_category->category_image;
        $category->level          =  $main_category->level+1;
        $category->description    =  $request->get('description');
        $category->commission    =  $request->get('commission');

        $category->save();

        return Redirect::to(route('sub-category'))
                            ->with('flash_alert_notice', 'New Sub category  successfully created.');
        }

    /*
     * Edit Group method
     * @param
     * object : $category
     * */

    public function edit(Category $category) {
        //$category = Category::with('parentCategory')->where('id',$category->id)->get();
        $page_title  = 'Category';
        $page_action = 'Edit Sub category';
        $categories  = Category::where('parent_id',0)->get();
        $url = url($category->sub_category_image) ;

        $sub_categories = Category::attr(['name' => 'category_name','class'=>'select-search'])
                        ->selected($category->parent_id)
                        ->renderAsDropdown(); 

        return view('admin::sub_category.edit', compact('sub_categories','categories','url','category', 'page_title', 'page_action'));
    }

    public function update(Request $request, $category) {

        $main_category = Category::find($request->get('category_name'));

        $parent_id = $request->get('category_name');

        $category->url  =  'category/' . strtolower(str_slug($request->get('category_name')));
        $category->slug = str_slug($request->get('sub_category_name'));
        // create Images
        if ($request->file('sub_category_image')) {
            $category_image = Category::createImage($request, 'sub_category_image');
            $request->merge(['sub_category_image' => $category_image]);
            $category->sub_category_image = $request->get('sub_category_image');
        }

        $category->parent_id        =  $request->get('category_name');
        $category->category_name    =  $request->get('sub_category_name');
        $category->sub_category_name  =  $request->get('sub_category_name');
        $category->category_image   =  $main_category->category_image;
        $category->level            =  $main_category->level+1;
        $category->description      =  $request->get('description');
        $category->commission       =  $request->get('commission');

        $category->save();

        return Redirect::to(route('sub-category'))
                        ->with('flash_alert_notice', 'Sub Category   successfully updated.');
    }
    /*
     *Delete
     * @param
     *
     */
    public function destroy(Category $category) {

        $category->delete();
        return Redirect::to(URL::previous())
                        ->with('flash_alert_notice', 'Sub Category  successfully deleted.');
    }

    public function show(Category $category) {

        $result = $category;
        $page_title  = 'Category';
        $page_action  = 'Show Category';
        return view('admin::sub_category.show', compact('result_set','result','data', 'page_title', 'page_action','html'));

    }

}
