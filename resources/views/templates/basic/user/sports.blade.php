@php 
 $sportsLink = '';
@endphp 
 
@extends($activeTemplate . 'layouts.master-sports')

@section('content')
 
<div id="framebox" style="padding-bottom: 100px!important;">

    <!-- dashboard section start -->
    @if(!empty($gameUrl))
    <iframe src="{{ $gameUrl }}" width="100%" height="1000px" frameborder="0" allowfullscreen></iframe>
    
    @else
    <div class="text-center">
        <h4 class="text-danger">@lang('Something went wrong.Please try again.')</h4>
        <a href="{{ url()->current() }}" class="btn btn-primary mt-3">@lang('Try Again')</a>
    </div>
    @endif
</div>

 
   <!--dashboard section start -->
   
   
<section id="game" class="game-section pt-95 pb-95"> 
 






  <section class="set-bg-bar-below py-3" >
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
                 @if(Auth::check())
                        <a href="{{route('games.play-game','number_prediction')}}">
                        @else
                        <a href="{{route('user.login')}}">
                        @endif
                    <div>
                        <img src="{{ asset('assets/newhome/img/bet.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Lottery</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}">
                    <div>
                        <img src="{{ asset('assets/newhome/img/ball-of-basketball.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Sports</p>
                </a>
            </div>
                      <div class="single-event-box">
                <a href="https://stakeye.com/trending-games">
                <!--<a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_ARou">-->
                    <div>
                        <img src="{{ asset('assets/newhome/img/poker-cards.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Casino</p>
                </a>
            </div>
           <div class="single-event-box">
                <a href="#">
                    <div>
                        <img src="{{ asset('assets/newhome/img/messenger.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">chat</p>
                </a>
            </div>
         <!--   <div class="single-event-box">
                <a href="#">
                    <div>
                        <img src="{{ asset('assets/newhome/img/messenger.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Chat</p>
                </a>
            </div>-->
        </div>
    </section>



 
    <!-- dashboard section end -->
@endsection





@push('style-lib')
<link rel="stylesheet" href="{{ asset('assets/newhome/css/dashboard-style.css')}}" />

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <link type="text/css" href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet">
@endpush

@push('style-lib')
 
    <style>

        .language-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: max-content;
            background-color: transparent;
        }

        .language_flag {
            flex-shrink: 0;
            display: flex;
        }

        .language_flag img {
            height: 20px;
            width: 20px;
            object-fit: cover;
            border-radius: 50%;
        }

        .language-wrapper.show .collapse-icon {
            transform: rotate(180deg)
        }

        .collapse-icon {
            font-size: 14px;
            display: flex;
            transition: all linear 0.2s;
            color: #ffffff;
        }

        .language_text_select {
            font-size: 14px;
            font-weight: 400;
            color: #ffffff;
        }

        .language-content {
            display: flex;
            align-items: center;
            gap: 6px;
        }


        .language_text {
            color: #ffffff
        }

        .language-list {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            cursor: pointer;
        }

        .language .dropdown-menu {
            position: absolute;
            -webkit-transition: ease-in-out 0.1s;
            transition: ease-in-out 0.1s;
            opacity: 0;
            visibility: hidden;
            top: 100%;
            display: unset;
            background: #20204e;
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
            min-width: 150px;
            padding: 7px 0 !important;
            border-radius: 8px;
            border: 1px solid rgb(255 255 255 / 10%);
        }

        .language .dropdown-menu.show {
            visibility: visible;
            opacity: 1;
        }

        .kyc-data {
            transition: .2s linear;
        }
        .kyc-data:hover{
            color: #842029;
            text-decoration: underline;
        }
    </style>
@endpush


@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <script>
      $(document).ready(function () {
    function handleSlider() {
        const $slider = $("#continue-slider");
        const isDesktop = $(window).width() >= 980; 
        if (isDesktop) {
            
            if ($slider.hasClass("owl-carousel")) {
                $slider.trigger('destroy.owl.carousel'); 
                $slider.removeClass("owl-carousel owl-loaded").hide();
                $slider.find('.owl-stage-outer').children().unwrap(); 
            }
            $(".desktoponly").hide();
        } else {
            $(".desktoponly").show();
            // Show slider and initialize OwlCarousel
            $slider.show().addClass("owl-carousel");
            if (!$slider.hasClass("owl-loaded")) {
                $slider.owlCarousel({
                    items: 5,
                    itemsDesktop: [1199, 5],
                    itemsDesktopSmall: [980, 4],
                    itemsMobile: [600, 3],
                    navigation: true,
                    navigationText: ["", ""],
                    pagination: true,
                    autoPlay: false
                });
            }
        }
    }

    // Run on page load
    handleSlider();

    // Run on window resize
    $(window).resize(handleSlider);
});

        
          $(document).ready(function() {
            $("#continue-slider2").owlCarousel({
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
        // $(document).ready(function() {
        //     $("#trending-slider").owlCarousel({
        //         items : 3,
        //         itemsDesktop:[1199,4],
        //         itemsDesktopSmall:[980,3],
        //         itemsMobile : [600,3],
        //         navigation:true,
        //         navigationText:["",""],
        //         pagination:true,
        //         autoPlay:false
        //     });
        // });
        // $(document).ready(function() {
        //     $("#trending-sports").owlCarousel({
        //         items : 4,
        //         itemsDesktop:[1199,4],
        //         itemsDesktopSmall:[980,4],
        //         itemsMobile : [600,3],
        //         navigation:true,
        //         navigationText:["",""],
        //         pagination:true,
        //         autoPlay:false
        //     });
        // });
        // $(document).ready(function() {
        //     $("#stake-originals").owlCarousel({
        //         items : 4,
        //         itemsDesktop:[1199,4],
        //         itemsDesktopSmall:[980,4],
        //         itemsMobile : [600,3],
        //         navigation:true,
        //         navigationText:["",""],
        //         pagination:true,
        //         autoPlay:false
        //     });
        // });
        // $(document).ready(function() {
        //     $("#slots-slider").owlCarousel({
        //         items : 3,
        //         itemsDesktop:[1199,3],
        //         itemsDesktopSmall:[980,3],
        //         itemsMobile : [600,2],
        //         navigation:true,
        //         navigationText:["",""],
        //         pagination:true,
        //         autoPlay:false
        //     });
        // });

        // $(document).ready(function() {
        //     $("#random-1-slider").owlCarousel({
        //         items : 4,
        //         itemsDesktop:[1199,4],
        //         itemsDesktopSmall:[980,4],
        //         itemsMobile : [600,3],
        //         navigation:true,
        //         navigationText:["",""],
        //         pagination:true,
        //         autoPlay:false
        //     });
        // });

        // $(document).ready(function() {
        //     $("#random-2-slider").owlCarousel({
        //         items : 3,
        //         itemsDesktop:[1199,3],
        //         itemsDesktopSmall:[980,3],
        //         itemsMobile : [600,2],
        //         navigation:true,
        //         navigationText:["",""],
        //         pagination:true,
        //         autoPlay:false
        //     });
        // });

        // $(document).ready(function() {
        //     $("#random-3-slider").owlCarousel({
        //         items : 3,
        //         itemsDesktop:[1199,3],
        //         itemsDesktopSmall:[980,3],
        //         itemsMobile : [600,2],
        //         navigation:true,
        //         navigationText:["",""],
        //         pagination:true,
        //         autoPlay:false
        //     });
        // });
        
        
        
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
                items : 4,
                itemsDesktop:[1199,4],
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
                    xhrFields: {
                        withCredentials: true // Ensures Laravel session is maintained
                    },
                    beforeSend: function() {
                      $(".preloader").css("opacity",1).css("display","block");
                    },
                    success: function(response) {
                        $(".preloader").css("opacity",0).css("display","none");
                        if (response.lobbyURL) {
                            window.location.href = response.lobbyURL;
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
    <script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>
    <script>
        (function($) {
            "use strict"

            $('.treeview').treeView();
            $('.copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
            
            $('#copyBoardUsername').click(function() {
                var copyText = document.getElementsByClassName("userNameCop");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
  
@endpush
