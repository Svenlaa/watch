<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($attributes['name'])
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl pb-1 text-gray-800 leading-tight">
                    {{ $attributes['name'] }}
                </h2>
                @isset($attributes['bread'])
                    <ul class="flex flex-row gap-1 font-medium text-sm text-gray-500">
                        @foreach($attributes['bread'] as $route => $display)
                            <li><a href="{{Route::has($route) ? route($route) : $route}}"
                                   class="hover:text-primary-600">{{$display}}</a></li>
                            {{$loop->last ? '' : '-'}}
                        @endforeach
                    </ul>
                @endisset
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main {{$attributes->except(['name', 'bread'])}}>
        {{ $slot }}
    </main>
</div>
</body>
</html>
