<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginSiswaController extends Controller
{
    function index(){
        return view('siswa.login');
    }

    // chek proses login
    function submit(Request $request)
    {
        // Validate the form data
         $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);

      // Attempt to log the user in
      if (Auth::guard('siswa')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        return redirect()->intended('/raport');
      }
      // if unsuccessful, then redirect back to the login with the form data
      return redirect('siswa/login')->withInput($request->only('email', 'remember'));
    }
}
