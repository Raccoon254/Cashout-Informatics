<x-app-layout>
    <section class="flex">
        <div class="z-40">
            @include('layouts.sidebar')
        </div>

        <div>
            <div class="w-full">

                <div class="w-full mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-3 sm:p-5 text-gray-900 dark:text-gray-100">

                            @if(session('success'))
                                <div class="alert rounded mb-4 alert-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert rounded mb-4 alert-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Display greeting according to time of day -->
                            <div class="mb-4">

                                <section>
                                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 leading-tight">
                                        {{ __('Welcome') }} {{ Auth::user()->name }}
                                    </h1>
                                </section>

                                <!-- Display User Balance -->
                                <div class="mb-4">
                                </div>

                                <div class="mb-4 w-full flex flex-wrap gap-4">

                                    <div class="card w-full p-0 rounded bg-base-100 shadow-sm">
                                        <div class="card-body m-[-10px]">
                                            <h2 class="card-title">Balance</h2>
                                            <p>Total Balance from all Cashout Tasks is <span class="font-sans font-bold text-orange-700 text-2xl">{{ Auth::user()->balance }}</span> KSH</p>
                                            <div class="card-actions gap-3 justify-end">
                                                <button class="btn ring ring-blue-700 btn-circle hover:bg-base-100">
                                                    <i class="fa-solid fa-building-columns"></i>
                                                </button>
                                                <button class="btn hover:bg-base-100 ring ring-orange-700 btn-circle">
                                                    <i class="fa-solid fa-coins"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cards -->

                                <div class="mb-4 w-full flex sm:flex-nowrap gap-4 flex-wrap">

                                    <div class="card w-full sm:w-1/2 rounded bg-base-100 shadow-sm">
                                        <form action="{{ route('send.money') }}" method="POST">
                                            @csrf
                                            <div class="card-body m-[-10px]">
                                                <h2 class="card-title">Send Money</h2>
                                                <p>You can share cash here using email</p>
                                                <input class="input ring ring-orange-700 input-warning mb-4" name="email" type="email" placeholder="Recipient's Email">
                                                <input class="input ring ring-blue-700 input-warning mb-4" name="amount" type="number" placeholder="Amount">
                                                <div class="card-actions gap-3 justify-end">
                                                    <button type="submit" data-tip="send money" class="btn hover:bg-base-100 tooltip ring ring-orange-700 btn-circle">
                                                        <i class="fa-solid fa-share-nodes"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    <form class="card w-full sm:w-1/2 rounded bg-base-100 shadow-sm" action="{{ route('deposit') }}" method="POST">
                                        @csrf
                                        <div class="">
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
                                        </div>
                                    </form>

                                </div>

                                <!-- Cards -->

                                <div class="mb-4 w-full flex sm:flex-nowrap gap-4 flex-wrap">

                                    <form class="card w-full sm:w-1/2 rounded bg-base-100 shadow-sm" action="{{ route('withdraw') }}" method="POST">
                                        @csrf
                                        <div class="">
                                            <div class="card-body m-[-10px]">
                                                <h2 class="card-title">Withdraw</h2>
                                                <p>Withdraw Cash to M-Pesa</p>

                                                <input class="input ring ring-orange-700 input-success mb-4" name="amount" type="number" placeholder="Amount">
                                                <div class="card-actions justify-end">
                                                    <button data-tip="Withdraw" class="btn tooltip ring tooltip-left ring-blue-700 btn-circle" type="submit">
                                                        <i class="fa-solid fa-circle-dollar-to-slot"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
