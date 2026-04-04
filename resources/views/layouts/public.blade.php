<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Komditi Part</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">
    <header class="bg-white shadow-md sticky top-0 z-50">
        @include('components.header')
    </header>
    
    <main class="pt-4 pb-12"> 
        <div class="container mx-auto px-4 max-w-7xl">
            @isset($breadcrumbs)                
                    @include('components.breadcrumbs', ['links' => $breadcrumbs])
            @endisset

            @yield('content')
        </div>
    </main>
    @include('components.footer')
    @stack('scripts')
</body>
</html>