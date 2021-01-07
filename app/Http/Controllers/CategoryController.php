<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    
    public function index()
    {
        $category=Category::get();

        return response()->json([
             'status'=>true,
             'category'=>$category
        ],200);
    }

    
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
        $this->validate($request, [
            'name'=>'required|max:255|string|unique:types,name',
        ]);

        $category = Category::create([
            'name'=>$request->name
        ]);

        if($category!=null){
           
            return response()->json([
                'status'=>true,
                'message'=>'Category is created.'
            ],200);
        }
        
            return response()->json([
                'status'=>false,
                'message'=>'Failed to create Category.'
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
        return Category::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();

        return response()->json([
            'status'=> true,
            'category'=> $category
        ]);
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
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status'=>true,
            'message'=>'Category is updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id)->delete();

        if($category==true){
            return response()->json([
                'status'=>true,
                'message'=>'Category is deleted'
            ], 200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to delete'
            ], 500);
        }
    }
}
