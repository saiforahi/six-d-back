<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
class CompanyController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('cors');
    }
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

    public function get_admin($company_id){
        return response()->json(['admin'=>Company::find($company_id)->admin->user]);
    }
    public function delete_company($company_id){
        
    }
    Public function create_company(Request $request){
        $this->validate($request,[
            'companyName'=> 'required|string|max:255',
            'adminName'=> 'required|string|max:255',
            'adminEmail'=> 'required|string|email|unique:users,email',
            'adminPassword'=>'required|string|min:8'
        ]);
        $newCompany=Company::create([
            'name'=>$request->companyName
        ]);
        $user=User::create([
            'name'=>$request->adminName,
            'email'=>$request->adminEmail,
            'password'=>Hash::make($request->adminPassword)
        ]);
        $newCompany->make_admin($user->id);
        if($newCompany!=null){
            return response()->json(['status'=>true,'company'=>$newCompany,'admin'=>$newCompany->admin()->user]);
        }
        return response()->json(['status'=>false,'message'=>'Server Error']);
    }
    public function get_all_companies(){
        return response()->json(['status'=>true,'companies'=>Company::all()]);
    }
}
