<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        // $categories = CategoryProduct::all();
        return view(
            'pages.admin.reservasi.index',
        );
    }
}
