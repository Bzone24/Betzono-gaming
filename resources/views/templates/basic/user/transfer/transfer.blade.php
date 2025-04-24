@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-100 pb-100">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="account-wrapper">
                        <div class="card-body">
                            <form id="withdrawForm" action="{{ route('user.withdraw.transferSubmit') }}" method="post" class="withdraw-form">
                                @csrf
                                <div class="gateway-card">
                                    <div class="row justify-content-center gy-sm-4 gy-3">
                                        <div class="col-12">
                                            <h5 class="payment-card-title">{{ __($pageTitle) }}</h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="payment-system-list p-3">
                                                <div class="deposit-info">
                                                    <div class="deposit-info__title">
                                                        <p class="text mb-0">@lang('Amount')</p>
                                                    </div>
                                                    <input type="hidden" name="type" class="transactiontype" value="{{$type}}">
                                                    <div class="deposit-info__input">
                                                        <div class="deposit-info__input-group input-group amount-div">
                                                            <span class="deposit-info__input-group-text">{{ gs('cur_sym') }}</span>
                                                            <input type="text" class="form-control form--control amount"
                                                                   name="amount"
                                                                   placeholder="@lang('00.00')"
                                                                   value="{{ old('amount') }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="deposit-info">
                                                    <div class="deposit-info__title">
                                                        @if($type === "in")
                                                            <p class="text has-icon"> @lang('Available Amount on Gamezone')</p>
                                                        @else
                                                            <p class="text has-icon"> @lang('Available Amount')</p>
                                                        @endif
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text">
                                                            @if($type === "in")
                                                                <span class="gateway-limit">{{ gs('cur_sym') }}{{ getAmount(@$gameZoneBalance) }}
                                                                    <input type="hidden" name="balance" class="balance_amt" value="{{ getAmount(@$gameZoneBalance) }}">
                                                                </span>
                                                            @else
                                                                <span class="gateway-limit">{{ gs('cur_sym') }}{{ getAmount(@$user->balance) }}
                                                                    <input type="hidden" name="balance" class="balance_amt" value="{{ getAmount(@$user->balance) }}">
                                                                </span>
                                                            @endif
                                                            
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="deposit-info gateway-conversion d-none total-amount pt-2">
                                                    <div class="deposit-info__title">
                                                        <p class="text">@lang('Conversion')</p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text"></p>
                                                    </div>
                                                </div>
                                                <div class="deposit-info conversion-currency d-none total-amount pt-2">
                                                    <div class="deposit-info__title">
                                                        <p class="text">
                                                            @lang('In') <span class="gateway-currency"></span>
                                                        </p>
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text">
                                                            <span class="in-currency"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn--base w-100 submit-btn" disabled>
                                                        @if($type === "in")
                                                             @lang('Confirm Withdrawal')
                                                        @else
                                                             @lang('Confirm Transfer')
                                                        @endif
                                                   
                                                </button>
                                                <div class="info-text pt-3">
                                                    <p class="text">@lang('Safely proccess your transactions to game zone')</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    "use strict";
    (function($) {
        var amountInput = $('.amount');
        var transactionType = $('.transactiontype');
        var balance = parseFloat($('.balance_amt').val() || 0);

        // Function to check validation and toggle submit button
        function toggleSubmitButton() {
            var amount = parseFloat(amountInput.val() || 0);
            if (amount > 0 && amount <= balance) {
                $('.submit-btn').prop('disabled', false); // Enable the button
            } else {
                $('.submit-btn').prop('disabled', true); // Keep the button disabled
            }
        }

        // Initial check to toggle the submit button
        toggleSubmitButton();

        // Listen for changes on the .amount input field
        amountInput.on('input', function(e) {
            var amount = parseFloat($(this).val());

            // Clear any existing error messages
            $('.amount-error').remove();

            // If amount is invalid or zero, set it to 0
            if (!amount || isNaN(amount)) {
                amount = 0;
            }

            // If amount exceeds balance, show error message and disable submit button
            if (amount > balance) {
                $('<span class="text-danger amount-error">@lang("Amount exceeds balance")</span>')
                    .insertAfter('.amount-div');
            }

            // Toggle submit button based on validation
            toggleSubmitButton();
        });

        // Handle form submission
        $('#withdrawForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var amount = parseFloat(amountInput.val());

            if(transactionType.val()=="in"){
                var confirmationMessage = `You are withdrawing ${amount} {{ gs('cur_sym') }}`;
            }
            else{
                var confirmationMessage = `You are transferring ${amount} {{ gs('cur_sym') }}`;
            }
            

            if (confirm(confirmationMessage)) {
                this.submit(); // Submit the form if confirmed
            }
        });
    })(jQuery);
</script>
@endpush
