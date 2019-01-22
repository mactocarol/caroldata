<?php

declare(strict_types=1);

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Nestable\NestableTrait;

use Illuminate\Database\Eloquent\SoftDeletes;
 
class Category extends Eloquent
{
    use NestableTrait;
    use SoftDeletes;
    
    protected $parent = 'parent_id';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $casts = [
        'created_at' => 'datetime:m-d-Y',
    ];

    protected $table = 'categories';
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
    protected $fillable = ['category_group_name','category','description'];  // All field of user table here


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function parentCategory(){
        return $this->belongsTo('Modules\Admin\Models\Category', 'parent_id');
    }


    public function subCategory(){
        return $this->belongsTo('Modules\Admin\Models\Category', 'parent_id');
    }


    public function products(){
        return $this->hasMany('Modules\Admin\Models\Product', 'product_category');

    }

    // images
    public static function createImage($request, $fielName)
    {
        try {
            if ($request->file($fielName)) {
                $photo = $request->file($fielName);

                $destinationPath = storage_path('uploads/category/');
                $photo->move($destinationPath, time() . $photo->getClientOriginalName());
                $photo_name = time() . $photo->getClientOriginalName();

                return  'storage/uploads/category/' . $photo_name; 
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
   
}
