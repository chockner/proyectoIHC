<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Secretary;

class SecretariaController extends Controller
{
    public function index()
    {
        $secretarias = Secretary::all();
        return view('admin.secretaria.index', compact('secretarias'));
    }

    public function create()
    {
        return view('admin.secretaria.create');
    }
}
