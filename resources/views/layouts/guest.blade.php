<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="https://kit.fontawesome.com/af6aba113a.js" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                         width="100px" height="100px" viewBox="0 0 2139.000000 2008.000000"
                         preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,1500.000000) scale(0.0700000,-0.0700000)"
                           fill="" stroke="none">
                            <path fill="blue" d="M10595 19074 c-422 -25 -600 -42 -900 -85 -561 -80 -1036 -192 -1580
                            -374 -1139 -380 -2155 -964 -3080 -1769 -199 -173 -659 -632 -829 -828 -806
                            -927 -1391 -1944 -1771 -3083 -249 -744 -379 -1402 -447 -2255 -16 -204 -16
                            -996 0 -1200 68 -853 198 -1511 447 -2255 584 -1748 1687 -3268 3175 -4374
                            1345 -1000 2941 -1602 4615 -1741 591 -49 1185 -39 1790 31 1149 131 2293 497
                            3304 1058 1269 704 2336 1687 3142 2893 155 232 175 279 166 385 -6 85 -44
                            159 -111 220 -37 34 -474 290 -1457 858 -772 446 -1440 828 -1483 850 -75 37
                            -85 40 -165 40 -156 -1 -212 -43 -391 -295 -588 -825 -1476 -1481 -2444 -1805
                            -549 -184 -1015 -259 -1606 -259 -318 0 -433 7 -710 45 -1609 223 -3029 1248
                            -3764 2716 -282 564 -443 1133 -508 1798 -16 170 -16 712 0 875 46 443 117
                            781 248 1169 418 1238 1323 2275 2501 2865 564 282 1134 443 1798 508 169 16
                            701 16 870 0 853 -84 1605 -343 2290 -790 559 -365 1063 -862 1433 -1414 57
                            -84 92 -116 168 -149 66 -30 178 -31 249 -2 79 31 2946 1691 2983 1726 18 18
                            50 65 70 106 33 66 37 83 37 150 0 67 -5 85 -37 153 -68 143 -396 610 -641
                            911 -273 337 -736 818 -1052 1093 -925 805 -1941 1389 -3080 1769 -739 247
                            -1401 379 -2240 446 -129 10 -874 20 -990 13z"/>
                                                        <path fill="green" d="M19100 13167 c-25 -7 -84 -35 -130 -61 -498 -287 -2930 -1692 -2960
                            -1711 -45 -29 -82 -74 -109 -136 -34 -78 -35 -121 -2 -319 56 -342 65 -461 66
                            -855 0 -396 -11 -537 -66 -865 -21 -120 -28 -191 -24 -225 9 -69 58 -168 104
                            -207 41 -35 2973 -1732 3070 -1776 109 -51 252 -30 349 52 85 73 171 311 306
                            851 350 1405 350 2925 0 4330 -124 498 -208 742 -285 829 -68 78 -218 122
                            -319 93z"/>
                        </g>
                    </svg>
                </a>
            </div>

            <div>
                <img width="200px" src="./images/Cash Type Blend.png" alt="">
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-900 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
