@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-100 pb-100 position-relative z-index-2">
        <div class="ball-1"><img src="{{ asset($activeTemplateTrue . 'images/ball-3.png') }}" alt="image"></div>
        <div class="ball-2"><img src="{{ asset($activeTemplateTrue . 'images/ball-3.png') }}" alt="image"></div>
        <div class="ball-3"><img src="{{ asset($activeTemplateTrue . 'images/ball-3.png') }}" alt="image"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="account-wrapper">
                        <div class="account-form">
                            <form method="POST" action="{{ route('user.agent.create_user.submit') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('First Name')</label>
                                            <input type="text" class="form-control form--control" name="firstname" value="{{ old('firstname') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Last Name')</label>
                                            <input type="text" class="form-control form--control" name="lastname" value="{{ old('lastname') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Username')</label>
                                            <input type="text" class="form-control form--control checkUser" name="username" value="{{ old('username') }}" required>
                                            <small class="text--danger usernameExist"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Email')</label>
                                            <input type="text" class="form-control form--control checkUser" name="email" value="{{ old('email') }}" required>
                                            <small class="text--danger emailExist"></small>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="country">@lang('Country')</label>
                                        <div class="custom--field">
                                            <select class="form--control" id="country" name="country" required>
                                                @foreach ($countries as $key => $country)
                                                    <option
                                                        data-mobile_code="{{ $country->dial_code }}"
                                                        data-code="{{ $key }}"
                                                        value="{{ $country->country }}"
                                                        @selected(old('country'))>
                                                        {{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile')</label>
                                            <div class="input-group">
                                                <span class="input-group-text mobile-code"></span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" required>
                                            </div>
                                            <small class="text--danger mobileExist"></small>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6 d-none">
                                        <label class="form-label">@lang('Address')</label>
                                        <input class="form--control" name="address" type="text" value="{{ old('address') }}">
                                    </div>
                                    <div class="form-group col-sm-6  d-none">
                                        <label class="form-label">@lang('State')</label>
                                        <input class="form--control" name="state" type="text" value="{{ old('state') }}">
                                    </div>
                                    <div class="form-group col-sm-6  d-none">
                                        <label class="form-label">@lang('Zip Code')</label>
                                        <input class="form--control" name="zip" type="text" value="{{ old('zip') }}">
                                    </div>

                                    <div class="form-group col-sm-6  d-none">
                                        <label class="form-label">@lang('City')</label>
                                        <input class="form--control" name="city" type="text" value="{{ old('city') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Password')</label>
                                            <input type="password" class="form-control form--control" name="password" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Confirm Password')</label>
                                            <input type="password" class="form-control form--control" name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <!-- Verification Dropdowns -->
                                    <div class="col-md-6 d-none">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Email Verification')</label>
                                            <select class="form--control" name="ev" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('ev') == '1' ? 'selected' : '' }} selected>@lang('Verified')</option>
                                                <option value="0" {{ old('ev') == '0' ? 'selected' : '' }}>@lang('Unverified')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-none">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile Verification')</label>
                                            <select class="form--control" name="sv" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('sv') == '1' ? 'selected' : '' }} selected>@lang('Verified')</option>
                                                <option value="0" {{ old('sv') == '0' ? 'selected' : '' }}>@lang('Unverified')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-none">
                                        <div class="form-group">
                                            <label class="form-label">@lang('2FA Verification')</label>
                                            <select class="form--control" name="ts" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('ts') == '1' ? 'selected' : '' }} selected>@lang('Enabled')</option>
                                                <option value="0" {{ old('ts') == '0' ? 'selected' : '' }}>@lang('Disabled')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-none">
                                        <div class="form-group">
                                            <label class="form-label">@lang('KYC')</label>
                                            <select class="form--control" name="kv" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('kv') == '1' ? 'selected' : '' }} selected>@lang('Verified')</option>
                                                <option value="0" {{ old('kv') == '0' ? 'selected' : '' }}>@lang('Unverified')</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <button class="btn btn--base w-100" type="submit">
                                        @lang('Submit')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('style')
    <style>
        span.selection {
            display: block;
        }

        .select2-container .select2-selection--single {
            height: 50px !important;
            background: #131340 !important;
            border-color: #37f5f9 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff !important;
            line-height: 36px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 13px !important;
        }

        .select2 .dropdown-wrapper {
            display: none;
        }

        .select2-dropdown {
            background-color: #20204e !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid rgb(255 255 255 / 50%) !important;
            background: #131340 !important;
            border-radius: 4px !important;
            color: #fff;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function ($) {
            //set default country India
        setTimeout(function () {
            $('select[name=country]').val('India');
            $('select[name=country]').trigger('change');
        },300);

            @if($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('.select2').select2();

            $('select[name=country]').on('change', function () {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('.checkUser').on('focusout', function (e) {
                var value = $(this).val();
                var name = $(this).attr('name');
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
                if (name == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                $.post(url, data, function (response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
