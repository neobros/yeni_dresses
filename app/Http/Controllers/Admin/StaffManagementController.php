<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use DB;


class StaffManagementController extends Controller
{
    public function staffList()
    {
        $staffList = DB::table('staff')->get();

        return view('Admin.Staff_Management.staffList')->with([
            'staffList'  =>  $staffList, 
        ]);
    }

    public function addStaff()
    {
        $categoryList = DB::table('category')->get();
        return view('Admin.Staff_Management.addStaff')->with([
            'categoryList'  =>  $categoryList, 
        ]);
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customer_seller',
            'password' => 'required|string|min:8|confirmed',
            'nic' => 'required',
            'address' => 'required',
            'phone' => 'required|digits:10',

         ]);

        // Create customer
        $customer = Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 1,
            'password' => Hash::make($request->password),
            'nic' => $request->nic,
            'address' => $request->address,
            'phone' => $request->phone,
            'join_date' => today(),
        ]);

        return redirect()->back()->with([
            'success'  =>  'Staff Member Added Successfully.', 
        ]);

    }

    public function deleteStaff($id)
    {   
        DB::delete('delete from staff where id = ?',[$id]);

        return redirect()->back()->with('delete', 'Staff Delete Successfully.');
    }


    public function updateStaff($id)
    {
        $userData = DB::table('staff')->where('id' , $id)->first();

        return view('Admin.Staff_Management.updateStaff')->with([
            'userData'  =>  $userData, 
        ]);
    }
    


    public function updateStaffDetails(Request $request)
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

        Staff::where('id',$request->id)->update($update);

        return redirect()->back()->with('success',  'Staff Update Successfully!');

    }

}
