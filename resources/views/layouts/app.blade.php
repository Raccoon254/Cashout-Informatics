<!DOCTYPE html>
<html data-theme="{{ session('theme', 'light') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="https://kit.fontawesome.com/af6aba113a.js" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
{{--        <link rel="stylesheet" href="{{ secure_asset('/app.css') }}">
        <script src="{{ secure_asset('/app.js') }}" defer></script>--}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            <section class="z-50 custom-z sticky top-0">
                @include('layouts.navigation')
            </section>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-900 shadow">
                    <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->

            <!-- if the user account status is not verified -->

            @if(Auth::user() && Auth::user()->status == "active")

                <main class="w-full">
                    {{ $slot }}
                </main>

            @else

                <main>
                    @include('verification.index')
                </main>

            @endif
        </div>

        <script>

            const fetchUrl = "{{ route('get-theme') }}"
            const setUrl = "{{ route('set-theme') }}"
            // Function to set the theme in session

            const setThemeInSession = (theme) => {
                fetch(setUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ theme }),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to set theme in session.');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            };

            // Function to get the theme from session
            const getThemeFromSession = () => {
                return fetch(fetchUrl, {
                    method: 'GET',
                })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error('Failed to get theme from session.');
                        }
                    })
                    .then(data => {
                        return data.theme;
                    })
                    .catch(error => {
                        console.error(error);
                        return 'light'; // Default to light theme if there's an error
                    });
            };

            // Function to apply the saved theme
            const applySavedTheme = () => {
                getThemeFromSession().then(savedTheme => {
                    const html = document.querySelector('html');
                    const themeSwitch = document.querySelector('#theme-switch');

                    html.setAttribute('data-theme', savedTheme);

                    themeSwitch.checked = savedTheme === 'dark';
                    /*
                    if (savedTheme === 'dark') {
                        themeSwitch.checked = true; // Check the switch
                    } else {
                        themeSwitch.checked = false; // Uncheck the switch
                    }
                    */
                });
            };

            // Get the theme switch checkbox
            const themeSwitch = document.querySelector('#theme-switch');

            // Add a change event listener to the theme switch
            themeSwitch.addEventListener('change', () => {
                const html = document.querySelector('html');

                if (themeSwitch.checked) {
                    // If the switch is checked (dark mode)
                    html.setAttribute('data-theme', 'dark');
                    setThemeInSession('dark'); // Save the theme in session
                } else {
                    // If the switch is not checked (light mode)
                    html.setAttribute('data-theme', 'light');
                    setThemeInSession('light'); // Save the theme in session
                }
            });

            // Apply the saved theme when the page loads
            window.addEventListener('load', () => {
                applySavedTheme();
            });
        </script>


    </body>
</html>
