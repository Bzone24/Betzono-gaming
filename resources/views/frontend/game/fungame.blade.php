<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, minimal-ui">
    <title>Bet</title>
    <link rel="icon" type="image/x-icon" href="favicon.svg">
    <link rel="stylesheet" href="{{ asset('assets/fungame/vendor/swiper/swiper.min.css')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/fungame/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/fungame/css/dataTables.bootstrap5.min.css')}}" />
    <script src="{{ asset('assets/fungame/js/lordicon.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('assets/fungame/css/style.css?v=1727872577')}}">

    <!-- iOS Safari Home Screen Icon -->
    <link rel="apple-touch-icon" href="/logo/logo.png">
    <!-- iOS Safari Home Screen Title -->
    <meta name="apple-mobile-web-app-title" content="-">
    <!-- iOS Safari Home Screen Shortcut Text -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- iOS Safari Home Screen Fullscreen -->
    <meta name="apple-mobile-web-app-capable" content="yes">

    <script>
        function reloadPage() {
            location.reload();
        }
    </script>

    <style>
        div#myModalalert .modal-content {
            width: 83% !important;
            margin: 0 auto !important;
            min-width: 360px;
            max-width: 430px;
        }

        div#myModalalert .modal-content .modal-header {
            background: #095eff;
            border: none !important;
        }

        div#myModalalert .modal-content .modal-header h5 {
            color: #fff;
        }

        .blink {
            animation: blink 1s steps(1, end) infinite;
        }
    </style>


</head>

<body>


    <!-- Overlay panel -->
    <div class="body-overlay"></div>
    <!-- Left panel -->
    <div id="panel-left">
        <div class="panel panel--left">
            <!-- Slider -->
            <div
                class="panel__navigation swiper-container-initialized swiper-container-horizontal swiper-container-android">
                <div class="swiper-wrapper">
                    <div class="swiper-slide swiper-slide-active" style="width: 356px;">
                        <div class="subnav-header closepanel">
                            <img src="{{ asset('assets/fungame/images/icons/arrow-back.svg')}}" alt="" title="">
                        </div>
                        <div class="user-details">
                            <div class="user-details__title">
                                <span> admin </span> Administrator
                            </div>
                        </div>
                        <nav class="main-nav">
                            <ul>
                                <li>
                                    <a href="profile.html">
                                        <lord-icon src="lordicon/kthelypq.json" trigger="loop" delay="1500"
                                            state="in-analytics" colors="primary:#ec2b3a"
                                            style="width:22px;height:22px;margin-right:5px;">
                                        </lord-icon>
                                        <span>My Account</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="convert.html">
                                        <lord-icon src="lordicon/bxdnmmpl.json" trigger="loop" delay="1500"
                                            state="in-analytics" colors="primary:#ec2b3a"
                                            style="width:22px;height:22px;margin-right:5px;">
                                        </lord-icon>
                                        <span>Convert Balance</span>
                                    </a>
                                </li>


                                <li>
                                    <a href="gamewallet.html">
                                        <lord-icon src="lordicon/ciawvzjk.json" trigger="loop" delay="500"
                                            state="in-wallet" colors="primary:#ec2b3a"
                                            style="width:22px;height:22px;margin-right:5px;">
                                        </lord-icon>
                                        <span>Game Wallet</span>
                                    </a>
                                </li>



                                <li>
                                    <a href="statement.html">
                                        <lord-icon src="lordicon/vuiggmtc.json" trigger="loop" delay="1500"
                                            state="in-analytics" colors="primary:#ec2b3a"
                                            style="width:22px;height:22px;margin-right:5px;">
                                        </lord-icon>
                                        <span>My Bid History</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="wallet.html">
                                        <lord-icon src="lordicon/xoaqvsym.json" trigger="loop" delay="1500"
                                            state="in-analytics" colors="primary:#ec2b3a"
                                            style="width:22px;height:22px;margin-right:5px;">
                                        </lord-icon>
                                        <span>Revenue</span>
                                    </a>
                                </li>





                                <li>
                                    <a href="#">
                                        <lord-icon src="lordicon/vuiggmtc.json" trigger="loop" delay="1500"
                                            state="in-analytics" colors="primary:#ec2b3a"
                                            style="width:22px;height:22px;margin-right:5px;">
                                        </lord-icon>
                                        <span>Rules & Regulations</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="contact.html">
                                        <lord-icon src="lordicon/axteoudt.json" trigger="loop" delay="1500"
                                            state="in-analytics" colors="primary:#ec2b3a"
                                            style="width:22px;height:22px;margin-right:5px;">
                                        </lord-icon>
                                        <span>Help &amp; Support</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <div class="buttons buttons--centered">
                            <a href="signout.html" class="button button--main button--small">LOGOUT</a>
                        </div>
                    </div>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
        </div>
    </div>
    <div class="page page--main" data-page="main">
        <!-- HEADER -->
        <header class="header">
            <div class="header__inner">
                <div class="header__logo header__logo--text">
                    <a href="game.html"><img src="{{ asset('assets/fungame/logo/logo.png')}}"></a>
                </div>
                <div class="header__icon d-flex">



                    <a href="#" onclick="reloadPage()" style="margin: 0 20px 0 0;">
                        <!--<img -->
                        <!--  src="images/icons/reload.png" -->
                        <!--  style="width:29px;height:29px" />-->

                        <lord-icon src="{{ asset('assets/fungame/lordicon/refresh.json')}}" trigger="loop" delay="1500" state="in-analytics"
                            style="width:28px;height:28px;margin-right:5px;">
                        </lord-icon>
                    </a>
                    <a href="signout.html" style="margin: 0 20px 0 0;">
                  

                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 430 430" width="28" height="28" preserveAspectRatio="xMidYMid meet"
                            style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px); content-visibility: visible;">
                            <defs>
                                <clipPath id="__lottie_element_588">
                                    <rect width="430" height="430" x="0" y="0" />
                                </clipPath>
                                <clipPath id="__lottie_element_590">
                                    <path d="M0,0 L430,0 L430,430 L0,430z" />
                                </clipPath>
                            </defs>
                            <g clip-path="url(#__lottie_element_588)">
                                <g clip-path="url(#__lottie_element_590)" transform="matrix(1,0,0,1,0,0)" opacity="1"
                                    style="display: block;">
                                    <g transform="matrix(1,0,0,1,275,215)" opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="secondary" stroke="rgb(183,39,49)" stroke-opacity="1"
                                                stroke-width="18"
                                                d=" M-125,0 C-125,0 125,0 125,0 M60.104000091552734,65 C60.104000091552734,65 125,0.052000001072883606 125,0.052000001072883606 C125,0.052000001072883606 60,-65 60,-65" />
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,579,215)" opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="secondary" stroke="rgb(183,39,49)" stroke-opacity="1"
                                                stroke-width="18"
                                                d=" M-125,0 C-125,0 125,0 125,0 M60.104000091552734,65 C60.104000091552734,65 125,0.052000001072883606 125,0.052000001072883606 C125,0.052000001072883606 60,-65 60,-65" />
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,175,215)" opacity="1" style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="primary" stroke="rgb(255,255,255)" stroke-opacity="1"
                                                stroke-width="18"
                                                d=" M115,80 C115,80 115,90 115,90 C115,95.51899719238281 115,108.96199798583984 115,120 C115,120 115,140 115,140 C115,151.03799438476562 106.03800201416016,160 95,160 C95,160 -95,160 -95,160 C-106.03800201416016,160 -115,151.03799438476562 -115,140 C-115,140 -115,-140 -115,-140 C-115,-151.03799438476562 -106.03800201416016,-160 -95,-160 C-95,-160 95,-160 95,-160 C106.03800201416016,-160 115,-151.03799438476562 115,-140 C115,-140 115,-121 115,-121 C115,-109.96199798583984 115,-96.29495239257812 115,-90.5 C115,-90.5 115,-80 115,-80" />
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>

                    <a href="{{url('/')}}" class="button btn--default">Home</a>
                    <a href="{{url('/user/dashboard')}}" class="button btn--default">Dashboard</a>

                    <div class="open-panel" data-panel="left">
                        <!--<img -->
                        <!--    src="images/icons/menu.png" -->
                        <!--    style="width:29px;height:29px" />-->



                        <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" -->
                            <!-- viewBox="0 0 430 430" width="28" height="28" preserveAspectRatio="xMidYMid meet" -->
                            <!-- style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px); content-visibility: visible;"> -->
                            <defs>
                                <clipPath id="__lottie_element_4595">
                                    <rect width="430" height="430" x="0" y="0" />
                                </clipPath>
                                <clipPath id="__lottie_element_4597">
                                    <path d="M0,0 L430,0 L430,430 L0,430z" />
                                </clipPath>
                            </defs>
                            <g clip-path="url(#__lottie_element_4595)">
                                <g clip-path="url(#__lottie_element_4597)" transform="matrix(1,0,0,1,0,0)" opacity="1"
                                    style="display: block;">
                                    <g transform="matrix(1,0,0,1,215,3.401672124862671)" opacity="1"
                                        style="display: none;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="secondary" stroke="rgb(183,39,49)" stroke-opacity="1"
                                                stroke-width="18.06"
                                                d=" M160.11900329589844,-17.1560001373291 C160.11900329589844,-17.1560001373291 -160.11900329589844,-17.1560001373291 -160.11900329589844,-17.1560001373291 C-160.11900329589844,-17.1560001373291 -160.11900329589844,-20.415000915527344 -160.11900329589844,-20.415000915527344 C-160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 C160.11900329589844,-20.415000915527344 160.11900329589844,-17.1560001373291 160.11900329589844,-17.1560001373291z" />
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,215,150.96783447265625)" opacity="1"
                                        style="display: none;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="primary" stroke="rgb(255,255,255)" stroke-opacity="1"
                                                stroke-width="18.06"
                                                d=" M160.11900329589844,20.415000915527344 C160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 C-160.11900329589844,20.415000915527344 -160.11900329589844,-20.415000915527344 -160.11900329589844,-20.415000915527344 C-160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 C160.11900329589844,-20.415000915527344 160.11900329589844,20.415000915527344 160.11900329589844,20.415000915527344z" />
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,215,102.23699951171875)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="secondary" stroke="rgb(183,39,49)" stroke-opacity="1"
                                                stroke-width="18.06"
                                                d=" M160.11900329589844,20.415000915527344 C160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 C-160.11900329589844,20.415000915527344 -160.11900329589844,-20.415000915527344 -160.11900329589844,-20.415000915527344 C-160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 C160.11900329589844,-20.415000915527344 160.11900329589844,20.415000915527344 160.11900329589844,20.415000915527344z" />
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,215,177.49200439453125)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="primary" stroke="rgb(255,255,255)" stroke-opacity="1"
                                                stroke-width="18.06"
                                                d=" M160.11900329589844,20.415000915527344 C160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 C-160.11900329589844,20.415000915527344 -160.11900329589844,-20.415000915527344 -160.11900329589844,-20.415000915527344 C-160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 C160.11900329589844,-20.415000915527344 160.11900329589844,20.415000915527344 160.11900329589844,20.415000915527344z" />
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,215,252.74600219726562)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="primary" stroke="rgb(255,255,255)" stroke-opacity="1"
                                                stroke-width="18.06"
                                                d=" M160.11900329589844,20.415000915527344 C160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 C-160.11900329589844,20.415000915527344 -160.11900329589844,-20.415000915527344 -160.11900329589844,-20.415000915527344 C-160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 C160.11900329589844,-20.415000915527344 160.11900329589844,20.415000915527344 160.11900329589844,20.415000915527344z" />
                                        </g>
                                    </g>
                                    <g transform="matrix(1,0,0,1,215,327.7460021972656)" opacity="1"
                                        style="display: block;">
                                        <g opacity="1" transform="matrix(1,0,0,1,0,0)">
                                            <path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"
                                                class="primary" stroke="rgb(255,255,255)" stroke-opacity="1"
                                                stroke-width="18.06"
                                                d=" M160.11900329589844,20.415000915527344 C160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 -160.11900329589844,20.415000915527344 C-160.11900329589844,20.415000915527344 -160.11900329589844,-20.415000915527344 -160.11900329589844,-20.415000915527344 C-160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 160.11900329589844,-20.415000915527344 C160.11900329589844,-20.415000915527344 160.11900329589844,20.415000915527344 160.11900329589844,20.415000915527344z" />
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>

                </div>
            </div>
        </header>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@900&display=swap" rel="stylesheet">
        <style>
            .circle-red,
            .circle-green,
            .circle-violet {
                height: 9px;
                width: 9px;
                margin: 0 1px 0 1px;
                border-radius: 50%;
                display: inline-block;
            }

            .circle-red {
                background-color: red;
            }

            .circle-green {
                background-color: green;
            }

            .circle-violet {
                background-color: #f51bf5;
            }

            .dis_able {
                pointer-events: none;
                cursor: not-allowed;
                filter: grayscale(1);
            }

            .ddd {
                margin: 10px 0 90px 0;
            }

            div#game_tablee_wrapper {
                margin: 0 0 90px 0;
            }

            .green-txt {
                color: green !important;
            }

            .red-txt {
                color: red !important;
            }

            .table th,
            .table tr,
            .table td {
                text-align: center !important;
                padding: 6px 3px 6px 3px !important;
            }

            #game_tablee th,
            #game_tablee tr,
            #game_tablee td {
                padding: 10px 3px 10px 3px !important;
            }



            #myBid_History {
                margin: 30px 0 110px 0;
            }

            #myBid_History .accordion-item {
                border: none;
            }

            #myBid_History button.accordion-button {
                width: 150px;
                margin: 10px auto 0 auto;
                background-color: #0c2d6b !important;
                border-radius: 40px !important;
                color: #fff !important;
                font-weight: 600;
                font-size: 14px;
                text-transform: uppercase;
                text-align: center;
            }

            div#my_bid .modal-content {
                background-color: transparent;
                background-image: url(./images/peri.png);
                background-size: cover;
                height: 475px;
                background-repeat: no-repeat;
                width: 330px;
                padding: 138px 20px 0 10px;
                margin: 0 auto;
                border: none;
            }

            div#my_bid .modal-content .period_id {
                text-align: center;
                font-size: 22px;
                font-weight: 600;
                font-family: Orbitron;
                margin: 0 0 0px 0;
            }

            div#my_bid .modal-content .modal-body {
                margin: 28px 0 0 0;
                padding: 0 5px 0 5px;
            }

            div#my_bid .modal-content .modal-body .point1 {
                text-align: left;
            }

            div#my_bid .modal-content .modal-body .point2 {
                text-align: right;
            }

            div#my_bid .modal-content .modal-body .point1,
            div#my_bid .modal-content .modal-body .point2 {
                font-family: Orbitron;
                font-family: Orbitron;
                width: 50%;
                padding: 7px 5px 2px 15px;
            }

            div#my_bid button.btn.btn-danger {
                font-size: 16px;
                font-weight: 600;
                text-transform: uppercase;
                width: 140px;
                border-radius: 120px;
                margin: 0 auto;
                position: relative;
                top: 10px;
            }
        </style>

        <!--<audio id="myAudio" autoplay loop volume="1.0">-->
        <!--    <source src="audio/b.mp3" type="audio/mpeg">-->
        <!--    <source src="audio/b.wav" type="audio/wav">-->
        <!--</audio>-->

        <!-- PAGE CONTENT -->

        <div class="page__content page__content--with-bottom-nav row px-3 m-0 justify-content-center">

            <div class="selectgame-option">
                <label> Select Game</label>
                <div class="custom-select">
                    <select id="choosegame">
                        <option value='813853' selected>GAMEE</option>
                        <option value='804288'>GAME DELHI</option>
                        <option value='839392'>GAME PUNJAB</option>
                        <option value='532772'>DEMO GAME</option>
                    </select>
                </div>

            </div>

            <div class="account-info">
                <div class=" d-flex justify-space align-items-center">
                    <div class="wallet-txt d-flex">

                        <div class="wallet-icon">
                            <lord-icon src="https://cdn.lordicon.com/depeqmsz.json" trigger="hover"
                            colors="primary:#ffffff" style ="width:100px;height:100px">
                            </lord-icon>
                        </div>
                        <!-- <div class="wallet-inr">
                            <div class="account-info__total">₹ 157.02</div>
                            <div class="account-info__title">Withdrawal Balance</div>
                        </div> -->
                        <div class="wallet-inr" style="position: absolute;right: 20px;">
                            <div class="account-info__total">₹ <span id="balance">10362.40</span></div>
                            <div class="account-info__title">Wallet Balance</div>
                        </div>
                    </div>
                </div>
                <div class=" d-flex justify-content-between align-items-center">
                    <a href="statement.html" class="button btn--default">History</a>

                </div>
            </div>

            <input type="hidden" id="endtime" value="October 2, 2024 22:36:00">

            <input type="hidden" id="gameduration" value="24">

            <input type="hidden" id="gameid" value="813853-2024-10-02">

            <div class="fieldset arun mt-5" id="counter-page">
                <div class="row">
                    <div class="col-7" id="time-id">
                        <div class="min-btn">
                            <span id="duration">Bet Name</span>
                        </div>
                        <div class="user-id">
                            <span>
                                GAMEE</span>
                        </div>
                    </div>
                    <div class="col-5" id="buy-counter">
                        <div class="time-buy">
                            Time
                        </div>
                        <div class="timer-count">
                            <div class="timer">
                                <div class="counter" style="font-family:Orbitron;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="fieldset arun mt-5 col-lg-12" id="gamecol">
                <div class="game-btn row">
                    <div class="col-6">
                        <button class="button btn--red btn-full mybtn" tagvalue="In Front">Number Front </button>
                    </div>
                    <div class="col-6">
                        <button class="button btn--red btn-full mybtn" tagvalue="In End">Number End</button>
                    </div>

                    <div class="col-6">
                        <button class="button btn--red btn-full mybtn" tagvalue="Combine Front End">Combine F &
                            E</button>
                    </div>

                    <div class="col-6">
                        <button class="button btn--red btn-full mybtn" tagvalue="Max Combine">Max Combine</button>
                    </div>

                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="0">0</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="1">1</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="2">2</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="3">3</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="4">4</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="5">5</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="6">6</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="7">7</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="8">8</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="9">9</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="10">10</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="11">11</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="12">12</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="13">13</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="14">14</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="15">15</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="16">16</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="17">17</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="18">18</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="19">19</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <!-- <div class="col-12">
                        <hr>
                    </div> -->
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="20">20</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="21">21</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="22">22</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="23">23</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="24">24</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="25">25</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="26">26</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="27">27</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="28">28</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="29">29</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="30">30</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="31">31</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="32">32</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="33">33</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="34">34</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="35">35</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="36">36</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="37">37</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="38">38</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="39">39</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="40">40</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="41">41</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="42">42</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="43">43</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="44">44</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="45">45</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="46">46</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="47">47</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="48">48</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="49">49</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="50">50</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="51">51</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="52">52</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="53">53</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="54">54</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="55">55</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="56">56</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="57">57</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="58">58</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="59">59</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="60">60</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="61">61</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="62">62</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="63">63</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="64">64</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="65">65</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="66">66</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="67">67</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="68">68</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="69">69</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="70">70</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="71">71</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="72">72</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="73">73</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="74">74</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="75">75</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="76">76</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="77">77</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="78">78</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="79">79</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="80">80</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="81">81</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="82">82</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="83">83</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="84">84</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="85">85</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="86">86</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="87">87</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="88">88</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="89">89</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="90">90</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="91">91</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="92">92</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="93">93</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="94">94</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="95">95</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="96">96</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="97">97</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="98">98</button>
                    </div>
                    <div class="col-3">
                        <button class="button btn--green mybtn" tagvalue="99">99</button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>


                </div>


            </div>





            <div class="table-record  ">
                <table id="game_table" class="table table-striped pb-1">
                    <thead>
                        <tr>
                            <th scope="col">Period</th>
                            <th scope="col">Price</th>
                            <th scope="col">Win No</th>

                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>813853</th>
                            <td>INR </td>
                            <td class="">-</td>

                        </tr>


                    </tbody>
                </table>
            </div>



        </div>





        <!-- PAGE END -->

        <!-- Bottom navigation -->
        <!--<div id="bottom-toolbar" class="bottom-toolbar">-->

        <!--</div>-->

        <!-- <div class="bottom-navigation bottom-navigation--gradient">
            <ul class="bottom-navigation__icons m-0 p-0">
                <li>
                    <a href="game.html">
                        <lord-icon src="https://cdn.lordicon.com/cnpvyndp.json" trigger="loop" delay="1500"
                            state="morph-home-2" colors="primary:#ffffff" style="width:30px;height:30px">
                        </lord-icon>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="team.html">
                        <lord-icon src="https://cdn.lordicon.com/kddybgok.json" trigger="loop" delay="1500"
                            state="in-thumbs" colors="primary:#ffffff" style="width:30px;height:30px">
                        </lord-icon>
                        <span> Team</span>
                    </a>
                </li>
                <li class="centered">
                    <a href="game.html">
                        <lord-icon src="https://cdn.lordicon.com/aklfruoc.json" trigger="loop" delay="1500"
                            state="in-thumbs" colors="primary:#ffffff" style="width:30px;height:30px">
                        </lord-icon>
                        <span>Game</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="open-popup" data-popup="notifications">
                        <lord-icon src="https://cdn.lordicon.com/bxdnmmpl.json" trigger="loop" delay="1500"
                            state="in-thumbs" colors="primary:#ffffff" style="width:30px;height:30px">
                        </lord-icon>
                        <span>Refer</span>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="alert('Redirect To Gateway ...')">
                        <lord-icon src="https://cdn.lordicon.com/vyqvtrtg.json" trigger="loop" delay="1500"
                            state="morph-card-cash-2" colors="primary:#ffffff" style="width:30px;height:30px">
                        </lord-icon>
                        <span>Recharge</span>
                    </a>
                </li>
            </ul>
        </div> -->

        <!-- Social Icons Popup -->
        <div id="popup-social"></div>

        <!-- Alert -->
        <div id="popup-alert">
            <div class="counter"></div>
        </div>


        <!--  Slide up  Red Number -->



        <div class="slideup-modal arun" id="slide">
            <div class="slide-header" style="background-color: #000;">
                <h3 style="font-size: 20px; ">GAMEE ( <span id="number"></span> )</h3>

            </div>
            <div class="slide-body">
                <div class="form-group row align-items-center justify-content-end">


                    <div class="col-12" style="display:none;" id="otherchoose">

                        <button class="button btn--red otherbtn" tagvalue="0">0</button>


                        <button class="button btn--red otherbtn" tagvalue="1">1</button>


                        <button class="button btn--red otherbtn" tagvalue="2">2</button>


                        <button class="button btn--red otherbtn" tagvalue="3">3</button>


                        <button class="button btn--red otherbtn" tagvalue="4">4</button>


                        <button class="button btn--red otherbtn" tagvalue="5">5</button>


                        <button class="button btn--red otherbtn" tagvalue="6">6</button>


                        <button class="button btn--red otherbtn" tagvalue="7">7</button>


                        <button class="button btn--red otherbtn" tagvalue="8">8</button>


                        <button class="button btn--red otherbtn" tagvalue="9">9</button>


                    </div>


                    <div id="otherchoose2" style="display:none;">

                        <button class="button btn--red otherbtn2" tagvalue="0">0</button>

                        <button class="button btn--red otherbtn2" tagvalue="1">1</button>

                        <button class="button btn--red otherbtn2" tagvalue="2">2</button>

                        <button class="button btn--red otherbtn2" tagvalue="3">3</button>

                        <button class="button btn--red otherbtn2" tagvalue="4">4</button>

                        <button class="button btn--red otherbtn2" tagvalue="5">5</button>

                        <button class="button btn--red otherbtn2" tagvalue="6">6</button>

                        <button class="button btn--red otherbtn2" tagvalue="7">7</button>

                        <button class="button btn--red otherbtn2" tagvalue="8">8</button>

                        <button class="button btn--red otherbtn2" tagvalue="9">9</button>

                        <button class="button btn--red otherbtn2" tagvalue="10">10</button>


                        <button class="button btn--red otherbtn2" tagvalue="11">11</button>

                        <button class="button btn--red otherbtn2" tagvalue="12">12</button>


                        <button class="button btn--red otherbtn2" tagvalue="13">13</button>



                        <button class="button btn--red otherbtn2" tagvalue="14">14</button>


                        <button class="button btn--red otherbtn2" tagvalue="15">15</button>

                        <button class="button btn--red otherbtn2" tagvalue="16">16</button>



                        <button class="button btn--red otherbtn2" tagvalue="17">17</button>


                        <button class="button btn--red otherbtn2" tagvalue="18">18</button>


                        <button class="button btn--red otherbtn2" tagvalue="19">19</button>


                        <button class="button btn--red otherbtn2" tagvalue="20">20</button>


                        <button class="button btn--red otherbtn2" tagvalue="21">21</button>


                        <button class="button btn--red otherbtn2" tagvalue="22">22</button>


                        <button class="button btn--red otherbtn2" tagvalue="23">23</button>


                        <button class="button btn--red otherbtn2" tagvalue="24">24</button>


                        <button class="button btn--red otherbtn2" tagvalue="25">25</button>


                        <button class="button btn--red otherbtn2" tagvalue="26">26</button>


                        <button class="button btn--red otherbtn2" tagvalue="27">27</button>


                        <button class="button btn--red otherbtn2" tagvalue="28">28</button>


                        <button class="button btn--red otherbtn2" tagvalue="29">29</button>


                        <button class="button btn--red otherbtn2" tagvalue="30">30</button>


                        <button class="button btn--red otherbtn2" tagvalue="31">31</button>


                        <button class="button btn--red otherbtn2" tagvalue="32">32</button>


                        <button class="button btn--red otherbtn2" tagvalue="33">33</button>


                        <button class="button btn--red otherbtn2" tagvalue="34">34</button>


                        <button class="button btn--red otherbtn2" tagvalue="35">35</button>


                        <button class="button btn--red otherbtn2" tagvalue="36">36</button>


                        <button class="button btn--red otherbtn2" tagvalue="37">37</button>


                        <button class="button btn--red otherbtn2" tagvalue="38">38</button>


                        <button class="button btn--red otherbtn2" tagvalue="39">39</button>


                        <button class="button btn--red otherbtn2" tagvalue="40">40</button>


                        <button class="button btn--red otherbtn2" tagvalue="41">41</button>


                        <button class="button btn--red otherbtn2" tagvalue="42">42</button>


                        <button class="button btn--red otherbtn2" tagvalue="43">43</button>


                        <button class="button btn--red otherbtn2" tagvalue="44">44</button>


                        <button class="button btn--red otherbtn2" tagvalue="45">45</button>


                        <button class="button btn--red otherbtn2" tagvalue="46">46</button>


                        <button class="button btn--red otherbtn2" tagvalue="47">47</button>


                        <button class="button btn--red otherbtn2" tagvalue="48">48</button>


                        <button class="button btn--red otherbtn2" tagvalue="49">49</button>


                        <button class="button btn--red otherbtn2" tagvalue="50">50</button>


                        <button class="button btn--red otherbtn2" tagvalue="51">51</button>


                        <button class="button btn--red otherbtn2" tagvalue="52">52</button>


                        <button class="button btn--red otherbtn2" tagvalue="53">53</button>


                        <button class="button btn--red otherbtn2" tagvalue="54">54</button>


                        <button class="button btn--red otherbtn2" tagvalue="55">55</button>


                        <button class="button btn--red otherbtn2" tagvalue="56">56</button>


                        <button class="button btn--red otherbtn2" tagvalue="57">57</button>


                        <button class="button btn--red otherbtn2" tagvalue="58">58</button>


                        <button class="button btn--red otherbtn2" tagvalue="59">59</button>


                        <button class="button btn--red otherbtn2" tagvalue="60">60</button>


                        <button class="button btn--red otherbtn2" tagvalue="61">61</button>


                        <button class="button btn--red otherbtn2" tagvalue="62">62</button>


                        <button class="button btn--red otherbtn2" tagvalue="63">63</button>


                        <button class="button btn--red otherbtn2" tagvalue="64">64</button>


                        <button class="button btn--red otherbtn2" tagvalue="65">65</button>


                        <button class="button btn--red otherbtn2" tagvalue="66">66</button>


                        <button class="button btn--red otherbtn2" tagvalue="67">67</button>


                        <button class="button btn--red otherbtn2" tagvalue="68">68</button>


                        <button class="button btn--red otherbtn2" tagvalue="69">69</button>


                        <button class="button btn--red otherbtn2" tagvalue="70">70</button>


                        <button class="button btn--red otherbtn2" tagvalue="71">71</button>


                        <button class="button btn--red otherbtn2" tagvalue="72">72</button>


                        <button class="button btn--red otherbtn2" tagvalue="73">73</button>


                        <button class="button btn--red otherbtn2" tagvalue="74">74</button>


                        <button class="button btn--red otherbtn2" tagvalue="75">75</button>


                        <button class="button btn--red otherbtn2" tagvalue="76">76</button>


                        <button class="button btn--red otherbtn2" tagvalue="77">77</button>


                        <button class="button btn--red otherbtn2" tagvalue="78">78</button>


                        <button class="button btn--red otherbtn2" tagvalue="79">79</button>


                        <button class="button btn--red otherbtn2" tagvalue="80">80</button>


                        <button class="button btn--red otherbtn2" tagvalue="81">81</button>


                        <button class="button btn--red otherbtn2" tagvalue="82">82</button>


                        <button class="button btn--red otherbtn2" tagvalue="83">83</button>


                        <button class="button btn--red otherbtn2" tagvalue="84">84</button>


                        <button class="button btn--red otherbtn2" tagvalue="85">85</button>


                        <button class="button btn--red otherbtn2" tagvalue="86">86</button>


                        <button class="button btn--red otherbtn2" tagvalue="87">87</button>


                        <button class="button btn--red otherbtn2" tagvalue="88">88</button>


                        <button class="button btn--red otherbtn2" tagvalue="89">89</button>


                        <button class="button btn--red otherbtn2" tagvalue="90">90</button>


                        <button class="button btn--red otherbtn2" tagvalue="91">91</button>


                        <button class="button btn--red otherbtn2" tagvalue="92">92</button>


                        <button class="button btn--red otherbtn2" tagvalue="93">93</button>


                        <button class="button btn--red otherbtn2" tagvalue="94">94</button>


                        <button class="button btn--red otherbtn2" tagvalue="95">95</button>


                        <button class="button btn--red otherbtn2" tagvalue="96">96</button>


                        <button class="button btn--red otherbtn2" tagvalue="97">97</button>


                        <button class="button btn--red otherbtn2" tagvalue="98">98</button>


                        <button class="button btn--red otherbtn2" tagvalue="99">99</button>

                    </div>


                    <div class="col-12" style="display:none;" id="crosschoose">

                        <button class="button btn--red otherbtn" tagvalue="0">0</button>


                        <button class="button btn--red otherbtn" tagvalue="1">1</button>


                        <button class="button btn--red otherbtn" tagvalue="2">2</button>


                        <button class="button btn--red otherbtn" tagvalue="3">3</button>


                        <button class="button btn--red otherbtn" tagvalue="4">4</button>


                        <button class="button btn--red otherbtn" tagvalue="5">5</button>


                        <button class="button btn--red otherbtn" tagvalue="6">6</button>


                        <button class="button btn--red otherbtn" tagvalue="7">7</button>


                        <button class="button btn--red otherbtn" tagvalue="8">8</button>


                        <button class="button btn--red otherbtn" tagvalue="9">9</button>




                    </div>


                    <div id="selectedcross"></div>
                    <!-- <hr> -->
                    <div id="selectednos"></div>


                    <!-- <div class="col-12">
                        <hr>
                    </div> -->
                    <div class="col-4">
                        <p style="font-size: 17px;">Money</p>
                    </div>
                    <div class="col-8">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-light">
                                    <input type="radio" name="options" id="option1" value="10"
                                        onClick="rfun(this.value)" checked> 10
                                </label>
                                <label class="btn btn-light">
                                    <input type="radio" name="options" id="option1" value="100"
                                        onClick="rfun(this.value)"> 100
                                </label>
                                <label class="btn btn-light">
                                    <input type="radio" name="options" id="option2" value="500"
                                        onClick="rfun(this.value)"> 500
                                </label>
                                <label class="btn btn-light">
                                    <input type="radio" name="options" id="option3" value="1000"
                                        onClick="rfun(this.value)"> 1000
                                </label>
                                <label class="btn btn-light">
                                    <input type="radio" name="options" id="option4" value="5000"
                                        onClick="rfun(this.value)"> 5000
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- <hr> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <p style="font-size: 17px;">Multiply</p>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <button type="button" class="btn btn-primary btn-number" disabled="disabled"
                                    data-type="minus" data-field="quant[1]">
                                    -
                                </button>
                            </span>
                            <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1"
                                max="10">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                    data-field="quant[1]">
                                    +
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- <hr> -->
                    </div>
                </div>
                <div class="form-group form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="term" checked>
                    <label class="form-check-label" for="exampleCheck1" style="font-size: 17px;"> I Agree <a
                            href="#">Rules</a></label>
                </div>
            </div>
            <div class="slide-footer">
                <div class="row">
                    <a href="javascript:;" class="btn btn-dark btn-lg slideup-close col-4"
                        style="font-size: 17px;">Cancel</a>
                    <button class="btn btn-success col-8" id="raisebid" style="font-size: 15px;">Play Bet For Single
                        Number Price <span id="price">10</span></button>
                </div>
            </div>
        </div>
        <!--//  Slide up  Red Number -->




        <div class="modal fade" id="myModalalert" role="dialog">
            <div class="modal-dialog modal-dialog-centered">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">IMPORTANT MESSAGE :-</h5>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal"
                            aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body" id="altmsg">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!--<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>-->
        <script src="{{ asset('assets/fungame/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('assets/fungame/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('assets/fungame/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{ asset('assets/fungame/vendor/swiper/swiper.min.js')}}"></script>
        <script src="{{ asset('assets/fungame/js/jquery.custom.js')}}"></script>
        <script src="{{ asset('assets/fungame/js/header-scroll.js')}}"></script>
        <script src="{{ asset('assets/fungame/js/game-timer2.js?v=1727872577')}}"></script>


        <script>
            function shootalert(data) {
                $('#altmsg').html(data);
                $('#myModalalert').modal('show');
            }

            function rfun(browser) {
                var inn = $('.input-number').val();
                $('#price').html(browser * inn);
            }
        </script>




        <script>
            $(document).ready(function () {
                $(".btn-round").on('click', function () {
                    $(".slideup-modal").addClass("slideup-open");
                });
                $(".slideup-close").on('click', function () {
                    $(".slideup-modal").removeClass("slideup-open");
                });
            });
        </script>
        <script>
            $('#choosegame').change(function () {

                var gameid = $('#choosegame').val();
                //window.location.href = "fungame?gid=" + gameid;
                window.location.href = "fungame";

            });

            $('.otherbtn').click(function () {

                var va = $(this).attr('tagvalue');
                var type = $('#number').html();

                if (type == 'In Front') {
                    var intNumber = parseInt(va, 10); // Parse the tagvalue as an integer

                    // Ensure the number is between 1 and 9
                    if (intNumber >= 0 && intNumber <= 9) {
                        var result = [];

                        // Generate numbers like 21, 22, 23, ..., 29 if input is 2
                        for (var i = 0; i <= 9; i++) {
                            result.push(intNumber.toString() + i); // Concatenate the input number with 1 to 9
                        }

                        // Display the result
                        $('#selectednos').text(result.join(", "));
                    } else {
                        $('#selectednos').text("Invalid input! Enter a number between 1 and 9.");
                    }
                }

                if (type == 'In End') {
                    var intNumber = parseInt(va, 10); // Parse the tagvalue as an integer

                    // Ensure the number is between 1 and 9
                    if (intNumber >= 0 && intNumber <= 9) {
                        var result = [];

                        result.push(intNumber.toString());

                        // Generate numbers like 21, 22, 23, ..., 29 if input is 2
                        for (var i = 1; i <= 9; i++) {
                            result.push(i + intNumber.toString()); // Concatenate the input number with 1 to 9
                        }

                        // Now add the "extra" number at the end (for example, append 10)
                        // Appends 20 for 2, 30 for 3, etc.

                        // Display the result
                        $('#selectednos').text(result.join(", "));

                    } else {
                        $('#selectednos').text("Invalid input! Enter a number between 1 and 9.");
                    }
                }

                if (type == 'Combine Front End') {
                    var intNumber = parseInt(va, 10); // Parse the tagvalue as an integer

                    // Ensure the number is between 1 and 9
                    if (intNumber >= 0 && intNumber <= 9) {
                        var result = [];
                        if (!result.includes(intNumber)) {
                            result.push(intNumber.toString());
                        }
                        // Generate numbers like 21, 22, 23, ..., 29 if input is 2
                        for (var i = 1; i <= 9; i++) {


                            if (!result.includes(i + intNumber)) {
                                result.push(i + intNumber.toString());
                            }// Concatenate the input number with 1 to 9


                        }

                        for (var i = 0; i <= 9; i++) {

                            if (intNumber == 0) {
                                if (!result.includes(i + intNumber)) {
                                    result.push(i);
                                }// Concatenate the input number with 1 to 9

                            } else {

                                if (!result.includes(i + intNumber)) {
                                    result.push(intNumber.toString() + i);
                                }// Concatenate the input number with 1 to 9

                            }
                        }

                        // Now add the "extra" number at the end (for example, append 10)
                        // Appends 20 for 2, 30 for 3, etc.

                        // Display the result
                        var uniqueResult = Array.from(new Set(result));

                        // Display the result
                        $('#selectednos').text(uniqueResult.join(", "));

                    } else {
                        $('#selectednos').text("Invalid input! Enter a number between 1 and 9.");
                    }
                }

                if (type === 'Max Combine') {
                    // Parse the input value (va) as an integer
                    var intNumber = parseInt(va, 10);

                    // Check if the parsed number is between 0 and 9
                    if (intNumber >= 0 && intNumber <= 9) {
                        var result = [];

                        // Check if the number is not already in the result array
                        if (!result.includes(intNumber.toString())) {
                            result.push(intNumber.toString()); // Append the number as a string if not present
                        }

                        var getin = $('#selectedcross').html();

                        if (getin === '') {
                            $("#selectedcross").append(intNumber);
                        } else {
                            // Display the result in #selectedcross, joining array elements with ", "
                            $("#selectedcross").append("," + intNumber);

                        }
                    } else {
                        // Display an error message for invalid input
                        $('#selectedcross').text("Invalid input! Enter a number between 0 and 9.");
                    }
                }


            });

            $('.otherbtn2').click(function () {

                var va = $(this).attr('tagvalue');

                $(this).toggleClass("btn--red");

                // $(this).removeClass("btn--red");
                //$(this).addClass("btn--green");

                var type = $('#number').html();

                var getin = $('#selectednos').html();

                if (getin === '') {
                    $("#selectednos").append(va);
                } else {

                    $("#selectednos").append("," + va);

                }
                // Concatenate the input number with 1 to 9

                // Display the result
                //  $('#selectednos').text(result.join(", "));



            });

            $('.mybtn').click(function (e) {
                e.preventDefault();

                tagvalue = $(this).attr('tagvalue');

                var violetarray = [];
                violetarray.push("0");
                violetarray.push("5");
                violetarray.push("Violet");


                var greenarray = [];
                greenarray.push("0");
                greenarray.push("1");
                greenarray.push("3");
                greenarray.push("6");
                greenarray.push("8");
                greenarray.push("Green");

                if (jQuery.inArray(tagvalue, greenarray) !== -1) {  //alert(tagvalue);
                    $("#slide").removeClass("bidmodal-red");
                    $("#slide").removeClass("bidmodal-violet");
                    $("#slide").addClass("bidmodal-green");
                } else {

                    if (jQuery.inArray(tagvalue, greenarray) !== -1) {
                        $("#slide").removeClass("bidmodal-green");
                        $("#slide").removeClass("bidmodal-red");
                        $("#slide").addClass("bidmodal-violet");
                    } else {
                        $("#slide").removeClass("bidmodal-green");
                        $("#slide").removeClass("bidmodal-violet");
                        $("#slide").addClass("bidmodal-red");
                    }
                }

                // if(tagvalue==)
                var btnflag = 0;
                if (tagvalue == 'In Front') { btnflag = 1; }

                if (tagvalue == 'In End') { btnflag = 1; }

                if (tagvalue == 'Combine Front End') { btnflag = 1; }

                if (tagvalue == 'Max Combine') { btnflag = 2; }

                if (btnflag > 1) {

                    $('#crosschoose').show();
                    $('#otherchoose').hide();
                    $('#otherchoose2').hide();

                } else {

                    if (btnflag > 0) { $('#otherchoose').show(); $('#otherchoose2').hide(); } else { $('#otherchoose').hide(); $('#otherchoose2').show(); }

                }

                $('#number').html(tagvalue);
                $(".slideup-modal").addClass("slideup-open");
            });


            $('.btn-number').click(function (e) {
                e.preventDefault();

                amt = $('input[name=options]:checked').val();
                //alert(amt);

                fieldName = $(this).attr('data-field');
                type = $(this).attr('data-type');
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());



                if (!isNaN(currentVal)) {
                    if (type == 'minus') {

                        if (currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }

                    } else if (type == 'plus') {

                        if (currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }

                    }

                    var currentVal = parseInt(input.val());
                    $('#price').html(amt * currentVal);


                } else {
                    input.val(0);
                }
            });
            $('.input-number').focusin(function () {
                $(this).data('oldValue', $(this).val());
            });
            $('.input-number').change(function () {

                minValue = parseInt($(this).attr('min'));
                maxValue = parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                name = $(this).attr('name');
                if (valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));
                }
                if (valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                }
            });

            $(".input-number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });



            $('#raisebid').click(function () {

                var amt = $('#price').html();
                var number = $('#number').html();
                var gameid = $('#gameid').val();
                var duration = $('#gameduration').val();
                var other = $('#selectednos').html();

                if (!($('#term').prop('checked'))) {
                    shootalert("You should agree with our rules.<br/>");
                    $('#lock').show();

                    return false;
                }

                $.post("bid.html",
                    {
                        amount: amt,
                        number: number,
                        gameid: gameid,
                        duration: duration,
                        other: other
                    },
                    function (data, status) {
                        if (data == 1) {
                            $(".slideup-modal").removeClass("slideup-open");

                            $('#game_tablee').load(location.href + " #game_tablee");
                            //    $('#game_table').load(location.href + " #game_table");

                            shootalert("Your Bid Raised.<br/>");
                            updatebal();
                        } else {
                            shootalert(data);
                        }
                    });
            });

            function updatebal() {
                $.post("getbal.html",
                    {
                        balance: "b"
                    },
                    function (data, status) {
                        $('#balance').html(data);
                    });
                //  $('#balance').html(0);
            }
        </script>


        <script>
            var audio = document.getElementById("myAudio");

            document.addEventListener("visibilitychange", function () {
                if (document.visibilityState === 'hidden') {
                    // Page is now hidden, pause the audio
                    audio.pause();
                } else {
                    // Page is now visible, resume playing the audio if it was playing before
                    if (!audio.paused) {
                        audio.play();
                    }
                }
            });
        </script>

        <script>
            jQuery(document).ready(function ($) {
                $('#game_table').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": false,
                    "autoWidth": true,
                    "responsive": true
                });
            });
        </script>
        <script>
            jQuery(document).ready(function ($) {
                $('#game_tablee').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": false,
                    "autoWidth": true,
                    "responsive": true
                });
            });
        </script>

</body>

</html>