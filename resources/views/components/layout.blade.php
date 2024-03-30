<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[SVG]Savages]</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Inter, sans-serif;
        }
        .header, .footer {
            background-color: #333;
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
    </style>
</head>
<body>

<div class="header">
    <h1>[SVG]Savages</h1>
</div>

<div class="main">
    {{ $slot }}
</div>

{{--<div class="footer">--}}
{{--    <p>Footer</p>--}}
{{--</div>--}}

</body>
</html>
