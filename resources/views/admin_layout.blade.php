<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="base-url" content="{{url('/')}}">
    <title>SOMA | @yield('title')</title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper" id="main-app">
    <div v-if="!!$store.getters.PRE_LOADER" class="text-center" style="margin: 100px;">
        <app-spinner size="fa-2x"></app-spinner>
    </div>
    <template v-else>
        <!-- Navbar -->
        <app-main-navbar title="@yield('title')"></app-main-navbar>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <app-main-sidebar></app-main-sidebar>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Main Footer -->
        <app-main-footer></app-main-footer>
    </template>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<script src="{{mix('js/app.js')}}" async></script>
</body>
</html>
