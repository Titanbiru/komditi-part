<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Komditi Part</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">
    <header class="bg-white shadow-md sticky top-0 z-50">
        @include('components.header')
    </header>
    
    <main class="pt-4 pb-12 bg-[#f9f9f9]"> 
        <div class="container mx-auto px-4 max-w-7xl bg-[#f9f9f9]">
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