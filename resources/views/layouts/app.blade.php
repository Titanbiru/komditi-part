<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komditi Part - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">    
    <script src="https://cdn.tailwindcss.com"></script>    
    <link rel="stylesheet" href="resources/css/app.css">
    <link rel="stylesheet" href="{{asset ('resources/css/app.css')}}">
</head>
<body>
    @include('components.header')
    
    <div class="container mx-auto mt-8">
        @yield('content')
    </div>
    @include('components.footer')
</body>
</html>