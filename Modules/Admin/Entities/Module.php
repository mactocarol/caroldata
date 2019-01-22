<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
   use SoftDeletes;
    protected $table = "modules"; 
    protected $fillable = ['module_name','slug']; 
    protected $dates = ['deleted_at'];
}
