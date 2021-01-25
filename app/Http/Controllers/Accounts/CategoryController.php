<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    //
    public function __construct(){
        //$this->middleware('cors');
    }

    public function create(Request $request){
        $this->validate($request,[
            'name'=> 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->service_id = Service::where('name','Accounts')->pluck('id')->first();
        $category->company_id = Auth::user()->admin->company;
        $category->status = $request->status;
        $category->created_by = Auth::user()->id;
        $category->updated_by = Auth::user()->id;
        $category->save();

        if($category!=null){
            return response()->json(['status'=>true,'message'=>'Category Created Successfully'],200);
        }
        return response()->json(['status'=>false,'message'=>'Category creation failed']);
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
    public function get_all_services(){
        $services = Service::all();
        return response()->json(['status'=>true,'services'=>$services]);
    }
}
