<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[SVG]Savages</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Inter, sans-serif;
        }
        .header, .footer {
            background-color: #121627;
            color: #fff;
            padding: 1em;
        }
        .align-center {
            text-align: center;
        }
        .align-right {
            text-align: right;
        }
        .main {
            padding: 1em;
        }
        @media (max-width: 600px) {
            .main, .header, .footer {
                padding: 0.5em;
            }
        }

        .logo {
            width: 15%;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="align-right">
        <x-locale-selection-selector></x-locale-selection-selector>
    </div>
    <div class="align-center">
        <picture>
            <source media="(min-width: 1200px)" srcset="{{ Storage::url($data->logo->large) }}">
            <source media="(min-width: 768px)" srcset="{{ Storage::url($data->logo->medium) }}">
            <source srcset="{{ Storage::url($data->logo->small) }}">
            <img class="logo" src="{{ Storage::url($data->logo->small) }}" alt="{{ $data->acronym }}">
        </picture>
    </div>
</div>

<div class="main">
    {{ $slot }}
</div>

</body>
</html>
