<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function get_all_roles(){
        return response()->json(['roles'=>Role::all()]);
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->save();
        if($role!=null){
            return response()->json(['status'=>true,'data'=>$role,'message'=>'Role created successfully'],200);
        }
        return response()->json(['status'=>false,'message'=>'Server Side error'],500);
    }
}
