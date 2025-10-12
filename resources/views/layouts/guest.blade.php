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
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-6" style="background-image: url('{{ asset('main-bg.png') }}'); background-size: cover; background-position: center;">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-[#c4b537]" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 shadow-lg overflow-hidden sm:rounded-3xl" style="background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); color: white;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
