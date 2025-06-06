<header class="header">
    <div class="header__bottom">
        <div class="container-fluid px-lg-5">
            <nav class="navbar navbar-expand-xl align-items-center p-0">
                <a class="site-logo site-title" href="{{ route('home') }}"><img
                        src="{{ getImage(getFilePath('logo_icon') . '/logo.png') }}" alt="logo"></a>
                        
                

                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu me-auto">
                        @auth
                        @php $referredByRole = \App\Models\User::with('referrer')->find(auth()->user()->id)->referrer->user_type??''; 
                        @endphp

                        @yield('fullscreen-button')
                            <li><a class="{{ menuActive('user.home') }}" href="{{ route('user.home') }}">@lang('Dashboard')</a></li>

                           <!--  <li class="menu_has_children">
                                <a class="{{ menuActive(['user.lottery', 'user.buy.lottery', 'user.tickets', 'user.wins']) }}" href="javascript:void(0)">@lang('Lotteries')</a>
                                <ul class="sub-menu">
                                    <li><a class="{{ menuActive('user.lottery') }}" href="{{ route('user.lottery') }}">@lang('All Lotteries')</a></li>
                                    <li><a class="{{ menuActive('user.wins') }}" href="{{ route('user.wins') }}">@lang('Total Wins')</a></li>
                                    <li><a class="{{ menuActive('user.tickets') }}" href="{{ route('user.tickets') }}">@lang('Purchased Tickets')</a></li>
                                    <li><a class="{{ menuActive('fun.game') }}" href="{{ route('fun.game') }}">Fun Game</a></li>
                                </ul>
                            </li> -->

                            @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT ||  $referredByRole =='AGENT' ) 
                         
                               <!-- <li>
                                    <a class="{{ menuActive('user.deposit.history') }}" href="{{ route('user.deposit.history') }}">@lang('Deposit History')</a>
                                </li>-->
                            @else
                            <li class="menu_has_children">
                                <a class="{{ menuActive('user.deposit.*') }}" href="javascript:void(0)">@lang('Deposit')</a>
                                <ul class="sub-menu">
                                    <li><a class="{{ menuActive('user.deposit.index') }}" href="{{ route('user.deposit.index') }}">@lang('Deposit Now')</a></li>
                                    <li><a class="{{ menuActive('user.deposit.history') }}" href="{{ route('user.deposit.history') }}">@lang('Deposit History')</a></li>
                                </ul>
                            </li>

                            @endif

                            @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT ||  $referredByRole =='AGENT' )
                           <!-- <li>
                                <a class="{{ menuActive('user.withdraw.history') }}" href="{{ route('user.withdraw.history') }}">@lang('Withdraw History')</a>
                            </li>-->
                            @else

                            <li class="menu_has_children">
                                <a class="{{ menuActive(['user.withdraw', 'user.withdraw.history']) }}" href="javascript:void(0)">@lang('Withdraw')</a>
                                <ul class="sub-menu">
                                    <li><a class="{{ menuActive('user.withdraw') }}" href="{{ route('user.withdraw') }}">@lang('Withdraw Now')</a></li>
                                    <li><a class="{{ menuActive('user.withdraw.history') }}" href="{{ route('user.withdraw.history') }}">@lang('Withdraw History')</a></li>
                                </ul>
                            </li>
                          
                            @endif



                            @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT  )
                            <li>
                                 <a class="{{ menuActive('user.transactions') }}" href="{{ route('user.transactions') }}">@lang('Transfer History')</a> 

                            </li>
                            @else

                            <li>
                                <a class="{{ menuActive('user.transactions') }}" href="{{ route('user.transactions') }}">@lang('Gamezone History')</a> 
                            </li>



                            @endif

 



                            @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT || $referredByRole !='AGENT')

                            <li class="menu_has_children">
                                <a class="{{ menuActive('ticket.*') }}" href="javascript:void(0)">@lang('Support')</a>
                                <ul class="sub-menu">
                                    <li><a class="{{ menuActive('ticket.open') }}" href="{{ route('ticket.open') }}">@lang('Open Ticket')</a></li>
                                    <li><a class="{{ menuActive('ticket.index') }}" href="{{ route('ticket.index') }}">@lang('Support Tickets')</a></li>
                                </ul>
                            </li>
                            @endif

                            @if (gs('deposit_commission') || gs('buy_commission') || gs('win_commission'))
                                <li class="menu_has_children">
                                    <a class="{{ menuActive(['user.commissions', 'user.referred']) }}" href="javascript:void(0)">@lang('Referral')</a>
                                    <ul class="sub-menu">
                                        <li><a class="{{ menuActive('user.commissions') }}" href="@if (gs('dc')) {{ route('user.commissions', 'all') }}
                                            @elseif(gs('buy_commission')) {{ route('user.commissions') }} @else
                                            {{ route('user.commissions') }} @endif ">@lang('Commission')</a>
                                        </li>
                                        <li><a class="{{ menuActive('user.referred') }}" href="{{ route('user.referred') }}">@lang('Referred Users')</a></li>
                                    </ul>
                                </li>
                            @endif

                            <li class="menu_has_children">
                                <a class="{{ menuActive(['user.profile.setting', 'user.change.password', 'user.twofactor', 'user.transactions']) }}" href="javascript:void(0)">@lang('Account')</a>
                                <ul class="sub-menu">
                                    <li><a class="{{ menuActive('user.profile.setting') }}" href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>

                                  <!--  <li><a class="{{ menuActive('user.transactions') }}" href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>-->

                                    <li><a class="{{ menuActive('user.change.password') }}" href="{{ route('user.change.password') }}">@lang('Change Password')</a>
                                    </li>
                                    <li><a class="{{ menuActive('user.twofactor') }}" href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                                </ul>
                            </li>
          


                            
                            @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT || $referredByRole !='AGENT' )
                            <li>
                                <a class="{{ menuActive('ticket.*') }}" href="{{ route('user.referred') }}">@lang('My Refferals')</a>
                            </li>
                            @endif



                            
                        @endauth
                    </ul>
                    <div class="nav-right">
                        @auth
                         
                            <a class="btn btn-sm btn--danger me-sm-3 me-2 btn--capsule px-3 text-white" href="{{ route('user.logout') }}">@lang('Logout')</a>
                        @else
                            <a class="btn btn-sm btn--base me-sm-3 me-2 btn--capsule px-3" href="{{ route('user.login') }}">@lang('Login')</a>
                        @endauth
                            @if(gs('multi_language'))
                                @php
                                    $language = App\Models\Language::all();
                                    $selectedLanguage = null;
                                    if (session('lang')) {
                                        $selectedLanguage = $language->where('code', config('app.locale'))->first();
                                    }
                                @endphp
                                <div class="language dropdown">
                                    <button class="language-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="language-content">
                                            <div class="language_flag">
                                                <img src="{{ getImage(getFilePath('language') . '/' . @$selectedLanguage->image, getFileSize('language')) }}" alt="image">
                                            </div>
                                            <p class="language_text_select">{{ __(@$selectedLanguage->name) }}</p>
                                        </div>
                                        <span class="collapse-icon"><i class="las la-angle-down"></i></span>

                                    </button>

                                    <div class="dropdown-menu langList_dropdow py-2" style="">
                                        <ul class="langList">
                                            @foreach ($language as $item)
                                                <li class="language-list">
                                                    <a href="{{ route('lang', $item->code) }}" >
                                                        <div class="language_flag">
                                                            <img src="{{ getImage(getFilePath('language') . '/' . @$item->image, getFileSize('language')) }}" alt="image">
                                                        </div>
                                                    </a>
                                                    <a href="{{ route('lang', $item->code) }}">
                                                        <p class="language_text @if (session('lang') == $item->code) custom--dropdown__selected @endif" >{{ __($item->name) }}</p>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>


@push('script-lib')
    <script>
        $(document).ready(function() {
            const $mainlangList = $(".langList");
            const $langBtn = $(".language-content");
            const $langListItem = $mainlangList.children();

            $langListItem.each(function() {
                const $innerItem = $(this);
                const $languageText = $innerItem.find(".language_text");
                const $languageFlag = $innerItem.find(".language_flag");

                $innerItem.on("click", function(e) {
                    $langBtn.find(".language_text_select").text($languageText.text());
                    $langBtn.find(".language_flag").html($languageFlag.html());
                });
            });
        });
    </script>
@endpush
