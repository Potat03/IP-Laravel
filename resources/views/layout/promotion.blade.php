<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Default Title')</title>
    @include('partials.fontawesome')
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
</head>

<body>
@include('header')

    <main>
        @if (isset($promotion) && $promotion->status == 'active')
            @yield('top')
            @hasSection('variation')
                @yield('variation')
            @endif
            @yield('mid')
            @yield('bundle')
            @yield('bottom')
        @else
            @include('errors.404')
        @endif
    </main>

    @stack('scripts')
</body>

</html>
