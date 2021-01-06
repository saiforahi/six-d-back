<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Company;
class Admin extends Model
{
    //
    protected $table="admins";
    protected $fillable=['user_id','company_id'];
    protected $dates=['created_at','updated_at'];
    protected $casts=[
        'created_at'=>'date:d-M-Y',
        'updated_at'=>'date:d-M-Y'
    ];

    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}
