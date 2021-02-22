<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <meta name="base-url" content="{{url('/')}}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SOMA - Authorization</title>
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box mt-0" id="main-app">
            <div class="login-logo">
                <a href="/"><b>SOMA</b></a>
            </div>
            <app-login error-message="{{session()->get('error')}}"></app-login>
        </div>
        <script src="{{mix('js/app.js')}}"></script>
    </body>
</html>
