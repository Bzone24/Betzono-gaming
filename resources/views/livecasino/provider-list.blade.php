<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StakEye</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
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
            width: 8px;
            /* Slim scrollbar */
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #000;
            /* Pure black track */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ff6600;
            /* Bright orange scrollbar */
            border-radius: 10px;
            border: 2px solid #000;
            /* Adds black border around thumb */
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #e65c00;
            /* Darker orange on hover */
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
            border-top: 4px solid #ff6600;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-[#181818] text-white">
    <!-- Header -->
    {{-- <header class="hidden p-4 bg-[#181818] shadow-lg">
        <div class="container mx-auto max-w-6xl px-5 flex justify-between items-center ">
            <h1 class="text-2xl font-bold">STAKEYE</h1>
            <div>
                <div class="flex items-center justify-between bg-[#181818] p-4 rounded-lg shadow-lg">
                    @auth
                        <div class="flex items-center space-x-4">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}&background=ff6600&color=fff"
                                alt="User Avatar"
                                class="w-12 h-12 rounded-full border-2 border-[#ff6600] object-cover shadow-md" />

                            <div>
                                <h4 class="text-white font-semibold text-lg leading-tight mr-2">{{ Auth::user()->username }}
                                </h4>
                                <p class="text-gray-400 text-sm mr-2">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <button id="logoutBtn"
                            class="bg-[#ff6600] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md">
                            Dashboard
                        </button>
                    @else
                        <div class="flex items-center space-x-2">
                            <button id="openLoginModalBtn"
                                class="bg-[#ff6600] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md">
                                Login
                            </button>
                            <button id="openRegisterModalBtn"
                                class="bg-[#ff6600] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md">
                                Register
                            </button>
                        </div>
                    @endauth
                </div>
                <button id="openModalBtn" class="bg-[#ff6600] text-[#fff] py-1.5 px-4 rounded-full ">Login</button>
               
                <button class="bg-[#ff6600] text-[#fff] py-1.5 px-4 rounded-full ml-1">Signup</button>
            </div>
        </div>
    </header> --}}

    <header class="p-4 bg-[#181818] shadow-lg">
        <div class="container mx-auto max-w-6xl px-5 flex flex-wrap justify-between items-center gap-4">
            <h1 class="text-2xl font-bold text-white">STAKEYE</h1>
            @auth
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <!-- ✅ User Info -->
                    <div class="flex items-center bg-[#212121] px-4 py-2 rounded-full shadow-lg w-full sm:w-auto">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}&background=ff6600&color=fff"
                            alt="User Avatar"
                            class="w-10 h-10 rounded-full border-2 border-[#ff6600] object-cover shadow-md" />
    
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
                        <div class="bg-[#ff66003d] text-[#ff6600] font-semibold px-4 py-2 rounded-full shadow-md w-full sm:w-auto text-center">
                            Balance: ₹{{ number_format(Auth::user()->balance, 2) }}
                        </div>
                        
                        <a href="{{ route('user.home') }}" target="_self" rel="noopener noreferrer"
                        id="dashboardBtn" class="bg-[#ff6600] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md w-full sm:w-auto">
                            Dashboard</a>
                        <a href="{{ route('user.logout') }}" target="_self" rel="noopener noreferrer" class="bg-red-500 text-white font-medium px-4 py-2 rounded-full hover:bg-red-600 transition duration-300 shadow-md w-full sm:w-auto">Logout</a>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <a href="{{ route('user.login') }}" target="_self" rel="noopener noreferrer" id="openLoginModalBtn"
                    class="bg-[#ff6600] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md w-full sm:w-auto">
                    Login</a>
                    <a href="{{ route('user.register') }}" target="_self" rel="noopener noreferrer" id="openRegisterModalBtn"
                    class="bg-[#ff6600] text-white font-medium px-4 py-2 rounded-full hover:bg-[#e65c00] transition duration-300 shadow-md w-full sm:w-auto">
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
                                class="flex items-center bg-[#ff6600] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                    class="mb-1">Let's go</span></button>
                        </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/2fbe3a6c-0ee4-4939-8b72-02f1a8bdce2d.png"
                            alt="Game 1" class="rounded-lg shadow-lg">
                        <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                            <button
                                class="flex items-center bg-[#ff6600] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                    class="mb-1">Let's go</span></button>
                        </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/21c4bea9-4ad7-40eb-bc70-bf6685e469a4.png"
                            alt="Game 2" class="rounded-lg shadow-lg">
                        <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                            <button
                                class="flex items-center bg-[#ff6600] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
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
                            <button
                                class="flex items-center bg-[#ff6600] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                    class="mb-1">Let's go</span>
                            </button>
                        </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/2984f3ce-66ee-4062-89dc-72a1f94dc583.png"
                            alt="Game 1" class="rounded-lg shadow-lg">
                        <div class="w-full absolute bottom-0 left-0 p-2 z-9">
                            <button
                                class="flex items-center bg-[#ff6600] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
                                    class="mb-1">Let's go</span></button>
                        </div>
                    </div>
                    <div class="relative swiper-slide flex justify-center items-center text-white text-xl font-bold">
                        <img src="https://games.cloudfire.app/images/tournaments/9092cf5a-2521-454c-9623-d70f769271e4.png"
                            alt="Game 2" class="rounded-lg shadow-lg">
                        <div class="w-full absolute bottom-0 left-0 p-2 z-9">

                            <button
                                class="flex items-center bg-[#ff6600] text-sm text-[#fff] font-medium py-[8px] px-4 rounded-full hover:bg-[#181818]"><span
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

                <!-- ✅ Back Button and Provider Name -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <!-- Back Button -->
                        <button onclick="window.history.back()"
                            class="flex items-center text-[#ff6600] font-semibold py-2 px-4 rounded-xl hover:bg-[#ff66003d] border border-[#ff6600]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            Back
                        </button>

                        <!-- Provider Name -->
                        <h2 class="text-white text-lg font-semibold">
                            {{ $name }}
                        </h2>
                    </div>

                    <!-- ✅ Provider List Button (Less Width) -->
                    <button id="openProviderModalBtn"
                        class="bg-[#ff6600] flex items-center text-white rounded-xl px-4 py-2 hover:bg-[#ff5500] whitespace-nowrap">
                        All Providers
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 ml-2 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>

                <!-- ✅ Search Bar (More Width) -->
                <div class="w-full mb-4">
                    <div class="flex items-center bg-[#000] rounded-xl w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 text-[#ff6600] ml-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" placeholder="Search games..."
                            class="w-full bg-transparent px-3 py-3 border-none focus:outline-none text-white" />
                        <button class="bg-[#ff66003d] text-[#ff6600] py-3 px-6 rounded-xl ml-2 hover:bg-[#ff66006b]">
                            Search
                        </button>
                    </div>
                </div>

                <!-- ✅ Game Type Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold border border-[#ff6600] hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="all games">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/all.webp" class="size-6 mr-2" />
                        All Games
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="slots">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/slots.webp" class="size-6 mr-2" />
                        Slots
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="roulette">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/roulette.webp" class="size-6 mr-2" />
                        Roulette
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="baccarat">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/baccarat.webp" class="size-6 mr-2" />
                        Baccarat
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="blackjack">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/blackjack.webp" class="size-6 mr-2" />
                        Blackjack
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="poker">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/poker.webp" class="size-6 mr-2" />
                        Poker
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="teenpatti">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/teenpatti.webp" class="size-6 mr-2" />
                        Teenpatti
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="andarbahar">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/Andarbahar.webp" class="size-6 mr-2" />
                        Andarbahar
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="dragontiger">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/dragontiger.webp"
                            class="size-6 mr-2" />
                        Dragontiger
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="card game">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/cardgame.webp" class="size-6 mr-2" />
                        Card Game
                    </button>
                    <button
                        class="flex items-center text-[#cacbd5] py-2.5 px-4 rounded-xl font-semibold hover:bg-[#ff66003d] transition game-type-btn"
                        data-type="number game">
                        <img src="https://cdn.cloudd.site/content/CasinoGameType/numbergame.webp" class="size-6 mr-2" />
                        Number Game
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div id="loader"
        class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-orange-500"></div>
    </div>

    <section class="relative my-6">
        <div class="container mx-auto max-w-6xl px-5">
            <!-- Games Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5 show-games"
                id="{{ Str::slug($name) }}-games">
                <!-- Example Game Item -->
                @foreach ($games as $game)

                    <div class="relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group">
                        <!-- Game Image -->
                        <div class="absolute top-0 left-0 h-full w-full">
                            <img src="{{ (!is_null($game->image_url) && !empty($game->image_url)) ? $game->image_url : 'https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png' }}"
                                onerror="this.onerror=null; this.src='https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png';"
                                class="w-full h-full rounded-xl" />
                        </div>
                        <!-- Hover Overlay with Rotating Sun Rays -->
                        <div
                            class="absolute top-0 left-0 bg-[#ff6600] h-full w-full rounded-xl opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">

                            <!-- Sun Rays Animation -->
                            <div
                                class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center -translate-x-1/2 -translate-y-1/2">
                                <div class="sun-rays"></div>
                            </div>

                            <!-- Content -->
                            <div class="relative z-10 leading-1">
                                <h6 class="text-white text-sm font-medium mb-0 leading-1">{{ $game->table_name }}</h6>
                                <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">{{ $game->game_name }}</p>
                            </div>

                            <button
                                class="relative z-10 w-full bg-white text-[#ff6600] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10 lobby-game"
                                data-gameid="{{$game->game_code}}" data-gametableid="{{$game->table_code}}">
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
                <!-- Repeat More Game Items Dynamically -->
            </div>

            @if(!$games->isEmpty())

                <div class="my-10 text-center">
                    <button
                        class="flex items-center bg-[#ff6600] text-white text-sm font-medium py-2.5 px-6 rounded-full mx-auto loadMoreBtn"
                        data-offset="14" data-provider="{{ Str::slug($name) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mr-2">
                            <path fill-rule="evenodd"
                                d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                clip-rule="evenodd" />
                        </svg>
                        Show More
                    </button>
                </div>

                <!-- No Games Message -->
                <p id="no-games-message" class="hidden text-gray-500 text-center mt-5">No games found.</p>

            @else
                <p class=" text-gray-500 text-center mt-5">No games found.</p>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="p-4 text-center mt-10">
        <!--<div class="container mx-auto max-w-6xl px-5 ">-->
        <!--    <div class="block lg:flex items-center">-->
        <!--        <div class="h-[2px] w-full bg-[#45509033] "></div>-->
        <!--        <div class="px-5 py-5 lg:py-0">-->
        <!--            <h1 class="text-2xl font-bold">STAKEYE</h1>-->
        <!--        </div>-->
        <!--        <div class="h-[2px] w-full bg-[#45509033] "></div>-->
        <!--    </div>-->
            <!--<div class="grid grid-cols-1 lg:grid-cols-4 py-8 gap-5">-->
            <!--    <div class="flex items-center justify-start">-->
            <!--        <div>-->
            <!--            <div class="bg-[#ff66003d] flex items-center justify-center w-10 h-10 rounded-full">-->
            <!--                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
            <!--                    stroke="currentColor" class="size-6 text-[#ff6600]">-->
            <!--                    <path stroke-linecap="round" stroke-linejoin="round"-->
            <!--                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />-->
            <!--                </svg>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="text-left pl-2">-->
            <!--            <h6 class="font-medium text-sm text-[#ff6600]">Support</h6>-->
            <!--            <h6 class="font-medium text-sm text-white">support@xyzxyzzys.com</h6>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="flex items-center justify-start">-->
            <!--        <div>-->
            <!--            <div class="bg-[#ff66003d] flex items-center justify-center w-10 h-10 rounded-full">-->
            <!--                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
            <!--                    stroke="currentColor" class="size-6 text-[#ff6600]">-->
            <!--                    <path stroke-linecap="round" stroke-linejoin="round"-->
            <!--                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />-->
            <!--                </svg>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="text-left pl-2">-->
            <!--            <h6 class="font-medium text-sm text-[#ff6600]">Service Security</h6>-->
            <!--            <h6 class="font-medium text-sm text-white">secutiry@xyzxyzzys.com</h6>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="flex items-center justify-start">-->
            <!--        <div>-->
            <!--            <div class="bg-[#ff66003d] flex items-center justify-center w-10 h-10 rounded-full">-->
            <!--                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
            <!--                    stroke="currentColor" class="size-6 text-[#ff6600]">-->
            <!--                    <path stroke-linecap="round" stroke-linejoin="round"-->
            <!--                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />-->
            <!--                </svg>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="text-left pl-2">-->
            <!--            <h6 class="font-medium text-sm text-[#ff6600]">Call Now</h6>-->
            <!--            <h6 class="font-medium text-sm text-white">0000 000 000</h6>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="flex items-center justify-start">-->
            <!--        <div>-->
            <!--            <div class="bg-[#ff66003d] flex items-center justify-center w-10 h-10 rounded-full">-->
            <!--                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
            <!--                    stroke="currentColor" class="size-6 text-[#ff6600]">-->
            <!--                    <path stroke-linecap="round" stroke-linejoin="round"-->
            <!--                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />-->
            <!--                </svg>-->

            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="text-left pl-2">-->
            <!--            <h6 class="font-medium text-sm text-[#ff6600]">Online Support</h6>-->
            <!--            <h6 class="font-medium text-sm text-white">Connect to a manager</h6>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
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
  margin-left: -18px;
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
    </footer>

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
                    class="tab-btn text-[#ff6600] w-full flex items-center justify-center font-semibold py-2 px-4 border-b-2 border-[#ff6600]">
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

                <button class="w-full bg-white text-[#ff6600] py-3 px-4 mt-10 rounded-full ml-1">Sign
                    In</button>
            </div>

            <!-- Phone Tab Content (Hidden by Default) -->
            <div id="phoneContent" class="tab-content mt-10 hidden">
                <label class="block text-white font-medium ">Phone Number</label>
                <input type="tel" class="w-full px-3 py-3 border rounded-lg mt-1" placeholder="Enter your phone number">

                <button class="w-full bg-white text-[#ff6600] py-3 px-4 mt-10 rounded-full ml-1">Sign
                    In</button>
            </div>
        </div>
    </div>

    <!-- Providers Modal (Hidden by Default) -->
    <div id="providerModalBackdrop"
        class="fixed inset-0 bg-black bg-opacity-50 p-3 hidden flex justify-center items-center z-[9999]">
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
                    stroke="currentColor" class="size-8 text-[#ff6600] ml-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" id="searchInput"
                    class="w-full bg-transparent px-3 py-3 border-none focus:outline-none" />
                <button class="bg-[#ff66003d] text-[#ff6600] py-3 px-6 rounded-xl ml-1">Search</button>
            </div>
            <div class="h-80 overflow-y-auto custom-scrollbar">
                <div class="grid grid-cols-2 lg:grid-cols-2 gap-x-6 gap-y-3 mt-5 lg:pl-5" id="gameList">
                    @foreach($providers as $provider)
                        <a href="{{ route('provider-list', $provider->game_name) }}"
                            class="flex items-center text-white px-4 py-2 hover:bg-[#ff66003d] hover:text-[#ff6600] rounded-xl">
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
                delay: 10000,
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
            emailTab.classList.add("text-[#ff6600]", "font-semibold", "border-b-2", "border-[#ff6600]");
            phoneTab.classList.remove("text-[#ff6600]", "font-semibold", "border-b-2", "border-[#ff6600]");
            phoneTab.classList.add("text-white");
        });

        phoneTab.addEventListener("click", () => {
            phoneContent.classList.remove("hidden");
            emailContent.classList.add("hidden");
            phoneTab.classList.add("text-[#ff6600]", "font-semibold", "border-b-2", "border-[#ff6600]");
            emailTab.classList.remove("text-[#ff6600]", "font-semibold", "border-b-2", "border-[#ff6600]");
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

        // document.addEventListener('DOMContentLoaded', () => {
        //     const lobbyGames = document.querySelectorAll('.lobby-game');
        //     const loader = document.getElementById('loader'); // Use existing loader

        //     lobbyGames.forEach(game => {
        //         game.addEventListener('click', async (e) => {
        //             e.preventDefault();

        //             let username = 'b1112223334';
        //             let gameId = game.getAttribute('data-gameid');
        //             let gameTableId = game.getAttribute('data-gametableid');

        //             // ✅ Show loader before request
        //             loader.classList.remove('hidden');

        //             try {
        //                 const response = await fetch('{{ route('get.lobby.url') }}', {
        //                     method: 'POST',
        //                     headers: {
        //                         'Content-Type': 'application/json',
        //                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //                     },
        //                     credentials: 'include',
        //                     body: JSON.stringify({
        //                         username: username,
        //                         gameId: gameId,
        //                         gameTableId: gameTableId
        //                     })
        //                 });

        //                 const data = await response.json();

        //                 if (data.lobbyURL) {
        //                     window.location.href = data.lobbyURL;
        //                 } else {
        //                     alert("Error: " + (data.error || 'Unknown error'));
        //                 }
        //             } catch (error) {
        //                 console.error('Error:', error);
        //                 alert("Error: " + (error.message || 'Failed to fetch data'));
        //             } finally {
        //                 // ✅ Hide loader after request completes
        //                 loader.classList.add('hidden');
        //             }
        //         });
        //     });
        // });

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
                            <a href="#" class="flex items-center text-white px-4 py-2 hover:bg-[#ff66003d] hover:text-[#ff6600] rounded-xl">
                                <img src="https://games-evo.cloudfire.app/provider/cf56ff68-5a6f-4d15-ac5a-d51dc5c4279d_small.svg"
                                    class="mr-2 size-7" />
                                <h6 class="font-medium">${game.game_name}</h6>
                            </a>`;
                    });
                });
        });
        document.addEventListener("DOMContentLoaded", function () {
            async function loadMoreGames(type, button) {
                let offset = parseInt(button.getAttribute('data-offset') || 0);
                let container = document.getElementById(`${type}-games`);
                const loader = document.getElementById('loader');
                const noGamesMessage = document.getElementById('no-games-message');


                // ✅ Debugging log
                console.log(`Loading games for type: ${type}`);
                console.log(`Container found:`, container);

                if (!container) {
                    console.error(`Container not found for type: ${type}`);
                    return;
                }

                try {
                    // ✅ Disable Button and Show Loader
                    button.disabled = true;
                    loader.classList.remove('hidden');

                    // ✅ Fetch Data
                    const response = await fetch(`{{ route('loadMore') }}?provider=${encodeURIComponent(type)}&offset=${offset}`);
                    const data = await response.json();

                    // ✅ Hide Loader and Enable Button
                    loader.classList.add('hidden');
                    button.disabled = false;

                    // ✅ Render Data
                    if (data.length > 0) {
                        data.forEach(game => {
                            let div = document.createElement("div");
                            div.classList = "relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group";

                            div.innerHTML = `
                                <div class="absolute top-0 left-0 h-full w-full">
                                    <img src="${game.image_url || 'https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png'}"
                                        class="w-full h-full rounded-xl" onerror="this.onerror=null; this.src='https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png';"
                                    class="w-full h-full rounded-xl"/>
                                </div>
                                <div class="absolute top-0 left-0 bg-[#ff6600] h-full w-full rounded-xl 
                                    opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">
                                    <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
                                        -translate-x-1/2 -translate-y-1/2">
                                        <div class="sun-rays"></div>
                                    </div>
                                    <div class="relative z-10 leading-1">
                                        <h6 class="text-white text-sm font-medium mb-0 leading-1">${game.table_name || 'Game Title'}</h6>
                                        <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">${game.game_name || 'Game Tag'}</p>
                                    </div>

                                    <button class="relative z-10 w-full bg-white text-[#ff6600] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10 lobby-game" data-gameid="${game.game_code}" data-gametableid="${game.table_code}">
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
                        if (data.length < 12) {
                            button.style.display = 'none';
                        }
                    } else {
                        console.log('No more games found.');
                        noGamesMessage.classList.remove('hidden');
                        noGamesMessage.textContent = 'No more games found';
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
                    let type = this.getAttribute('data-provider');
                    loadMoreGames(type, this);
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const gameTypeButtons = document.querySelectorAll('.game-type-btn');
            const loader = document.getElementById('loader');
            const noGamesMessage = document.getElementById('no-games-message');
            const gamesContainer = document.querySelector('.show-games');

            gameTypeButtons.forEach(button => {
                button.addEventListener('click', async (event) => {
                    const type = button.getAttribute('data-type');

                    gameTypeButtons.forEach(btn => btn.classList.remove('bg-[#ff66003d]'));
                    button.classList.add('bg-[#ff66003d]');

                    try {
                        loader.classList.remove('hidden');

                        const response = await fetch(`{{ route('get-games') }}?type=${type}`);
                        const data = await response.json();

                        loader.classList.add('hidden');
                        noGamesMessage.classList.add('hidden');

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
                gamesContainer.innerHTML = '';

                games.forEach(game => {
                    let div = document.createElement("div");
                    div.classList = "relative bg-[#171b35] h-[150px] lg:h-[200px] rounded-lg p-2 cursor-pointer group";

                    div.innerHTML = `
                        <div class="absolute top-0 left-0 h-full w-full">
                            <img src="${game.image_url || 'https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png'}"
                                class="w-full h-full rounded-xl"
                                onerror="this.onerror=null; this.src='https://stakeye.com/assets/newhome/img/sliders/live-blackjack-at.png';" />
                        </div>
                        <div class="absolute top-0 left-0 bg-[#ff6600] h-full w-full rounded-xl 
                            opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-[999] px-2 py-3 lg:px-4 lg:py-3 overflow-hidden">
                            <div class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex items-center justify-center 
                                -translate-x-1/2 -translate-y-1/2">
                                <div class="sun-rays"></div>
                            </div>
                            <div class="relative z-10 leading-1">
                                <h6 class="text-white text-sm font-medium mb-0 leading-1">${game.table_name || 'Game Title'}</h6>
                                <p class="text-[#e0e0e0] text-xs mt-[0px] leading-1">${game.game_name || 'Game Tag'}</p>
                            </div>

                            <button class="relative z-10 w-full bg-white text-[#ff6600] text-sm py-1.5 lg:py-2 px-2 lg:px-4 rounded-xl lg:ml-1 mt-5 lg:mt-10 lobby-game" data-gameid="${game.game_code}" data-gametableid="${game.table_code}">
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

                    gamesContainer.appendChild(div);
                });
            }
        });
    </script>

</body>

</html>