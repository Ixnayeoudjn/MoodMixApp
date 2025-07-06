<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MoodMix</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* ... keep your inline Tailwind CSS here ... */
        </style>
    @endif
</head>
<body class="text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="flex-1"></div>
    <div class="flex items-end justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 mt-12 lg:mt-24 flex-1">
        <main class="fade-in-up flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            <div class="flex-1 p-6 pb-2 lg:p-20 dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none flex flex-col items-center justify-center">
                <div class="flex flex-col items-center w-full justify-center gap-4 h-full min-h-[250px]">
                    <div class="flex items-center justify-center gap-6 mt-8">
                        <img src="{{ asset('logo.png') }}" alt="MoodMix Logo" class="h-32 w-32 object-contain" />
                        <h1 class="text-7xl font-black text-center text-[#D0C408]">MoodMix</h1>
                    </div>
                    @if (Route::has('login'))
                        <nav class="flex items-center justify-center gap-2 mt-2">
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="inline-block px-7 py-3 dark:text-[#EDEDEC] text-[#ffff] rounded-[50px] text-lg leading-normal bg-[#241b11] hover:bg-[#352c23] transition-colors font-inter"
                                    style="font-family: 'Inter', sans-serif;"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-block px-7 py-3 dark:text-[#EDEDEC] text-[#ffff] rounded-[50px] text-lg leading-normal bg-[#241b11] hover:bg-[#352c23] transition-colors font-inter"
                                    style="font-family: 'Inter', sans-serif;"
                                >
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-block px-7 py-3 dark:text-[#EDEDEC] text-[#ffff] rounded-[50px] text-lg leading-normal bg-[#241b11] hover:bg-[#352c23] transition-colors font-inter"
                                        style="font-family: 'Inter', sans-serif;"
                                    >
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
            <div class="bg-[#fff2f2] dark:bg-[#1D0002] relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden hidden"></div>
        </main>
    </div>
</body>
</html>