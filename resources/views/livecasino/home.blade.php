<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Betzono</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <!--<link rel="stylesheet" href="{{ asset('assets/newhome/css/plugins.css')}}" />-->
    <style>
        @keyframes rotate-sun-rays {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .sun-rays {
            position: absolute;
            width: 400%;
            /* Make rays extend beyond the div */
            height: 400%;
            background: repeating-conic-gradient(transparent 0deg,
                    transparent 20deg,
                    rgba(255, 255, 255, 0.362) 25deg);
            animation: rotate-sun-rays 8s linear infinite;
            mask-image: radial-gradient(circle, transparent 10%, rgba(255, 255, 255, 0.348) 15%);
            clip-path: circle(150px at center);
            /* Keeps the center small */
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px; /* Slim scrollbar */
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #000; /* Pure black track */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #fc6404; /* Bright orange scrollbar */
            border-radius: 10px;
            border: 2px solid #000; /* Adds black border around thumb */
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #e65c00; /* Darker orange on hover */
        }

        .loader-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            width: 100%;
        }

        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #fc6404;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        

    </style>
</head>
<body class="bg-[#181818] text-white">
    <!-- Header -->
    {{-- <header class="p-4 bg-[#181818] shadow-lg">
        <div class="container mx-auto max-w-6xl px-5 flex justify-between items-center ">
            <h1 class="text-2xl font-bold">StakEye</h1>
            <div>
                <div class="flex items-center justify-between bg-[#181818] p-4 rounded-lg shadow-lg">
                    @auth
                    <div class="flex items-center space-x-4">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->firstname .' '. Auth::user()->lastname }}&background=fc6404&color=fff" 
                            alt="User Avatar" 
                            class="w-12 h-12 rounded-full border-2 border-[#fc6404] object-cover shadow-md" />
                        
                        <div>
                            <h4 class="text-white font-semibold text-lg leading-tight mr-2">{{ Auth::user()->username }}</h4>
                            <p class="text-gray-400 text-sm mr-2">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                
                    <button id="logoutBtn" 
                        class="bg-[#fc6404] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md">
                        Dashboard
                    </button>
                    @else
                    <div class="flex items-center space-x-2">
                        <button id="openLoginModalBtn" 
                            class="bg-[#fc6404] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md">
                            Login
                        </button>
                        <button id="openRegisterModalBtn" 
                            class="bg-[#fc6404] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md">
                            Register
                        </button>
                    </div>
                    @endauth
                </div>
                <button id="openModalBtn" class="bg-[#fc6404] text-[#fff] py-1.5 px-4 rounded-full ">Login</button>
                <button class="bg-[#fc6404] text-[#fff] py-1.5 px-4 rounded-full ml-1">Signup</button>
            </div>
        </div>
    </header> --}}

    <header class="p-4 bg-[#181818] shadow-lg">
        <div class="container mx-auto max-w-6xl px-5 flex flex-wrap justify-between items-center gap-4">
            <!-- ✅ Logo using Image -->
            <a href="{{ route('user.home') }}">
                <img src="{{ asset('assets/images/logo_icon/logo.png') }}" alt="STAKEYE Logo" class="h-12 object-contain">
            </a>
            
            @auth
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <!-- ✅ User Info -->
                    <div class="flex items-center bg-[#212121] px-4 py-2 rounded-full shadow-lg w-full sm:w-auto">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}&background=fc6404&color=fff"
                            alt="User Avatar"
                            class="w-10 h-10 rounded-full border-2 border-[#fc6404] object-cover shadow-md" />
    
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-base leading-tight truncate">
                                {{ Auth::user()->username }}
                            </h4>
                            <p class="text-gray-400 text-sm truncate">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>
    
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="bg-[#181818] text-#ff6604 font-semibold px-4 py-2 rounded-full shadow-md w-full sm:w-auto text-center">
                            Balance: ₹{{ number_format(Auth::user()->balance, 2) }}
                        </div>
                        <a href="{{ route('user.home') }}" target="_self" rel="noopener noreferrer"
                        id="dashboardBtn" class="bg-[#fc6404] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md w-full sm:w-auto">
                            Dashboard</a>
                        <a href="{{ route('user.logout') }}" target="_self" rel="noopener noreferrer" class="bg-red-500 text-white font-medium px-4 py-2 rounded-full hover:bg-red-600 transition duration-300 shadow-md w-full sm:w-auto">
                            Logout</a>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <a href="{{ route('user.login') }}" target="_self" rel="noopener noreferrer" id="openLoginModalBtn"
                    class="bg-[#fc6404] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md w-full sm:w-auto">
                    Login</a>
                    <a href="{{ route('user.register') }}" target="_self" rel="noopener noreferrer" id="openRegisterModalBtn"
                    class="bg-[#fc6404] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md w-full sm:w-auto">
                    Register</a>
                </div>
            @endauth
        </div>
    </header>


    <!-- Hero Section with Slider -->
    <section class="relative w-full mt-4">
        <div class="container mx-auto max-w-6xl px-5">
            <div class="swiper mySwiper w-full h-full">
                <div class="swiper-wrapper">
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/4140abdd-f735-49ff-9ee6-f1a9133aa403.png"
                            alt="Game 2" class="rounded-lg shadow-lg">
                        <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                            <button
                                class="flex items-center bg-[#fc6404] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                    class="mb-1">Let's go</span></button>
                        </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/2fbe3a6c-0ee4-4939-8b72-02f1a8bdce2d.png"
                            alt="Game 1" class="rounded-lg shadow-lg">
                            <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                                <button
                                    class="flex items-center bg-[#fc6404] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                        class="mb-1">Let's go</span></button>
                            </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/21c4bea9-4ad7-40eb-bc70-bf6685e469a4.png"
                            alt="Game 2" class="rounded-lg shadow-lg">
                            <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                                <button
                                    class="flex items-center bg-[#fc6404] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                        class="mb-1">Let's go</span></button>
                            </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/b56567fa-ff4e-4928-be06-69c437016278.png"
                            alt="Game 3" class="rounded-lg shadow-lg">
                            <!-- overlay content -->
                            <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                                <h6 class="text-white font-bold text-2xl">Drops & Wins</h6>
                                <div id="timer" class="mb-5"></div>
                                <button class="flex items-center bg-[#fc6404] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                        class="mb-1">Let's go</span>
                                </button>
                            </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/2984f3ce-66ee-4062-89dc-72a1f94dc583.png"
                            alt="Game 1" class="rounded-lg shadow-lg">
                            <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                                <button
                                    class="flex items-center bg-[#fc6404] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                        class="mb-1">Let's go</span></button>
                            </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/9092cf5a-2521-454c-9623-d70f769271e4.png"
                            alt="Game 2" class="rounded-lg shadow-lg">
                            <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                                
                                <button
                                    class="flex items-center bg-[#fc6404] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                        class="mb-1">Let's go</span></button>
                            </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section class="relative w-full mt-6">
        <div class="container mx-auto max-w-6xl px-5">
            <div class="bg-gradient-to-r from-[#111111] to-[#111111] p-3 rounded-lg shadow-2xl">
                <div class="flex items-center justify-between w-full">
                    <div class="w-full flex items-center bg-[#000] rounded-xl lg:mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-10 lg:size-8 text-[#fc6404] ml-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" class="w-full bg-transparent px-3 py-3 border-none focus:outline-none" />
                        <!--<button class="bg-[#fc64043d] text-[#fc6404] py-3 px-6 rounded-xl ml-1">Search</button>-->
                    </div>
                    <div class="lg:sm ml-1">
                        <button id="openProviderModalBtn"
                            class="bg-[#fc6404] flex items-center whitespace-nowrap text-white rounded-xl px-6 py-3">
                            All Provides
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 ml-2 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mt-5">
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold border border-solid border-[#fc6404] hover:bg-[#fc64043d] game-type-btn" data-type="all games">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/all.webp" class="size-6 mr-2" />
                        All Games
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="slots">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/slots.webp" class="size-6 mr-2" />
                        Slots
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="roulette">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/roulette.webp" class="size-6 mr-2" />
                        Roulette
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="baccarat">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/baccarat.webp" class="size-6 mr-2" />
                        Baccarat
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="blackjack">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/blackjack.webp" class="size-6 mr-2" />
                        Blackjack
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="poker">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/poker.webp" class="size-6 mr-2" />
                        Poker
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="teenpatti">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/teenpatti.webp" class="size-6 mr-2" />
                        TeenPatti
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="andarbahar">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/Andarbahar.webp" class="size-6 mr-2" />
                        AndarBahar
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="dragontiger">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/dragontiger.webp" class="size-6 mr-2" />
                        DragonTiger
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="card game">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/cardgame.webp" class="size-6 mr-2" />
                        Card Game
                    </button>
                    <!--<button-->
                    <!--    class="flex items-center text-[#cacbd5] py-1 px-2 rounded-xl font-semibold hover:bg-[#fc64043d] game-type-btn" data-type="number game">-->
                    <!--    <img src="https://cdn.cloudd.site/content/CasinoGameType/numbergame.webp?v=12" class="size-6 mr-2" />-->
                    <!--    Number Game-->
                    <!--</button>-->
                </div>
            </div>

        </div>
    </section>

    <div id="loader" class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-orange-500"></div>
    </div>

    <section class="relative my-10 hidden" id="show-games">
        <div class="container mx-auto max-w-6xl px-5">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:lg:grid-cols-6 gap-5 lg:gap-5" id="filter-games"></div>
            <p id="no-games-message" class="hidden text-gray-500 text-center">No games found.</p>
        </div>
    </section>
    
    <!-- Jento Games Section with Slider -->
    <section class="relative my-10" id="bz-live-game">
        <div class="container mx-auto max-w-6xl px-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-white py-4">
                    <img src="https://games-evo.cloudfire.app/category/popular.svg" class="size-7 mr-2" />
                    <h5 class="text-lg font-medium">Live Games</h5>
                </div>
                <div>
                    <h5 class="text-white font-medium text-lg">Show All ({{ $liveGamesCount }})</h5>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:lg:grid-cols-5 gap-5 lg:gap-5" id="live-games">
                @foreach ($liveGames as $game)

                <div class="relative bg-[#181818] h-[230px] lg:h-[110px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="{{ (!is_null($game->image_url) && !empty($game->image_url)) ? $game->image_url : 'https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png' }}" onerror="this.onerror=null; this.src='https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png';" class="w-full h-full rounded-xl"/>
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center -translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">{{ $game->table_name }}</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">{{ $game->game_name }}</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10 lobby-game" data-gameid="{{$game->game_code}}" data-gametableid="{{$game->table_code}}">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                @endforeach
                <!-- Unavailable game -->
                <div class="relative hidden bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative hidden bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                            transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <div class="absolute top-0 left-0">
                        <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                            class="w-full rounded-tl-xl rounded-tr-xl" />
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
            </div>
            <div class="my-10 text-center">
                <button
                    class="flex items-center bg-[#fc6404] text-white text-sm font-medium py-2.5 px-6 rounded-full mx-auto loadMoreBtn"  data-offset="14" data-type="live">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mr-2">
                        <path fill-rule="evenodd"
                            d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                            clip-rule="evenodd" />
                    </svg>
                    Show More
                </button>
            </div>
        </div>
    </section>
    
    

    
  <!--  <section <article class="wrapper">-->
		<!--<div class="marquee">-->
		<!--	<div class="marquee__group">-->
				<!-- ICONS -->
				<!-- <svg>
				
                
                <img src="https://stakeye.com/sports/assets/assets/img-4.jpg" id="brand" alt="brand Image">
                <img src="https://stakeye.com/sports/assets/assets/img-4.jpg" id="brand" alt="brand Image">
                <img src="https://stakeye.com/sports/assets/assets/img-4.jpg" id="brand" alt="brand Image">
                <img src="https://stakeye.com/sports/assets/assets/img-4.jpg" id="brand" alt="brand Image">


               
    
    
    </section>
    
    <!--style for brand loog slider-->
    
<!--    <style>-->
<!--        .marquee {-->
<!--  display: flex;-->
<!--  overflow: hidden;-->
<!--  user-select: none;-->
<!--  gap: var(--gap);-->
<!--  mask-image: linear-gradient(-->
<!--    var(--mask-direction, to right),-->
<!--    hsl(0 0% 0% / 0),-->
<!--    hsl(0 0% 0% / 1) 20%,-->
<!--    hsl(0 0% 0% / 1) 80%,-->
<!--    hsl(0 0% 0% / 0);-->
<!--}-->

<!--.marquee__group {-->
<!--  flex-shrink: 0;-->
<!--  display: flex;-->
<!--  align-items: center;-->
<!--  justify-content: space-around;-->
<!--  gap: var(--gap);-->
<!--  min-width: 100%;-->
<!--  animation: scroll-x var(--duration) linear infinite;-->
<!--}-->

<!--@media (prefers-reduced-motion: reduce) {-->
<!--  .marquee__group {-->
<!--    animation-play-state: paused;-->
<!--  }-->
<!--}-->

<!--.marquee--vertical {-->
<!--  --mask-direction: to bottom;-->
<!--}-->

<!--.marquee--verical,-->
<!--.marquee--vertical .marquee__group {-->
<!--  flex-direction: column;-->
<!--}-->

<!--.marquee--vertical .marquee__group {-->
<!--  animation-name: scroll-y;-->
<!--}-->

<!--.marquee--reverse .marquee__group {-->
<!--  animation-direction: reverse;-->
<!--  animation-delay: -3s;-->
<!--}-->

<!--@keyframes scroll-x {-->
<!--  from {-->
<!--    transform: translateX(var(--scroll-start));-->
<!--  }-->
<!--  to {-->
<!--    transform: translateX(var(--scroll-end));-->
<!--  }-->
<!--}-->

<!--@keyframes scroll-y {-->
<!--  from {-->
<!--    transform: translateY(var(--scroll-start));-->
<!--  }-->
<!--  to {-->
<!--    transform: translateY(var(--scroll-end));-->
<!--  }-->
<!--}-->

<!--/*ELMENT STYLES*/-->
<!--#brand {-->
<!--  display: grid;-->
<!--  place-items: center;-->
<!--  width: var(--size);-->
<!--  fill: var(--color-text);-->
<!--  background: var(--color-bg-accent);-->
<!--  aspect-ratio: 16/9;-->
<!--  padding: calc(var(--size) / 10);-->
<!--  border-radius: 0.5rem;-->
<!--}-->

<!--#brand--vertical {-->
<!--  aspect-ratio: 1;-->
<!--  width: calc(var(--size) / 1.5);-->
<!--  padding: calc(var(--size) / 6);-->
<!--}-->

        
<!--    </style>-->
    
    <!--END HERE style for brand loog slider-->

    <!-- Providers Section with Slider -->
    <section class="relative my-10" id="bz-provider">
        <div class="container mx-auto max-w-6xl px-5">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center text-white py-4">
                    <svg fill="currentColor" viewBox="0 0 96 96" class="svg-icon " style=""> <title></title> <path fill-rule="evenodd" clip-rule="evenodd" d="M48.117 24.078c6.648 0 12.04-5.391 12.04-12.039S54.764 0 48.116 0C41.47 0 36.078 5.391 36.078 12.039s5.391 12.039 12.04 12.039ZM3.594 50.246l40.003 18.4a10.33 10.33 0 0 0 4.32.933 10.41 10.41 0 0 0 4.387-.96l-.066.027 40.003-18.4a2.608 2.608 0 0 0 1.509-2.362 2.597 2.597 0 0 0-1.494-2.352l-.015-.006-39.445-18.16v16.36a4.8 4.8 0 0 1-4.8 4.8 4.8 4.8 0 0 1-4.801-4.8v-16.36L3.59 45.526a2.608 2.608 0 0 0-1.509 2.361c0 1.041.612 1.939 1.494 2.353l.015.006h.003Zm40.403 28.922L2.074 60.206V72.82c0 1.932 1.134 3.6 2.772 4.377l.03.012L44 95.13c1.173.55 2.55.87 4 .87 1.449 0 2.826-.32 4.059-.893l-.06.024 39.124-17.92c1.668-.79 2.799-2.458 2.799-4.39V60.206L51.999 79.168a9.305 9.305 0 0 1-4 .888 9.365 9.365 0 0 1-4-.889l.001-.002-.057-.024.055.026v.001Z"></path></svg>
                    <!--<img src="https://jetton.games/static/media/providers-cluster.6d08698636c707ed90d53e4c48753ccc.svg"-->
                        <!--class="size-7 mr-2" />-->
                    <h5 class="text-lg font-medium">Providers</h5>
                </div>
            </div>
    
            <!-- Providers Grid -->
            <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-5 lg:gap-5">
                @foreach($providers as $provider)
                    @if(!empty($provider->image_url))
                    <div class="provider-item relative flex items-center justify-center bg-[#fc64043d] h-[50px] lg:h-[80px] rounded-lg p-2 cursor-pointer transition-all duration-300 hover:bg-[#fc6404]" 
                        data-route="{{ route('provider-list', $provider->game_name) }}">
                            <img src="{{ !is_null($provider->image_url) ? asset('assets/providers') . '/' . $provider->image_url : 'https://stakeye.com/assets/images/logo_icon/logo.png' }}"
                            class="w-[100%] h-auto lg:w-full lg:h-auto" />
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative my-10" id="bz-virtual-game">
        <div class="container mx-auto max-w-6xl px-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-white py-4">
                    <img src="https://games-evo.cloudfire.app/category/popular.svg" class="size-7 mr-2" />
                    <h5 class="text-lg font-medium">Virtual Games</h5>
                </div>
                <div>
                    <h5 class="text-white font-medium text-lg">Show All ({{ $virtualGamesCount }})</h5>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:lg:grid-cols-5 gap-5 lg:gap-5" id="virtual-games">
                @foreach ($virtualGames as $game)

                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="{{ (!is_null($game->image_url) && !empty($game->image_url)) ? $game->image_url : 'https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png' }}" onerror="this.onerror=null; this.src='https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png';" class="w-full h-full rounded-xl"/>
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">{{ $game->table_name }}</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">{{ $game->game_name }}</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10 lobby-game" data-gameid="{{$game->game_code}}" data-gametableid="{{$game->table_code}}">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                @endforeach
                <!-- Unavailable game -->
                <div class="relative hidden bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative hidden bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                            transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <div class="absolute top-0 left-0">
                        <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                            class="w-full rounded-tl-xl rounded-tr-xl" />
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
            </div>
            <div class="my-10 text-center">
                <button
                    class="flex items-center bg-[#fc6404] text-white text-sm font-medium py-2.5 px-6 rounded-full mx-auto loadMoreBtn" data-type="virtual" data-offset="14">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mr-2">
                        <path fill-rule="evenodd"
                            d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                            clip-rule="evenodd" />
                    </svg>
                    Show More
                </button>
            </div>
        </div>
    </section>

    <!-- Popular Section with Slider -->
    <section class="relative my-6 hidden">
        <div class="container mx-auto max-w-6xl px-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-white py-4">
                    <img src="https://games-evo.cloudfire.app/category/popular.svg" class="size-7 mr-2" />
                    <h5 class="text-lg font-medium">Most Popular</h5>
                </div>
                <div>
                    <h5 class="text-white font-medium text-lg">Show All (50)</h5>
                </div>
            </div>
            <div class="grid grid-cols-3 md:grid-cols-5 lg:lg:grid-cols-7 gap-2 lg:gap-5">
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                                transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <div class="absolute top-0 left-0">
                        <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                            class="w-full rounded-tl-xl rounded-tr-xl" />
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
    -translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                                transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <div class="absolute top-0 left-0">
                        <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                            class="w-full rounded-tl-xl rounded-tr-xl" />
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
    -translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                                transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <div class="absolute top-0 left-0">
                        <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                            class="w-full rounded-tl-xl rounded-tr-xl" />
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
    -translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
   -translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/2fcc18a445f3417f8fbe2482820e8fdb.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                            transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <!-- <div class="absolute top-0 left-0">
                    <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                        class="w-full rounded-tl-xl rounded-tr-xl" />
                </div> -->

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/426de23515354096a8a0a90d2253ecbe.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                            transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/2952eab4fc944b17a66d5ce0e0810515.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/fdf1aa54ee8d4d1db611d4761b65663c.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                            transition-opacity duration-300 opacity-100">
                    </div>


                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/aaa703789dc8427e93c63864628e0c23.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
            </div>
            <div class="my-10 text-center">
                <button
                    class="flex items-center bg-[#fc6404] text-white text-sm font-medium py-2.5 px-6 rounded-full mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mr-2">
                        <path fill-rule="evenodd"
                            d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                            clip-rule="evenodd" />
                    </svg>
                    Show More
                </button>
            </div>
        </div>
    </section>

    <!-- New Games Section with Slider -->
    <section class="relative my-10 hidden">
        <div class="container mx-auto max-w-6xl px-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-white py-4">
                    <img src="https://games-evo.cloudfire.app/category/popular.svg" class="size-7 mr-2" />
                    <h5 class="text-lg font-medium">New Games</h5>
                </div>
                <div>
                    <h5 class="text-white font-medium text-lg">Show All (50)</h5>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-5 lg:lg:grid-cols-7 gap-5">
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                            transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <div class="absolute top-0 left-0">
                        <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                            class="w-full rounded-tl-xl rounded-tr-xl" />
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                            transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <div class="absolute top-0 left-0">
                        <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                            class="w-full rounded-tl-xl rounded-tr-xl" />
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                            transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <div class="absolute top-0 left-0">
                        <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                            class="w-full rounded-tl-xl rounded-tr-xl" />
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/2fcc18a445f3417f8fbe2482820e8fdb.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                        transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Bonus Badge -->
                    <!-- <div class="absolute top-0 left-0">
                <img src="https://jetton.games/static/media/bonus-buy.e65bd0ab68e7f73c8ecf6c99bc710505.svg"
                    class="w-full rounded-tl-xl rounded-tr-xl" />
            </div> -->

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/426de23515354096a8a0a90d2253ecbe.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/e581ee7ee58f44aeaea192af8ee6a385.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                        transition-opacity duration-300 opacity-100">
                    </div>

                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/2952eab4fc944b17a66d5ce0e0810515.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/fdf1aa54ee8d4d1db611d4761b65663c.webp"
                            class="w-full h-full rounded-xl" />
                    </div>

                    <!-- Default Overlay -->
                    <div class="absolute top-0 left-0 bg-[#00000075] h-full w-full rounded-xl 
                        transition-opacity duration-300 opacity-100">
                    </div>


                    <!-- Warning Message -->
                    <div class="w-full absolute bottom-5 left-0 text-center p-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto">
                            <g id="Danger 1">
                                <g id="Iconly/Bold/Danger">
                                    <g id="Danger">
                                        <path id="Vector"
                                            d="M10.6279 3.35309C11.9877 2.59902 13.7174 3.09447 14.4773 4.44209L21.746 17.0572C21.906 17.4338 21.976 17.7399 21.996 18.058C22.036 18.8012 21.776 19.5236 21.2661 20.0795C20.7562 20.6334 20.0663 20.9604 19.3164 21H4.6789C4.36896 20.9812 4.05901 20.9108 3.76906 20.8018C2.3193 20.2172 1.61942 18.5723 2.20932 17.1464L9.52809 4.43317C9.77804 3.98628 10.158 3.60082 10.6279 3.35309ZM11.9977 15.2726C11.5178 15.2726 11.1178 15.669 11.1178 16.1456C11.1178 16.6202 11.5178 17.0176 11.9977 17.0176C12.4776 17.0176 12.8675 16.6202 12.8675 16.1347C12.8675 15.66 12.4776 15.2726 11.9977 15.2726ZM11.9977 9.09039C11.5178 9.09039 11.1178 9.47585 11.1178 9.95248V12.7557C11.1178 13.2314 11.5178 13.6287 11.9977 13.6287C12.4776 13.6287 12.8675 13.2314 12.8675 12.7557V9.95248C12.8675 9.47585 12.4776 9.09039 11.9977 9.09039Z"
                                            fill="white"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <h6 class="text-sm lg:text-md text-white font-semibold leading-4">
                            Not available in your country
                        </h6>
                    </div>
                </div>
                <!-- Unavailable game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/aaa703789dc8427e93c63864628e0c23.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
                <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                    <!-- Game Image -->
                    <div class="absolute top-0 left-0 h-full w-full">
                        <img src="https://games-evo.cloudfire.app/827bfeb930664c339d9a1496aeb77dc6.webp"
                            class="w-full h-full rounded-xl" />
                    </div>
                    <!-- Hover Overlay with Rotating Sun Rays -->
                    <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                        <!-- Sun Rays Animation -->
                        <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
-translate-x-1/2 -translate-y-1/2">
                            <div class="sun-rays"></div>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 leading-1">
                            <h6 class="text-white text-sm font-medium mb-0 leading-1">Game Title</h6>
                            <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">Game Tag</p>
                        </div>

                        <button
                            class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10">
                            Play
                        </button>

                        <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Available game -->
            </div>
            <div class="my-10 text-center">
                <button
                    class="flex items-center bg-[#fc6404] text-white text-sm font-medium py-2.5 px-6 rounded-full mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mr-2">
                        <path fill-rule="evenodd"
                            d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                            clip-rule="evenodd" />
                    </svg>
                    Show More
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="p-4 text-center mt-10">
        <!--<div class="container mx-auto max-w-6xl px-5 ">-->
        <!--    <div class="block lg:flex items-center">-->
        <!--        <div class="h-[2px] w-full bg-[#45509033] "></div>-->
        <!--          <div class="py-5 text-center text-white">-->
        <!--        <p>© 2025 STAKEYE ｜ All Rights Reserved.</p>-->
        <!--    </div>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--        <div class="px-5 py-5 lg:py-0">-->
        <!--            <h1 class="text-2xl font-bold">STAKEYE</h1>-->
        <!--        </div>-->
        <!--        <div class="h-[2px] w-full bg-[#45509033] "></div>-->
        <!--    </div>-->
        <!--    <div class="grid grid-cols-1 lg:grid-cols-4 py-8 gap-5">-->
        <!--        <div class="flex items-center justify-start">-->
        <!--            <div>-->
        <!--                <div class="bg-[#fc64043d] flex items-center justify-center w-10 h-10 rounded-full">-->
        <!--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
        <!--                        stroke="currentColor" class="size-6 text-[#fc6404]">-->
        <!--                        <path stroke-linecap="round" stroke-linejoin="round"-->
        <!--                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />-->
        <!--                    </svg>-->
        <!--                </div>-->
        <!--            </div>-->
                <!--    <div class="text-left pl-2">-->
                <!--        <h6 class="font-medium text-sm text-[#fc6404]"><a href="https://stakeye.com/">Home page</a>  </h6>-->
                        <!--<h6 class="font-medium text-sm text-white">suppor</h6>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="flex items-center justify-start">-->
                <!--    <div>-->
                <!--        <div class="bg-[#fc64043d] flex items-center justify-center w-10 h-10 rounded-full">-->
                <!--            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
                <!--                stroke="currentColor" class="size-6 text-[#fc6404]">-->
                <!--                <path stroke-linecap="round" stroke-linejoin="round"-->
                <!--                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />-->
                <!--            </svg>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--    <div class="text-left pl-2">-->
                <!--        <h6 class="font-medium text-sm text-[#fc6404]"><a href="https://stakeye.com/">sports</a> </h6>-->
                        <!--<h6 class="font-medium text-sm text-white">secutiry@xyzxyzzys.com</h6>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="flex items-center justify-start">-->
                <!--    <div>-->
                <!--        <div class="bg-[#fc64043d] flex items-center justify-center w-10 h-10 rounded-full">-->
                <!--            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
                <!--                stroke="currentColor" class="size-6 text-[#fc6404]">-->
                <!--                <path stroke-linecap="round" stroke-linejoin="round"-->
                <!--                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />-->
                <!--            </svg>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--    <div class="text-left pl-2">-->
                <!--        <h6 class="font-medium text-sm text-[#fc6404]">Call Now</h6>-->
                <!--        <h6 class="font-medium text-sm text-white">0000 000 000</h6>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="flex items-center justify-start">-->
                <!--    <div>-->
                <!--        <div class="bg-[#181818] flex items-center justify-center w-10 h-10 rounded-full">-->
                <!--            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
                <!--                stroke="currentColor" class="size-6 text-[#fc6404]">-->
                <!--                <path stroke-linecap="round" stroke-linejoin="round"-->
                <!--                    d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />-->
                <!--            </svg>-->

                <!--        </div>-->
                <!--    </div>-->
                    <!--<div class="text-left pl-2">-->
                    <!--    <h6 class="font-medium text-sm text-[#fc6404]">Online Support</h6>-->
                    <!--    <h6 class="font-medium text-sm text-white">Connect to a manager</h6>-->
                    <!--</div>-->
            <!--    </div>-->
            <!--</div>-->
      
          
       
         <a href="#" class="scroll-top btn-hover">
        <span class="icon-gden- icon-gdenangle-up"></span>
    </a>
     </footer>
    
        <nav class="mobile-nav">
        <a href="https://stakeye.com/" class="bloc-icon">
            <img src="https://stakeye.com/assets/newhome/img/find.png" alt="">
            <!--<p class="my-12">Home</p>-->
        </a>
        <a href="" class="bloc-icon">
            <img src="https://stakeye.com/assets/newhome/img/bet.png" alt="">
            <!--<p class="my-12">Lottery</p>-->
        </a>
        <a href="https://stakeye.com/betting" class="bloc-icon">
            <img src="https://stakeye.com/assets/newhome/img/ball-of-basketball.png" alt="">
             <!--<p class="my-12">Sports</p>-->
        </a>
        <a href="https://stakeye.com/livecasino" class="bloc-icon">
            <img src="https://stakeye.com/assets/newhome/img/poker-cards.png" alt="">
            <!--<p class="my-12">Sports</p>-->
        </a>
        <a href="#" class="bloc-icon">
            <img src="https://stakeye.com/assets/newhome/img/messenger.png" alt="">
            <!--<p class="my-12">chat.png</p>-->
        </a>
    </nav>
    <style>
    .mobile-nav {
  background: #181818;
  position: fixed;
  bottom: 0;
  height: 65px;
  width: 100%;
  display: flex;
  justify-content: space-around;
  /*margin-left: -15px;*/
  
  
}

.bloc-icon {
  display: flex;
  justify-content: center;
  align-items: center;
}
.bloc-icon img {
  width: 30px;
}

@media screen and (min-width: 600px) {
  .mobile-nav {
    display: none;
  }
  .mobile-nav a p {
      font-size: 12px;
        margin-bottom: 0px !important;
  }
  .my-12 {
    margin-top: .5rem !important;
    margin-bottom: .5rem !important;
  
}
.p my-12 {
    font-size: 16px !important;
    font-weight: 400 !important;
    line-height: 25px !important;
    margin: 0;
}
  
}
</style>
    

    <!-- Signin Modal (Hidden by Default) -->
    <div id="modalBackdrop"
        class="fixed inset-0 bg-black bg-opacity-50 p-3 hidden flex justify-center items-center z-[9999]">
        <!-- Modal Content -->
        <div class="bg-[#181818] w-full lg:w-[30%] p-5 rounded-lg shadow-lg relative">
            <div class="text-center ">
                <h3 class="text-white text-2xl font-medium">Sign In</h3>
            </div>
            <div class="absolute right-6 top-6">
                <svg id="closeModalBtn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-7 text-white cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

            <!-- Tabs -->
            <div class="flex border-b mt-7">
                <button id="emailTab"
                    class="tab-btn text-[#fc6404] w-full flex items-center justify-center font-semibold py-2 px-4 border-b-2 border-[#fc6404]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    Email
                </button>
                <button id="phoneTab" class="tab-btn w-full flex items-center justify-center font-medium py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>

                    Phone
                </button>
            </div>

            <!-- Email Tab Content -->
            <div id="emailContent" class="tab-content mt-10">
                <label class="block text-white font-normal">Email</label>
                <input type="email" class="w-full px-3 py-3 border rounded-lg mt-1" placeholder="Enter your email">

                <label class="block text-white font-normal mt-3">Password</label>
                <input type="password" class="w-full px-3 py-3 border rounded-lg mt-1"
                    placeholder="Enter your password">

                <button class="w-full bg-white text-[#fc6404] py-3 px-4 mt-10 rounded-full ml-1">Sign
                    In</button>
            </div>

            <!-- Phone Tab Content (Hidden by Default) -->
            <div id="phoneContent" class="tab-content mt-10 hidden">
                <label class="block text-white font-medium ">Phone Number</label>
                <input type="tel" class="w-full px-3 py-3 border rounded-lg mt-1" placeholder="Enter your phone number">

                <button class="w-full bg-white text-[#fc6404] py-3 px-4 mt-10 rounded-full ml-1">Sign
                    In</button>
            </div>
        </div>
    </div>

    <!-- Providers Modal (Hidden by Default) -->
    <div id="providerModalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 p-3 hidden flex justify-center items-center z-[9999]">
        <!-- Modal Content -->
        <div class="bg-[#181818] w-full lg:w-[40%] p-5 rounded-lg shadow-lg relative">
            <div class="text-center ">
                <h3 class="text-white text-2xl font-medium">Game Providers </h3>
            </div>
            <div class="absolute right-6 top-6">
                <svg id="closeProviderModalBtn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-7 text-white cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
            <div class="w-full flex items-center bg-[#000] rounded-xl lg:mr-3 mt-10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 text-[#fc6404] ml-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" id="searchInput" class="w-full bg-transparent px-3 py-3 border-none focus:outline-none" />
                <button class="bg-[#fc64043d] text-[#fc6404] py-3 px-6 rounded-xl ml-1">Search</button>
            </div>
            <div class="h-80 overflow-y-auto custom-scrollbar">
                <div class="grid grid-cols-2 lg:grid-cols-2 gap-x-6 gap-y-3 mt-5 lg:pl-5" id="gameList">
                    @foreach($providers as $provider)
                        <a href="{{ route('provider-list', $provider->game_name) }}" class="flex items-center text-white px-4 py-2 hover:bg-[#fc64043d] hover:text-[#fc6404] rounded-xl">
                            <img src="https://games-evo.cloudfire.app/provider/cf56ff68-5a6f-4d15-ac5a-d51dc5c4279d_small.svg"
                                class="mr-2 size-7" />
                            <h6 class="font-medium">{{ $provider->game_name }}</h6>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            centeredSlides: false,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {  // Small screens (phones)
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                640: {  // Tablets
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: { // Laptops / Desktops
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        });
    </script>

    <script>
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const modalBackdrop = document.getElementById("modalBackdrop");

        const emailTab = document.getElementById("emailTab");
        const phoneTab = document.getElementById("phoneTab");
        const emailContent = document.getElementById("emailContent");
        const phoneContent = document.getElementById("phoneContent");

        // Open modal
        openModalBtn.addEventListener("click", () => {
            modalBackdrop.classList.remove("hidden");
        });

        // Close modal
        closeModalBtn.addEventListener("click", () => {
            modalBackdrop.classList.add("hidden");
        });

        // Close modal when clicking outside
        modalBackdrop.addEventListener("click", (e) => {
            if (e.target === modalBackdrop) {
                modalBackdrop.classList.add("hidden");
            }
        });

        // Tab switching logic
        emailTab.addEventListener("click", () => {
            emailContent.classList.remove("hidden");
            phoneContent.classList.add("hidden");
            emailTab.classList.add("text-[#fc6404]", "font-semibold", "border-b-2", "border-[#fc6404]");
            phoneTab.classList.remove("text-[#fc6404]", "font-semibold", "border-b-2", "border-[#fc6404]");
            phoneTab.classList.add("text-white");
        });

        phoneTab.addEventListener("click", () => {
            phoneContent.classList.remove("hidden");
            emailContent.classList.add("hidden");
            phoneTab.classList.add("text-[#fc6404]", "font-semibold", "border-b-2", "border-[#fc6404]");
            emailTab.classList.remove("text-[#fc6404]", "font-semibold", "border-b-2", "border-[#fc6404]");
            emailTab.classList.add("text-white");
        });
    </script>

    <!-- providers modal -->
    <script>
        const openProviderModalBtn = document.getElementById("openProviderModalBtn");
        const closeProviderModalBtn = document.getElementById("closeProviderModalBtn");
        const providerModalBackdrop = document.getElementById("providerModalBackdrop");

        // Open modal
        openProviderModalBtn.addEventListener("click", () => {
            providerModalBackdrop.classList.remove("hidden");
        });

        // Close modal
        closeProviderModalBtn.addEventListener("click", () => {
            providerModalBackdrop.classList.add("hidden");
        });

        // Close modal when clicking outside
        providerModalBackdrop.addEventListener("click", (e) => {
            if (e.target === providerModalBackdrop) {
                providerModalBackdrop.classList.add("hidden");
            }
        });

    </script>

    <!--banner timer -->
    <script>
        function startCountdown(targetDate) {
            function updateTimer() {
                const now = new Date().getTime();
                const timeLeft = targetDate - now;

                if (timeLeft <= 0) {
                    document.getElementById("timer").innerHTML = "Time's up!";
                    clearInterval(interval);
                    return;
                }

                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                document.getElementById("timer").innerHTML =
                    `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }

            updateTimer(); // Initial call
            const interval = setInterval(updateTimer, 1000);
        }

        // Set your target date (YYYY, MM (0-indexed), DD, HH, MM, SS)
        const targetDate = new Date(2025, 3, 10, 12, 0, 0).getTime();
        startCountdown(targetDate);
    </script>

    <script>
        var searchRoute = "{{ route('searchGame') }}";

        document.getElementById('searchInput').addEventListener('keyup', function() {
            let query = this.value;

            fetch(`${searchRoute}?query=${query}`)
            .then(response => response.json())
                .then(data => {
                    let gameList = document.getElementById('gameList');
                    gameList.innerHTML = '';

                    data.forEach(game => {
                        gameList.innerHTML += `
                            <a href="#" class="flex items-center text-white px-4 py-2 hover:bg-[#fc64043d] hover:text-[#fc6404] rounded-xl">
                                <img src="https://games-evo.cloudfire.app/provider/cf56ff68-5a6f-4d15-ac5a-d51dc5c4279d_small.svg"
                                    class="mr-2 size-7" />
                                <h6 class="font-medium">${game.game_name}</h6>
                            </a>`;
                    });
                });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            async function loadMoreGames(type, button) {
                let offset = parseInt(button.getAttribute('data-offset') || 0);
                let container = document.getElementById(type + "-games");
                const loader = document.getElementById('loader');

                try {
                    // ✅ Disable Button and Show Loader
                    button.disabled = true;
                    loader.classList.remove('hidden');

                    // ✅ Fetch Data
                    const response = await fetch(`{{ route('loadMore') }}?game_type=${type}&offset=${offset}`);
                    const data = await response.json();

                    // ✅ Hide Loader and Enable Button
                    loader.classList.add('hidden');
                    button.disabled = false;

                    // ✅ Render Data
                    data.forEach(game => {
                        let div = document.createElement("div");
                        div.classList = "relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group";
                        div.innerHTML = `<div class="absolute top-0 left-0 h-full w-full">
                                    <img src="${game.image_url || 'https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png'}"
                                        class="w-full h-full rounded-xl" />
                                </div>
                                <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
                                    opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">
                                    <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
                                        -translate-x-1/2 -translate-y-1/2">
                                        <div class="sun-rays"></div>
                                    </div>
                                    <div class="relative z-10 leading-1">
                                        <h6 class="text-white text-sm font-medium mb-0 leading-1">${game.table_name || 'Game Title'}</h6>
                                        <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">${game.game_name || 'Game Tag'}</p>
                                    </div>

                                    <button class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10 lobby-game" data-gameid="${game.game_code}" data-gametableid="${game.table_code}">
                                        Play
                                    </button>

                                    <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-5">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-5">
                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                            <path fill-rule="evenodd"
                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>`;
                            container.appendChild(div);
                    });

                    // ✅ Update Offset
                    button.setAttribute('data-offset', offset + data.length);

                    // ✅ Hide Button if No More Data
                    if (data.length < 10) {
                        button.style.display = 'none';
                    }
                } catch (error) {
                    console.error('Error fetching games:', error);
                    loader.classList.add('hidden');
                    button.disabled = false;
                }
            }

            // ✅ Load More Button Click Event
            document.querySelectorAll('.loadMoreBtn').forEach(button => {
                button.addEventListener('click', function () {
                    let type = this.getAttribute('data-type');
                    loadMoreGames(type, this);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const gameTypeButtons = document.querySelectorAll('.game-type-btn');
            const loader = document.getElementById('loader');
            const noGamesMessage = document.getElementById('no-games-message');
            const gamesContainer = document.getElementById('filter-games');

            gameTypeButtons.forEach(button => {
                button.addEventListener('click', async (event) => {
                    const type = button.getAttribute('data-type');

                    // ✅ Active Button Styling
                    gameTypeButtons.forEach(btn => btn.classList.remove('bg-[#fc64043d]'));
                    button.classList.add('bg-[#fc64043d]');

                    try {
                        // ✅ Show Loader
                        loader.classList.remove('hidden');

                        const response = await fetch(`{{ route('get-games') }}?type=${type}`);
                        const data = await response.json();

                        // ✅ Hide Loader
                        loader.classList.add('hidden');
                        noGamesMessage.classList.add('hidden');
                        document.getElementById('show-games').classList.remove('hidden');
                        document.getElementById('bz-live-game').classList.add('hidden');
                        document.getElementById('bz-virtual-game').classList.add('hidden');
                        document.getElementById('bz-provider').classList.add('hidden');

                        if (data.length === 0) {
                            noGamesMessage.classList.remove('hidden');
                            gamesContainer.innerHTML = '';
                        } else {
                            updateGamesSection(data);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        loader.classList.add('hidden');
                        noGamesMessage.classList.remove('hidden');
                        noGamesMessage.textContent = 'Failed to load games. Please try again.';
                    }
                });
            });

            function updateGamesSection(games) {
                gamesContainer.innerHTML = ''; // ✅ Clear existing games

                games.forEach(game => {
                    let div = document.createElement("div");
                    div.classList = "relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group";

                    div.innerHTML = `
                        <div class="absolute top-0 left-0 h-full w-full">
                            <img src="${game.image_url || 'https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png'}"
                                class="w-full h-full rounded-xl"
                                onerror="this.onerror=null; this.src='https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png';" />
                        </div>
                        <div class="absolute top-0 left-0 bg-[#fc6404] h-full w-full rounded-xl 
                            opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">
                            <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
                                -translate-x-1/2 -translate-y-1/2">
                                <div class="sun-rays"></div>
                            </div>
                            <div class="relative z-10 leading-1">
                                <h6 class="text-white text-sm font-medium mb-0 leading-1">${game.table_name || 'Game Title'}</h6>
                                <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">${game.game_name || 'Game Tag'}</p>
                            </div>

                            <button class="relative z-10 w-full bg-white text-[#fc6404] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10 lobby-game" data-gameid="${game.game_code}" data-gametableid="${game.table_code}">
                                Play
                            </button>

                            <div class="relative z-10 flex justify-between items-center text-[#e0e0e0] mt-5 lg:mt-10">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    `;

                    gamesContainer.appendChild(div); // ✅ Append to container
                });
            }
        });

        document.addEventListener('click', async (e) => {
            if (e.target.closest('.lobby-game')) {
                e.preventDefault();

                const game = e.target.closest('.lobby-game');
                let username = '{{ auth()->check() ? auth()->user()->username : "" }}';
                let gameId = game.getAttribute('data-gameid');
                let gameTableId = game.getAttribute('data-gametableid');

                // ✅ Check if user is not logged in
                if (!username) {
                    window.location.href = '{{ route('user.login') }}';
                    return;
                }

                const loader = document.getElementById('loader');
                loader.classList.remove('hidden');

                try {
                    const response = await fetch('{{ route('get.lobby.url') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        credentials: 'include',
                        body: JSON.stringify({
                            username: username,
                            gameId: gameId,
                            gameTableId: gameTableId
                        })
                    });

                    const data = await response.json();

                    if (data.lobbyURL) {
                        window.location.href = data.lobbyURL;
                    } else {
                        alert("Error: " + (data.error || 'Unknown error'));
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert("Error: " + (error.message || 'Failed to fetch data'));
                } finally {
                    loader.classList.add('hidden');
                }
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const providerItems = document.querySelectorAll('.provider-item');

            providerItems.forEach(item => {
                item.addEventListener('click', () => {
                    // ✅ Reset all items to default state
                    providerItems.forEach(el => {
                        el.classList.remove('bg-[#fc6404]');
                        el.classList.add('bg-[#fc64043d]');
                    });

                    // ✅ Apply clicked effect
                    item.classList.remove('bg-[#fc64043d]');
                    item.classList.add('bg-[#fc6404]');

                    // ✅ Delay for click effect before redirecting
                    setTimeout(() => {
                        const route = item.getAttribute('data-route');
                        if (route) {
                            window.location.href = route;
                        }
                    }, 200); // 200ms delay for smooth effect
                });
            });
        });

    </script>
</body>
</html>