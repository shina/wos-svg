<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')

    <title>[SVG]Savages</title>
</head>

<body class="antialiased bg-gray-200 flex items-center justify-center h-screen">
<div>
    <img src="{{ asset('layout/logo-large.jpg') }}" alt="Savages" class="w-full h-auto">
</div>
</body>

</html>
