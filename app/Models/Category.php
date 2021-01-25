<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\Company;
use App\Models\SubCategory;
class Category extends Model{
    protected $table="categories";
    protected $fillable=["name","service_id","company_id","status","created_by","updated_by"];
    public function service(){
        return $this->belongsTo(Service::class,'id','service_id');
    }
    public function sub_catefories(){
        return $this-hasMany(SubCategory::class,'category_id','id');
    }
    public function company(){
        return $this->belongsTo(Company::class,'id','company_id');
    }
}
