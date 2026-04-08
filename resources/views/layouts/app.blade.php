<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komditi Part - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">    
    <script src="https://cdn.tailwindcss.com"></script>    
    <link rel="stylesheet" href="resources/css/app.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    @include('components.header')
    
    <main class="pt-4 pb-12 bg-[#F9F9F9]">
        <div class="container mx-auto px-4 max-w-7xl bg-[#f9f9f9]">
            @yield('content')
        </div>
    </main>
    @include('components.footer')
</body>
</html>