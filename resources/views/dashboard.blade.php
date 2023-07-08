<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 h-4 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Display User Balance -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Balance') }}</h3>
                        <p>{{ Auth::user()->balance }}</p>
                    </div>

                    <!-- Display User Transactions -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Transactions') }}</h3>
                        <ul>
                            @foreach(Auth::user()->transactions as $transaction)
                                <li>
                                    {{ $transaction->created_at }}: {{ $transaction->amount }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Display User Referrals -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Referrals') }}</h3>
                        <ul>
                            @foreach(Auth::user()->referrals as $referral)
                                <li>
                                    {{ $referral->created_at }}: {{ $referral->email }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
