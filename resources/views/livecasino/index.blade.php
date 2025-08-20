<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Betzono - Gaming & Betting with cryptocurrency, betting with crypto </title>
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
    <style>
        .page-link {
            color: #86FF00;
            background-color: #181818;
            border: 1px solid #181818;
        }

        .pagination-dark .page-item .page-link {
            color: #fff;
            background-color: #333;
            border: 1px solid #444;
            margin: 2px;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .pagination-dark .page-item.active .page-link {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .pagination-dark .page-item.disabled .page-link {
            color: #666;
            background-color: #222;
            border: 1px solid #333;
        }

        .pagination-dark .page-item .page-link:hover {
            background-color: #555;
            border: 1px solid #777;
        }

        .game-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            background-color: #222;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(255, 255, 255, 0.1);
            justify-content: center;
            align-items: center;
        }

        /* Search box */
        .search-box {
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            outline: none;
            width: 200px;
        }

        /* Dropdown styles */
        .filter-dropdown,
        .sort-dropdown {
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            outline: none;
            cursor: pointer;
        }

        /* Filter button */
        .filter-btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #86FF00;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .filter-btn:hover {
            background-color: #86FF00;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .game-filter {
                flex-direction: column;
                gap: 10px;
            }

            .search-box,
            .filter-dropdown,
            .sort-dropdown,
            .filter-btn {
                width: 100%;
            }
        }
    </style>
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
                                    <span class="wow fadeInLeft mb-20" data-wow-delay=".2s">Welcome To BETZONO</span>
                                    <h1 class="wow fadeInUp" data-wow-delay=".4s">
                                        Play Online <span class="common-gre-color">Games & Win</span> Money Unlimited
                                    </h1>
                                    <p class="wow fadeInUp" data-wow-delay=".6s">Play casino and earn crypto in online. The ultimate
                                        online gaming & casino platform.</p>
                                    <a href="#" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Play Now!</a>
                                    <a href="#" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Sign Up</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a href="#">
                                    <div class="hero-img wow fadeInRight" data-wow-delay=".5s">
                                        <img src="{{ asset('assets/newhome/img/hero/np.png')}}" alt="">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="hero-content top-greadient">
                                    <span class="wow fadeInLeft mb-20" data-wow-delay=".2s">Sports Betting</span>
                                    <h1 class="wow fadeInUp" data-wow-delay=".4s">
                                        Play your <span class="common-gre-color">Favourite sports</span> with Betzono
                                    </h1>
                                    <p class="wow fadeInUp" data-wow-delay=".6s">Play you favourite sports game with Betzono</p>
                                    <a href="#" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Play Now!</a>
                                    <a href="#" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Sign Up</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a href="#">
                                    <div class="hero-img wow fadeInRight" data-wow-delay=".5s">
                                        <img src="{{ asset('assets/newhome/img/hero/cp.png')}}" alt="">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="hero-content top-greadient">
                                    <span class="wow fadeInLeft mb-20" data-wow-delay=".2s">Betzono Casino</span>
                                    <h1 class="wow fadeInUp" data-wow-delay=".4s">
                                        Play Online <span class="common-gre-color">Casino Games</span> Earn Big
                                    </h1>
                                    <p class="wow fadeInUp" data-wow-delay=".6s">All Type of Casino games avaible on bzone game section.</p>
                                    <a href="#" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Play Now!</a>
                                    <a href="#" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Sign Up</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a href="#">
                                    <div class="hero-img wow fadeInRight" data-wow-delay=".5s">
                                        <img src="{{ asset('assets/newhome/img/hero/casino.jpeg')}}" alt="">
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
        <div class="game-filter">
            <!-- <input type="text" class="search-box" placeholder="Search game..."> -->
            <form method="GET" action="{{route('liveCasino')}}">
                <select class="filter-dropdown" name="category">
                    <option value="All" {{ $selectedCategory == 'All' ? 'selected' : '' }}>All Categories</option>
                    @foreach($gameCategory as $category)
                    <option value="{{ $category }}" {{ $selectedCategory == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                    @endforeach
                </select>
                <!-- <select class="sort-dropdown">
                    <option value="popular">Most Popular</option>
                    <option value="newest">Newest</option>
                    <option value="top-rated">Top Rated</option>
                </select> -->
                <button class="filter-btn">Apply Filter</button>
            </form>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="game-list">
            @foreach($games as $item)
            <div class="col">
                <div class="card h-100">
                    @if(Auth::check())
                        <a href="#" class="lobby-game" data-gameid="{{$item['gameCode']}}" data-gametableid="{{$item['tableCode']}}">
                    @else
                        <a href="{{route('user.login')}}">
                    @endif
                    <img src="{{ (isset($item['imageUrl']) && $item['imageUrl']!='')?$item['imageUrl']:asset('assets/newhome/img/hero/cp.png') }}" class="card-img-top" alt="Card Image">
                    </a>
                    <div class="card-body bg-dark">
                        {{ $item['tableName'] }}
                        <div class="d-flex align-items-center gap-1">
                            <span class="set-green-circle"></span>
                            <strong class="set-strong-sm">{{ rand(20, 2000) }}</strong>
                            <span class="set-sm-text">&nbsp;playing</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <!-- <div class="d-flex justify-content-center mt-4">
            {{ $games->links() }}
        </div> -->

        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    @if ($games->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $games->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                    @endif

                    @foreach ($games->links()->elements as $element)

                    @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif


                    @if (is_array($element))
                    @foreach ($element as $page => $url)
                    @if ($page == $games->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    @endforeach
                    @endif
                    @endforeach


                    @if ($games->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $games->nextPageUrl() }}" rel="next">&raquo;</a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>


        <!-- <nav aria-label="Page navigation example bg-dark" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav> -->
    </div>

    <!-- Footer Section Start -->
    <footer class="footer pt-5">
        <div class="container">

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


            <div class="widget-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-md-12 text-center" style="max-width:30%;margin:auto">
                        <img class="mb-50" src="{{ asset('assets/newhome/img/logo/logo1.png')}}" alt="logo">
                    </div>
                </div>

                <!--          <div class="row">-->
                <!--    <div class="col-xl-12 col-md-12 text-center">-->

                <!--        <ul>-->
                <!--            <li><a href="https://stakeye.com/" target="_blank">Games</a></li>-->
                <!--            <li><a href="https://stakeye.com/" target="_blank">Terms & Conditions</a></li>-->
                <!--            <li><a href="https://stakeye.com/" target="_blank">Privacy Policy</a></li>-->
                <!--        </ul>-->
                <!--    </div>-->
                <!--</div>-->
            </div>


            <div class="copy-right">
                <p>Design and Developed by Betzono </p>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

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
                <a href="https://stakeye.com/sports/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/ball-of-basketball.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Sports</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://stakeye.com/livecasino">
                    <div>
                        <img src="{{ asset('assets/newhome/img/poker-cards.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Casino</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="https://stakeye.com">
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
                items: 4,
                itemsDesktop: [1199, 4],
                itemsDesktopSmall: [980, 4],
                itemsMobile: [600, 3],
                navigation: true,
                navigationText: ["", ""],
                pagination: true,
                autoPlay: false
            });
        });
        $(document).ready(function() {
            $("#trending-slider").owlCarousel({
                items: 3,
                itemsDesktop: [1199, 3],
                itemsDesktopSmall: [980, 3],
                itemsMobile: [600, 2],
                navigation: true,
                navigationText: ["", ""],
                pagination: true,
                autoPlay: false
            });
        });
        $(document).ready(function() {
            $("#trending-sports").owlCarousel({
                items: 4,
                itemsDesktop: [1199, 4],
                itemsDesktopSmall: [980, 4],
                itemsMobile: [600, 3],
                navigation: true,
                navigationText: ["", ""],
                pagination: true,
                autoPlay: false
            });
        });
        $(document).ready(function() {
            $("#stake-originals").owlCarousel({
                items: 4,
                itemsDesktop: [1199, 4],
                itemsDesktopSmall: [980, 4],
                itemsMobile: [600, 3],
                navigation: true,
                navigationText: ["", ""],
                pagination: true,
                autoPlay: false
            });
        });
        $(document).ready(function() {
            $("#slots-slider").owlCarousel({
                items: 3,
                itemsDesktop: [1199, 3],
                itemsDesktopSmall: [980, 3],
                itemsMobile: [600, 2],
                navigation: true,
                navigationText: ["", ""],
                pagination: true,
                autoPlay: false
            });
        });
        $(document).ready(function() {
            $("#random-1-slider").owlCarousel({
                items: 4,
                itemsDesktop: [1199, 4],
                itemsDesktopSmall: [980, 4],
                itemsMobile: [600, 3],
                navigation: true,
                navigationText: ["", ""],
                pagination: true,
                autoPlay: false
            });
        });

        $(document).ready(function() {
            $("#random-2-slider").owlCarousel({
                items: 3,
                itemsDesktop: [1199, 3],
                itemsDesktopSmall: [980, 3],
                itemsMobile: [600, 2],
                navigation: true,
                navigationText: ["", ""],
                pagination: true,
                autoPlay: false
            });
        });

        $(document).ready(function() {
            $("#random-3-slider").owlCarousel({
                items: 3,
                itemsDesktop: [1199, 3],
                itemsDesktopSmall: [980, 3],
                itemsMobile: [600, 2],
                navigation: true,
                navigationText: ["", ""],
                pagination: true,
                autoPlay: false
            });
        });

        $(document).ready(function() {
            $(".lobby-game").click(function(e) {
                e.preventDefault();
                let username = $("#authUsername").val();
                let gameId = $(this).data("gameid");
                let gameTableId = $(this).data("gametableid");
                window.location.href = "{{ url('setup-game') }}/"+gameId+"/"+gameTableId;

                /*$.ajax({
                    url: "{{ route('get.lobby.url') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        username: username,
                        gameId: gameId,
                        gameTableId: gameTableId
                    },
                    xhrFields: {
                        withCredentials: true // Ensures Laravel session is maintained
                    },
                    beforeSend: function() {
                      $(".preloader").css("opacity",1).css("display","block");
                    },
                    success: function(response) {
                        $(".preloader").css("opacity",0).css("display","none");

                        if (response.lobbyURL) {
                           // window.location.href = response.lobbyURL;
                           window.location.href = '{{url("rungame")}}'+'/'+response.lobbyURL;
                        } else {
                            alert("Error: " + response.error);
                        }
                    },
                    error: function(xhr) {
                        $(".preloader").css("opacity",0).css("display","none");
                        alert("Error: " + xhr.responseJSON.error);
                    }
                });*/
            });
        });
    </script>
</body>

</html>