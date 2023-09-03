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
                            <button class="btn ring ring-blue-700 btn-circle hover:bg-base-100">
                                <i class="fa-solid fa-user"></i>
                            </button>
                            <button class="btn hover:bg-base-100 ring ring-orange-700 btn-circle">
                                <i class="fa-solid fa-bell"></i>
                            </button>
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
            </div>
        </section>
    </div>

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
