<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class Login extends Controller
{
   // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $age= $request->input('age',0);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $age  ;
        $user->password = Hash::make($request->password);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }


        $user->save();

        $user->profile()->create(['photo' =>$photoPath,]);
     
        return redirect()->route('login')->with('success', 'Account created successfully!');
    }

    public function loginn(Request $request){


 
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);



        if (Auth::attempt($credentials)) {
            
         $request->session()->regenerate(); 

         if(Auth::user()->is_admin == 1){

         return redirect()->route('admindashboard');

          

        }
        elseif(Auth::user()->is_admin == 0){
         
         return redirect('/dashboard');
            
 
        }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); 
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    }


