<?php

declare(strict_types=1);

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorProduct extends Eloquent
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
    protected $table = 'vendor_products';
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

    protected $fillable = ['product_id','vendor_id','status','url','pincode'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function product()
    {
        return $this->belongsTo('Modules\Admin\Models\Product','product_id','id');
    }
    // vendor
    public function vendor()
    {
        return $this->belongsTo('Modules\Admin\Models\Vendor','vendor_id','id');
    }
}
