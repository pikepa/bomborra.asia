<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0-beta.0/dist/trix.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    @stack('childstyles')
    <title>{{  $title ?? 'Bomborra Studio' }}</title>

</head>

<body class="font-sans antialiased">

    <div>
        <div class="max-w-6xl p-2 mx-auto mt-2 bg-slate-200 rounded-lg">

            {{ $slot }}

        </div>
    </div>
    @livewireScripts()
 
    <!-- Scripts -->
    <script src="https://unpkg.com/trix@2.0.0-beta.0/dist/trix.umd.js"></script>

    @stack('childscripts')

</body>

</html>