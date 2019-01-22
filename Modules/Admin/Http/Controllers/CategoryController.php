<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Input;
use Modules\Admin\Http\Requests\CategoryRequest;
use Modules\Admin\Models\Category;
use Route;
use URL;
use View; 

/**
 * Class AdminController
 */
class CategoryController extends Controller
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
        View::share('heading', 'Categories');
        View::share('route_url', route('category'));

        $this->record_per_page = Config::get('app.record_per_page');
    }


    /*
     * Dashboard
     * */

    public function index(Category $category, Request $request)
    {
        $page_title  = 'Category';
        $page_action = 'View Category';


        if ($request->ajax()) {
            $id               = $request->get('id');
            $status       = $request->get('status');
            $category         = Category::find($id);
            $s            = ($status == 1) ? $status=0:$status=1;
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

            $categories = Category::with('products')->where(function ($query) use ($search,$status) {
                if (!empty($search)) {
                    $query->Where('category_name', 'LIKE', "%$search%");
                }
            })->orderBy('id', 'DESC')->where('parent_id', 0)->Paginate($this->record_per_page);
        } else {
            $categories = Category::with('products')
                            ->orderBy('id', 'ASC')
                            ->where('parent_id', 0) 
                            ->Paginate($this->record_per_page);
        } 

        return view('admin::category.index', compact('categories', 'page_title', 'page_action'));
    }

    /*
     * create Group method
     * */

    public function create(Category $category)
    {
        $page_title  = 'Category';
        $page_action = 'Edit category'; 
        return view('admin::category.create', compact('category', 'url', 'page_title', 'page_action', 'page_title'));
    }

    /*
     * Save Group method
     * */

    public function store(CategoryRequest $request, Category $category)
    {
        $parent_id = 0;

        $validate_cat = Category::where('category_name', $request->get('category_name'))
            ->where('parent_id', 0)
            ->where('id', '!=', $category->id)
            ->first();

        if ($validate_cat) {
            return  Redirect::back()->withInput()->with(
                'field_errors',
                  'The  Category name already been taken!'
            );
        }

        $category->url  =  'category/' . strtolower(str_slug($request->get('category_name')));
        $category->slug = str_slug($request->get('category_name'));
        // create Images
        if ($request->file('category_image')) {
                $category_image = Category::createImage($request, 'category_image');
                $request->merge(['category_image' => $category_image]);
                $category->category_image = $request->get('category_image');
        } 

        
        $category->parent_id      =  $parent_id;
        $category->category_name  =  $request->get('category_name');
        $category->level          =  1;
        $category->description    =  $request->get('description');
        
        $category->save();

        return Redirect::to(route('category'))
            ->with('flash_alert_notice', 'New category  successfully created !');
    }

    /*
     * Edit Group method
     * @param
     * object : $category
     * */

    public function edit(Request $request, $category)
    {
          
        $page_title  = 'Category';
        $page_action = 'Edit category';
        if($category->category_image){
            $url         = url($category->category_image) ;
        }
         
        return view('admin::category.edit', compact('url', 'category' ,'page_title', 'page_action'));
    }

    public function update(CategoryRequest $request, $category)
    {
        $parent_id = 0;

        $validate_cat = Category::where('category_name', $request->get('category_name'))
            ->where('parent_id', 0)
            ->where('id', '!=', $category->id)
            ->first();

        if ($validate_cat) {
            return  Redirect::back()->withInput()->with(
                'field_errors',
                  'The  Category name already been taken!'
            );
        }

        $category->url  =  'category/' . strtolower(str_slug($request->get('category_name')));
        $category->slug = str_slug($request->get('category_name'));
        // create Images
        if ($request->file('category_image')) {
                $category_image = Category::createImage($request, 'category_image');
                $request->merge(['category_image' => $category_image]);
                $category->category_image = $request->get('category_image');
        } 

        
        $category->parent_id      =  $parent_id;
        $category->category_name  =  $request->get('category_name');
        $category->level          =  1;
        $category->description    =  $request->get('description');
        


        $category->save();

        return Redirect::to(route('category'))
            ->with('flash_alert_notice', 'Category  successfully updated.');
    }
    /*
     * Category category
     * @param ID
     *
     */
    public function destroy(Request $request, $category)
    {
        $count = Category::where('parent_id',$category->id)->count();

         if($count){
            return Redirect::to(route('category'))
            ->with('flash_alert_notice', "Category  associated with sub category. So you can't delete it");

         }else{
             $category->delete();
             return Redirect::to(route('category'))
            ->with('flash_alert_notice', 'Category  successfully deleted.');
         }

        
    }

    public function show(Category $category)
    {
    }
}
