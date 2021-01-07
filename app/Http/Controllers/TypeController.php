<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;


class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $type=Type::get();

       return response()->json([
           'status'=>true,
           'type'=>$type
       ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required|max:255|string|unique:types,name',
        ]);
        $type=Type::create([
            'name'=>$request->name
        ]);
        if($type!=null){
            return response()->json([
                'status' => true,'message'=>'Type created'
            ],200);
        }
        return response()->json([
            'status' => false,'message'=>'Failed to create type'
        ],500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Type::findOrFail($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type=Type::where('id', $id)->first();
        return response()->json([
            'status'=>true,
            'type'=>$type
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $type = Type::findOrFail($id);
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();

        return response()->json([
            'status'=>true,
            'type'=>$type
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id)->delete();
        
        if($type==true){
            return response()->json([
                'status'=>true,
                'message'=>'Type deleted'
            ], 200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to delete'
            ], 500);
        }
        
    }
}
