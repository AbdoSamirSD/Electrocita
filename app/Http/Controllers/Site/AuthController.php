<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('site.auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => 'required|string|min:8'
        ],[
            'email.required' => 'this field is required',
            'email.email' => 'this field must be valid email',
            'email.exists' => 'The email address is not exist.',
            'password.required' => 'this field is required',
            'password.string' => 'this field must be string',
            'password.min' => 'this field must be at least 8 characters'
        ]);

        dd($request);
    }

    public function register()
    {
        return view('site.auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email|regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/',
            'password' => 'required|string|min:8|confirmed|max:32',
            'password_confirmation' => 'required|string|min:8|max:32'
        ],[
            'name.required' => 'this field is required',
            'name.string' => 'this field must be string',
            'email.required' => 'this field is required',
            'email.email' => 'this field must be valid email',
            'email.unique' => 'The email address is already exist.',
            'email.regex' => 'this field must be valid email',
            'password.required' => 'this field is required',
            'password.string' => 'this field must be string',
            'password.min' => 'this field must be at least 8 characters',
            'password.confirmed' => 'password confirmation does not match',
            'password.max' => 'this field must be at most 32 characters',
            'password_confirmation.required' => 'this field is required',
            'password_confirmation.string' => 'this field must be string',
            'password_confirmation.min' => 'this field must be at least 8 characters',
            'password_confirmation.max' => 'this field must be at most 32 characters'
        ]);
        dd($request);   
    }
}
