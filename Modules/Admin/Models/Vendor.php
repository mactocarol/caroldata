<?php

declare(strict_types=1);

namespace Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model as Eloquent; 
use URL;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vendor extends Eloquent
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendors';
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

    protected $guarded = ['created_at', 'updated_at', 'id'];

    // Return user record
    public function getUserDetail($id = null)
    {
        if ($id) {
            return User::find($id);
        }

        return User::all();
    }

    public function user(){
        return $this->belongsTo('Modules\Admin\Models\User', 'user_id', 'id');
    }

    public function areaPincode(){
        return $this->hasOne('Modules\Admin\Models\AreaPincode', 'vendor_id', 'id');
    }

    // images
    public static function uploadImage($request,$location,$fileName){

        try {
            if ($request->file($fileName)) {
                $photo = $request->file($fileName);
                $destinationPath = storage_path('uploads/'.$location); 
                $photo->move($destinationPath, time() . $photo->getClientOriginalName());
                $photo_name = time() . $photo->getClientOriginalName();
                
                return  'storage/uploads/'.$location.'/' . $photo_name;
            //$request->merge(['photo'=>$photo_name]);
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
 

    public function role()
    {
        return $this->belongsTo('Modules\Admin\Models\Role', 'id','role_type');
    }

}
