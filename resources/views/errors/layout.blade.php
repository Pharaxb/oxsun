<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/sass/dashboard.scss', 'resources/js/dashboard.js', 'resources/js/charts.js'])

    <!-- Google Fonts (Vazirmatn) -->
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">


</head>
<body>
<main class="container-fluid">
    @yield('content')
</main>
</body>
</html>
