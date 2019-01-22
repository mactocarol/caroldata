<?php

declare(strict_types=1);

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Eloquent
{
    use SoftDeletes;
  /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /**
     * The primary key used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['product_title','slug','url','meta_key','meta_description','product_category',
    'price','unit','qty','discount','description','photo','additional_images','video_url','product_type',
    'validity','coupon_code','total_stocks','available_stocks','views','created_by','meta_title',
    'rating','vendor_id','status','publish'];  // All field of user table here


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function category()
    {
        return $this->belongsTo('Modules\Admin\Models\Category','product_category','id');
    }

    //Prouct Unit
    public function units()
    {
        return $this->belongsTo('Modules\Admin\Models\ProductUnit','unit','id');
    }

    //Product Type
    public function types()
    {
        return $this->belongsTo('Modules\Admin\Models\ProductType','product_type','id');
    }

    public function vendorProduct(){
       return $this->hasMany('Modules\Admin\Models\VendorProduct','product_id');
    }
}
