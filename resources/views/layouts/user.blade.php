<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Komditi Part {{ $title ?? 'Dashboard' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen">

    {{-- Header Tetap Ada di Atas --}}
    @include('components.header')
    
    {{-- Notifikasi --}}
    @include('components.alert')
    
    {{-- Main Content --}}
    <main class="pt-4 pb-12">
        <div class="container mx-auto px-4 max-w-7xl">
            {{-- Gunakan Flex untuk membagi Kiri (Sidebar) dan Kanan (Content) --}}
            @isset($breadcrumbs)
                @include('components.breadcrumbs', ['links' => $breadcrumbs])
            @endisset
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Bagian Sidebar --}}
                @include('components.sidebar.user') {{-- Pastikan path ini benar! --}}

                {{-- Bagian Konten Utama --}}
                <div class="flex-1">
                    @yield('content')
                </div>
                
            </div>
        </div>
    </main>

    @stack('scripts')
</body>
</html> 