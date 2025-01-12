<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer_seller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

class CustomerController extends Controller
{

    public function welcome()
    {
        $categories = DB::table('category')->get();

        $items = DB::table('item')
            ->join('category', 'item.category_ID', '=', 'category.category_ID')
            ->leftJoin('reviews', 'item.item_ID', '=', 'reviews.item_id')
            ->select(
                'item.*',
                'category.name as category_name',
                'category.type as category_type',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('AVG(reviews.rating) as average_rating') // Calculate average rating
            )
            ->groupBy(
                'item.item_ID',
                'category.name',
                'category.type',
                'item.name',
                'item.price',
                'item.description',
                'item.photo',
                'item.size',
                'item.quantity',
                'item.created_at',
                'item.updated_at',
                'item.seller_ID'
            ) // Include all grouped columns
            ->orderByDesc('review_count') // Order by review count (highest first)
            ->get();

        $cartData = null;
        $wishlistCount = null;

        if (Auth::guard('customer')->check()) {
            $cartData = DB::table('cart')
                ->join('item', 'cart.item_ID', '=', 'item.item_ID')
                ->where('cart.user_ID', Auth::guard('customer')->user()->id)
                ->get();

            $wishlistCount = Wishlist::where('user_ID', Auth::guard('customer')->user()->id)->count();
        }

        return view('Customer.welcome')->with([
            'categories' => $categories,
            'items' => $items,
            'cartData' => $cartData,
            'wishlistCount' => $wishlistCount,
        ]);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            // Authentication passed for staff
            return redirect()->intended('/')->with('success', 'Login Successfully.');
        }
        return redirect()->back()->with('delete',  'These credentials do not match our records!');

    }


    // Handle customer registration
    public function register(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customer_seller',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create customer
        $customer = Customer_seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => 1,
            'password' => Hash::make($request->password),
            'nic' => $request->nic,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        // Log the customer in
        Auth::guard('customer')->login($customer);

        // Redirect to customer dashboard or any other route
        return redirect()->intended('/')->with('success', 'Login Successfully.');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();

        // Optionally invalidate the session
        request()->session()->invalidate();

        // Regenerate session token to prevent session fixation attacks
        request()->session()->regenerateToken();

        // Redirect to the homepage or login page
        return redirect('/')->with('message', 'Successfully logged out');
    }



    public function userDashboard()
    {
        $categories = DB::table('category')->get();
        $items = DB::table('item')->join('category', 'item.category_ID', '=', 'category.category_ID')->select('item.*', 'category.name as category_name' , 'category.type as category_type' )->get();


        $cartData = null ;

        if(Auth::guard('customer')->check())  
        {

            $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)->get();

        }

        return view('Customer.userDashboard')->with([
            'categories'  =>  $categories, 
            'items'  =>  $items, 
            'cartData'  =>  $cartData, 
        ]);
    }

    public function orderList()
    {
        $categories = DB::table('category')->get();
      

        $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)->get();



        $orderData = DB::table('order')->join('item', 'order.item_ID', '=', 'item.item_ID')->join('payment', 'order.payment_ID', '=', 'payment.payment_ID')
        ->where('order.user_ID' , Auth::guard('customer')->user()->id)
        ->select('order.*', 'item.*', 'order.quantity as orderQuantity')->get();


        return view('Customer.orderList')->with([
            'categories'  =>  $categories, 
            'cartData'  =>  $cartData, 
            'orderData'  =>  $orderData, 
        ]);
    }

    public function about()
    {
        $categories = DB::table('category')->get();

        $items = DB::table('item')->join('category', 'item.category_ID', '=', 'category.category_ID')->select('item.*', 'category.name as category_name' , 'category.type as category_type' )->get();
        
        $cartData = null ;

        if(Auth::guard('customer')->check())  
        {

            $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)->get();

        }

        return view('Customer.about')->with([
            'categories'  =>  $categories, 
            'items'  =>  $items, 
            'cartData'  =>  $cartData, 
        ]);
    }

    public function contact()
    {
        $categories = DB::table('category')->get();

        $items = DB::table('item')->join('category', 'item.category_ID', '=', 'category.category_ID')->select('item.*', 'category.name as category_name' , 'category.type as category_type' )->get();
        
        $cartData = null ;

        if(Auth::guard('customer')->check())  
        {

            $cartData = DB::table('cart')->join('item', 'cart.item_ID', '=', 'item.item_ID')->where('cart.user_ID' , Auth::guard('customer')->user()->id)->get();

        }

        return view('Customer.contact')->with([
            'categories'  =>  $categories, 
            'items'  =>  $items, 
            'cartData'  =>  $cartData, 
        ]);
    }

}
