<x-app-layout>
    {{--<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
--}}
    <section class="flex">
        <div>
            @include('layouts.sidebar')
        </div>
        <div>
            <div class="w-full">
                <div class="w-full mx-auto sm:px-6 lg:px-8">

                    @include('session.alerts')
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-3 sm:p-5 ">


                            <div class="mb-4 w-full flex sm:flex-nowrap gap-4 flex-wrap">

                                <div class="card w-full sm:w-1/2 rounded bg-base-100 shadow-sm">

                                    <div class="card-body m-[-10px]">
                                        <h2 class="card-title">Referral Code</h2>
                                        <p>Your CASHOUT™️⚡ Referral Code is <span class="font-sans font-bold text-orange-700 text-2xl">{{ Auth::user()->referral_code }}</span></p>
                                        <div class="card-actions gap-3 justify-end">
                                            <button data-tip="Copy {{ Auth::user()->referral_code }}" class="tooltip ring ring-blue-700 btn-circle hover:bg-base-100">
                                                <i class="fa-solid fa-clone"></i>
                                            </button>
                                            <button class="btn hover:bg-base-100 ring ring-orange-700 btn-circle">
                                                <i class="fa-solid fa-coins"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>


                                @if(Auth::user()->balance > 100)

                                    <form class="card w-full sm:w-1/2 rounded bg-base-100 shadow-sm" action="{{ route('activate') }}" method="POST">
                                        @csrf
                                        <div class="card-body m-[-10px]">
                                            <h2 class="card-title">Activate</h2>
                                            <p>You can activate another user's Account.</p>
                                            <input class="input ring ring-orange-700 input-warning mb-4" name="email" type="email" placeholder="Email">
                                            <div class="card-actions justify-end">
                                                <button data-tip="Deposit to your account" class="btn tooltip ring tooltip-left ring-blue-700 btn-circle" type="submit">
                                                    <i class="fa-solid fa-sack-dollar"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                @else

                                    <form class="card w-full sm:w-1/2 rounded bg-base-100 shadow-sm" action="{{ route('deposit') }}" method="POST">
                                        @csrf
                                        <div class="card-body m-[-10px]">
                                            <h2 class="card-title">Deposit</h2>
                                            <p>You can deposit cash here using your M-Pesa Contact</p>
                                            <input class="input ring ring-orange-700 input-success mb-4" name="deposit" type="number" placeholder="Amount">
                                            <div class="card-actions justify-end">
                                                <button data-tip="Deposit to your account" class="btn tooltip ring tooltip-left ring-blue-700 btn-circle" type="submit">
                                                    <i class="fa-solid fa-sack-dollar"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                @endif



                            </div>

                            <!-- Referral Code -->
                            <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    <h3 class="text-lg font-semibold">{{ __('Referral Code') }}</h3>
                                    <p>{{ Auth::user()->referral_code }}</p>
                                </div>
                            </div>

                            <!-- Referral Link -->
                            <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    <h3 class="text-lg font-semibold">{{ __('Referral Link') }}</h3>
                                    <p>{{ route('register', ['ref' => Auth::user()->referral_code]) }}</p>
                                </div>
                            </div>

                            <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>

                            <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>

                            <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
</x-app-layout>
