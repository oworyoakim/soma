@extends('errors.layout')
@section('title', '404')
@section('content')
    <div class="error-box text-center mt-5">
        <h1>404</h1>
        <h3 class="h2 mb-3"><i class="fa fa-warning"></i> Oops! Page not found!</h3>
        <p class="h4 font-weight-normal">The page you requested was not found.</p>
        <a href="/" class="btn btn-primary">Back to Home</a>
    </div>
@endsection
