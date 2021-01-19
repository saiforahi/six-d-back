<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
class Company extends Model
{
    //
    protected $table="companies";
    protected $fillable=['name','address'];
    protected $dates=['created_at','updated_at'];
    protected $guarded = [];
    protected $casts=[
        'created_at'=>'date:d-M-Y',
        'updated_at'=>'date:d-M-Y',
        'address' => 'array'
    ];
    public function admin(){
        return $this->belongsTo(Admin::class,'id','company_id');
    }
    public function make_admin($user_id){
        $admin=Admin::create([
            'user_id'=>$user_id,
            'company_id'=>$this->id
        ]);
        return $admin;
    }
}
