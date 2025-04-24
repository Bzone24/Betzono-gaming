@extends('Template::layouts.app')
@section('panel')
    <div class="scroll-to-top">
        <span class="scroll-icon">
            <i class="fa fa-rocket" aria-hidden="true"></i>
        </span>
    </div>
 
    @if(auth()->user())
        @include('Template::partials.auth_header')
        @php 
        $user = auth()->user();
        @endphp
     <div class="mobile_view_only" style="text-align: right;margin: 10px;overflow:auto">

        <label class="btn btn-light btn-sm" style="float:left;color: black;font-weight: 600;">
            <span style="float:left;color: red;font-weight: 200;"> Main Balance</span>
            <br/>{{ gs('cur_sym') }}{{ number_format(getAmount(@$user->balance), 2, '.', ',') }}</label>
         <a class="btn btn-warning btn-sm" href="{{ route('user.deposit.index') }}" style="margin-top:10px">@lang('Deposit Now')</a>
         <a class="btn btn-danger btn-sm" href="{{ route('user.withdraw') }}" style="margin-top:10px">@lang('Withdraw')</a>
         
        </div>

    @else
        @include('Template::partials.header')
    @endif

    <div class="main-wrapper">
        @if (!request()->routeIs('home'))
   
            @include('Template::partials.breadcrumb')
        @endif

        @yield('content')

    </div>

    @include('Template::partials.footer')
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            function formatState(state) {
                if (!state.id) return state.text;
                let gatewayData = $(state.element).data();
                return $(
                    `<div class="d-flex gap-2">${gatewayData.imageSrc ? `<div class="select2-image-wrapper"><img class="select2-image" src="${gatewayData.imageSrc}"></div>` : '' }<div class="select2-content"> <p class="select2-title">${gatewayData.title}</p><p class="select2-subtitle">${gatewayData.subtitle}</p></div></div>`
                    );
            }

            $('.select2').each(function(index, element) {
                $(element).select2({
                    templateResult: formatState,
                    minimumResultsForSearch: "-1"
                });
            });

            $('.select2-searchable').each(function(index, element) {
                $(element).select2({
                    templateResult: formatState,
                    minimumResultsForSearch: "1"
                });
            });


            $('.select2-basic').each(function(index, element) {
                $(element).select2({
                    dropdownParent: $(element).closest('.select2-parent')
                });
            });

        })(jQuery)
    </script>
@endpush
