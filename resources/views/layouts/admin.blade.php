<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Komditi Part {{$title ?? 'Dashboard'}}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="bg-[#F9F9F9] antialiased flex flex-col min-h-screen">
    @include('components.header')
    @include('components.alert')
    
    {{-- Overlay untuk klik di luar sidebar (Hanya muncul di HP saat menu buka) --}}
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-[45] hidden lg:hidden transition-opacity"></div>

    <div class="flex">
        <x-sidebar />

        {{-- Margin kiri (ml-64) hanya aktif di layar desktop (lg:ml-64) --}}
        {{-- pt-16 agar konten tidak tertutup header yang fixed --}}
        <main class="flex-1 w-full pt-2 min-h-screen transition-all duration-300 lg:ml-64">
            <div class="p-6 md:p-8 lg:p-10">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            // Toggle translate untuk sliding effect
            sidebar.classList.toggle('-translate-x-full');
            // Toggle overlay
            overlay.classList.toggle('hidden');
        }

        // Tutup sidebar otomatis jika user melebarkan layar ke desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                document.getElementById('mainSidebar')?.classList.remove('-translate-x-full');
                document.getElementById('sidebarOverlay')?.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>