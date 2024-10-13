<?php

namespace App\Http\Controllers\dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {


    public function logout() {
        Auth::logout();
        return redirect('/dashboard/login');
    }




    public function customLogin(Request $request) {
        // return 's';

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('dashboard-index')->with('success', 'Signed in');
        }

        // return 's';
        return redirect()->route('login')->with('error', 'Login details are not valid')->withInput($request->only('email'));
    }



    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $admin = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        if ($admin) {
            return redirect()->route('login')->with('success', 'Admin registered successfully');
        }

        return back()->withInput($request->only('name', 'email'))->with('error', 'Failed to register admin');
    }

    public function home () {

        return view('dashboard.home');


    }
   



}
