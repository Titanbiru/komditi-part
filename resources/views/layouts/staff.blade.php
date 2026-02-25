<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komditi Part - Home</title>
    <link rel="stylesheet" href="{{asset ('public/css/app.css')}}">
    
</head>
<body>
    @include('components.header')
    
    <div class="container mx-auto mt-8">
        @yield('content')
    </div>

</body>
</html>