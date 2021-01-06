<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
class CompanyController extends Controller
{
    //
    public function create_admin(Request $request){
        $this->validate($request,[
            'user_id'=>'required|exists:users,id',
            'company_id'=>'required|exists:companies,id'
        ]);
        $admin=Admin::create([
            'user_id'=>$request->user_id,
            'company_id'=>$request->company_id
        ]);
        if($admin!=null){
            return response()->json(['status'=>true,'message'=>'Admin Created Successfully','data'=>$admin],200);
        }
        return response()->json(['status'=>false,'message'=>'Admin creation failed']);
    }

    public function get_admin(){
        
    }
}
