@php
$kycInstruction = getContent('kyc\.content', true);
@endphp
@php $referredByRole = \App\Models\User::with('referrer')->find(auth()->user()->id)->referrer->user_type??''; 
@endphp
@extends($activeTemplate . 'layouts.master')

@section('content')


    <!-- dashboard section start -->
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="notice"></div>
            <div class="row mt-5">
                <div class="col-lg-12">
                    @php
                        $kyc = getContent('kyc.content', true);
                    @endphp
                    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                        <div class="alert alert-danger" role="alert">
                            <div class="d-flex justify-content-between">
                                <h4 class="alert-heading">@lang('KYC Documents Rejected')</h4>
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#kycRejectionReason">@lang('Show Reason')</button>
                            </div>
                            <hr>
                            <p class="mb-0">{{ __(@$kyc->data_values->reject) }} <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Re-submit Documents')</a>.</p>
                            <br>
                            <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                        </div>
                    @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                            <hr>
                            <p class="mb-0">{{ __(@$kyc->data_values->required) }} <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Submit Documents')</a></p>
                        </div>
                    @elseif(auth()->user()->kv == Status::KYC_PENDING)
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                            <hr>
                            <p class="mb-0">{{ __(@$kyc->data_values->pending) }} <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                        </div>
                    @endif
                </div>

                @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT || $referredByRole !='AGENT' )
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>@lang('Referral Link')</label>
                        <div class="input-group">
                            <input class="form--control referralURL" name="text" type="text" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly>
                            <span class="input-group-text copytext copyBoard" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="row gy-4 align-items-center mt-2">
                <div class="col-lg-3 col-sm-6">
                    <div class="balance-card">
                        <span class="text--dark">@lang('Main Wallet Balance')</span>
                        <h3 class="number text--dark">{{ gs('cur_sym') }}{{ getAmount(@$user->balance) }}</h3>
                        @if (auth()->user()->user_type != \App\Models\User::USER_TYPE_AGENT) 
                        <a class="btn btn-sm btn-success" href="{{route('user.withdraw.transfer','out')}}">Add to game zone </a>
                        <br/>   <br/>  <a  class="btn btn-sm btn-danger"  href="{{route('user.withdraw.transfer','in')}}">Withdrawal from gamezone </a>
                        @endif
                    </div>
                </div>

              
            </div><!-- row end -->
            
        </div>
    </section>

    @if (auth()->user()->user_type != \App\Models\User::USER_TYPE_AGENT) 
    @php
    $otherGames = \App\Models\OtherGames::where('status',1)->get();
        if(count($otherGames)> 0 ){ 

      
        



    @endphp
  <!-- dashboard section start -->
  <section id="game" class="game-section pt-95 pb-95">
      <div class="container">
            <hr/>
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-10">
                    <div class="section-title text-center right-greadient mb-50">
                        <h1 class="mb-25">Most Played <span class="common-gre-color">Games</span></h1>
                        <p>Play most played game and earn more</p>
                    </div>
                </div>
            </div>
            <div class="row">
 
             @foreach($otherGames as $key=>$val) 
                <div class="col-lg-3 col-sm-6">
                    <div class="balance-card">
                  
                    <h3 >  <span class="text--dark">{{strtoupper($val->name)}}</span></h3>
                
                        <br/>  <br/>
                         <a class="form--control" href="{{route('games.play-game',$val->slug)}}">Play Now </a> 
                      
                    </div>
                </div> 

                @endforeach
            </div>

            </div>

    </section>
@php
    }
@endphp
  
@endif

     <!-- Game Section Start -->
   
     <section id="game" class="game-section pt-95 pb-95">
        <div class="container"><hr/>
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
    <!-- dashboard section end -->
@endsection

@push('style-lib')
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
        })(jQuery);
    </script>
  
@endpush
