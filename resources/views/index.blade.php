<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container">Test</div>
    @if ($name)
        <div class="container">
            <h1>こんにちは、{{ $name }}さん</h1>
            <h1>GGWP</h1>
        </div>
    @endif
</body>
</html>
