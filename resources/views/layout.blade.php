<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="base-url" content="{{url('/')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOMA</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
</head>
    <body class="hold-transition sidebar-mini sidebar-collapse">
        <div class="wrapper" id="main-app">
            <app-container></app-container>
        </div>
        <script src="{{mix('js/bundle.js')}}" async></script>
        <script src="{{mix('js/app.js')}}"></script>
    </body>
</html>
