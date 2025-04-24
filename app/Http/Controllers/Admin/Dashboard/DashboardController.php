<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Admin/Dashboard/Index', []);
    }
}
