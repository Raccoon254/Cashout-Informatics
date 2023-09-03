<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalPaidNotification;
use App\Notifications\WithdrawalUpdatedForAdmin;
use App\Notifications\WithdrawalUpdatedForUser;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Notification;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);
        $withdrawals = Withdrawal::orderByDesc('created_at')->get();

        return view('withdraw.index', compact('withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('viewAny', User::class);
        // Display a form to create a new withdrawal request.
        return view('withdraw.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('viewAny', User::class);
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'contact' => 'required',
        ]);

        // Create a new Withdrawal record
        $withdrawal = new Withdrawal([
            'user_id' => auth()->user()->id,
            'amount' => $request->input('amount'),
            'status' => 'pending',
            'contact' => $request->input('contact'),
            'fee' => 0,
        ]);

        $withdrawal->save();

        return redirect()->route('withdrawals.index')->with('success', 'Withdrawal request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        // Check if the user is the owner or an admin of the withdrawal request
        if (auth()->user()->id === $withdrawal->user_id || auth()->user()->isAdmin()) {
            return view('withdraw.show', compact('withdrawal'));
        }

        return redirect()->back()->with('error', 'You are not authorized to view this withdrawal request.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $this->authorize('viewAny', User::class);
        // Find the withdrawal record with the given $id
        $withdrawal = Withdrawal::findOrFail($id);

        // Display a form to edit the withdrawal request
        return view('withdraw.edit', compact('withdrawal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validate the request data
        $request->validate([
            'status' => 'required',
        ]);

        // Find the withdrawal record with the given $id
        $withdrawal = Withdrawal::findOrFail($id);

        // Store the old status for comparison
        $oldStatus = $withdrawal->status;

        // Check if the old status is not "paid" and the new status is "paid"
        if ($oldStatus !== 'paid' && $request->input('status') === 'paid') {
            // Update the withdrawal record
            $withdrawal->update([
                'status' => $request->input('status'),
            ]);

            // Notify the user that they have received cash
            $withdrawal->user->notify(new WithdrawalPaidNotification($withdrawal));

            //create a transaction record
            $transaction = new Transaction([
                'user_id' => $withdrawal->user_id,
                'transaction_type' => 'WITHDRAWAL',
                'from' => $withdrawal->user_id,
                'to' => 'MPESA',
                'amount' => $withdrawal->amount,
                'date' => now(),
            ]);
            $transaction->save();

        } elseif ($oldStatus !== 'paid') {
            // If the status is not changing to "paid," allow the update
            $withdrawal->update([
                'status' => $request->input('status'),
            ]);
            $withdrawal->user->notify(new WithdrawalUpdatedForUser($withdrawal));
        } else {
            // If the status is already "paid," do not allow further modifications
            return redirect()->back()->with('error', 'Withdrawal request is already paid and cannot be modified.');
        }

        // Notify the admin(s)
        $admins = User::where('type', 'admin')->get();
        Notification::send($admins, new WithdrawalUpdatedForAdmin($withdrawal));

        return redirect()->route('withdrawals.index')->with('success', 'Withdrawal request updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        // Find the withdrawal record with the given $id and delete it
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->delete();

        return redirect()->route('withdrawals.index')->with('success', 'Withdrawal request deleted successfully.');
    }

    //userWithdrawals
    public function userWithdrawals(): View
    {
        $withdrawals = Withdrawal::where('user_id', auth()->user()->id)->get();
        return view('withdraw.userWithdrawals', compact('withdrawals'));
    }
}
