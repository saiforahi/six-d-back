<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    //
    public function __construct(){
        //$this->middleware('cors');
    }
    public function update(Request $request,$id){
        try{
            $this->validate($request,[
                'name'=> 'required|string|max:255',
            ]);
            $category=Category::findOrFail($id);
            $category->name=$request->name;
            $category->service_id=Service::where('name','Accounts')->first()->id;
            $category->save();
            return response()->json(['status'=>true,'message'=>'Accounts Category details updated!']);
        }catch(Exception $e){
            return response()->json(['status'=>false,'error'=>$error]);
        }
    }
}
