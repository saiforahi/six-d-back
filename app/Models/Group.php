<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\SubCategory;
class Group extends Model
{
    //
    protected $table="groups";
    protected $fillable=["name","category_id","sub_category_id","status","created_by","updated_by"];

    public function category(){
        return $this->belongsTo(Category::class,'id','category_id');
    }
    public function sub_category(){
        return $this->belongsTo(SubCategory::class,'id','sub_category_id');
    }
}
