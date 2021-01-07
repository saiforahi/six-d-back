<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Type extends Model
{
    //
    protected $table = "types";
    protected $fillable = ['name'];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts=[
      'created_at'=>'date:d-M-Y',
      'updated_at'=>'date:d-M-Y'
    ];

    
}
