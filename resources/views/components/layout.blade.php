<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[SVG]Savages</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
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
            text-align: center;
            padding: 1em;
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
{{--    <h1>[SVG]Savages</h1>--}}
    <picture>
        <source media="(min-width: 1200px)" srcset="layout/logo-large.jpg">
        <source media="(min-width: 768px)" srcset="layout/logo-medium.jpg">
        <source srcset="layout/logo-small.jpg">
        <img class="logo" src="layout/logo-small.jpg" alt="SVG">
    </picture>
</div>

<div class="main">
    {{ $slot }}
</div>

{{--<div class="footer">--}}
{{--    <p>Footer</p>--}}
{{--</div>--}}

</body>
</html>
