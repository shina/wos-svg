<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')

    <title>{{ $alliance->full_name }}</title>
</head>

<body class="antialiased bg-gray-200 flex items-center justify-center h-screen">
<div>
    <img src="{{ Storage::url($alliance->logo) }}" alt="{{ $alliance->name }}" class="w-full h-auto">
</div>
</body>

</html>
