<header class="header">
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl align-items-center p-0">
                <a class="site-logo site-title" href="{{ route('home') }}"><img
                        src="{{ getImage(getFilePath('logo_icon') . '/logo.png') }}" alt="logo"></a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu me-auto">
                        <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                        <li><a href="{{ route('pages', 'about') }}">@lang('About')</a></li>
                        <li><a href="{{ route('lottery') }}">@lang('Lotteries')</a></li>

                        @if (@$pages)
                            @foreach ($pages as $k => $data)
                                <li><a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                            @endforeach
                        @endif

                        <li><a href="{{ route('blog') }}">@lang('Blog')</a></li>
                        <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                    </ul>
                    <div class="nav-right">
                        @auth
                            <a class="btn btn-sm btn--base me-sm-3 me-2 btn--capsule {{ menuActive('user.home') }} px-3" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            <a class="fs--14px me-sm-3 me-2 text-white" href="{{ route('user.logout') }}">@lang('Logout')</a>
                        @else
                            <a class="btn btn-sm btn--base me-sm-3 me-2 btn--capsule px-3" href="{{ route('user.login') }}">@lang('Login')</a>
                            <a class="fs--14px me-sm-3 me-2 text-white" href="{{ route('user.register') }}">@lang('Register')</a>
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

@push('script')
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

@push('style')
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
    </style>
@endpush
