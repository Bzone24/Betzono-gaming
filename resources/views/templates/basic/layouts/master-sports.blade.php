@extends('Template::layouts.app')
@section('panel')
 
 
    @if(auth()->user())
        @include('Template::partials.auth_header')
        @php 
        $user = auth()->user();
        @endphp


    @else
        @include('Template::partials.header')
    @endif

    <div class="main-wrapper" style="max-width: 100%!important;">
    

        @yield('content')

    </div>

  
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
