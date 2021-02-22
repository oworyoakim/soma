<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SOMA | Classroom | Error</title>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.9/css/bootstrap.css"/>
    <style type="text/css">
        .ma-20 {
            margin: 5% !important;
        }
        .text-x-large {
            font-size: x-large !important;
        }
    </style>
</head>

<body>
<div class="container-fluid ma-20">
    <pre class="text-danger text-x-large">{{$error}}</pre>
</div>
</body>
</html>
