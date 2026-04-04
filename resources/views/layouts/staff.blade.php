<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Komditi Part {{$title ?? 'Dashboard'}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">
    @include('components.header')
    @include('components.alert')
    <x-sidebar />
    <main class="flex-1 ml-64 p-6 md:p-8 lg:p-10">
        <div class="container max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>