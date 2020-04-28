<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <meta name="base-url" content="{{url('/')}}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>E-Exam</title>
        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <v-app id="inspire">
                <v-app-bar app absolute color="indigo" dark>
                    <v-spacer></v-spacer>
                </v-app-bar>
                <v-content>
                    <v-container fill-height>
                        <app-exam slug="{{$slug}}"></app-exam>
                    </v-container>
                </v-content>
            </v-app>
        </div>
    <script src="/js/app.js"></script>
    </body>
</html>
