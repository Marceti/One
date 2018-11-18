<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>One</title>
    <!-- Styles -->
    <link href="\css\app.css" rel="stylesheet" type="text/css">

</head>
<body>

@include('layouts.partials._navbar')

@yield('content')

@include('layouts.partials._errors')
@include('layouts.partials._sessionMessages')
</body>
</html>
