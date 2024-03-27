<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>Login | School MS</title> --}}
        @stack('title')

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> --}}

        <!-- Styles -->
        <link href="{{asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
        <!-- sweetalert -->
        <link href= "{{asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    </head>
    <body class="vh-100">
