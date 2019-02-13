<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Csrf-Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="/static/dist/css/bulma.min.css">
    <link rel="stylesheet" href="/static/index/css/index.css">
    <link rel="stylesheet" href="/static/common/css/eeyes_common.css">
    <title>e快下</title>
</head>
<body>
    <div id="app">
        @include('layouts._header')
        <div>
            <example></example>
        </div>
        <div class="container">
            <!-- @include('shared._messages') -->
            @yield('content')
        </div>
        @include('layouts._footer')
    </div>
    <script src="/static/index/js/index.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>