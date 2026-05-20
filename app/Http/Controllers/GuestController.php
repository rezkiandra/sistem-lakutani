<?php

namespace App\Http\Controllers;

class GuestController extends Controller
{
	public function index()
	{
		return view('beranda');
	}


	public function informasi()
	{
		return view('informasi');
	}

	public function layanan()
	{
		return view('layanan');
	}


	public function icare()
	{
		return view('icare');
	}
}
