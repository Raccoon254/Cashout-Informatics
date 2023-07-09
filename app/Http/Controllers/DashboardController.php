<?php

// DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        // Fetch user with transactions and referrals
        $user = Auth::user()->load('transactions', 'referrals');

        // Pass to view
        return view('dashboard', compact('user'));
    }
}
