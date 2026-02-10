<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
		{
				return view('auth.login');
		}

		public function signIn(Request $request)
		{
				return view('auth.login');
		}
}
