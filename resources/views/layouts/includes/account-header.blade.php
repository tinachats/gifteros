<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/app/visionaries-logo.png') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Material-Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/material-design-icons/iconfont/material-icons.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('plugins/Ionicons/css/ionicons.min.css') }}">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- AnimatesCSS -->
    <link rel="stylesheet" href="{{ asset('plugins/animate.css/animate.min.css') }}">
    <!-- iziToast -->
    <link rel="stylesheet" href="{{ asset('plugins/iziToast/css/iziToast.min.css') }}">
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/gifteros.min.css') }}">
</head>
<body class="account-page">
    <div class="container-fluid my-2">
        <div class="d-grid">
            <div class="m-auto">
                <a href="/" class="d-flex align-items-center justify-content-center">
                    <img src="{{ asset('img/app/visionaries-logo.png') }}" alt="Gifteros Logo" height="50" width="50">
                    <h2 class="app-name my-0 py-0 font-600 display-5 ml-1">{{ config('app.name') }}</h2>
                </a>