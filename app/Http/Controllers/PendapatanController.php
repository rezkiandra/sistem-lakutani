<?php

namespace App\Http\Controllers;

use App\Models\Pendapatan;
use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index()
    {
        $pendapatans = Pendapatan::orderBy('created_at', 'ASC')->get();
        return view('admin.pendapatan.index');
    }

    public function create()
    {
        return view('admin.pendapatan.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            ''
        ]);
    }

    public function show(Pendapatan $pendapatan)
    {
        //
    }
}