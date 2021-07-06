<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="base-url" content="{{url('/')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOMA - Administrator Authorization</title>
    <link rel="stylesheet" href="{{mix('css/admin.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box" id="main-app">
    <div class="login-logo">
        <a href="/">
            <img src="/images/logo.png" class="img-fluid img-rounded" alt="SOMA">
        </a>
        <div class="small">(Administrator Authorization)</div>
    </div>
    <app-login error-message="{{session()->get('error')}}"></app-login>
</div>
<script src="{{mix('js/admin.js')}}"></script>
</body>
</html>

