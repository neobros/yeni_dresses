<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Customer_seller;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    
    public function userList()
    {
        $userList = DB::table('customer_seller')->get();

        return view('Admin.User_Management.userList')->with([
            'userList'  =>  $userList, 
        ]);
    }

    public function user_update($id)
    {
        $userData = DB::table('customer_seller')->where('id' , $id)->first();

        return view('Admin.User_Management.userUpdate')->with([
            'userData'  =>  $userData, 
        ]);
    }

    public function updateUserDetails(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

    
        $update = [
            'name' => $request->name,
            'nic' => $request->nic,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        Customer_seller::where('id',$request->id)->update($update);

        return redirect()->back()->with('success',  'User Update Successfully!');

    }


    public function user_delete($id)
    {   
        DB::delete('delete from customer_seller where id = ?',[$id]);

        return redirect()->back()->with('delete', 'User Delete Successfully.');
    }


}
