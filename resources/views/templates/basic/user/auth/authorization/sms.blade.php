@extends($activeTemplate .'layouts.frontend')
@section('content')
<section class="pt-100 pb-100 position-relative z-index-2">
    <div class="ball-1"><img src="{{ asset($activeTemplateTrue . 'images/ball-1.png') }}" alt="image"></div>
    <div class="ball-2"><img src="{{ asset($activeTemplateTrue . 'images/ball-2.png') }}" alt="image"></div>
    <div class="ball-3"><img src="{{ asset($activeTemplateTrue . 'images/ball-3.png') }}" alt="image"></div>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="verification-code-wrapper account-wrapper">
            <div class="verification-area">
                <form action="{{route('user.verify.mobile')}}" method="POST" class="submit-form">
                    @csrf
                    <p class="verification-text">@lang('A 6 digit verification code sent to your mobile number') :  +{{ showMobileNumber(auth()->user()->mobile) }}</p>
                    @include($activeTemplate.'partials.verification_code')
                    <div class="mb-3">
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                    </div>
                    <div class="form-group">
                        <p>
                            @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a href="{{route('user.send.verify.code', 'sms')}}" class="try-again-link d-none"> @lang('Try again')</a>
                        </p>
                        @if($errors->has('resend'))
                            <br/>
                            <small class="text-danger">{{ $errors->first('resend') }}</small>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>

@endsection

@push('script')
    <script>
        var distance =Number("{{@$user->ver_code_send_at->addMinutes(2)->timestamp-time()}}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush
