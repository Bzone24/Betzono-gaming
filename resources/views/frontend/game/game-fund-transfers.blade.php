@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-100 pb-100">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="account-wrapper">
                        <div class="card-body">
                            <form id="withdrawForm" action="" method="post" class="withdraw-form">
                                @csrf
                                <div class="gateway-card">
                                    <div class="row justify-content-center gy-sm-4 gy-3">
                                        <div class="col-12">
                                            <h5 class="payment-card-title">Fund Transfer</h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="payment-system-list p-3">
                                            <div class="deposit-info"> Balance in game : 
                                            <?php   $userOngame = DB::connection($gameslug)->table('USERS')->where("EMAIL", auth()->user()->email)->first();?>
                                            {{ gs('cur_sym') }}{{$userOngame->WALLET??0}} 

                                          </div><hr/>
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
                                                        @if($type === "addtogame")
                                                        <p class="text has-icon"> @lang('Available Amount')</p>
                                                        @else
                                                        <p class="text has-icon"> @lang('Available Amount in game')</p>
                                                        @endif
                                                    </div>
                                                    <div class="deposit-info__input">
                                                        <p class="text">
                                                            @if($type === "addtogame")
                                                              
                                                                <span class="gateway-limit">   {{ gs('cur_sym') }}{{floatval(auth()->user()->balance)}} 
                                                                    <input type="hidden" name="balance" class="balance_amt" value="{{floatval(auth()->user()->balance)}}">
                                                                </span>
                                                            @else
                                                            <span class="gateway-limit"> {{ gs('cur_sym') }}{{$userOngame->WALLET??0}} 
                                                                    <input type="hidden" name="balance" class="balance_amt" value="{{$userOngame->WALLET??0}} ">
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
                                                        
                                                             @lang('Confirm Transfer')
                                                        
                                                </button>
                                                <div class="info-text pt-3">
                                                    <p class="text">@lang('Safely proccess your transaction')</p>
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

            if(transactionType.val()=="addtogame"){
                var confirmationMessage = `You are adding ${amount} {{ gs('cur_sym') }} into game wallet`;
            }
            else{
                var confirmationMessage = `You are transferring ${amount} {{ gs('cur_sym') }} from game wallet`;
            }
            

            if (confirm(confirmationMessage)) {
                this.submit(); // Submit the form if confirmed
            }
        });
    })(jQuery);
</script>
@endpush
