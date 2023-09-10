<x-app-layout>
    <div class="flex">
        <section class="z-50">
            @include('admin.sidebar')
        </section>

        <section class="px-4 w-full">

            <section class="prose welcome mb-4">
                <h1 class="text-2xl font-semibold m-3">
                    Hello  {{ Auth::user()->name }}<br>
                    <span class="text-xl text-gray-400">Welcome to the admin dashboard</span>
                </h1>
            </section>


            <div class="mb-4 w-full flex flex-wrap gap-4">

                <div class="card w-full sm:w-5/12 p-0 rounded bg-base-100 border-gray-200 border-2 shadow-md ">
                    <div class="card-body m-[-10px]">
                        <h2 class="card-title">Admin</h2>
                        <p class="text-base-content">Welcome back, {{ Auth::user()->name }}!</p>
                        <p class="text-sm text-gray-400 italic">
                            Elevated permissions allow you to manage users, posts, and more.
                        </p>
                        <div class="card-actions gap-3 justify-end">

                            <a href="{{ route('users.index') }}">
                                <button class="btn ring ring-blue-700 btn-circle hover:bg-base-100">
                                    <i class="fa-solid fa-user"></i>
                                </button>
                            </a>

                            <a href="{{ route('notifications.index') }}">
                                <button class="btn hover:bg-base-100 ring ring-orange-700 btn-circle">
                                    <i class="fa-solid fa-bell"></i>
                                </button>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="card w-full sm:w-5/12 p-0 rounded border-gray-200 border-2 bg-base-100 shadow-md ">
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

                    <!-- Earnings Chart -->
                    <div class="card w-full sm:w-5/12 p-0 rounded border-gray-200 border-2 bg-base-100 shadow-md " id="earnings-chart">
                        <center>
                            Earnings with time
                        </center>
                    </div>

                    <!-- User Counts Chart -->
                    <div class="card w-full sm:w-5/12 p-0 rounded border-gray-200 border-2 bg-base-100 shadow-md " id="user-counts-chart">
                        <center>
                            User counts per type
                        </center>
                    </div>

                    <!-- Transactions Chart -->
                    <div class="card w-full sm:w-5/12 p-0 rounded border-gray-200 border-2 bg-base-100 shadow-md " id="transactions-chart">
                        <center>
                            Transaction amounts with time
                        </center>
                    </div>
            </div>



        </section>
    </div>

    <!-- Include ApexCharts CDN Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.29.0/dist/apexcharts.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.29.0/dist/apexcharts.min.js"></script>


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


        // Data
        var earningsData = @json($earnings);
        var userCountsData = @json($userCounts);
        var transactionsData = @json($transactions);

        // Earnings Chart
        var earningsOptions = {
            chart: {
                type: 'line',
                height: 350
            },
            series: [{
                name: 'Earnings',
                data: earningsData.map(item => item.total_amount)
            }],
            xaxis: {
                categories: earningsData.map(item => shortenDate(item.created_at))
            }
        }

        var earningsChart = new ApexCharts(document.querySelector("#earnings-chart"), earningsOptions);
        earningsChart.render();

        // User Counts Chart
        var userCountsOptions = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'User Counts',
                data: userCountsData.map(item => item.count)
            }],
            xaxis: {
                categories: userCountsData.map(item => item.type)
            }
        }

        var userCountsChart = new ApexCharts(document.querySelector("#user-counts-chart"), userCountsOptions);
        userCountsChart.render();

        // Transactions Chart
        var transactionsOptions = {
            chart: {
                type: 'area',
                height: 350
            },
            series: [{
                name: 'Total Amount',
                data: transactionsData.map(item => item.total_amount)
            }],
            xaxis: {
                categories: transactionsData.map(item => shortenDate(item.date))
            }
        }

        function shortenDate(date) {
            //return only the month and day and time hh:mm
            return date.substring(5, 16);
        }

        var transactionsChart = new ApexCharts(document.querySelector("#transactions-chart"), transactionsOptions);
        transactionsChart.render();
    </script>
</x-app-layout>
