<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="base-url" content="{{url('/')}}">
    <!-- Favicon -->
    <link href="/images/favicon.png" rel="icon">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{mix('css/site-theme.css')}}">
    <link rel="stylesheet" href="{{mix('css/site.css')}}">
    <title>SOMA | @yield('title')</title>
</head>
<body class="account-page">
<!-- Main Wrapper -->
<div class="main-wrapper" id="site-app">
    <!-- Page Content -->
    <div class="bg-pattern-style">
        <div class="content">
            <div class="account-content">
                <div class="account-box">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Main Wrapper -->
<!-- App JS -->
<script src="{{mix('js/site.js')}}"></script>
</body>
</html>
