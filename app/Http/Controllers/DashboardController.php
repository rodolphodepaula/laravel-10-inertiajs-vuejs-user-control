<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCompanies = Company::count();

        return Inertia::render('Dashboard', [
            'totalUsers' => $totalUsers,
            'totalCompanies' => $totalCompanies,
        ]);
    }
}
