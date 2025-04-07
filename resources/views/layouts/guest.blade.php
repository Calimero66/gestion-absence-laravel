<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Student Absence Management') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full bg-gray-50 dark:bg-gray-900">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                            AbsenceMS
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-20 sm:pt-16 pb-8">
            <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-800 shadow-lg overflow-hidden sm:rounded-lg border border-gray-200 dark:border-gray-700">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} Student Absence Management System. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>