<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Broadcast Laravel Example</title>
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<main role="main" id="app" class="container">
    @yield('content')
</main>

<footer class="border-top">
    <div class="container">
        <div class="pt-3">
            <p>&copy; {{ date('Y') }} - Broadcast Laravel Example</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
