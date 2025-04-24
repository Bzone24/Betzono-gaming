<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Bzone24 - Gaming & Betting with cryptocurrency, betting with crypto </title>
    <meta name="description" content="Gaming & Betting with cryptocurrency" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/img/favicon.png')}}" />

    <link rel="stylesheet" href="{{ asset('assets/front/css/plugins.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/default.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/color/color-04.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/gden-icon.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css')}}" />
</head>

<body>

    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader Section Start -->
    <div class="preloader">
        <div class="loader">
            <div class="spinner">
                <div class="spinner-container">
                    <div class="spinner-rotator">
                        <div class="spinner-left">
                            <div class="spinner-circle"></div>
                        </div>
                        <div class="spinner-right">
                            <div class="spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Section End -->

    <!-- Header Section Start -->
    <header class="header">
        <div class="navbar-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="index.html"><img src="{{ asset('assets/front/img/logo/logo.png')}}"
                                    alt="Logo" /></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="page-scroll active" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#game">Game</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#faq">FAQ</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="page-scroll" href="#deposit">deposit</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#partners">partners</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#crypto">crypto support</a>
                                    </li> --}}

                                    @auth
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn--base me-sm-3 me-2 btn--capsule {{ menuActive('user.home') }} px-3" href="{{ route('user.home') }}">@lang('Dashboard')</a> </li>
                                        <li class="nav-item">
                                        <a class="fs--14px me-sm-3 me-2 text-white" href="{{ route('user.logout') }}">@lang('Logout')</a>
                                    </li>
                                    @else
                                    <li class="nav-item">
                                        <a class="btn btn-sm btn--base me-sm-3 me-2 btn--capsule px-3" href="{{ route('user.login') }}">@lang('Login')</a> </li>
                                        <li class="nav-item">
                                        <a class="fs--14px me-sm-3 me-2 text-white" href="{{ route('user.register') }}">@lang('Register')</a>
                                    </li>
                                    @endauth



                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
