<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class AllLanguages extends Model
{
   protected $table = "all_languages";
    protected $fillable = ['name','code'];

   
}
