<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{

    public function index(): Response
    {

        return Inertia::render('Admin/Dashboard');
    }

    public function laporan(): Response
    {
        return Inertia::render('Admin/Laporan');

    }

}