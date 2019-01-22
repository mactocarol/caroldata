<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Input;
use Modules\Admin\Http\Requests\ProductRequest;
use Modules\Admin\Models\Product;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\ProductType;
use Modules\Admin\Models\ProductUnit;
use Modules\Admin\Models\Vendor;
use Modules\Admin\Models\VendorProduct;
use Route;
use URL;
use View;
use Validator;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
use Hash;
use Lang;
use Session;
use Crypt;
use Illuminate\Http\Dispatcher;
use Response;

/**
 * Class AdminController
 */
class VendorProductController extends Controller
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
        View::share('viewPage', 'Vendor Product');
        View::share('helper', new Helper);
        View::share('heading', 'Products');
        View::share('route_url', route('vendorProduct'));
        $this->record_per_page = Config::get('app.record_per_page');

        $submenu = [
                route('product.create')=>'Create Product',
                route('product')=>'View Products',
            ];
        View::share('submenu',   $submenu);
        View::share('js', true);
    }

    /*
     * Dashboard
     * */

    public function index(Product $product, Request $request)
    {

        $page_title  = 'Vendor Product';

        $page_action = 'View Vendor Product';

        if ($request->ajax()) {
            $id           = $request->get('id');
            $status       = $request->get('status');
            $s            = ($status == 1) ? $status=0:$status=1;
            $product  = Product::find($id);
            $product->status = $s;
            $product->save();
            echo $s;
            exit;
        }

        //Search by name ,email and group
        $search =  (Input::get('search'));
        $category_id =  (Input::get('category_id'));
        $vendor_id = $request->get('vendor_id');

        $product_ids = VendorProduct::where('vendor_id',$vendor_id)->pluck('product_id')->toArray();


        //$status = Input::get('status');

        if ((isset($search) && !empty($search))) {
            $categoryArray = Category::where('category_name', 'LIKE', "%$search%")->pluck('id');
            $products = Product::with('category')->where(function ($query) use ($search,$categoryArray,$category_id,$product_ids,$vendor_id) {
                if (!empty($search)) {
                    $query->Where('product_title', 'LIKE', "%$search%");
                }
                if (!empty($categoryArray)) {
                    $query->orWhereIn('product_category', $categoryArray);
                }
                if ($category_id) {
                    $query->orWhere('product_category', $category_id);
                }
                if($product_ids || $vendor_id){
                    $query->whereIn('id', $product_ids);
                }
            })
            ->whereHas('vendorProduct')
            ->orderBy('id', 'desc')->Paginate($this->record_per_page);
        } else {
            $products = Product::with('category')->orderBy('id', 'desc')->where(function($query) use($category_id,$product_ids,$vendor_id){
               if ($category_id) {
                    $query->where('product_category', $category_id);
                }
                if($product_ids || $vendor_id){
                    $query->whereIn('id', $product_ids);
                }
            })
            ->whereHas('vendorProduct')
            ->Paginate($this->record_per_page);
        }


        return view('admin::vendor_product.index', compact('products', 'page_title', 'page_action'));
    }


    public function create(Request $request, Product $product)
    {
        $page_title  = 'Product';
        $page_action = 'Add Product';



        $categories = Category::attr(['name' => 'product_category','class'=>'form-control form-cascade-control input-small','id'=>'product_category','placeholder'=>'select category'])
                        ->selected([1])
                        ->renderAsDropdown();

        $category = Category::all();
        $productunits =  ProductUnit::where('status', 1)->pluck('name', 'id');

        $producttypes =  ProductType::where('status', 1)->pluck('name', 'id');

        $existing_product = $request->get('product');
        $vendors = Vendor::all();
        $products = Category::with('products')->get();


        return view('admin::vendor_product.create', compact('categories','product','page_title', 'page_action','productunits','producttypes','category','products','vendors','existing_product'));
    }


     public function getCategoryById($id){

        $url =  Category::where('id',$id)->first();
        return  $url->slug.'/';
    }


    public function store(Request $request, Product $product)
    {


        if($request->get('existing_product')){
           $vendors = $request->get('vendors');
           $products = $request->get('products');
           foreach ($vendors as $key => $vendor) {

              $vendorProduct = new VendorProduct;
              $vendorProduct->vendor_id = $vendor;
              foreach ($products as $key => $product) {
                $vendorProduct->product_id = $product;
              }
                $vendorProduct->save();
           }
           $msg = count($products) ." Product added successfully.";
        return Redirect::to(route('vendorProduct'))
                            ->with('flash_alert_notice', $msg);

        }

        $cat_url    = $this->getCategoryById($request->get('product_category'));
        $pro_slug   = str_slug($request->get('product_title'));
        $url        = $cat_url.$pro_slug;

        $request->validate([
            'product_title' => 'required',
            'store_price' => 'required',
            'product_category' => 'required',
            'photo' => 'mimes:jpeg,bmp,png,gif,jpg,PNG',
        ]);

        if ($request->file('image')) {
            $destinationPath = storage_path('uploads/products');
            if($request->hasfile('images'))
            {
                foreach($request->file('images') as $image)
                {
                    $image->move($destinationPath, time().$image->getClientOriginalName());
                    $name =  time().$image->getClientOriginalName();
                    $images[] = $name;
                }
                $product->additional_images  = json_encode($images);
            }
        }

        try {
            \DB::beginTransaction();

            $table_cname = \Schema::getColumnListing('products');
            $except = ['id','created_at','updated_at','deleted_at','additional_images','btn_name'];

            foreach ($table_cname as $key => $value) {

               if(in_array($value, $except )){
                    continue;
               }
               if($request->file($value)){
                    $product->$value = Vendor::uploadImage($request, 'products' ,$value);

               }else if($request->get($value)){
                    $product->$value = $request->get($value);
               }
            }
            $product->slug   =   str_slug($request->get('product_title'));
            $product->url    =   $url;
            $product->save();
            // vendor
            $vendorProduct =  VendorProduct::firstOrNew(
                [
                    'vendor_id'=> $request->get('vendor_id'),
                    'product_id'=>$product->id
                ]
            );

            $vendorProduct->vendor_id = $request->get('vendor_id');
            $vendorProduct->product_id = $product->id;
            $vendorProduct->save();

            \DB::commit();
            $msg = 'New Product was successfully created !';
        } catch (\Exception $e) {
             \DB::rollback();
            $msg = $e->getMessage();
        }

        if($request->get('btn_name')=="Save & Continue"){
            return Redirect::to(route('vendorProduct.edit',$product->id))
                            ->with('flash_alert_notice', $msg);
        }

        return Redirect::to(route('vendorProduct'))
                            ->with('flash_alert_notice', $msg);
    }


    public function destroy(Product $product) {

        Product::where('id',$product->id)->delete();

        return Redirect::to(route('vendorProduct'))
                        ->with('flash_alert_notice', 'Product was successfully deleted!');
    }

    public function edit(Request $request,Product $product) {

        $page_title = 'Product';
        $page_action = 'View Product';
        $category   = Category::all();
        $existing_product = $request->get('product');
        $vendors = Vendor::all();
        $products = Category::with('products')->get();

        $cat = [];
        foreach ($category as $key => $value) {
             $cat[$value->category_name][$value->id] =  $value->sub_category_name;
        }
        $categories =  Category::attr(['name' => 'product_category','class'=>'form-control form-cascade-control input-small','id'=>'product_category'])
                        ->selected(['id'=>$product->product_category])
                        ->renderAsDropdown();
        $productunits =  ProductUnit::where('status', 1)->pluck('name', 'id');
        $producttypes =  ProductType::where('status', 1)->pluck('name', 'id');

        if(!empty($product->additional_images)){
            $additional_images = json_decode($product->additional_images);
        }else{

            $additional_images = '';
        }

        return view('admin::vendor_product.edit', compact('categories','product', 'page_title', 'page_action','productunits','producttypes','additional_images','category','existing_product','vendors','products'));
    }


    public function update(ProductRequest $request, Product $product)
    {
        $cat_url    = $this->getCategoryById($request->get('product_category'));
        $pro_slug   = str_slug($request->get('product_title'));
        $url        = $cat_url.$pro_slug;

        if ($request->file('image')) {
            $destinationPath = storage_path('uploads/products');
            if($request->hasfile('images'))
            {
                foreach($request->file('images') as $image)
                {
                    $image->move($destinationPath, time().$image->getClientOriginalName());
                    $name =  time().$image->getClientOriginalName();
                    $images[] = $name;
                }
                $product->additional_images  = json_encode($images);
            }
        }

          try {
            \DB::beginTransaction();

            $table_cname = \Schema::getColumnListing('products');
            $except = ['id','created_at','updated_at','deleted_at','additional_images','btn_name'];

            foreach ($table_cname as $key => $value) {

               if(in_array($value, $except )){
                    continue;
               }
               if($request->file($value)){
                    $product->$value = Vendor::uploadImage($request, 'products' ,$value);

               }else if($request->get($value)){
                    $product->$value = $request->get($value);
               }
            }
            $product->slug   =   str_slug($request->get('product_title'));
            $product->url    =   $url;

            $product->save();

            // vendor
            $vendorProduct =  VendorProduct::firstOrNew(
                [
                    'vendor_id'=> $request->get('vendor_id'),
                    'product_id'=>$product->id
                ]
            );

            $vendorProduct->vendor_id = $request->get('vendor_id');
            $vendorProduct->product_id = $product->id;
            $vendorProduct->save();

            \DB::commit();
            $msg = 'Product was successfully updated!';
        } catch (\Exception $e) {
             \DB::rollback();
            $msg = $e->getMessage();
        }

        if($request->get('btn_name')=="Save & Continue"){
            return Redirect::to(route('vendorProduct.edit',$product->id))
                            ->with('flash_alert_notice', $msg);
        }

        return Redirect::to(route('vendorProduct'))
                            ->with('flash_alert_notice', $msg);
    }

}

