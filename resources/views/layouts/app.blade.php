<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

               <!-- Toast -->
               <div
               x-data="toast"
               x-show="visible"
               x-transition
               x-cloak
               @notify.window="show($event.detail.message)"
               class="fixed w-[400px] left-1/2 -ml-[200px] top-20 py-2 px-4 pb-4 bg-emerald-500 text-white z-10 text-center"
             >
               <div class="font-semibold" x-text="message"></div>
               <button
                 @click="close"
                 class="absolute flex items-center justify-center right-2 top-2 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors"
               >
                 <svg
                   xmlns="http://www.w3.org/2000/svg"
                   class="h-6 w-6"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke="currentColor"
                   stroke-width="2"
                 >
                   <path
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     d="M6 18L18 6M6 6l12 12"
                   />
                 </svg>
               </button>
             </div>
             <!--/ Toast -->
        </div>

    </body>
</html>
