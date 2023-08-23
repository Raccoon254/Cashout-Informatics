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
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referred_by' => ['nullable', 'string', 'max:255'], // 'referred_by' is now optional
            'contact' => ['required', 'string', 'max:255'],
        ]);

        $contact = $request->contact;

        if (str_starts_with($contact, '+')) {
            $contact = substr($contact, 1);
        }

        if (str_starts_with($contact, '0')) {
            $contact = '254' . substr($contact, 1);
        }

        $request->merge(['contact' => $contact]);
        //dd($request->contact);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $this->generateReferralCode(),
            'balance' => 0,
            'previous' => 0,
            'referred_by' => $request->referred_by ?? null,
            'tokens' => 0,
            'type' => 'user',
            'status' => 'pending',
            'last_login' => now(),
            'contact' => $request->contact,
        ]);

        event(new Registered($user));

        Auth::login($user);
        $user->update(['last_login' => now()]);

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
