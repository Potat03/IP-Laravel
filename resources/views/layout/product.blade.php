{{-- 
    Author: Lim Weng Ni
    Date: 20/09/2024
--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    @include('header')
    
    <main>
        @if (isset($product) && $product->status == 'active')
            @yield('top')

            @hasSection('variation')
                @yield('variation')
            @endif

            @yield('mid')

            {{-- @hasSection('bundle')
                @yield('bundle')
            @endif --}}

            @yield('bottom')
        @else
            @include('errors.404')
        @endif
    </main>

    @stack('scripts')
</body>

</html>
