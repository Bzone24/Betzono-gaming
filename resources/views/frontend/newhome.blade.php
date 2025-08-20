<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Betzono - Big Wins Start Here - Sports Betting & Casino Games Play with cryptocurrency,Usdt  </title>
    <meta name="description" content="Gaming & Betting with cryptocurrency" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/newhome/img/favicon.png')}}" />

    <link rel="stylesheet" href="{{ asset('assets/newhome/css/plugins.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/newhome/css/default.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/newhome/css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/newhome/css/color/color-04.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/newhome/css/gden-icon.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/newhome/css/responsive.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>


    @php 
    if(Auth::check()){
     $autologinUrl = Auth::user()->fast_create_url;
    }else{
      $autologinUrl = url('user/login');
    }
    
    @endphp
    <input type="hidden" id="authUsername" name="username" value="{{ auth()->check() ? auth()->user()->username : '' }}">
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
                        <nav class="navbar navbar-expand-lg justify-content-between">
                            <a class="navbar-brand" href="{{url('/')}}"><img src="{{ asset('assets/newhome/img/logo/logo.png')}}"
                                    alt="Logo" /></a>
                            <div class="d-flex align-items-center gap-3 gap-lg-5">
                              
                            @auth
                            <div class="nav-item">
                                    <a class="text-white btn-login-all" href="{{ route('user.home') }}">Dashboard</a>
                                </div>
                                <div class="nav-item">
                                    <a href="{{ route('user.logout') }}" class="px-4 main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Logout</a>
                                </div>
                            @else
                                 <div class="nav-item">
                                    <a class="text-white btn-login-all" href="{{ route('user.login') }}">Login</a>
                                </div>
                                <div class="nav-item">
                                    <a href="{{ route('user.register') }}" class="px-4 main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Register</a>
                                </div>

                            @endauth
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    
    <!-- Header Section End -->

    <!-- Hero Section Start -->
    <section id="home" class="hero-section go-zoom-1">
        <div class="container">
            <div id="carouselExampleCaptions" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row align-items-center">
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="hero-content top-greadient">
                                    <!--<span class="wow fadeInLeft mb-20" data-wow-delay=".2s">Welcome To Betzono</span>-->
                                    <h1 class="wow fadeInUp" data-wow-delay=".2s">
                                        <span class="common-gre-color">Play & Win </span> Money Unlimited
                                    </h1>
                                    <p class="wow fadeInUp" data-wow-delay=".2s">Play Sports and Live Casino Games. Your Gaming Destination.</p>
                                    <a href="#" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Play Now!</a>
                                    <a href="#" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Sign Up</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a href="#">
                                    <div class="hero-img wow fadeInRight" data-wow-delay=".2s">
                                        <img src="{{ asset('assets/newhome/img/hero/main-1.png')}}" alt="">
                                        {{-- <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/6e628b9e-0172-484d-7725-edef8ba79f00/hero" alt=""> --}}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="hero-content top-greadient">
                                    <!--<span class="wow fadeInLeft mb-20" data-wow-delay=".2s">Sports Betting</span>-->
                                    <h1 class="wow fadeInUp" data-wow-delay=".2s">
                                        <span class="common-gre-color">Live Casino</span> Play & Earn Big
                                    </h1>
                                    <p class="wow fadeInUp" data-wow-delay=".2s">Enjoy Your Favourite game on lucky table.</p>
                                    <a href="https://cric.Betzono.com/" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Play Now!</a>
                                    <a href="https://Betzono.com/user/register" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Sign Up</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a href="#">
                                    <div class="hero-img wow fadeInRight" data-wow-delay=".2s">
                                       <img src="{{ asset('assets/newhome/img/hero/main-sports.png')}}" alt="">
                                         {{-- <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/d4c546d8-bfa9-45d3-8338-a6db2b827b00/hero" alt=""> --}}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="hero-content top-greadient">
                                    <!--<span class="wow fadeInLeft mb-20" data-wow-delay=".2s">Live Casino</span>-->
                                    <h1 class="wow fadeInUp" data-wow-delay=".2s">
                                         <h1 class="wow fadeInUp" data-wow-delay=".2s">
                                        <span class="common-gre-color">Sports Betting</span> with Betzono
                                    </h1>
                                    <p class="wow fadeInUp" data-wow-delay=".2s">Pre- match and In play Match with Best Odds</p>
                                       
                                    <a href="https://Betzono.com/livecasino" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Play Now!</a>
                                    <a href="https://Betzono.com/user/register" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Sign Up</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a href="#">
                                    <div class="hero-img wow fadeInRight" data-wow-delay=".2s">
                                       <img src="{{ asset('assets/newhome/img/hero/main-casino.png')}}" alt="">
                                         {{-- <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/9dd96d18-6eea-4194-867e-17bca5133f00/hero" alt=""> --}}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    
      <!-- SLIDERS -->
   <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">play Now</h2>
                <div id="slots-slider" class="owl-carousel">
                    <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                        <a href="https://betzono.com/trending-games">
                        <!--<a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_ARou">-->
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/casino-main1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/5bd7df23-8f7a-4755-7249-5f6a66ac5800/main" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                             <!--<a href="https://cric.stakeye.com/">-->
                             <a href="https://betzono.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/sports-main1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/1199e866-d0e3-4525-9cdb-5a2d0192a100/main" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                     <div class="post-slide">
                        @if(Auth::check())
                        <a href="#" class="lobby-game">
                         <a href="{{route('games.play-game','aviator')}}"> 
                        @else
                        <a href="{{route('user.login')}}">
                        @endif
                        
                            <div class="post-img">
                                
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/24e61645-a357-47d9-62ed-4826eab04900/main" alt="slide"> 
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_hndlightrout">
                            <div class="post-img">
                                <!--golden balls banner   lucky ball-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/414fe23e-3a8e-498a-2f3f-8bf316d59e00/main" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                        @if(Auth::check())
                        <a href="{{route('games.play-game','number_prediction')}}">
                        @else
                        <a href="{{route('user.login')}}">
                        @endif
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/satta.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/72d2a87f-60ef-4576-c77d-049bc6994700/main" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
            </div>
        </div>
    </div>
  
  
                    </section>
                    
                    
            

    
    
      <!-- SLIDERS -->
     <div class="container set-none-slider-menu mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Continue Playing</h2>
                <div id="continue-slider" class="owl-carousel">
                    <div class="post-slide">
                         <!--<a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_SupAndBah">-->
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="1016" data-gametableid="jili_DragonTiger">
                        
                            <div class="post-img">
                               
                                  <!--super andar bahar banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/f8df7753-2d29-4a59-bce5-a94045bb3b00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                     <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_ARou">
                         
                            <div class="post-img">
                                
                                  <!--auto roullete banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/81895a99-ed0d-4bdf-a1bb-fa842ace7300/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                       <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_iblk">
                            <div class="post-img">
                               
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/c111b88a-b91a-4046-58f3-e1fedd363c00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                   
                    <div class="post-slide">
                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="Evo_Craps">
                            <div class="post-img">
                                
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/52967175-f5ba-4f74-c22d-08a149c15e00/style1" alt="slide">
                                
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_SpRou">
                            <div class="post-img">
                                
                                 <!--Dragon tiger banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/04d0da24-6073-4e83-6e3a-9cef4a011900/style1" alt="slide"> 
                               
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>spo
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    
               
                </div>
            </div>
        </div>
    </div>
  

    <!-- SLIDERS -->
    
      <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Live Tables </h2>
                <div id="stake-originals" class="owl-carousel">
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1016" data-gametableid="jili_TeenPatti">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/auto1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/e25c9bcc-b623-4053-1f76-77fc22bcd400/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1016" data-gametableid="jili_Rummy">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/xxxtreme_lightning_roulette_ev.jpg')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/be7e31c6-a5f4-46bc-7398-0b4f97dc2700/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                     <div class="post-slide">
                        @if(Auth::check())
                        <a href="#" class="lobby-game">
                         <a href="{{route('games.play-game','aviator')}}"> 
                        @else
                        <a href="{{route('user.login')}}">
                        @endif
                        
                            <div class="post-img">
                                
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/24e61645-a357-47d9-62ed-4826eab04900/style1" alt="slide"> 
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_CasHold">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/andar-bahar.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/466f6c17-1a62-48f9-984f-6ce9b2bc1000/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_GoldVaultRoulette">                            
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/auto1.png ')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/02b47d56-b4a3-45c2-82bc-7efdc17abb00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_dbRoulette"> 
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/andar1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/635126f9-65a6-4484-0a71-2537821fdd00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <!--<div class="post-slide">-->
                    <!--    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="ez_unru">-->
                    <!--        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/blackjack2.png')}}" alt="slide">-->
                    <!--            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/249131c9-86ad-478e-9d8e-65092f747700/style1" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_SpRou">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/poker1.png')}}" alt="slide">-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/04d0da24-6073-4e83-6e3a-9cef4a011900/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                        <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_immersiveroulette">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/blackjack2.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/b9c82ce3-f45c-4398-d02f-ee0e1c153b00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <!--    <div class="post-slide">-->
                    <!--    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="ez_diru">-->
                    <!--        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/blackjack2.png')}}" alt="slide">-->
                    <!--            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/0236e17b-42f6-4f46-03ce-d869cd944b00/style1" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                        <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="Evo_InsRou">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/blackjack2.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/59c21ece-3424-4a8a-fe85-adca1ea5dd00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   
     <!-- SLIDERS -->
     
    <!--  <div class="container set-none-slider-menu mt-4 mt-lg-5">-->
    <!--    <div class="row">-->
    <!--        <div class="col-md-12">-->
    <!--            <h2 class="slider-main-title">Live Card Games</h2>-->
    <!--            <div id="trending-slider" class="owl-carousel">-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_dt">-->
                         <!--@if(Auth::check())-->
                        <!--<a href="{{route('games.play-game','number_prediction')}}">-->
                        <!--@else-->
                        <!--<a href="{{route('user.login')}}">-->
                        <!--@endif-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/dragon_tiger_ezugi.png')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                     <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_ab">-->
                    <!--@if(Auth::check())-->
                    <!--    <a href="{{route('games.play-game','color_prediction')}}">-->
                    <!--    @else-->
                    <!--    <a href="{{route('user.login')}}">-->
                    <!--    @endif-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/andar_bahar_ezugi.png')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                      <div class="post-slide">-->
    <!--                           <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_botp">-->
                    <!--@if(Auth::check())-->
                    <!--    <a href="{{route('games.play-game','aviator')}}">-->
                    <!--    @else-->
                    <!--    <a href="{{route('user.login')}}">-->
                    <!--    @endif-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/teen_patti_ezugi.png')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                 <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_cwar">-->
                 
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/cricket_war_ezugi.png')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_chom">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/casino_holdem_ezugi.png')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_32cd">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/32_cards_ezugi.png')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                  <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="Evo_Craps">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/craps_thumbnail_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                  <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_DraTig">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/dragon_tiger_web_imagery_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    
    <!-- SLIDERS -->
    
      <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Live Games</h2>
                <div id="live-games" class="owl-carousel">
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_2HCHold">
                                                    <div class="post-img">
                                
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/00bfa264-bb5c-4ef8-1b39-3ae2cefd7b00/public" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_pbljk">
                            <div class="post-img">
                               
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/49e9dbc7-800b-4f38-c920-2e8545b39a00/public" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                          <div class="post-slide">
                               <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_SSB">
                            <div class="post-img">
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/0b5b067e-98ee-4e18-6af7-2b5b0711dc00/public" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                     <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_LigRou">
                 
                            <div class="post-img">
                                
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/d8434895-fb9d-47c3-5763-49b3357f4300/public" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <!--<div class="post-slide">-->
                    <!--    <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_csnhl">-->
                    <!--        <div class="post-img">-->
                               
                    <!--            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8fe5acfa-f3ac-45e4-0107-215cec608000/style2" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                    <!--<div class="post-slide">-->
                    <!--    <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_32cd">-->
                    <!--        <div class="post-img">-->
                               
                    <!--            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8fe5acfa-f3ac-45e4-0107-215cec608000/style2" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                    <!--<div class="post-slide">-->
                    <!--  <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_crps">-->
                    <!--        <div class="post-img">-->
                              
                    <!--            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8fe5acfa-f3ac-45e4-0107-215cec608000/style2" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                    <!--<div class="post-slide">-->
                    <!--  <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_DraTig">-->
                    <!--        <div class="post-img">-->
                               
                    <!--            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8fe5acfa-f3ac-45e4-0107-215cec608000/style2" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
    <!-- SLIDERS -->
    <div class="container set-none-slider-menu">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Trending Sports</h2>
                <div id="trending-sports" class="owl-carousel">
                    <div class="post-slide">
                       <!--<a href="{{$autologinUrl}}">-->
                       <!--<a href="https://cric.Betzono.com/">-->
                       <a href="https://betzono.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/cricket1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/b9121102-1c50-454d-ba8d-7ec21f36f500/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                        <!--<a href="https://cric.Betzono.com/">-->
                        <a href="https://Betzono.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/soccer1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/24af9497-dc5f-48dc-eb09-e628a90e7f00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                       <!--<a href="{{$autologinUrl}}">-->
                       <!--<a href="https://cric.Betzono.com/">-->
                       <a href="https://Betzono.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/tennis1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8d41fa9b-38fe-4d6a-505b-f0b8034e8e00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <!--<div class="post-slide">-->
                        <!--<a href="{{$autologinUrl}}">-->
                        <!--<a href="https://cric.Betzono.com/">-->
                    <!--    <a href="https://Betzono.com/sports">-->
                    <!--        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/boxing1.png')}}" alt="slide">-->
                    <!--            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/74dc9faa-0503-4e8f-b0aa-e7e588ea4f00/style1" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                   
                    <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                        <!--<a href="https://cric.Betzono.com/">-->
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/table-tennis1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/751508b2-7734-4d06-47ac-77c5ea17bd00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                        <!--<a href="https://cric.Betzono.com/">-->
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/basketball1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/159290d1-ce66-4a00-ea3c-2e9226b10f00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                        <!--<a href="https://cric.Betzono.com/">-->
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/rugby1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/82d22949-026c-41cf-85b7-8243c2057900/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- SLIDERS -->
    <!--<div class="container set-none-slider-menu mt-4 mt-lg-5">-->
    <!--    <div class="row">-->
    <!--        <div class="col-md-12">-->
    <!--            <h2 class="slider-main-title">Fast Games</h2>-->
    <!--            <div id="random-1-slider" class="owl-carousel">-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_COC">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/deal_or_no_deal_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_FanTan">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/fan_tan_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="Evo_CraTm">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/crazy_time_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                   <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_CCFlip">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/crazy_coin_flip_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_FStudiodice">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/football_studio_dice_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_GWBac">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/golden_wealth_baccarat_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_SSB">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/super_sic_bo_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_MonoBBall">-->
    <!--                        <div class="post-img">-->
    <!--                            <img src="{{ asset('assets/newhome/img/sliders/monopoly_ev.jpg')}}" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    <!-- SLIDERS -->
   <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Must Try</h2>
                <div id="random-2-slider" class="owl-carousel">
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_baccaratA">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Plinko_X_smt.png')}}" alt="slide">-->
                                <!--plinko banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/200653df-abcd-4e92-1e8d-1230e4b63100/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_hndlightrout">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/mine.png')}}" alt="slide">-->
                                <!--minefield banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/5b0236a2-1080-4a38-b28a-cddd6ba37100/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_FunTime">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Bet_Games_Lucky7_tvbet.png')}}" alt="slide">-->
                                <!--Lucky7 banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/bd9008d1-32fb-47c1-baa9-b3782f986500/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_MonoBBall">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Bet_Games_6_Poker_tvvet.png')}}" alt="slide">-->
                                <!--Bet-on-poker banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/7a8fab87-9f5f-4250-c55b-473e3da2e200/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_Balloonrace">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Bet_Games_Dice_Duel_tvbet.png')}}" alt="slide">-->
                                <!--SLicer banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/fe5bf86c-9b21-4273-2b1c-3ff1d1113f00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    
    <!-- SLIDERS -->
    
       <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Fun Games</h2>
                <div id="stake-originals-1" class="owl-carousel">
                  
                    <div class="post-slide">
                       
                            <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_HindiSpeedBaccaratA">
                                
                            <div class="post-img">
                                <!--bet stacker banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/07d99946-06cb-4365-cb1f-68d2ea5bbc00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_hndlightrout">
                            <div class="post-img">
                                <!--golden balls banner   lucky ball-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/e7fcc47f-5047-4ceb-2b96-55471ece6c00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_DreCat">
                            <div class="post-img">
                                                               <!--bet on numbers banner Lucky Numbers x12-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/17dbb8db-5a27-485e-9852-1be849f00f00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                      <div class="post-slide">
                            <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_mbl">
                            <div class="post-img">
                                <!--bet stacker banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/26c64783-fda1-4dc0-cc24-7d9e1007d300/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_Lightningstorm">
                            <div class="post-img">
                                                              <!--lightning storm  banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/b20a83f8-031e-4de5-1835-39ff40b3bd00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                  
                    <!--<div class="post-slide">-->
                    <!--    <a href="javascript:void(0)" class="lobby-game" data-gameid="1016" data-gametableid="jili_LuckyBall">-->
                    <!--        <div class="post-img">-->
                                <!--golden balls banner   lucky ball-->
                    <!--            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/3e41fb21-ebc7-4531-646a-8b87e10e0f00/style1" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
                    
                </div>
            </div>
        </div>
    </div>

    <!-- SLIDERS -->
    <!--<div class="container set-none-slider-menu mt-4 mt-lg-5">-->
    <!--    <div class="row">-->
    <!--        <div class="col-md-12">-->
    <!--            <h2 class="slider-main-title">Fast Games</h2>-->
    <!--            <div id="random-4-slider" class="owl-carousel">-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80001">-->
    <!--                        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/mine1.png')}}" alt="slide">-->
                                <!--Dragon tiger banner mac88-->
    <!--                            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/61d9a8da-32f0-4c02-d086-f605e9391f00/style2" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80007">-->
    <!--                        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/bomb1.png')}}" alt="slide">-->
                                <!--andar bahar banner mac88-->
    <!--                            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/2ac3fae9-a700-4830-ee52-d5680bedde00/style2" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80082">-->
    <!--                        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/head1.png')}}" alt="slide">-->
                                 <!--limbo banner mac88-->
    <!--                            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8ea50835-d919-4b5e-0f44-5e2a104e2300/style2" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80069">-->
    <!--                        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/more1.png')}}" alt="slide">-->
                                <!--Race20 banner mac88-->
    <!--                            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/2856abb5-1708-438c-903d-a93a15afa200/style2" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80071">-->
    <!--                        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/four1.png')}}" alt="slide">-->
                                <!--High Low banner mac88-->
    <!--                            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/35cb72a5-84c3-43b6-c0c6-c7fc56563000/style2" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80035">-->
    <!--                        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/courier1.png')}}" alt="slide">-->
                                <!--Race17 banner mac88-->
    <!--                            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/1021897d-b84e-4dc4-b155-e2055394b000/style2" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80029">-->
    <!--                        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/aviator2.png')}}" alt="slide">-->
                                <!--10 ka dum banner mac88-->
    <!--                            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/284a34c3-9c63-4112-f5c2-16246aec8300/style2" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--                <div class="post-slide">-->
    <!--                    <a href="javascript:void(0)" class="lobby-game" data-gameid="1026" data-gametableid="RG-DTL101">-->
    <!--                        <div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/red1.png')}}" alt="slide">-->
                                <!--dragon tiger lion banner Royalgaming-->
    <!--                            <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/bff42292-8677-4eb5-75c7-0779bf4bc000/style2" alt="slide">-->
    <!--                        </div>-->
    <!--                        <div class="d-flex align-items-center gap-1 py-1">-->
    <!--                            <span class="set-green-circle"></span>-->
    <!--                            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
    <!--                            <span class="set-sm-text">playing</span>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    <!-- SLIDERS -->
    <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">New Games</h2>
                <div id="random-3-slider" class="owl-carousel">
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-alphaeagle">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/slots/rt-1.jpg')}}" alt="slide">-->
                                <img src="https://www-live.hacksawgaming.com/casino_thumbnails/1201.jpg" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-jokerbombs">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/slots/rt-2.jpg')}}" alt="slide">-->
                                 <img src="https://www-live.hacksawgaming.com/casino_thumbnails/1117.jpg" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                       <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-mysterymotel">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/slots/rt-3.jpg')}}" alt="slide">-->
                                 <img src="https://www-live.hacksawgaming.com/casino_thumbnails/1071.jpg" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                       <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-buffalostacknsync">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/slots/rt-4.jpg')}}" alt="slide">-->
                                 <img src="https://www-live.hacksawgaming.com/casino_thumbnails/1176.jpg" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1007" data-gametableid="HAK-franksfarm">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/slots/rt-6.jpg')}}" alt="slide">-->
                                 <img src="https://www-live.hacksawgaming.com/casino_thumbnails/1225.jpg" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-dragonsdomain">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/slots/rt-7.jpg')}}" alt="slide">-->
                                 <img src="https://www-live.hacksawgaming.com/casino_thumbnails/1360.jpg" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-doublerainbow">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/slots/rt-8.jpg')}}" alt="slide">-->
                                 <img src="https://www-live.hacksawgaming.com/casino_thumbnails/1144.jpg" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                       <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-cubes2">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/slots/rt-17.jpg')}}" alt="slide">-->
                                 <img src="https://www-live.hacksawgaming.com/casino_thumbnails/1069.jpg" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- END SLIDERS -->
     
    <!-- LIVE EVENTS SLIDER -->
    <section class="container">
        <div class="set-inner-event-box mt-5">
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/tennis-balls.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Tennis</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/football.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Soccer</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/cricket-ball.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Cricket</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/ball-of-basketball.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Baske...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/ice-hockey.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Ice Ho...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/table-tennis.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Table...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/football.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Darts</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/rugby-balls.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Rugby</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/block.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Hand...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/snooker.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Snook...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/football.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">CS2</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://cric.Betzono.com//">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/dota-2.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Dota 2</p>
                </a>
            </div>
        </div>
    </section>


    <!-- Faq Section Start -->
    <!--<section id="faq" class="faq-section pt-95 pb-60">-->
    <!--    <div class="container">-->
    <!--        <div class="row justify-content-center">-->
    <!--            <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-10">-->
    <!--                <div class="section-title text-center left-greadient mb-50">-->
    <!--                    <h1><span class="common-gre-color">FAQ</span>s</h1>-->
    <!--                    <p>A Bzone24 Gamezone is a facility for certain types of Sports games, live Casino Games much-->
    <!--                        more for enjoying.</p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <div class="row" id="accordionExample">-->
    <!--            <div class="col-md-6">-->
    <!--                <div class="accordion pb-15">-->
    <!--                    <div class="single-faq box-inner-shadow">-->
    <!--                        <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"-->
    <!--                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Why do I-->
    <!--                            need to be registered on Bzone24?</button>-->
    <!--                        <div id="collapseOne" class="collapse" data-bs-parent="#accordionExample">-->
    <!--                            <div class="faq-content">-->
    <!--                                Registration on Bzone24 website is a condition for using all the products available-->
    <!--                                on the website. Registration entitles you to open a Bzone24 account free-of-charge-->
    <!--                                and without obligations. Use the account to manage your bets and personal data. You-->
    <!--                                can make bets with real money after you replenish your account.-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="single-faq box-inner-shadow">-->
    <!--                        <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"-->
    <!--                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">I don’t-->
    <!--                            want to deposit money right after registration. Do I have to?</button>-->
    <!--                        <div id="collapseTwo" class="collapse" data-bs-parent="#accordionExample">-->
    <!--                            <div class="faq-content">-->
    <!--                                You don’t need to make a deposit immediately. You may make a deposit whenever you-->
    <!--                                like by using the “Deposit” option.-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="single-faq box-inner-shadow">-->
    <!--                        <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"-->
    <!--                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Can-->
    <!--                            I change my personal data after registration?</button>-->
    <!--                        <div id="collapseThree" class="collapse" data-bs-parent="#accordionExample">-->
    <!--                            <div class="faq-content">-->
    <!--                                Please note that you will no longer be able to modify your basic data, such as your-->
    <!--                                first name and last name, date of birth, the currency of your account in Bzone24 or-->
    <!--                                the country settings. Seriousness and trustworthiness are the top priorities for-->
    <!--                                Bzone24. You will, however, still be able to change other data even after-->
    <!--                                registration. In special cases (e.g. the personal data was filled incorrectly,-->
    <!--                                etc.), Bzone24 will verify and accept changes to your basic data if you submit the-->
    <!--                                corresponding confirming document.-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-md-6">-->
    <!--                <div class="accordion pb-15">-->
    <!--                    <div class="single-faq box-inner-shadow">-->
    <!--                        <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"-->
    <!--                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">What-->
    <!--                            should I do if I have forgotten my username/password?</button>-->
    <!--                        <div id="collapseFour" class="collapse" data-bs-parent="#accordionExample">-->
    <!--                            <div class="faq-content">-->
    <!--                                If you’ve forgotten your password, first try to restore it through the site using-->
    <!--                                the “Forgot password?” option. Password recovery will not function in some cases-->
    <!--                                (e.g. the e-mail address is wrong or there are technical problems). If you’ve-->
    <!--                                forgotten your username or if you experience any other issues, you should contact us-->
    <!--                                through Live Support, send us an email using our support email address-->
    <!--                                help@Bzone24.com or the “Send a Message” option on Live chat.-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="single-faq box-inner-shadow">-->
    <!--                        <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"-->
    <!--                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">What-->
    <!--                            kind of games can I play online at the Bzone24 Gamezone?</button>-->
    <!--                        <div id="collapseFive" class="collapse" data-bs-parent="#accordionExample">-->
    <!--                            <div class="faq-content">-->
    <!--                                Bzone24 offers a wide selection of games to our players. You can find many different-->
    <!--                                3D games, Table games, a huge variety of Slot games, and even Live games including-->
    <!--                                Blackjack and Roulette, with Baccarat and Crash Games, Fast Games including Head &-->
    <!--                                Tale, Mine Game, Stone Paper Seizer, Bomb Sqard and Race games, Lotteries and many-->
    <!--                                easier to play games.-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="single-faq box-inner-shadow">-->
    <!--                        <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"-->
    <!--                            data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">How to I-->
    <!--                            withdraw my fund?</button>-->
    <!--                        <div id="collapseSix" class="collapse" data-bs-parent="#accordionExample">-->
    <!--                            <div class="faq-content">-->
    <!--                                Click on withdrawal Option and choose method what you want you and make a request.-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    <!-- Faq Section End --> 


    <section id="supporting-section" class="py-5">
        <div class="container">
            <hr />
            <div class="row align-items-start mb-4">
                <!-- Payment Icons -->
                <div class="col-lg-5 col-md-6 text-center mb-4">
                    <h3 class="common-gre-color">Payments</h3>
                    <div class="row justify-content-center">
                        @foreach(['gpay', 'upi', 'paypal', 'visa', 'bitcoin', 'tether'] as $icon)
                            <div class="col-4 col-md-4 mb-3">
                                <img src="{{ asset('assets/newhome/img/Payment_icons/' . $icon . '.png') }}" alt="{{ ucfirst($icon) }}" class="payment-icon img-fluid">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Social Media Icons -->
                <div class="col-lg-3 col-md-6 text-center mb-4">
                    <h3 class="common-gre-color">&nbsp;</h3>
                    <div class="row justify-content-center">
                        @foreach([
                            ['url' => 'https://www.telegram.com', 'img' => '18plus.png', 'alt' => '18+'],
                            ['url' => 'https://www.instagram.com', 'img' => 'gamecare.png', 'alt' => 'GameCare'],
                            ['url' => 'https://www.facebook.com', 'img' => 'gt.png', 'alt' => 'GT']
                        ] as $social)
                            <div class="col-4 col-md-4 mb-3">
                                <a href="{{ $social['url'] }}" target="_blank">
                                    <img src="https://cdn.cloudd.site/content/assets/images/{{ $social['img'] }}" alt="{{ $social['alt'] }}" class="social-icon img-fluid">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Download App -->
        <!--        <div class="col-lg-4 col-md-12 text-center">-->
        <!--            <h3 class="common-gre-color">Download App</h3>-->
        <!--            <a href="{{ url('assets/front/Betzono.apk') }}" target="_blank">-->
        <!--                <img src="{{ url('assets/front/androidapp.png') }}" alt="Android App" class="img-fluid" style="max-width: 150px;">-->
        <!--            </a>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <style>
            .social-icon, .payment-icon {
                max-width: 80px;
                margin: 5px;
            }

            @media (max-width: 767px) {
                .social-icon, .payment-icon {
                    max-width: 60px;
                }
            }
        </style>
    </section>


    <!-- Footer Section Start -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Footer Section End -->
    <footer class="footer" style="    padding-top: 3.125rem;
    padding-bottom: 1.875rem; ">

    <div class="container">
      
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-3 text-md-start text-center">
                <a class="footer-logo" href="https://Betzono.com">
                    <img src="{{ asset('assets/newhome/images/logo_icon/logo.png')}}" alt="image"></a>
                     <!--<img src="{{ asset('assets/newhome/images/logo_icon/logo.png')}}" alt="event" height="">-->
            </div>
            <div class="col-lg-10 col-md-9 mt-md-0 mt-3">
                <ul class="inline-menu d-flex justify-content-md-end justify-content-center align-items-center flex-wrap" style="    margin: -.1875rem -.625rem;">
                    <li><a href="http://localhost/Betzono">Home</a></li>
                    <!-- <li><a href="http://localhost/Betzono/lottery">Lotteries</a></li> -->

                    
                                            <li><a href="http://localhost/Betzono/policy/privacy-policy?42">Privacy Policy</a></li>
                                            <li><a href="http://localhost/Betzono/policy/terms-of-service?43">Terms of Service</a></li>
                                    </ul>
            </div>
        </div>
        <hr class="mt-3">
        <div class="row align-items-center flex-wrap">

            <div class="col-md-6 text-md-start text-center mb-3 mb-md-0">
            <span class="footer-content__left-text">License Info: Peniks Studio LTD, with registered address at Sakartvelo, Kalaki Batumi, Giorgi Ancuxelizis Kucha, N 16 (Georgia) and registered number 445598844.</span>
            </div>

            <div class="col-md-6 text-md-end text-center">
            <ul class="inline-social-links d-flex align-items-center justify-content-md-end justify-content-center">
                <li><a href="https://t.me/Betzono_casino" target="_blank" style="color: #fff; font-size: 20px;"><i class="fab fa-telegram"></i> </a></li>
                <li><a href="https://x.com" target="_blank" style="color: #fff; font-size: 20px;"><i class="fab fa-twitter"></i></a></li>
                <li><a href="https://twitch.com" target="_blank" style="color: #fff; font-size: 20px;"><i class="fab fa-twitch"></i></a></li>
            </ul>
            </div>
<!--fa-brands fa-telegram-->
        </div>


        <div class="row align-items-center" style="padding-top:40px;">

            <div class="col-md-12 text-center">
                    <span class="footer-content__left-text"> Copyright ©
                        2025, All Right Reserved By               
                            <a class="text--base" href="{{ route('home') }}">Betzono.</a>
                    </span>
                <br/>
                <br/>
            </div>

        </div>

    </div>

    
</footer>
<style>
    .footer{
        background:black!important;
    }
.inline-social-links li {
    padding: .1875rem .4375rem;
}

.inline-social-links li a {
    width: 32px;
    height: 32px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    color: #fff;
}
@media (max-width: 767px) {
    .footer {
        padding-bottom: 100px!important;
    }
}


.inline-menu li a {
    color: #fff;
}
.inline-menu li {
    padding: .1875rem .625rem;
}

.footer-logo img {
    max-height: 50px;
}
.text--base {
    color: #86FF00 !important;
}

    </style>
    <!-- Back To Top Start -->
    <a href="#" class="scroll-top btn-hover">
        <span class="icon-gden- icon-gdenangle-up"></span>
    </a>
    <!-- Back To Top End -->
    <!-- lower bar -->
    <section class="set-bg-bar-below py-3">
        <div class="d-flex align-items-center justify-content-between px-3">
            <div class="single-event-box">
                <a href="{{url('/')}}">
                    <div>
                        <img src="{{ asset('assets/newhome/img/find.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Main</p>
                </a>
            </div>
  
            <div class="single-event-box">
                <a href="#">
                    <div>
                        <img src="{{ asset('assets/newhome/img/bet.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Lottery</p>
                </a>
            </div>
            <div class="single-event-box">
                <!--<a href="https://cric.Betzono.com//">-->
                <a href="https://Betzono.com/sports">
                    <div>
                        <img src="{{ asset('assets/newhome/img/ball-of-basketball.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Sports</p>
                </a>
            </div>
                      <div class="single-event-box">
                <a href="https://Betzono.com/trending-games">
                <!--<a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_ARou">-->
                    <div>
                        <img src="{{ asset('assets/newhome/img/poker-cards.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Casino</p>
                </a>
            </div>
           <div class="single-event-box" >
                <a href="https://t.me/Betzono_support">
                    <div>
                        <img src="{{ asset('assets/newhome/img/messenger.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Chat</p>
                </a>
            </div>
    </section>
    
    
    
    <!-- end lower bar -->
    <script src="{{ asset('assets/newhome/js/plugins.js')}}"></script>
    <script src="{{ asset('assets/newhome/js/main.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <!--@php echo loadExtension('tawk-chat') @endphp-->
    <script>
        $(document).ready(function() {
            $("#continue-slider").owlCarousel({
                items : 5,
                itemsDesktop:[1199,5],
                itemsDesktopSmall:[980,4],
                itemsMobile : [600,3],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });
        $(document).ready(function() {
            $("#trending-slider").owlCarousel({
                items : 3,
                itemsDesktop:[1199,3],
                itemsDesktopSmall:[980,3],
                itemsMobile : [600,2],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });
         $(document).ready(function() {
            $("#live-games").owlCarousel({
                items : 3,
                itemsDesktop:[1199,3],
                itemsDesktopSmall:[980,3],
                itemsMobile : [600,2],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });
        $(document).ready(function() {
            $("#trending-sports").owlCarousel({
                items : 5,
                itemsDesktop:[1199,5],
                itemsDesktopSmall:[980,4],
                itemsMobile : [600,3],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });
        $(document).ready(function() {
            $("#stake-originals").owlCarousel({
                items : 5,
                itemsDesktop:[1199,5],
                itemsDesktopSmall:[980,4],
                itemsMobile : [600,3],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });
        $(document).ready(function() {
            $("#slots-slider").owlCarousel({
                items : 5,
                itemsDesktop:[1199,5],
                itemsDesktopSmall:[980,3],
                itemsMobile : [600,2],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });

        $(document).ready(function() {
            $("#random-1-slider").owlCarousel({
                items : 5,
                itemsDesktop:[1199,5],
                itemsDesktopSmall:[980,4],
                itemsMobile : [600,3],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });

        $(document).ready(function() {
            $("#random-2-slider").owlCarousel({
                items : 5,
                itemsDesktop:[1199,5],
                itemsDesktopSmall:[980,5],
                itemsMobile : [600,3],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });

        $(document).ready(function() {
            $("#random-3-slider").owlCarousel({
                items : 5,
                itemsDesktop:[1199,5],
                itemsDesktopSmall:[980,3],
                itemsMobile : [600,3],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });
          $(document).ready(function() {
            $("#stake-originals-1").owlCarousel({
                items : 5,
                itemsDesktop:[1199,5],
                itemsDesktopSmall:[980,4],
                itemsMobile : [600,3],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });
         $(document).ready(function() {
            $("#random-4-slider").owlCarousel({
                items : 3,
                itemsDesktop:[1199,3],
                itemsDesktopSmall:[980,3],
                itemsMobile : [600,2],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:false
            });
        });

        $(document).ready(function() {
            $(".lobby-game").click(function(e) {
                e.preventDefault();
                let username = '{{ auth()->check() ? auth()->user()->username : "" }}';
                const gameId = $(this).data('gameid');
                const gameTableId = $(this).data('gametableid');
                if (!username) {
                    window.location.href = '{{ route('user.login') }}';
                    return;
                }
                $.ajax({
                    url: "{{ route('get.lobby.url') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        username: username,
                        gameId: gameId,
                        gameTableId: gameTableId
                    },
                    beforeSend: function() {
                      $(".preloader").css("opacity",1).css("display","block");
                    },
                    xhrFields: {
                        withCredentials: true // Ensures Laravel session is maintained
                    },
                    success: function(response) {
                        $(".preloader").css("opacity",0).css("display","none");
                        if (response.lobbyURL) {
                            window.location.href = '{{url("rungame")}}'+'/'+response.lobbyURL;
                        } else {
                            alert("Error: " + response.error);
                        }
                    },
                    error: function(xhr) {
                        $(".preloader").css("opacity",0).css("display","none");
                        alert("Error: " + xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
    
</body>

</html>