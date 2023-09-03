<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 h-4 dark:text-gray-200 leading-tight">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <section class="flex w-full">
        <div class="h-full z-30 sticky">
            @include('layouts.sidebar')
        </div>
        <div class="w-full">
            <div class="w-full">
                <div class="w-full sm:px-6 lg:px-8">

                    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm container sm:rounded-lg">
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
                                <table class="table w-full">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>Amount</th>
                                            <th>Transaction Type</th>
                                            <th>Recipient/Sender</th>
                                            <th>Transaction Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Transactions where the user sent money -->
                                    @foreach(Auth::user()->sent_transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td class="bg-red-500">-{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->transaction_type }}</td>
                                            <td><i class="fa-solid fa-caret-up"></i> &nbsp; {{ $transaction->recipient->name ?? "CASHOUT" }}</td> <!-- Accessing recipient's name -->
                                            <td>{{ $transaction->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach

                                    <!-- Transactions where the user received money -->
                                    @foreach(Auth::user()->received_transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td class="bg-warning">+{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->transaction_type }}</td>
                                            <td><i class="fa-solid fa-caret-down"></i> &nbsp;{{ $transaction->sender->name?? 'CASHOUT™️' }}</td> <!-- Accessing sender's name -->
                                            <td>{{ $transaction->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>



                            <!-- Display User Referrals -->
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold">{{ __('Referrals') }}</h3>
                                <section>
                                    @if(count( Auth::user()->referrals)<=0)
                                        <div class="text-center p-1 m-2 sm:p-6 sm:m-6 rounded-lg shadow-sm border border-base-100 hover:bg-base-100">
                                            <div class="my-3 text-lg">You have no referrals</div>
                                            <div class="text-gray-500">
                                                You can use your referral link or code to invite your friends to join the platform. You will earn 10% of their earnings for life.
                                                <div class="mt-4">
                                                    <div class="mb-2">Your Referral Code is: <span class="font-bold text-blue-600">{{ Auth::user()->referral_code }}</span></div>
                                                    <button class="btn btn-blue btn-circle ring ring-orange-700" onclick="copyToClipboard('{{ Auth::user()->referral_code }}')"><i class="fas fa-copy"></i></button>
                                                    <div class="mt-4">You can also use the link below to invite your friends.</div>
                                                    <p class="mt-2">{{ route('register', ['ref' => Auth::user()->referral_code]) }}</p>
                                                    <button class="btn btn-blue btn-circle ring ring-blue-700 mt-2" onclick="copyToClipboard('{{ route('register', ['ref' => Auth::user()->referral_code]) }}')"><i class="fas fa-copy"></i></button>
                                                </div>
                                            </div>
                                        </div>


                                    <script>
                                        function copyToClipboard(text) {
                                            navigator.clipboard.writeText(text)
                                                .then(() => alert('Copied to clipboard ⚡'))
                                                .catch((error) => console.log('Failed to copy to clipboard: ', error));
                                        }
                                    </script>

                                    @else

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
                                                <span class="text-sm">
                                                    {{ $referral->created_at->diffForHumans() }}
                                                </span>
                                            </td>
                                            <td>{{ $referral->status }}</td>
                                        </tr>
                                    @endforeach
                                            </tbody>
                                            <!-- foot -->
                                        </table>
                                        </div>
                                    @endif
                                </section>
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

            var seconds = (timeDiff % 60).toString().padStart(2, "0"); // extract seconds
            timeDiff = Math.floor(timeDiff / 60); // convert to minutes
            var minutes = (timeDiff % 60).toString().padStart(2, "0"); // extract minutes
            timeDiff = Math.floor(timeDiff / 60); // convert to hours
            var hours = (timeDiff % 24).toString().padStart(2, "0"); // extract hours
            var days = Math.floor(timeDiff / 24); // extract days

            var timeOnline = '';
            if(days > 0) {
                timeOnline += days + 'd ';
            }
            timeOnline += hours + 'h ' + minutes + 'm ' + seconds + 's';

            document.getElementById('timeOnline').textContent = timeOnline;
        }

        setInterval(updateTime, 1000); // update every second
    </script>



</x-app-layout>
