<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function all_users(){
       return response()->json(['users' => User::all()]);
    }

    public function store(Request $request){
        dd($request->all);
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|string|min:8',

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->api_token = Hash::make(Str::random(80));

        $user->save();
        if($user!=null){
            return response()->json(['status'=>true,'data'=>$user,'message'=>'User created successfully'],200);
        }
        return response()->json(['status'=>false,'message'=>'Server Side error'],500);
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        if($user!=null){
            return response()->json(['status'=>true,'message'=>'User deleted successfully'],200);
        }
        return response()->json(['status'=>false,'message'=>'Server Side error'],500);
    }

}
