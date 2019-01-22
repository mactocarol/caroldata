<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = "languages";
    protected $fillable = ['language_id'];
}
