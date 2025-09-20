<?php
namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(): Response
    {
        $dashboardData = $this->dashboardService->getDashboardData();

        return Inertia::render('Admin/Dashboard', $dashboardData);
    }

    public function laporan(): Response
    {
        return Inertia::render('Admin/Laporan');

    }
}