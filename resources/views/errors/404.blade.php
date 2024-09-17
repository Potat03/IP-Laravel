<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
</head>

<body>
    <main class="container text-center mt-5">
        <h1 class="display-1">404</h1>
        <h2 class="display-4">Page Not Found</h2>
        <p class="lead mt-2">Sorry, the page you are looking for does not exist. It might have been moved or deleted.</p>
        <div class="text-center text-uppercase">
            <a class="btn btn-outline-dark btn-add-to-cart mt-auto fw-bold" href="{{ url('/home') }}">Return to
                Home</a>
        </div>
    </main>

    <!-- Scripts -->
    @stack('scripts')
</body>

</html>
