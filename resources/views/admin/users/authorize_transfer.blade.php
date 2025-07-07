@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">

            <div class="card mt-30">
                <div class="card-header">
                   <h5 class="mb-4">@lang('Transfer Request Information')</h5>
                            <ul class="list-group mb-4">
                                <li class="list-group-item">
                                    <strong>@lang('User Name'):</strong> {{ __($userToManage->fullname) }}
                                </li>
                                <li class="list-group-item">
                                    <strong>@lang('User Email'):</strong> {{ __($userToManage->email) }}
                                </li>
                                <li class="list-group-item">
                                    <strong>@lang('Amount'):</strong> {{ gs('cur_sym') }}{{ old('amount', $amount ?? '') }}
                                </li>
                                <li class="list-group-item">
                                    <strong>@lang('Type'):</strong>
                                    @if($type === "add")
                                        @lang('Add Funds')
                                    @else
                                        @lang('Withdraw Funds')
                                    @endif
                                </li>
                            </ul>
                </div>
                <div class="card-body">
                     <form id="otpForm" action="" method="post" class="otp-form">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userToManage->id }}">
                                <input type="hidden" name="type" value="{{ $type }}">
                                <input type="hidden" name="amount" value="{{ old('amount', $amount ?? '') }}">

                                <div class="mb-3">
                                    <label for="otp" class="form-label">@lang('Enter OTP')</label>
                                    <input type="text" class="form-control" id="otp" name="otp" placeholder="@lang('Enter the OTP sent to your email')" required autocomplete="off" minlength="6" maxlength="6" >
                                </div>
                                <button type="submit" class="btn btn--base w-100">
                                    @lang('Authorize Request')
                                </button>
                            </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>
    (function($){
    "use strict"

        let mobileElement = $('.mobile-code');
        $('select[name=country]').on('change', function(){
            mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
        });

    })(jQuery);

    $(document).ready(function(){
        $('select[name=country]').trigger('change');
    })
        
</script>
@endpush
