<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
class Company extends Model
{
    //
    protected $table="companies";
    protected $fillable=['name'];
    protected $dates=['created_at','updated_at'];
    protected $casts=[
        'created_at'=>'date:d-M-Y',
        'updated_at'=>'date:d-M-Y'
    ];
    public function admin(){
        return $this->belongsTo(Admin::class,'company_id','id');
    }
}
