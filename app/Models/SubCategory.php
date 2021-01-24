<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class SubCategory extends Model
{
    //
    protected $table="sub_categories";
    protected $fillable=["name","category_id","status","created_by","updated_by"];

    public function category(){
        return $this->belongsTo(Category::class,'id','category_id');
    }
}
