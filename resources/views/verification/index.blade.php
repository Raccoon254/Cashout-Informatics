<section>
    <section class="flex">
        <div>


            <div class="drawer lg:drawer-open">
                <input id="my-drawer" type="checkbox" class="drawer-toggle lg:hidden" />
                <div class="drawer-side z-40 lg:block">
                    <label for="my-drawer" class="drawer-overlay lg:hidden"></label>
                    <section class="menu p-4 flex flex-col justify-between gap-1 sm:gap-4 mt-16 sm:mt-0 w-56 h-full bg-base-200 text-base-content lg:block">
                        <a data-tip="Activate account to unlock" href="#" class="sidebar-item-lock justify-between active">
                            <div class="flex gap-2 items-center">
                                <i class="fa-solid fa-house"></i>
                                Dashboard
                            </div><i class="fa-solid side-lock fa-lock"></i>
                        </a>

                        <header class="text-[15px] py-[10px] px-[16px] mx-[16px]">
                            PAGES
                        </header>

                        <!-- Sidebar content here -->
                        <a data-tip="Activate account to unlock" href="#" class="sidebar-item-lock  justify-between">
                            <div class="flex gap-2 items-center">
                                <i class="fa-solid fa-circle-user"></i>
                                Account
                            </div>
                            <i class="fa-solid side-lock fa-lock"></i>
                        </a>

                        <a data-tip="Activate account to unlock" class="sidebar-item-lock justify-between">
                            <div class="flex gap-2 items-center">
                                <i class="fa-solid fa-crosshairs"></i>
                                Spin & Win
                            </div>
                            <i class="fa-solid side-lock fa-lock"></i>
                        </a>
                        <a data-tip="Activate account to unlock" class="sidebar-item-lock  justify-between">
                            <div class="flex gap-2 items-center">
                                <i class="fa-regular fa-circle-play"></i>
                                Ad to Cash
                            </div>
                            <i class="fa-solid side-lock fa-lock"></i>
                        </a>
                        <a data-tip="Activate account to unlock" class="sidebar-item-lock justify-between">
                            <div class="flex gap-2 items-center">
                                <i class="fa-solid fa-rectangle-ad"></i>
                                Advertise
                            </div>
                            <i class="fa-solid side-lock fa-lock"></i>
                        </a>
                        <a data-tip="About Cashout" class="sidebar-item-lock justify-between">
                            <div class="flex gap-2 items-center">
                                <i class="fa-regular fa-circle-question"></i>
                                About
                            </div>
                            {{--<i class="fa-solid fa-lock"></i>--}}
                        </a>
                    </section>

                </div>
            </div>



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

                                {{--<div class="mb-4 w-full flex flex-wrap gap-4">
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
                                </div>--}}

                                <div class="mb-4 w-full flex sm:flex-nowrap gap-4 flex-wrap">

                                    <div class="card w-full sm:w-1/2 rounded bg-base-100 shadow-sm">

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


                                    @if(Auth::user()->balance > 100)

                                        <form class="card w-full sm:w-1/2 rounded bg-base-100 shadow-sm" action="{{ route('activate') }}" method="POST">
                                            @csrf
                                                <div class="card-body m-[-10px]">
                                                    <h2 class="card-title">Activate</h2>
                                                    <p>You can activate your account</p>
                                                    <input class="input ring ring-orange-700 input-warning mb-4" name="email" type="email" placeholder="Email">
                                                    <div class="card-actions justify-end">
                                                        <button data-tip="Activate Account" class="btn tooltip ring tooltip-left ring-blue-700 btn-circle" type="submit">
                                                            <i class="fa-solid fa-bolt-lightning"></i>
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



                            </div>

                    </div>

                        <section class="footer p-3 sm:p-5 text-gray-900 dark:text-gray-100">
                            @include('verification.info')
                        </section>
                </div>
            </div>
        </div>
    </section>
</section>
