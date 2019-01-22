<?php

declare(strict_types=1);

namespace Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model as Eloquent; 
use URL;

class Vendors extends Eloquent
{
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

    public static function createImage($request, $fielName)
    {
        try {
            if ($request->file($fielName)) {
                $photo = $request->file($fielName);

                $destinationPath = storage_path('uploads/profile/');
                $photo->move($destinationPath, time() . $photo->getClientOriginalName());
                $photo_name = time() . $photo->getClientOriginalName();

                return  'storage/uploads/profile/' . $photo_name;
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
