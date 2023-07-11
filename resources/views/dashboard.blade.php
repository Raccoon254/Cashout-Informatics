<x-app-layout>
{{--
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 h-4 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
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
                    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-3 sm:p-5 text-gray-900 dark:text-gray-100">

                            <!-- Display greeting according to time of day -->
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold">{{ __('Welcome') }}</h3>
                                <p>
                                    @php
                                        $hour = date('H');
                                        if ($hour >= 5 && $hour <= 11) {
                                            echo "Good Morning";
                                        } else if ($hour >= 12 && $hour <= 18) {
                                            echo "Good Afternoon";
                                        } else if ($hour >= 19 || $hour <= 4) {
                                            echo "Good Evening";
                                        }
                                    @endphp
                                    {{ Auth::user()->name }}
                                </p>

                            <!-- Display User Balance -->
                            <div class="mb-4">
                            </div>

                                <div class="mb-4 w-full flex flex-wrap gap-4">
                                    <div class="card w-full sm:w-5/12 p-0 rounded bg-base-100 shadow-sm">
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

                                    <div class="card w-full sm:w-5/12 p-0 rounded bg-base-100 shadow-sm">
                                        <div class="card-body m-[-10px]">
                                            <h2 class="card-title">Activity</h2>
                                            <p>You have been online for
                                                <span id="timeOnline" class="font-sans font-bold text-orange-700 text-2xl"></span>
                                            </p>
                                            <div class="card-actions justify-end">
                                                <button class="btn ring ring-orange-700 btn-circle">
                                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
                                    @if(Auth::user()->referrals)
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full table divide-y divide-gray-200">
                                            <!-- head -->
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th class="hidden sm:table-cell">Email</th>
                                                <th class="hidden sm:table-cell">Date</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                    @foreach(Auth::user()->referrals as $referral)
                                        <!-- row 1 -->
                                        <tr>
                                            <td>
                                                <div class="flex items-center space-x-3">
                                                    <div>
                                                        <div class="font-bold">{{ $referral->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="hidden sm:table-cell">
                                                <span class="text-sm">{{ $referral->email }}</span>
                                            </td>
                                            <td class="hidden sm:table-cell">
                                                <span class="text-sm"> {{ $referral->created_at }}</span>
                                            </td>
                                            <td>{{ $referral->status }}</td>
                                        </tr>
                                    @endforeach
                                            </tbody>
                                            <!-- foot -->
                                        </table>
                                        </div>
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>
    <script>
        var startTime = new Date('{{ Auth::user()->last_login }}');

        function updateTime() {
            var currentTime = new Date();
            var timeDiff = Math.floor((currentTime - startTime) / 1000); // in seconds

            var seconds = timeDiff % 60; // extract seconds
            timeDiff = Math.floor(timeDiff / 60); // convert to minutes
            var minutes = timeDiff % 60; // extract minutes
            timeDiff = Math.floor(timeDiff / 60); // convert to hours
            var hours = timeDiff % 24; // extract hours
            var days = Math.floor(timeDiff / 24); // extract days

            var timeOnline = '';
            if(days > 0) {
                timeOnline += days + 'd ';
            }
            if(hours > 0) {
                timeOnline += hours + 'h ';
            }
            if(minutes > 0) {
                timeOnline += minutes + 'm ';
            }
            timeOnline += seconds + 's';

            document.getElementById('timeOnline').textContent = timeOnline;
        }

        setInterval(updateTime, 1000); // update every second
    </script>


</x-app-layout>
