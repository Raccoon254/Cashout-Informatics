<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            /*            'referral_code' => ['unique:'.User::class],
                      'balance' => ['required', 'numeric'],
                       'previous' => ['required', 'numeric'],*/
            'referred_by' => ['nullable', 'string', 'max:255'], // 'referred_by' is now optional
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $this->generateReferralCode(),
            'balance' => 0, // Set initial balance to 0
            'previous' => 0, // Set initial previous to 0
            'referred_by' => $request->referred_by ?? null, // Assign 'referred_by' only if it's present in the request
            'tokens' => 0, // Set initial tokens to 0
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Send verification email
        if(!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('verification.notice');
    }

    private function generateReferralCode(): string
    {
        do {
            // generate a random string of 8 uppercase characters and digits
            $referral_code = strtoupper(Str::random(8));
            // ensure it doesn't exist already
        } while (User::where('referral_code', $referral_code)->exists());

        return $referral_code;
    }

}
