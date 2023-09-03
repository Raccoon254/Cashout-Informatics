<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->update($request->all());

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index');
    }
}
