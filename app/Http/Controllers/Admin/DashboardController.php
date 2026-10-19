<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // GET /admin — summary, to-dos, analytics and shortcuts for what the user can manage
    public function __invoke(Request $request, DashboardService $dashboard): View
    {
        return view('admin.dashboard', $dashboard->for($request->user()));
    }
}
