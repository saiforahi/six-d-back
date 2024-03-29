<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;
class AuthController extends Controller
{
    public function __construct(){
        //$this->middleware('cors');
    }
    //
    public function login(Request $request){
        try {
            $this->validate($request,[
                'username' => 'string|required|exists:users,email',
                'password' => 'required|string|min:6'
            ]);
            $user = User::where('email', $request->username)->first();
            if ( ! Hash::check($request->password, $user->password, [])) {
                return response()->json(['status'=>false,'message'=>'wrong password']);
            }
            $new_token = Hash::make(Str::random(80));
            $user->forceFill([
                'api_token' => $new_token,
            ])->save();
            return response()->json([
                'status' => true,
                'api_token' => $user->api_token,
                'message'=>'Successfully logged in'
            ],200);
        } catch (Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Error in Login',
                'error' => $error,
            ],500);
        }
    }
    public function register(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255|string',
            'email'=>'required|string|max:255|email|unique:users',
            'phone'=>'required|string|max:11|min:11|unique:users',
            'password' => 'required|confirmed|string|min:6'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'api_token' => Hash::make(Str::random(80))
        ]);
        return response()->json([
            'status_code' => 200,
            'api_token' => $user->api_token
        ]);
    }
    public function get_user_details(){
        return Auth::user();
    }
    public function get_user_permissions(){
        return Auth::user()->getAllPermissions() ;
    }
    public function get_user_roles(){
        return Auth::user()->getRoleNames();
    }
    public function logout(){
        $user=Auth::user();
        //Auth::guard('web')->logout();
        $this->guard()->logout();
        $user->api_token=null;
        $user->save();
        return response()->json(['status'=>true,'message'=>'logged out']);
    }
}
