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
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if(isset($header) || isset($telegram))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center space-x-4">
                        <div>
                            @isset($header)
                                {{ $header }}
                            @endisset
                        </div>
                        <div>
                            @isset($telegram)
                                {{ $telegram }}
                            @endisset
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-6">

                        @isset($sidebar)
                            <aside class="w-1/4">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                                    {{ $sidebar }}
                                </div>
                            </aside>
                        @endisset

                        <div class="flex-1">
                            {{ $slot }}
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
