<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;


class PatientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.patient-login');
    }

    public function showRegisterForm()
    {
        return view('auth.patient-register');
    }

    public function login(Request $request)
    {
        $request->merge(['user_type' => 'user','is_deleted' => 0]); //add request
        $credentials = $request->only('email', 'password', 'user_type');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->intended('patient/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {

        
        try{

             $this->validate($request, [
            'email' => 'required|email|unique:patients',
            'password' => 'required|min:6|max:8',
            'name' => 'required',
            'age' => 'required',
            'mobile' => 'required|min:10|max:12',
            'ip_number' => 'required|min:12|max:15',
            'gender' => 'required',
            ]);

      

     

        $patients = [


            'email' => $request->email,
            'patient_id' => 'patient_'.rand(111111,999999),
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'age' => $request->age,
            'mobile' => $request->mobile,
            'ip_number' => $request->ip_number,
            'gender' => $request->gender

        ];

        $patients = Patient::create($patients);

        return redirect()->back()->with('success', 'User has been successfully registered.');



        }catch(\Exception $e){
           
            return redirect()->back()->withErrors($e->getMessage());

        }

    }


    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/patient/login');
    }
}
