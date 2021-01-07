<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $fillable = ['name'];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'created_at'=>'date:d-M-Y',
      'updated_at'=>'date:d-M-Y'
    ];
}
