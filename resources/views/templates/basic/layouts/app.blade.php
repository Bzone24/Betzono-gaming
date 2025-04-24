<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> {{ gs()->siteName(__(@$customTitle ? $customTitle : $pageTitle)) }}</title>

    @include('partials.seo')

    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet"/>

    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/main.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/bootstrap-fileinput.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">

    @stack('style-lib')

    @stack('style')

    <link href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}" rel="stylesheet">
</head>
@php echo loadExtension('google-analytics') @endphp
<body>
    @stack('fbComment')
<!-- preloader -->
<div class="preloader">
    <div class="preloader-container">
        <span class="animated-preloader"></span>
    </div>
</div>


@yield('panel')
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/jquery.countdown.js') }}"></script>
<script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>

@stack('script-lib')

@php echo loadExtension('tawk-chat') @endphp

@include('partials.notify')

@if (gs('pn'))
    @include('partials.push_script')
@endif
@stack('script')


<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function () {
            window.location.href = "{{ route('home') }}/change/" + $(this).val();
        });

        $('.policy').on('click', function () {
            $.get('{{ route('cookie.accept') }}', function (response) {
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function () {
            $('.cookies-card').removeClass('hide')
        }, 2000);


        let disableSubmission = false;
        $('.disableSubmission').on('submit', function (e) {
            if (disableSubmission) {
                e.preventDefault()
            } else {
                disableSubmission = true;
            }
        });

    })(jQuery);
</script>

</body>

</html>
