<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Komditi Part {{ $title ?? 'Dashboard' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen">

    {{-- Header Tetap Ada di Atas --}}
    @include('components.header')
    
    {{-- Notifikasi --}}
    @include('components.alert')
    
    {{-- Main Content --}}
    <main class="pt-4 pb-28 lg:pb-12 bg-[#F9F9F9]">
        <div class="container mx-auto px-4 max-w-7xl">
            
            @isset($breadcrumbs)
                @include('components.breadcrumbs', ['links' => $breadcrumbs])
            @endisset

            <div class="flex flex-col lg:flex-row gap-8 items-start relative">
    
                {{-- SIDEBAR DESKTOP --}}
                <aside class="hidden lg:block w-[300px] flex-none">
                    @include('components.sidebar.user')
                </aside>

                {{-- KONTEN UTAMA --}}
                <section class="flex-auto min-w-0 w-full">
                    @yield('content')
                </section>
                
            </div>
        </div>
    </main>
    @include('components.sidebar.bottom-nav')

    @stack('scripts')
</body>
</html> 