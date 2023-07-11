<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Tailwind CSS -->
        <title>Cashout</title>
        <script src="https://kit.fontawesome.com/af6aba113a.js" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .swiper-slide {
                height: 80.7vh; /* 2/3 of viewport height */
            }
            .swiper-slide img {
                height: 100%;
                width: 100%;
                object-fit: cover;
            }
        </style>
    </head>
    <body class="bg-gray-100 h-screen antialiased leading-none">

    <div class="navbar sticky top-0 z-50 bg-base-100 px-6">
        <div class="navbar-start">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a>Homepage</a></li>
                    <li><a>Portfolio</a></li>
                    <li><a>About</a></li>
                </ul>
            </div>
        </div>
        <div class="navbar-center">
            <p class="normal-case text-xl">Cashout</p>
        </div>
        <div class="navbar-end">
            <button class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </button>
            <button class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    <span class="badge badge-xs badge-primary indicator-item"></span>
                </div>
            </button>
        </div>
    </div>


    <div class="mx-auto max-w-7xl">
        <main class="">
            <!-- Swiper -->
            <div class="swiper-container relative">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide bg-[url('C:/Apps/cashout/public/images/cashout.svg')] h-fit">
                        {{--<img height="screen" src="/images/dark2.jpg" class="w-full min-h-64 object-cover" alt="image description">--}}
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                            <h1 class="text-2xl font-semibold text-white">Welcome to Our Cashout</h1>
                            <p class="text-white mt-2">The next level game changing Cash Platform</p>
                            <div class="space-x-4 flex items-center justify-center mt-4">
                                <!-- Register and login buttons with icons -->
                                <a href="{{ route('register') }}" class="">
                                    <button class="btn btn-warning backdrop-blur-md ring-offset-2 rounded-full btn-outline ring-2">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Register
                                    </button>
                                </a>
                                <a href="{{ route('login') }}" class="btn backdrop-blur-md btn-success rounded-full btn-outline ring-2 ring-offset-2 text-base-100">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Login
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="custom-shape-divider-bottom-1689080022">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
                        </svg>
                    </div>

                    <!-- Add more slides as needed -->
                </div>

            </div>

            <div>

            </div>
        </main>
    </div>

    <!-- Swiper JS -->

    <!-- Scripts -->
    </body>
</html>
