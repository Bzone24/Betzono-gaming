@extends('Template::layouts.frontend')
@section('content')
    @if (gs('registration'))
        <section class="pt-100 pb-100 position-relative z-index-2">
            <div class="ball-1"><img src="{{ asset($activeTemplateTrue . 'images/ball-1.png') }}" alt="image"></div>
            <div class="ball-2"><img src="{{ asset($activeTemplateTrue . 'images/ball-2.png') }}" alt="image"></div>
            <div class="ball-3"><img src="{{ asset($activeTemplateTrue . 'images/ball-3.png') }}" alt="image"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-7 col-xl-8 col-lg-10">
                        <div class="account-wrapper">
                           <?php

/* @include($activeTemplate.'partials.social_login')*/?>
                            <form class="account-form verify-gcaptcha" action="{{ route('user.register') }}"
                                  method="POST">
                                @csrf
                                <div class="account-thumb-area text-center">
                                    <h3 class="title">@lang('Welcome to') {{ gs('site_name') }}</h3>
                                </div>

                                <div class="row">
                                    @if (session()->get('reference') != null)
                                        <div class="form-group col-12">
                                            <label for="referenceBy">@lang('Reference By') <sup
                                                    class="text-danger">*</sup></label>
                                            <div class="custom--field">
                                                <input class="form--control" id="referenceBy" name="referBy" type="text"
                                                       value="{{ session()->get('reference') }}" readonly>
                                                <i class="las la-user-alt"></i>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="form-group col-sm-6">
                                        <label class="form-label">@lang('First Name')</label>
                                        <input type="text" class="form-control form--control" name="firstname"
                                               value="{{old("firstname")}}" required>
                                    </div>
                                    
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">@lang('Last Name')</label>
                                        <input type="text" class="form-control form--control" name="lastname"
                                               value="{{old("lastname")}}" required>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang('E-Mail Address')</label>
                                            <input type="email" class="form-control form--control checkUser"
                                                   name="email" value="{{ old('email') }}"
                                                   required>
                                        </div>
                                    </div>
                                  @php  $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
                                  @endphp

   <div class="form-group col-lg-6">
                                        <label for="country">@lang('Country')</label>
                                        <div class="custom--field">
                                            <select class="form--control select2" id="country" name="country" required>
                                                @foreach ($countries as $key => $country)
                                                    <option
                                                        data-mobile_code="{{ $country->dial_code }}"
                                                        data-code="{{ $key }}"
                                                        value="{{ $country->country }}" >
                                                        {{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile')</label>
                                            <div class="input-group ">
                                            <span class="input-group-text mobile-code">

                                            </span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" 
                                                       class="form-control form--control checkUser"
                                                       required>
                                            </div>
                                            <small class="text--danger mobileExist"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Password')</label>
                                            <input type="password"
                                                   class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                                   name="password" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Confirm Password')</label>
                                            <input type="password" class="form-control form--control"
                                                   name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <x-captcha/>

                                    @if (gs('agree'))
                                        @php
                                            $policyPages = getContent('policy_pages.element', false, null, true);
                                        @endphp

                                        <div class="form-group">
                                            <input type="checkbox" id="agree" @checked(old('agree')) name="agree"
                                                   required>
                                            <label for="agree">@lang('I agree with')</label> <span>
                                            @foreach ($policyPages as $policy)
                                                    <a href="{{ route('policy.pages', $policy->slug) }}"
                                                       target="_blank">{{ __($policy->data_values->title) }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                        </span>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <button class="btn btn--base w-100 mt-3 registerUserBtn" id="recaptcha"
                                                type="submit">@lang('Register')</button>

                                        <p class="mt-3 text-center"><span
                                                class="text-white">@lang('Have an account') ?</span> <a
                                                class="text--base" href="{{ route('user.login') }}">@lang('Login')</a>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle"
             aria-hidden="true" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                        <span class="close text-center" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn--danger text-white" data-bs-dismiss="modal"
                                type="button">@lang('Close')</button>
                        <a class="btn btn-sm btn--base" href="{{ route('user.login') }}">@lang('Login')</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('Template::partials.registration_disabled')
    @endif
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
@push('style')
    <style>
        .social-login-btn {
            border: 1px solid #cbc4c4;
        }

        .register-disable {
            height: 100vh;
            width: 100%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-disable-image {
            max-width: 300px;
            width: 100%;
            margin: 0 auto 32px;
        }

        .register-disable-title {
            color: #fff;
            font-size: 42px;
            margin-bottom: 18px;
            text-align: center
        }

        .register-disable-desc {
            color: #fff;
            font-size: 18px;
            max-width: 565px;
            width: 100%;
            margin: 0 auto 32px;
            text-align: center;
        }
    </style>
@endpush
@push('script')
    <script>
        "use strict";
        (function ($) {

            $('.checkUser').on('focusout', function (e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                var data = {
                    email: value,
                    _token: token
                }

                $.post(url, data, function (response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
 
    <script>
        "use strict";
        (function ($) {
 

            $('select[name=country]').on('change', function () {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));


            $('.checkUser').on('focusout', function (e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function (response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                        $(".registerUserBtn").prop("disabled",true);
                    } else {
                        $(`.${response.type}Exist`).text('');
                        $(".registerUserBtn").prop("disabled",false);
                    }
                });
            }
        })(jQuery);
    </script>
@endpush