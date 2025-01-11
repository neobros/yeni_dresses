<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

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
        return view('admin.dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        // Optionally invalidate the session
        request()->session()->invalidate();

        // Regenerate session token to prevent session fixation attacks
        request()->session()->regenerateToken();

        // Redirect to the homepage or login page
        return redirect('/login/admin')->with('message', 'Successfully logged out');
    }
}
