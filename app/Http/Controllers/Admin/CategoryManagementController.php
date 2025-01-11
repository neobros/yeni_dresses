<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;

class CategoryManagementController extends Controller
{
    public function categoryList()
    {
        $categoryList = DB::table('category')->get();

        return view('Admin.Category_Management.categoryList')->with([
            'categoryList'  =>  $categoryList, 
        ]);
    }

    public function addCategory()
    {
        $categoryList = DB::table('category')->get();
        return view('Admin.Category_Management.addCategory')->with([
            'categoryList'  =>  $categoryList, 
        ]);
    }


    public function storeCategory(Request $request)
    {
        $request->validate([
            'mainCategory' => 'required',
            'subCategory' => 'required',
         ]);


        //store DB
        $save = new Category([
            'name' => $request->subCategory,
            'type'=> $request->mainCategory,
            ]);
        $save->save();


        $categoryList = DB::table('category')->get();

        return redirect()->back()->with([
            'categoryList'  =>  $categoryList, 
            'success'  =>  'Category Added Successfully.', 
        ]);

    }

    public function deleteCategory($category_ID)
    {
        DB::delete('delete from category where category_ID = ?',[$category_ID]);

        return redirect()->back()->with('delete', 'Category Delete Successfully.');
    }


}
