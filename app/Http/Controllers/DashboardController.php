<?php

// DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Fetch user with transactions and referrals
        $user = Auth::user()->load('transactions', 'referrals');

        // Pass to view
        return view('dashboard', compact('user'));
    }

    public function spin(): View
    {
        return view('spin');
    }

    public function admin(): View
    {
        return view('admin.index');
    }
}
