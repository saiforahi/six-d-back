<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function store(Request $request){

        $this->validate($request,[
            'name' => 'required|unique:permissions',
        ]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name = "api";
        $permission->save();
        if($permission!=null){
            return response()->json(['status'=>true,'data'=>$permission,'message'=>'Permission created successfully'],200);
        }
        return response()->json(['status'=>false,'message'=>'Server Side error'],500);
    }

    public function all_permissions(){
        $permission  = Permission::all();
        return response()->json(['permissions'=>$permission]);
    }

    public function destroy($id){
        $permission = Permission::findOrFail($id);
        $permission->delete();
        if($permission!=null){
            return response()->json(['status'=>true,'message'=>'Permission deleted successfully'],200);
        }
        return response()->json(['status'=>false,'message'=>'Server Side error'],500);
    }
}
