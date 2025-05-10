@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <section class="  position-relative z-index-2">
     
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="account-wrapper" style="padding:10px!important">
                        <div class="account-form">
                        @if(!empty($gameUrl))
                            <iframe src="{{ $gameUrl }}" width="100%" height="700" frameborder="0" allowfullscreen></iframe>
                        @else
                            <div class="text-center">
                                <h4 class="text-danger">@lang('Something went wrong.Please try again.')</h4>
                                <a href="{{ url()->current() }}" class="btn btn-primary mt-3">@lang('Try Again')</a>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
 