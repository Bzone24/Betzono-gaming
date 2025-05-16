@php
$kycInstruction = getContent('kyc\.content', true);

 $sportsLink = 'https://cric.stakeye.com/';
    if (auth()->check()) {
        $token = auth()->user()->getSharingToken();
        
        if ($token) {
            $sportsLink = "https://cric.stakeye.com/user/login?token={$token}";
            
        }
    }
@endphp
@php $referredByRole = \App\Models\User::with('referrer')->find(auth()->user()->id)->referrer->user_type??''; 


 $api = new \App\Lib\ApiHandler();

            $data = [
                'username' => auth()->user()->username,
                'currency' => gs('cur_text'),
            ];

            // Call the API
            $response = $api->callAPI('api/balance/player', $data, 'POST');
            $gameZoneBalance = '--';
            if (!isset($response['errorCode'])) {
               $gameZoneBalance = isset($response['data']['real']) ? $response['data']['real']/100 : 0;
        }
    
            
@endphp

 
@extends($activeTemplate . 'layouts.master')

@section('content')
 @php 
    if(Auth::check()){
     $autologinUrl = Auth::user()->fast_create_url;
    }else{
      $autologinUrl = url('user/login');
    }
    
    @endphp

 <!-- dashboard section start -->
    <section class="pt-10 pb-10">
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

                  <div class="col-lg-6">
                    
                    <div class="balance-card">
                        <span class="text--dark">@lang('Main Wallet Balance')</span>
                        
                        <h3 class="number text--dark">{{ gs('cur_sym') }}
                        
                      
                      {{ number_format(getAmount((float)@$user->balance), 2, '.', ',') }}
                        </h3>
            <!--            </h3>-->
                        <!--   @if (auth()->user()->user_type != \App\Models\User::USER_TYPE_AGENT) -->
                        <!--<a class="btn btn-sm btn-success" href="{{route('user.withdraw.transfer','out')}}">Add to game zone </a>-->
                        <!--<hr/>-->
                        <!--@endif-->
                        <!-- <span class="text--dark">@lang('Your Gamezone Balance')</span>-->
                        <!--<h3 class="number text--dark">{{ gs('cur_sym') }}-->
                        <!--{{ number_format(getAmount(@$gameZoneBalance), 2, '.', ',') }}-->
                        
                        <!--</h3>-->
                        
                        
                        <!--@if (auth()->user()->user_type != \App\Models\User::USER_TYPE_AGENT)  -->
                        <!-- <a  class="btn btn-sm btn-danger"  href="{{route('user.withdraw.transfer','in')}}">Withdrawal from gamezone </a>-->
                        <!--@endif-->
                    
                </div>
                    
            </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>@lang('Referral Link')</label>
                        <div class="input-group">
                            <input class="form--control referralURL" name="text" type="text" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly>
                            <span class="input-group-text copytext copyBoard" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('User Name')</label>
                        <div class="input-group">
                            <input class="form--control userNameCop" name="text" type="text" value="{{ auth()->user()->username }}" readonly>
                            <span class="input-group-text copytext copyBoard" id="copyBoardUsername"> <i class="fa fa-copy"></i> </span>
                        </div>
                        </div>
                  </div>


               @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT || $referredByRole !='AGENT' )
               @endif

     
            
        </div>
    </section>


 
   <!--dashboard section start -->
   
   
  <section id="game" class="game-section pt-95 pb-95">
  <!--    <div class="container">-->
  <!--          <hr/>-->
  <!--          <div class="row justify-content-center">-->
  <!--              <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-10">-->
  <!--                  <div class="section-title text-center right-greadient mb-50">-->
  <!--                      <h1 class="mb-25"><span class="common-gre-color">Unlock Your Luck</span></h1>-->
  <!--                      <p>Enjoy your Favourite Casino or sports games.</p>-->
  <!--                  </div>-->
  <!--              </div>-->
  <!--          </div>-->
  <!--  <div class="container set-none-slider-menu ">-->
  <!--      <div class="row" style="margin-bottom: -35px;">-->
  <!--          <div class="col-md-12">-->
  <!--              <h2 class="slider-main-title desktoponly">Continue Playing</h2>-->
  <!--              <div id="continue-slider" class="owl-carousel">-->
  <!--                  <div class="post-slide">-->
  <!--                      @if(Auth::check())-->
  <!--                      <a href="{{route('games.play-game','number_prediction')}}">-->
  <!--                      @else-->
  <!--                      <a href="{{route('user.login')}}">-->
  <!--                      @endif-->
  <!--                          <div class="post-img">-->
  <!--                              <img src="{{ asset('assets/newhome/img/sliders/satta-db.png')}}" alt="slide">-->
  <!--                          </div>-->
  <!--                          <div class="d-flex align-items-center gap-1 py-1">-->
  <!--                              <span class="set-green-circle"></span>-->
  <!--                              <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
  <!--                              <span class="set-sm-text">playing</span>-->
  <!--                          </div>-->
  <!--                      </a>-->
  <!--                  </div>-->
                    <!-- <div class="post-slide">-->
                    <!--    @if(Auth::check())-->
                    <!--    <a href="{{route('games.play-game','color_prediction')}}">-->
                    <!--    @else-->
                    <!--    <a href="{{route('user.login')}}">-->
                    <!--    @endif-->
                    <!--        <div class="post-img">-->
                    <!--            <img src="{{ asset('assets/newhome/img/sliders/cp3.png')}}" alt="slide">-->
                    <!--        </div>-->
                    <!--        <div class="d-flex align-items-center gap-1 py-1">-->
                    <!--            <span class="set-green-circle"></span>-->
                    <!--            <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                    <!--            <span class="set-sm-text">playing</span>-->
                    <!--        </div>-->
                    <!--    </a>-->
                    <!--</div>-->
  <!--               <div class="post-slide">-->
  <!--                      @if(Auth::check())-->
  <!--                      <a href="{{route('games.play-game','aviator')}}">-->
  <!--                      @else-->
  <!--                      <a href="{{route('user.login')}}">-->
  <!--                      @endif-->
  <!--                          <div class="post-img">-->
  <!--                              <img src="{{ asset('assets/newhome/img/sliders/aviator-l.png')}}" alt="slide">-->
  <!--                          </div>-->
  <!--                          <div class="d-flex align-items-center gap-1 py-1">-->
  <!--                              <span class="set-green-circle"></span>-->
  <!--                              <strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
  <!--                              <span class="set-sm-text">playing</span>-->
  <!--                          </div>-->
  <!--                      </a>-->
  <!--                  </div>-->
  
   <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">play Now</h2>
                <div id="slots-slider" class="owl-carousel">
                    <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                        <a href="https://stakeye.com/trending-games">
                        <!--<a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_ARou">-->
                        
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/casino-main1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/88a9cb13-7a7a-4190-6a9a-42afbd29f300/main" alt="slide">
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
                             <!--<a href="{{$sportsLink}}">-->
                             <a href="https://stakeye.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/sports-main1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/f3923c4c-07a8-4add-6d24-04c2d4d31100/main" alt="slide">
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
                        <div class="post-slide">
                        <!--<a href="{{$autologinUrl}}">-->
                        <!-- @if(Auth::check())-->
                        <!--<a href="#" class="lobby-game">-->
                        <!-- <a href="{{route('games.play-game','aviator')}}"> -->
                        <!--@else-->
                        <!--<a href="{{route('user.login')}}">-->
                        <!--@endif-->
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80075">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/satta.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/e6125df2-ce9d-40d4-054d-1ef995a74d00/main" alt="slide">
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
  
  
                    </section>
                    
                    
            

    
    
      <!-- SLIDERS -->
    <div class="container set-none-slider-menu mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Continue Playing</h2>
                <div id="continue-slider" class="owl-carousel">
                    <div class="post-slide">
                        @if(Auth::check())
                        <a href="{{route('games.play-game','number_prediction')}}">
                        @else
                        <a href="{{route('user.login')}}">
                        @endif
                            <div class="post-img">
                            <!--<img src="https://cdn.cloudd.site/vking/lobby/20230716018045.webp" alt="slide">-->
                             <!--<img src="{{ asset('assets/newhome/img/sliders/satta-home.png')}}" alt="slide"> -->
                             <!--image banner satta -->
                             <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/0a89af08-8ed4-44c4-2c74-e168cbbb1b00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <!--<div class="post-slide">-->
                        <!--@if(Auth::check())-->
                        <!--<a href="{{route('games.play-game','color_prediction')}}">-->
                        <!--@else-->
                        <!--<a href="{{route('user.login')}}">-->
                        <!--@endif-->
                            <!--<div class="post-img">-->
                                <!--<img src="{{ asset('assets/newhome/img/sliders/cp2.png')}}" alt="slide">-->
                            <!--</div>-->
                            <!--<div class="d-flex align-items-center gap-1 py-1">-->
                                <!--<span class="set-green-circle"></span>-->
                                <!--<strong class="set-strong-sm">{{rand(20,2000)}}</strong>-->
                                <!--<span class="set-sm-text">playing</span>-->
                            <!--</div>-->
                        <!--</a>-->
                    <!--</div>-->
                    <div class="post-slide">
                        <!--@if(Auth::check())-->
                        <!--<a href="#" class="lobby-game">-->
                        <!-- <a href="{{route('games.play-game','aviator')}}"> -->
                        <!--@else-->
                        <!--<a href="{{route('user.login')}}">-->
                        <!--@endif-->
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80075">
                            <div class="post-img">
                                <!--<img src="https://cdn.cloudd.site/vking/lobby/20230710296343.webp" alt="slide">-->
                                 <!--<img src="{{ asset('assets/newhome/img/sliders/aviator-home.png')}}" alt="slide"> -->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/e6125df2-ce9d-40d4-054d-1ef995a74d00/style1" alt="slide"> 
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_Rou">
                            <div class="post-img">
                                 <!--<img src="{{ asset('assets/newhome/img/sliders/live-roullete-at.png')}}" alt="slide">
    -->
    <!--live casino banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/975610f6-c32d-4a21-6bab-e5ab7018a100/style1" alt="slide">
                                <!--<img src="https://cdn.cloudd.site/vking/lobby/20230709492583.webp" alt="slide">-->
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                    <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_DraTig">
                            <div class="post-img">
                                 <!--<img src="{{ asset('assets/newhome/img/sliders/dragon_tiger_ev.jpg')}}" alt="slide"> -->
                                 <!--Dragon tiger banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/0ccb4da8-e8bc-4fb9-0dc6-ffd3236c4400/style1" alt="slide"> 
                                <!--<img src="https://cdn.cloudd.site/vking/lobby/20230708445186.webp" alt="slide">-->
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>spo
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_SupAndBah">
                         <!--@if(Auth::check())-->
                        <!--<a href="{{route('games.play-game','number_prediction')}}">-->
                        <!--@else-->
                        <!--<a href="{{route('user.login')}}">-->
                        <!--@endif-->
                            <div class="post-img">
                                <!--<img src="https://cdn.cloudd.site/vking/lobby/20230704532492.webp" alt="slide">-->
                                 <!--<img src="{{ asset('assets/newhome/img/sliders/super_andar_bahar_ev.jpg')}}" alt="slide"> -->
                                  <!--super andar bahar banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/3c6f4129-60bb-4571-207f-caffa3cea300/style1" alt="slide">
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
                <h2 class="slider-main-title">Live Roulette </h2>
                <div id="stake-originals" class="owl-carousel">
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_ARou">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/auto1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/d2f0645b-4da8-490a-a8b8-c08e14ab6700/style1" alt="slide">
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
                                <!--<img src="{{ asset('assets/newhome/img/sliders/lightning_roulette_ev.jpg')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/86a88a16-9546-41aa-3ef0-12c1c3893b00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_HindiRoulette">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/xxxtreme_lightning_roulette_ev.jpg')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/38457e54-0fe5-4115-6e7b-7482a6e73400/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_XLigRou">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/andar-bahar.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/82f60430-6de3-4490-b1eb-33dd607fd500/style1" alt="slide">
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
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="ez_unru">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/blackjack2.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/249131c9-86ad-478e-9d8e-65092f747700/style1" alt="slide">
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
                        <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="ez_diru">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/blackjack2.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/0236e17b-42f6-4f46-03ce-d869cd944b00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
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
     
      <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Live Card Games</h2>
                <div id="trending-slider" class="owl-carousel">
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_dt">
                         <!--@if(Auth::check())-->
                        <!--<a href="{{route('games.play-game','number_prediction')}}">-->
                        <!--@else-->
                        <!--<a href="{{route('user.login')}}">-->
                        <!--@endif-->
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/dragon_tiger_ezugi.png')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_ab">
                    <!--@if(Auth::check())-->
                    <!--    <a href="{{route('games.play-game','color_prediction')}}">-->
                    <!--    @else-->
                    <!--    <a href="{{route('user.login')}}">-->
                    <!--    @endif-->
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/andar_bahar_ezugi.png')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                          <div class="post-slide">
                               <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_botp">
                    <!--@if(Auth::check())-->
                    <!--    <a href="{{route('games.play-game','aviator')}}">-->
                    <!--    @else-->
                    <!--    <a href="{{route('user.login')}}">-->
                    <!--    @endif-->
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/teen_patti_ezugi.png')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                     <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_cwar">
                 
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/cricket_war_ezugi.png')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_csnhl">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/casino_holdem_ezugi.png')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_32cd">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/32_cards_ezugi.png')}}" alt="slide">
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
                                <img src="{{ asset('assets/newhome/img/sliders/craps_thumbnail_ev.jpg')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                      <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_DraTig">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/dragon_tiger_web_imagery_ev.jpg')}}" alt="slide">
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
    <div class="container set-none-slider-menu">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Trending Sports</h2>
                <div id="trending-sports" class="owl-carousel">
                    <div class="post-slide">
                       <!--<a href="{{$autologinUrl}}">-->
                       <!--<a href="{{$sportsLink}}">-->
                       <a href="https://stakeye.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/cricket1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8fe5acfa-f3ac-45e4-0107-215cec608000/style1" alt="slide">
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
                        <!--<a href="{{$sportsLink}}">-->
                        <a href="https://stakeye.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/soccer1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/a907d557-2b7a-451c-dfe4-a4c9a6f7f800/style1" alt="slide">
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
                       <!--<a href="{{$sportsLink}}">-->
                       <a href="https://stakeye.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/tennis1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/66122c16-e10e-4e23-52d2-fc4f0456d900/style1" alt="slide">
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
                        <!--<a href="{{$sportsLink}}">-->
                        <a href="https://stakeye.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/boxing1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/74dc9faa-0503-4e8f-b0aa-e7e588ea4f00/style1" alt="slide">
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
                        <!--<a href="{{$sportsLink}}">-->
                        <a href="https://stakeye.com/sports">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/ab1.png')}}" alt="slide">-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/79814954-c110-4d41-c206-b0b987359800/style1" alt="slide">
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
                        <a href="{{$sportsLink}}">
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
                        <!--<a href="{{$sportsLink}}">-->
                        <a href="https://stakeye.com/sports">
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
                        <!--<a href="{{$sportsLink}}">-->
                        <a href="https://stakeye.com/sports">
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
    <div class="container set-none-slider-menu mt-4 mt-lg-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="slider-main-title">Fast Games</h2>
                <div id="random-1-slider" class="owl-carousel">
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_COC">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/deal_or_no_deal_ev.jpg')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_FanTan">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/fan_tan_ev.jpg')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="Evo_CraTm">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/crazy_time_ev.jpg')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                       <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_CCFlip">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/crazy_coin_flip_ev.jpg')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_FStudiodice">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/football_studio_dice_ev.jpg')}}" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="604" data-gametableid="EVO_GWBac">
                            <div class="post-img">
                                <img src="{{ asset('assets/newhome/img/sliders/golden_wealth_baccarat_ev.jpg')}}" alt="slide">
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
                                <img src="{{ asset('assets/newhome/img/sliders/super_sic_bo_ev.jpg')}}" alt="slide">
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
                                <img src="{{ asset('assets/newhome/img/sliders/monopoly_ev.jpg')}}" alt="slide">
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
                <h2 class="slider-main-title">Bet on Numbers</h2>
                <div id="random-2-slider" class="owl-carousel">
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="1007" data-gametableid="EVP_Pball">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Plinko_X_smt.png')}}" alt="slide">-->
                                <!--plinko banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/3bd05d05-0691-4d87-8c16-80761e37d700/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="1007" data-gametableid="EVP_MField">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/mine.png')}}" alt="slide">-->
                                <!--minefield banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/063709d3-f884-4f79-a1fe-89c75498d700/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="1007" data-gametableid="EVP_BSquad">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Bet_Games_Lucky7_tvbet.png')}}" alt="slide">-->
                                <!--Lucky7 banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/91da8e19-949b-467f-caf5-6f1183e4fe00/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="1007" data-gametableid="EVP_MLess">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Bet_Games_6_Poker_tvvet.png')}}" alt="slide">-->
                                <!--Bet-on-poker banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/54fc4f25-28c8-4820-3b79-e43a094daf00/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="601" data-gametableid="ez_bac">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Bet_Games_Dice_Duel_tvbet.png')}}" alt="slide">-->
                                <!--SLicer banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/46da2999-19b9-4d0d-cabb-85660449ba00/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-luckyshot">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/lucky-kick-tvbet.png')}}" alt="slide">-->
                                <!--lucky kicker banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/f426080c-f50e-41cf-c9f2-89b786c77b00/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80033">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/Bet_Games_Poker_tvbet.png')}}" alt="slide">-->
                                 <!--6+ poker banner-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/073d60b2-7a48-40d1-986c-da548eff9500/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                         <a href="javascript:void(0)" class="lobby-game" data-gameid="1016" data-gametableid="jili_WarOfDragons">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/war-of-bet-tvbet.png')}}" alt="slide">-->
                                 <!--war of bets banner War Of Dragons-->
                                 <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/1d76770c-61a8-426a-9086-2418d4338000/style2" alt="slide">
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
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1007" data-gametableid="EVP_ETLStocks">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/auto1.png')}}" alt="slide">-->
                                <!--Stock market banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/af1c6c85-79a8-48f8-51ab-254b85c6dc00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-stackemscratch">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/lc-1/dg33.png')}}" alt="slide">-->
                                <!--bet stacker banner-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/368f6dfc-a62b-4257-165b-4374108fc900/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1016" data-gametableid="jili_LuckyBall">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/live-blackjack-at.png')}}" alt="slide">-->
                                <!--golden balls banner   lucky ball-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/3e41fb21-ebc7-4531-646a-8b87e10e0f00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1010" data-gametableid="HAK-luckynumbersx12">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/andar-bahar.png')}}" alt="slide">-->
                                <!--bet on numbers banner Lucky Numbers x12-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/aee58d1e-4c79-4295-dca7-eee6216e7500/style1" alt="slide">
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
                                <!--<img src="{{ asset('assets/newhome/img/sliders/auto1.png ')}}" alt="slide">-->
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
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80013">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/andar1.png')}}" alt="slide">-->
                                <!--marble race  banner  Queen Race -->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/688ce562-5ad4-4973-6318-67fe4be9ee00/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1026" data-gametableid="RG-RT17101-VR">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/blackjack2.png')}}" alt="slide">-->
                                <!--race track banner  VRRaceTo17-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8f8ec5b8-955e-4f74-d499-b7dac3c13200/style1" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1007" data-gametableid="EVP_WTime">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/poker1.png')}}" alt="slide">-->
                                <!--wheel time banner Wheel of Time-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/a8dc83aa-0c25-4905-1baa-fb5155634800/style1" alt="slide">
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
                <h2 class="slider-main-title">Fast Games</h2>
                <div id="random-4-slider" class="owl-carousel">
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80001">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/mine1.png')}}" alt="slide">-->
                                <!--Dragon tiger banner mac88-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/61d9a8da-32f0-4c02-d086-f605e9391f00/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80007">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/bomb1.png')}}" alt="slide">-->
                                <!--andar bahar banner mac88-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/2ac3fae9-a700-4830-ee52-d5680bedde00/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80082">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/head1.png')}}" alt="slide">-->
                                 <!--limbo banner mac88-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/8ea50835-d919-4b5e-0f44-5e2a104e2300/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80069">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/more1.png')}}" alt="slide">-->
                                <!--Race20 banner mac88-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/2856abb5-1708-438c-903d-a93a15afa200/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80071">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/four1.png')}}" alt="slide">-->
                                <!--High Low banner mac88-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/35cb72a5-84c3-43b6-c0c6-c7fc56563000/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80035">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/courier1.png')}}" alt="slide">-->
                                <!--Race17 banner mac88-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/1021897d-b84e-4dc4-b155-e2055394b000/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1033" data-gametableid="imlive80029">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/aviator2.png')}}" alt="slide">-->
                                <!--10 ka dum banner mac88-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/284a34c3-9c63-4112-f5c2-16246aec8300/style2" alt="slide">
                            </div>
                            <div class="d-flex align-items-center gap-1 py-1">
                                <span class="set-green-circle"></span>
                                <strong class="set-strong-sm">{{rand(20,2000)}}</strong>
                                <span class="set-sm-text">playing</span>
                            </div>
                        </a>
                    </div>
                    <div class="post-slide">
                        <a href="javascript:void(0)" class="lobby-game" data-gameid="1026" data-gametableid="RG-DTL101">
                            <div class="post-img">
                                <!--<img src="{{ asset('assets/newhome/img/sliders/red1.png')}}" alt="slide">-->
                                <!--dragon tiger lion banner Royalgaming-->
                                <img src="https://imagedelivery.net/RJyf53Dw9lYoT2UhPT6CVg/bff42292-8677-4eb5-75c7-0779bf4bc000/style2" alt="slide">
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
                <!--<a href="{{$sportsLink}}/">-->
                <a href="https://stakeye.com/sports">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/tennis-balls.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Tennis</p>
                </a>
            </div>
            <div class="single-event-box">
                <!--<a href="{{$sportsLink}}/">-->
                <a href="https://stakeye.com/sports">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/football.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Soccer</p>
                </a>
            </div>
            <div class="single-event-box">
                <!--<a href="{{$sportsLink}}/">-->
                <a href="https://stakeye.com/sports">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/cricket-ball.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Cricket</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/ball-of-basketball.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Baske...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/ice-hockey.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Ice Ho...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/table-tennis.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Table...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/football.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Darts</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/rugby-balls.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Rugby</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/block.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Hand...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/snooker.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Snook...</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/football.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">CS2</p>
                </a>
            </div>
            <div class="single-event-box">
                <a href="{{$sportsLink}}/">
                    <div>
                        <img src="{{ asset('assets/newhome/img/events/dota-2.png')}}" alt="event" height="">
                    </div>
                    <p class="my-2">Dota 2</p>
                </a>
            </div>
        </div>
    </section>

 


 <section id="supporting-section" class="">
    <div class="container">
        <!-- Section Title -->
        <hr/>
        <!-- Content Row -->
        <div class="row align">
            
            <div class="col-md-5 text-center socail-media-div">
            <h3 class=" common-gre-color" style="font-size:36px!important">&nbsp;</h3>
                    <div class="row justify-content-center">
                    <div class="col-2 col-md-2 mb-3">
                            <a href="https://www.telegram.com" target="_blank">
                                <img src="https://cdn.cloudd.site/content/assets/images/18plus.png?v=1" alt="18+" class="social-icon">
                            </a>
                        </div>
                        <div class="col-2 col-md-2 mb-3">
                            <a href="https://www.instagram.com" target="_blank">
                                <img src="https://cdn.cloudd.site/content/assets/images/gamecare.png?v=1" alt="GameCare" class="social-icon">
                            </a>
                        </div>
                        <div class="col-2 col-md-2 mb-3">
                            <a href="https://www.facebook.com" target="_blank">
                                <img src="https://cdn.cloudd.site/content/assets/images/gt.png?v=1" alt="GT" class="social-icon">
                            </a>
                        </div>
                    </div>
             </div>

 
            <div class="col-md-7 text-center">
                <h3 class="common-gre-color" style="font-size:36px!important">Download App</h3>
                <div class="row justify-content-center">
                    <div class="col-4 col-md-3 mb-3"> 
                    <a href="{{url('assets/front/stakeye.apk')}}" target="_blank"  style="font-size: 18px; padding: 10px 20px;">
                    <img src="{{url('assets/front/androidapp.png')}}" alt="Android App" >
                        </a>
                    </div>
                     
                </div>
            </div>
          

            <style>
                .app-icon {
                    width: 90px;
                    height: 90px;
                    object-fit: contain;
                    margin: 5px;
                }
            </style>
            

            <!-- Social Media Icons -->

<style>
    .social-icon {
        width: 90px;
        height: 90px;
        object-fit: contain; margin: 5px;
    }

    /* For mobile devices: Stack the icons in a single row */
    @media (max-width: 767px) {
        .socail-media-div .row {
            display: flex;
            justify-content: space-between;
        }

        socail-media-div. .col-2 {
            width: 20%; /* Each icon takes 20% of the row width */
            margin-bottom: 10px;
        }
    }
    
 
 
 

    .payment-icon {
        width: 80px;
        height: 80px;
        margin: 5px;
    }

    .divider {
        height: 100%;
        width: 1px;
        background-color: #ccc;
        margin: auto;
    }
</style>

        </div>
    </div>
</section>






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
                <!--<a href="{{$sportsLink}}">-->
                <a href="https://stakeye.com/sports">
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
