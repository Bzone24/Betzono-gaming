@extends('Template::layouts.app')
@section('panel')
    <!-- scroll-to-top -->
    <div class="scroll-to-top">
        <span class="scroll-icon">
            <i class="fa fa-rocket" aria-hidden="true"></i>
        </span>
    </div>

    @include('Template::partials.header')

    <div class="main-wrapper">
        @if (!request()->routeIs('home') && gs('maintenance_mode') == Status::DISABLE)
            @include('Template::partials.breadcrumb')
        @endif

        @yield('content')
    </div>

    @include('Template::partials.footer')

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <!-- cookies dark version start -->
        <div class="cookies-card hide text-center">
            <div class="cookies-card__icon bg--base text-dark">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="cookies-card__content mt-4">{{ $cookie->data_values->short_desc }}
                <a class="text--base" href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a>
            </p>
            <div class="cookies-card__btn mt-4">
                <a class="btn btn--base w-100 policy" href="javascript:void(0)">@lang('Allow')</a>
            </div>
        </div>
        <!-- cookies dark version end -->
    @endif
@endsection
