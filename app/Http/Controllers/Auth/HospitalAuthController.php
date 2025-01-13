<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.hospital-login');
    }

    ## login for admin

    public function login(Request $request)
    {

        try{
        
            $request->merge(['user_type' => 'admin','is_deleted' => 0]); //add request
            $credentials = $request->only('email', 'password', 'user_type');

            

            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->intended('hospital/dashboard');
            }

            return back()->withErrors(['email' => 'Invalid credentials']);

        }catch(\Exception $e){
           
            return redirect()->back()->withErrors($e->getMessage());

        }
    }


    ##logout for admin
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/hospital/login');
    }



}