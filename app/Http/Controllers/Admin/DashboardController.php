<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
