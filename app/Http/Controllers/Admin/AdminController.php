<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Customer_seller;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\Review;

class AdminController extends Controller
{

    public function loginForm()
    {
        return view('Admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed for admin
            return redirect()->intended('/admin/dashboard')->with('success', 'Login Successfully.');
        }

        return redirect()->back()->with('delete',  'These credentials do not match our records!');
    }

    public function dashboard()
    {
        $totalCustomers = Customer_seller::where('type', 1)->count();

        $totalSellers = Customer_seller::where('type', 0)->count();

        $totalIncome = Order::join('item', 'order.item_ID', '=', 'item.item_ID')
            ->selectRaw('SUM(order.quantity * item.price) as total_income')
            ->value('total_income');

        $totalOrders = Order::count();

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now();

        $ratingsData = Review::whereBetween('created_at', [$startDate, $endDate])
            ->select('item_id', DB::raw('COUNT(*) as ratings_count'))
            ->with(['item' => function ($query) {
                $query->select('item_ID', 'seller_ID', 'name')
                    ->with(['seller' => function ($subQuery) {
                        $subQuery->select('id', 'name');
                    }]);
            }])
            ->groupBy('item_id')
            ->orderBy('ratings_count', 'desc')
            ->get();

        $chartData = [
            'labels' => $ratingsData->map(fn($review) => $review->item->name ?? 'Unknown Item'),
            'values' => $ratingsData->map(fn($review) => $review->ratings_count),
        ];

        return view('admin.dashboard', compact('totalCustomers', 'totalSellers', 'totalIncome', 'totalOrders', 'chartData'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login/admin')->with('message', 'Successfully logged out');
    }
}
