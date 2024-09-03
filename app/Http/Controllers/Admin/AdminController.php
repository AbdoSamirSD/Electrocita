<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getLogin(){
        return view('admin.auth.login');
    }

    public function postLogin(Request $request){
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required',
        ],[
            'email.required'=> 'Email is required',
            'email.email'=> 'Email is not correct',

            'password.required'=> 'Password is required',
        ]);

        $remember_me = $request->has('remember_me')? true : false;

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)){
            return redirect()->route('admin.dashboard')
            ->with('loginsuccess', 'You are logged in successfully');
        }else{
            return back()->with('loginerror', 'Invalid email or password');
        }
    }

    public function getLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('dashboard.getlogin');
    }
}
