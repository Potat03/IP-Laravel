<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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