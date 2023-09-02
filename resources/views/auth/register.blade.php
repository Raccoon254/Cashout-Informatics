<x-guest-layout>

    <!-- Referred By Message -->
    @if(request('ref'))
        @php
            $referrer = App\Models\User::where('referral_code', request('ref'))->first();
        @endphp
        @if($referrer)
            <div class="mb-4 text-center text-sm text-green-600">
                You've been referred by {{ $referrer->name }}
            </div>
        @else
            <div class="mb-4 text-center text-sm text-red-600">
                The referral code provided is not valid.
            </div>
        @endif
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="contact" :value="__('Phone Number')" />
            <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact')" required autocomplete="contact" />
            <x-input-error :messages="$errors->get('contact')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <!-- Referred By -->
        @if(isset($referrer))
            <div class="mt-4">
                @php
                    $referralCode = $referrer->name . '\'s Referral Code';
                @endphp

                <x-input-label for="referred_by" :value="$referralCode" />
                <x-text-input id="referred_by" class="block mt-1 w-full" type="text" name="referred_by" :value="$referrer->referral_code" readonly />
                <x-input-error :messages="$errors->get('referred_by')" class="mt-2" />
            </div>

        @else
            <div class="mt-4">
                <section class="flex gap-2 items-center">
                    <x-input-label for="referred_by" :value="__('Enter Referral Code')" />
                    <span class="text-xs text-blue-400">[Optional]</span>
                </section>
                <x-text-input id="referred_by" class="block mt-1 w-full" type="text" name="referred_by" :value="old('referred_by')" />
                <x-input-error :messages="$errors->get('referred_by')" class="mt-2" />
            </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
