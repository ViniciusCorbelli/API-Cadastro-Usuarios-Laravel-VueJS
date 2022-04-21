<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Grupo Plan Marketing</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

</head>

<body>
    <div id="app">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
