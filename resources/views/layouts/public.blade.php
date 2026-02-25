<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Komditi Part</title>
    <link rel="stylesheet" href="{{asset ('public/css/app.css')}}">
    
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">
    @include('components.header')
    <div class="container mx-auto mt-8">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>