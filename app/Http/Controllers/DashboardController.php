<?php

// DashboardController.php

namespace App\Http\Controllers;

use App\Models\Earning;
use App\Models\Transaction;
use App\Models\User;
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
        // Fetch data for Earnings
        $earnings = Earning::select('created_at', 'total_amount')->get();

        // Fetch data for User Counts
        $userCounts = User::select('type', \DB::raw('count(*) as count'))->groupBy('type')->get();

        // Fetch data for Transactions
        $transactions = Transaction::select('date', \DB::raw('sum(amount) as total_amount'))
            ->groupBy('date')
            ->get();

        return view('admin.index', compact('earnings', 'userCounts', 'transactions'));
    }

}
