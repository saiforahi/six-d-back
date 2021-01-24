<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Company;
use Spatie\Permission\Models\Role;
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
        $company_name=Company::find($company_id)->name;
        $deleted_company=Company::find($company_id)->delete();
        Admin::where('company_id',$company_id)->delete();
        if($deleted_company!=null){
            return response()->json(['status'=>true,'message'=>$company_name.' company has been softly deleted']);
        }
        return response()->json(['status'=>false,'message'=>'Failed to delete '.$company_name.' company']);
    }
    Public function create_company(Request $request){
        $this->validate($request,[
            'companyName'=> 'required|string|max:255',
            'companyEmail'=> 'required|string|email|max:255|unique:companies,email',
            'companyPhone'=> 'required|string|max:11|min:11|unique:companies,phone',
            'TIN'=> 'required|string|max:255|unique:companies,TIN',
            'BIN'=> 'required|string|max:255|unique:companies,BIN',
            'inc_no'=> 'required|string|max:255|unique:companies,inc_no',
            'trade_license_no'=> 'required|string|max:255|unique:companies,trade_license_no',
            'adminName'=> 'required|string|max:255',
            'adminEmail'=> 'required|string|email|unique:users,email',
            'adminPassword'=>'required|string|min:8'
        ]);
        $newCompany=Company::create([
            'name'=>$request->companyName,
            'email'=>$request->companyEmail,
            'phone'=>$request->companyPhone,
            'inc_no'=>$request->inc_no,
            'trade_license_no'=>$request->trade_license_no,
            'TIN'=>$request->TIN,
            'BIN'=>$request->BIN
        ]);
        $user=User::create([
            'name'=>$request->adminName,
            'email'=>$request->adminEmail,
            'password'=>Hash::make($request->adminPassword)
        ]);
        $newCompany->make_admin($user->id);
        $user->assignRole(Role::where('name','company-admin')->first());
        if($newCompany!=null){
            return response()->json(['status'=>true,'message'=>$newCompany->name.' Company Created Successfully','company'=>$newCompany]);
        }
        return response()->json(['status'=>false,'message'=>'Server Error']);
    }
    public function get_all_companies(){
        $companies=Company::join('admins','companies.id','=','admins.company_id')
        ->join('users','users.id','=','admins.user_id')
        ->select('companies.id','companies.name','companies.email','companies.phone','companies.inc_no','companies.trade_license_no','companies.TIN','companies.BIN','companies.period_from','companies.period_to','companies.address','users.name as admin','users.id as user_id')
        ->get();
        return response()->json(['status'=>true,'companies'=>$companies]);
    }
    public function update_company(Request $request,$company_id){
        try{
            $this->validate($request,[
                'companyName'=> 'required|string|max:255',
                'companyEmail'=> 'required|string|email|max:255',
                'companyPhone'=> 'required|string|max:11|min:11',
                'TIN'=> 'required|string|max:255',
                'BIN'=> 'required|string|max:255',
                'inc_no'=> 'required|string|max:255',
                'trade_license_no'=> 'required|string|max:255',
                'adminName'=> 'required|string|max:255',
                'adminEmail'=> 'required|string|email',
                'adminPassword'=>'sometimes|nullable|string|min:8'
            ]);
            Company::find($company_id)->forceFill([
                'name'=>$request->companyName,
                'email'=>$request->companyEmail,
                'phone'=>$request->companyPhone,
                'inc_no'=>$request->inc_no,
                'trade_license_no'=>$request->trade_license_no,
                'TIN'=>$request->TIN,
                'BIN'=>$request->BIN,
            ])->save();
            Company::find($company_id)->admin->user->forceFill([
                'name'=>$request->adminName,
                'email'=>$request->adminEmail,
                'phone'=>$request->adminPhone
            ])->save();
            return response()->json(['status'=>true,'message'=>'Company details updated!']);
        }catch(Exception $e){
            return response()->json(['status'=>false,'error'=>$error]);
        }
    }
}
