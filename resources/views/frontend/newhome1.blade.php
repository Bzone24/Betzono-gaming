@extends('frontend.master')
@section('content')
    <!-- Hero Section Start -->
    <section id="home" class="hero-section go-zoom-1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content top-greadient">
                        <span class="wow fadeInLeft mb-20" data-wow-delay=".2s">Welcome To Bzone24</span>
                        <h1 class="wow fadeInUp" data-wow-delay=".4s">
                            Play Online <span class="common-gre-color">Games & Win</span> Money Unlimited
                        </h1>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Play casino and earn crypto in online. The ultimate
                            online gaming & casino platform.</p>
                        <a href="{{ route('user.login') }}" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Play Now!</a>
                        <a href="{{ route('user.register') }}" class="main-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Sign Up</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-img wow fadeInRight" data-wow-delay=".5s">
                        <img src="{{ asset('assets/front/img/hero/hero-01.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
    <!-- New image slider trying -->

    <!-- <div class="main-wrapper">
        <div class="slider-btns">
            <span id="prev-btn"><i class="fa-solid fa-chevron-left"></i></span>
            <span id="next-btn"><i class="fa-solid fa-angle-right"></i></span>
        </div>
        <div class="slider-wrapper">
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>

            </div>
            <div class="slides">
                <h1></h1>
                <img src="assets/img/Slider/5.png" alt="Roullete banner" class="responsive">
            </div>
            <div class="slides">
                <h1></h1>
                <img src="assets/img/Slider/6.jpeg" alt="casino banner" class="responsive">
            </div>
            <div class="slides">
                <h1></h1>
                <img src="assets/img/Slider/9.jpg" alt="sports banner" class="responsive">
            </div>
        </div>
    </div> -->

    <!-- images slider edn here -->
     <div>

     </div>

    <div class="slideshow-container">
        <div class="mySlides">
            <div class="numbertext">1 / 3</div>
            <img src="{{ asset('assets/front/img/testimonial/14b.jpg')}}" style="width:100%">
            <!-- <div class="text">Caption Text</div> -->
          </div>
        <div class="mySlides">
            <div class="numbertext">2 / 3</div>
            <img src="{{ asset('assets/front/img/testimonial/13b.jpg')}}" style="width:100%">
            <!-- <div class="text">Caption Text</div> -->
          </div>
         <div class="mySlides">
            <div class="numbertext">3 / 3</div>
            <img src="{{ asset('assets/front/img/testimonial/casino.jpeg')}}" style="width:100%">
          </div>
        </div>
          <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <span class="dot" onclick="currentSlide(3)"></span>
</div>

    </div>


    <!-- About Section Start -->
    <section id="about" class="about-section pt-100 pb-95">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-img wow fadeInLeft" data-wow-delay=".2s">
                        <img src="{{ asset('assets/front/img/about/about-01.png')}}" alt="about">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content left-greadient mb-40">
                        <div class="section-title mb-40">
                            <h1 class="mb-20">About <span class="common-gre-color">BZONE24</span> Gamezone</h1>
                            <p>A Game-zone is a facility for certain types of games. We have Sports Betting, Race Games
                                (Horse, Dog, Camel Race) Crash Games, Fast Games, Casino Slots, Live Casino games
                                (Roullete, Blackjack, Dragon Tiger, ETC), Lottery.</p>
                        </div>
                        <a href="#" class="main-btn btn-hover">View More</a>
                    </div>
                    <div class="counter-up-wrapper">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mt-3">
                                <div class="single-counter box-inner-shadow">
                                    <div class="content">
                                        <h1 class="countup"><span>$</span><span class="counter">14,567</span></h1>
                                        <span>Today Win Upto</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mt-3">
                                <div class="single-counter box-inner-shadow">
                                    <div class="content">
                                        <h1 class="countup"><span class="counter">2,436</span></h1>
                                        <span>Happy Winners</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mt-3">
                                <div class="single-counter box-inner-shadow">
                                    <div class="content">
                                        <h1 class="countup"><span class="counter">942</span></h1>
                                        <span>Players Online</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mt-3">
                                <div class="single-counter box-inner-shadow">
                                    <div class="content">
                                        <h1 class="countup"><span>$</span><span class="counter">26</span><span>K</span>
                                        </h1>
                                        <span>Daily Tournaments</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Game Section Start -->
    <section id="game" class="game-section pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-10">
                    <div class="section-title text-center right-greadient mb-50">
                        <h1 class="mb-25">Our Rated <span class="common-gre-color">Games</span></h1>
                        <p>A Bzone24 is a facility for certain types of games. Our Gamezone offers Fast games, Crash
                            Games, Race Games, Casino, Live Casino, Sports Betting, Lottery and much more</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-01.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Daily Lottery</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="#">Play Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-02.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Live Casino</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="https://bzone24.com/live-casino" target="_blank">Play
                                Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-03.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Crash Games</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="https://bzone24.com/crash" target="_blank">Play Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-04.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Sports Betting</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="https://bzone24.com/sport/home" target="_blank">Play
                                Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-05.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Race Games </h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="https://bzone24.com/races" target="_blank">Play Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-06.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Card Games</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="https://bzone24.com/live-casino" target="_blank">Play
                                Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-07.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Casino Slots</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="https://bzone24.com/casino" target="_blank">Play
                                Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-08.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Poker Games</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="https://bzone24.com/live-casino" target="_blank">Play
                                Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-09.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Poker Games</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="#">Play Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-10.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Poker Games</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="#">Play Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-11.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Poker Games</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="#">Play Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="single-game box-inner-shadow">
                        <div class="game-thumb">
                            <img src="{{ asset('assets/front/img/games/game-04.png')}}" alt="game-img" class="rounded-3 w-100">
                        </div>
                        <div class="game-content mt-10">
                            <h3>Poker Games</h3>
                            <p class="mb-15"></p>
                            <a class="play-btn btn-hover" href="#">Play Now!</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="view-all-btn text-center pt-30">
                <a href="#" class="main-btn btn-hover">View All Services</a>
            </div>
        </div>
    </section>
    <!-- Game Section End -->

    <!-- Faq Section Start -->
    <section id="faq" class="faq-section pt-95 pb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-10">
                    <div class="section-title text-center left-greadient mb-50">
                        <h1><span class="common-gre-color">FAQ</span>s</h1>
                        <p>A Bzone24 Gamezone is a facility for certain types of Sports games, live Casino Games much
                            more for enjoying.</p>
                    </div>
                </div>
            </div>
            <div class="row" id="accordionExample">
                <div class="col-md-6">
                    <div class="accordion pb-15">
                        <div class="single-faq box-inner-shadow">
                            <button class="w-100 text-start" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Why do I
                                need to be registered on Bzone24?</button>
                            <div id="collapseOne" class="collapse show" data-bs-parent="#accordionExample">
                                <div class="faq-content">
                                    Registration on Bzone24 website is a condition for using all the products available
                                    on the website. Registration entitles you to open a Bzone24 account free-of-charge
                                    and without obligations. Use the account to manage your bets and personal data. You
                                    can make bets with real money after you replenish your account.
                                </div>
                            </div>
                        </div>
                        <div class="single-faq box-inner-shadow">
                            <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">I don’t
                                want to deposit money right after registration. Do I have to?</button>
                            <div id="collapseTwo" class="collapse" data-bs-parent="#accordionExample">
                                <div class="faq-content">
                                    You don’t need to make a deposit immediately. You may make a deposit whenever you
                                    like by using the “Deposit” option.
                                </div>
                            </div>
                        </div>
                        <div class="single-faq box-inner-shadow">
                            <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Can
                                I change my personal data after registration?</button>
                            <div id="collapseThree" class="collapse" data-bs-parent="#accordionExample">
                                <div class="faq-content">
                                    Please note that you will no longer be able to modify your basic data, such as your
                                    first name and last name, date of birth, the currency of your account in Bzone24 or
                                    the country settings. Seriousness and trustworthiness are the top priorities for
                                    Bzone24. You will, however, still be able to change other data even after
                                    registration. In special cases (e.g. the personal data was filled incorrectly,
                                    etc.), Bzone24 will verify and accept changes to your basic data if you submit the
                                    corresponding confirming document.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="accordion pb-15">
                        <div class="single-faq box-inner-shadow">
                            <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">What
                                should I do if I have forgotten my username/password?</button>
                            <div id="collapseFour" class="collapse" data-bs-parent="#accordionExample">
                                <div class="faq-content">
                                    If you’ve forgotten your password, first try to restore it through the site using
                                    the “Forgot password?” option. Password recovery will not function in some cases
                                    (e.g. the e-mail address is wrong or there are technical problems). If you’ve
                                    forgotten your username or if you experience any other issues, you should contact us
                                    through Live Support, send us an email using our support email address
                                    help@Bzone24.com or the “Send a Message” option on Live chat.
                                </div>
                            </div>
                        </div>
                        <div class="single-faq box-inner-shadow">
                            <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">What
                                kind of games can I play online at the Bzone24 Gamezone?</button>
                            <div id="collapseFive" class="collapse" data-bs-parent="#accordionExample">
                                <div class="faq-content">
                                    Bzone24 offers a wide selection of games to our players. You can find many different
                                    3D games, Table games, a huge variety of Slot games, and even Live games including
                                    Blackjack and Roulette, with Baccarat and Crash Games, Fast Games including Head &
                                    Tale, Mine Game, Stone Paper Seizer, Bomb Sqard and Race games, Lotteries and many
                                    easier to play games.
                                </div>
                            </div>
                        </div>
                        <div class="single-faq box-inner-shadow">
                            <button class="w-100 text-start collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">How to I
                                withdraw my fund?</button>
                            <div id="collapseSix" class="collapse" data-bs-parent="#accordionExample">
                                <div class="faq-content">
                                    Click on withdrawal Option and choose method what you want you and make a request.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Faq Section End -->

    <!-- Pricing Section Start -->
    <section id="pricing" class="pricing-section pt-95 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-6">
                    <div class="pricing-content">
                        <div class="image">
                            <img src="{{ asset('assets/front/img/pricing/price-01.png')}}" alt="Price">
                        </div>
                        <div class="section-title">
                            <h1 class="mb-20 wow fadeInUp" data-wow-delay=".2s">Supported<span
                                    class="common-gre-color">Currency
                                    Option</span></h1>
                            <p class="wow fadeInUp" data-wow-delay=".4s">A Bzone24 Gamezone is Offers to user Fiat
                                Current and USDT Option. Fiat currency Option Like GPAY,PhonePay,UPI,IMPS and For
                                cryptocurrency We support USDT on BEP20 Blockchain. In the future we will add more
                                blockhains and cryptocurrency.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-6">
                    <div class="pricing-active-wrapper">
                        <div class="pricing-active">
                            <div class="pricing-box">
                                <div class="single-pricing box-inner-shadow">
                                    <div class="price-header">
                                        <div class="shape">

                                        </div>
                                        <div class="text">
                                            <h3 class="package-name">Crypto Deposit</h3>
                                            <h2 class="price">USDT (BEP20)</h2>
                                        </div>
                                    </div>
                                    <ul class="content">
                                        <li>Fast and Secure</li>
                                        <li>In the future add more crypto options</li>
                                        <!-- <li>E-commerce website</li> -->
                                        <!-- <li>Create new business</li> -->
                                        <!-- <li>Startup business design</li> -->
                                        <!-- <li>Product design</li> -->
                                    </ul>
                                    <div class="pricing-btn text-center">
                                        <a href="#" class="main-btn btn-hover">Deposit now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="pricing-box">
                                <div class="single-pricing box-inner-shadow">
                                    <div class="price-header">
                                        <div class="shape">

                                        </div>
                                        <div class="text">
                                            <h3 class="package-name">Fiat currency</h3>
                                            <h2 class="price">INR</h2>
                                        </div>
                                    </div>
                                    <ul class="content">
                                        <li>GPAY, PhonePay</li>
                                        <li>UPI IMPS, NEFT</li>
                                        <li>Bank Transfer </li>
                                        <!-- <li>Create new business</li> -->
                                        <!-- <li>Startup business design</li> -->
                                        <!-- <li>Product design</li> -->
                                    </ul>
                                    <div class="pricing-btn text-center">
                                        <a href="#" class="main-btn btn-hover">Deposit now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="pricing-box">
                                <div class="single-pricing box-inner-shadow">
                                    <div class="price-header">
                                        <div class="shape">

                                        </div>
                                        <div class="text">
                                            <h3 class="package-name">Fiat Currency</h3>
                                            <h2 class="price">USD</h2>
                                        </div>
                                    </div>
                                    <ul class="content">
                                        <li>Coming Soon</li>
                                        <li>Debit Card & Credit Card </li>
                                        <li>More Options Soon</li>
                                        <!-- <li>Create new business</li> -->
                                        <!-- <li>Startup business design</li> -->
                                        <!-- <li>Product design</li> -->
                                    </ul>
                                    <div class="pricing-btn text-center">
                                        <a href="#" class="main-btn btn-hover">Coming Soon</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Section End -->

    <!-- Team Section Start -->
    <section id="team" class="team-section pt-95 pb-65">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7">
                    <div class="section-title text-center right-greadient mb-60">
                        <h1 class="mb-20 wow fadeInUp" data-wow-delay=".2s">Our <span class="common-gre-color">Gaming
                                Partners</span></h1>
                        <p class="wow fadeInUp" data-wow-delay=".4s">A bzone24 gamezone provides complete gaming experience with wide range of games.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-3 col-md-6 col-sm-10">
                    <div class="single-team box-inner-shadow">
                        <div class="image">
                            <img src="{{ asset('assets/front/img/team/team-01.png')}}" alt=""> `
                        </div>
                        <div class="content">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-10">
                    <div class="single-team box-inner-shadow">
                        <div class="image">
                            <img src="{{ asset('assets/front/img/team/team-02.png')}}" alt="">
                        </div>
                        <div class="content">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-10">
                    <div class="single-team box-inner-shadow">
                        <div class="image">
                            <img src="{{ asset('assets/front/img/team/team-03.png')}}" alt="">
                        </div>
                        <div class="content">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-10">
                    <div class="single-team box-inner-shadow">
                        <div class="image">
                            <img src="{{ asset('assets/front/img/team/team-04.png')}}" alt="">
                        </div>
                        <div class="content">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Testimonial Section Start -->
    <section id="testimonial" class="testimonial-section pt-95 pb-105">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center mb-60">
                        <h1 class="mb-20 wow fadeInUp" data-wow-delay=".2s"><span class="common-gre-color">Bzone
                                Supporting</span></h1>
                        <p class="wow fadeInUp" data-wow-delay=".4s">Bzone24 is provide to players wide range of deposit
                            and withdrawl Option including cryptocurrency!</p>
                    </div>
                </div>
            </div>
            <!-- <div class="testimonial-active-wrapper"> -->
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12">
                    <div class="testimonial-active">
                        <!-- <div class="single-testimonial mt-20 mb-20"> -->
                            <!-- <div class="testimonial-con-all box-inner-shadow"> -->
                                 <!-- <div class="image">
                                        <img src="assets/img/testimonial/13.png" alt="">
                                    </div>
                                    <div class="image">
                                        <img src="assets/img/testimonial/14.png" alt="">
                                    </div>
                                    <div class="image">
                                        <img src="assets/img/testimonial/13b.jpg" alt="">
                                    </div> -->
                                    <!-- <div class="slider-img">
                                        <img src="assets/img/testimonial/14b.jpg" alt="">
                                    </div>  -->


                                <!-- <div class="content">
                                        <p></p>
                                    </div>
                                    <div class="info">
                                        <h4>Casino Games</h4>
                                        <p></p>
                                    </div>
                                </div>
                            </div> -->
                                <!-- <div class="single-testimonial mt-20 mb-20">
                                <div class="testimonial-con-all box-inner-shadow"> -->
                                <!-- <div class="image">
                                        <img src="assets/img/testimonial/14.png" alt="">
                                    </div> -->
                                <!-- <div class="content">
                                        <p>Sports Bettin</p>
                                    </div>
                                    <div class="info">
                                        <h4>Haris Ahmed</h4>
                                        <p>Business Man</p>
                                    </div>
                                </div>
                            </div> -->
                                <!-- <div class="single-testimonial mt-20 mb-20">
                                <div class="testimonial-con-all box-inner-shadow"> -->
                                <!-- <div class="image">
                                        <img src="assets/img/testimonial/13b.jpg" alt="">
                                    </div> -->
                                <!-- <div class="content">
                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                            eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                            voluptua.</p>
                                    </div>
                                    <div class="info">
                                        <h4>Ahmed Josef</h4>
                                        <p>Business Man</p> -->
                            </div>
                        </div>
                    </div>

                    <section>
                        <!-- <h1>Our Partners</h1> -->
                        <div class="slider">
                            <div class="slider-items">
                                <img src="{{ asset('assets/front/img/brand_logo/bitcoin.png')}}"
                                    alt="">
                                <img src="{{ asset('assets/front/img/brand_logo/usdt.png')}}"
                                    alt="">
                                <img src="{{ asset('assets/front/img/brand_logo/secured.png')}}"
                                    alt="">
                                <img src="{{ asset('assets/front/img/brand_logo/trust.png')}}"
                                    alt="">
                                <img src="{{ asset('assets/front/img/brand_logo/visa.png')}}"
                                    alt="">
                                <img src="{{ asset('assets/front/img/brand_logo/mastercard.png')}}" alt="">
                                <img src="{{ asset('assets/front/img/brand_logo/ae.png')}}" alt="">
                                <img src="{{ asset('assets/front/img/brand_logo/paypal.png')}}" alt="">
                                <!-- <img src="https://brandlogos.net/wp-content/uploads/2014/12/starbucks_coffee_company-logo_brandlogos.net_9jqys.png"
                                    alt="">
                                <img src="https://www.zarla.com/images/nike-logo-2400x2400-20220504.png?crop=1:1,smart&width=150&dpr=2"
                                    alt="">
                                <img src="https://www.zarla.com/images/apple-logo-2400x2400-20220512-1.png?crop=1:1,smart&width=150&dpr=2"
                                    alt="">
                                <img src="https://www.zarla.com/images/disney-logo-2400x2400-20220513-2.png?crop=1:1,smart&width=150&dpr=2"
                                    alt="">
                                <img src="https://upload.wikimedia.org/wikipedia/en/thumb/4/4d/Loon_%28company%29_logo.svg/800px-Loon_%28company%29_logo.svg.png"
                                    alt="">
                                <img src="https://upload.wikimedia.org/wikipedia/en/thumb/3/37/Jumpman_logo.svg/1200px-Jumpman_logo.svg.png"
                                    alt="">
                                <img src="https://www.svgrepo.com/show/303123/bmw-logo.svg" alt="">
                                <img src="https://brandlogos.net/wp-content/uploads/2014/12/starbucks_coffee_company-logo_brandlogos.net_9jqys.png"
                                    alt=""> -->


                            </div>
                        </div>

                    </section>
                    <!-- <section id="banner-slider"> -->
                        <!-- <section id="banner-slider" class="promo-banner">
                    <div class="slideshow-container">
                        <div class="mySlides fade">
                            <div class="numbertext">1 / 3</div>
                            <img src="assets/img/testimonial/13.png" alt="">
                        </div>
                        <div class="mySlides fade">
                            <div class="numbertext">2 / 3</div>
                            <img src="assets/img/testimonial/14.png" alt="" style="width:100%">
                        </div>
                        <div class="mySlides fade">
                            <div class="numbertext">3 / 3</div>
                            <img src="assets/img/testimonial/13b.jpg" alt="" style="width:100%">
                        </div>
                        <div class="mySlides fade">
                            <div class="numbertext">4 / 3</div>
                            <img src="assets/img/testimonial/14b.jpg" alt="" style="width:100%">
                        </div>

                        <div class="mySlides fade">
                            <div class="numbertext">5 / 3</div>
                            <img src="assets/img/testimonial/14b.jpg" alt="" style="width:100%">
                        </div>
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                    <br> -->
                    <!-- The dots/circles -->
                    <!-- <div style="text-align:center">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
                    </div>
                </section>  -->
                <!-- </section> -->
                    <!-- <div class="content">
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                    eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                    voluptua.</p>
                            </div>
                            <div class="info">
                                <h4>Haris Ahmed</h4>
                                <p>Business Man</p> -->
                <!-- </div> -->
            <!-- </div> -->
        </div>
        </div>
        </div>
        </div>
    </section>
    <!-- Testimonial Section Start -->
@endsection
