<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Tailwind CSS -->
        <title>Cashout</title>
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="robots" content="index, follow">
        <meta name="language" content="English">
        <meta property="og:title" content="Cashout Kenya">
        <meta property="og:description" content="
        Cashout Kenya is a community of people who are tired of online scams and are looking for a legit way to make money online.
        ">
        <meta property="og:image" content="{{asset('images/Cash Type Blend.png')}}">
        <meta property="og:url" content="https://cashout.co.ke/">

        <meta name="twitter:card" content="{{asset('images/Cash Type Blend.png')}}">
        <meta name="twitter:site" content="@cashoutkenya">
        <meta name="twitter:title" content="Cashout Kenya">
        <meta name="twitter:description" content="
        Cashout Kenya is a community of people who are tired of online scams and are looking for a legit way to make money online."/>
        <meta name="twitter:image" content="{{asset('images/Cash Type Blend.png')}}">



        <link rel="icon" href="{{ asset('images/fav.png') }}" type="image/png" sizes="16x16">
        <meta aria-description="
        Cashout Kenya is a community of people who are tired of online scams and are looking for a legit way to make money online.
CAUTION: This is not a get rich quick scheme. You will have to work hard to make money. However, we will provide you with the tools and resources you need to succeed.">

        <!--details for search engines-->
        <meta name="description" content="Cashout Kenya is a community of people who are tired of online scams and are looking for a legit way to make money online.
CAUTION: This is not a get rich quick scheme. You will have to work hard to make money. However, we will provide you with the tools and resources you need to succeed.">

        <meta name="keywords" content="cashout kenya, cashoutkenya, cashout, kenya, cash, cashout.com,
        cashoutkenya.com, cashoutkenya.co.ke, cashoutkenya.co.ke, cashoutkenya.co.ke, cashoutkenya.co.ke,
        pesa, withdraw, money, make money, make money online, make money online in kenya, make money online in kenya,
        make money online in kenya, make money online in kenya, make money online in kenya, make money online in kenya,
        free, free money, free money online, free money online in kenya, free money online in kenya,
        earn, earn money, earn money online, earn money online in kenya, earn money online in kenya,
        easy, easy money, easy money online, easy money online in kenya, easy money online in kenya," />
        <script src="https://kit.fontawesome.com/af6aba113a.js" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- add assets -->
{{--        <link rel="stylesheet" href="{{ secure_asset('/app.css') }}">
        <script src="{{ secure_asset('/app.js') }}" defer></script>--}}
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
                <a href="{{ route('about') }}" tabindex="0" class="btn btn-ghost btn-circle">
                    <i class="fa-solid fa-2x fa-circle-info"></i>
                </a>
            </div>
        </div>
        <div class="navbar-center">
            <a href="{{ route('dashboard') }}" >
                <img src="{{ asset('images/Cash Type Blend.png') }}" alt="Cashout" class="w-28 sm:w-32">
            </a>
        </div>
        <div class="navbar-end">

            <button class="btn btn-ghost btn-circle">
                <i class="fa-brands fa-2x fa-github"></i>
            </button>

            <button class="btn fa-2x btn-ghost btn-circle">
                    <i class="fa-brands fa-2x fa-whatsapp"></i>
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
                    <div style="background: url('{{ secure_asset('images/cashout.svg') }}')" class="swiper-slide bg-[url('C:/Apps/cashout/public/images/cashout.svg')] h-fit">
                        {{--<img height="screen" src="/images/dark2.jpg" class="w-full min-h-64 object-cover" alt="image description">--}}
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                            <h1 class="text-2xl font-semibold text-white">Welcome to Our Cashout</h1>
                            <p class="text-white mt-2">The next level game changing Cash Platform</p>
                            <div class="space-x-4 flex items-center justify-center mt-4">
                                <!-- Register and login buttons with icons -->
                                <a href="{{ route('register') }}" class="">
                                    <button class="btn normal-case w-[120px] btn-warning backdrop-blur-md ring-offset-2 rounded-full btn-outline ring-2">
                                        <i class="fas fa-user-plus mr-1"></i>
                                        Register
                                    </button>
                                </a>
                                <a href="{{ route('login') }}" class="btn w-[120px] normal-case backdrop-blur-md btn-success rounded-full btn-outline ring-2 ring-offset-2 text-base-100">
                                    <i class="fas fa-sign-in-alt mr-1"></i>
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

    <!-- Google Analytics -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('send', 'pageview');
</script>
<!-- End Google Analytics -->

    <!-- Google Analytics -->
<script>
    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>
<!-- End Google Analytics -->

    <!-- Scripts -->
    </body>
</html>
