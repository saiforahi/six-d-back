<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Auth;
class ServiceController extends Controller
{
    //
    public function get_all_services(){
        return response()->json(['status'=>true,'services'=>Service::all()]);
    }
    public function create(Request $request){
        $this->validate($request,[
            'name'=>'required|string|max:255'
        ]);
        $new_service=Service::create([
            'name'=>$request->name,
            'created_by'=>Auth::user()->id
        ]);
    }
}
