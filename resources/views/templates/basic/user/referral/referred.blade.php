@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-100 pb-100">
        <div class="container">


<div class="row justify-content-center mb-4">
    <div class="col-md-12">
        <div id="jsonResponseMessages"></div>
    </div>
</div>


        @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT)
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card custom__bg">
                    <div class="card-body">
                        <div class="col-md-12">
                         <h5 class="mb-3">  @lang('To add or withdraw funds, this PIN is mandatory.')</h5>
                        <div class="mb-3 d-flex align-items-center">
                            @if(\App\Models\SecurityPin::where('user_id', auth()->user()->id)->where('is_active', 1)->exists())
                            <input type="password" class="form--control" maxlength="6" minlength="4" style="width: 150px; letter-spacing: 10px; font-size: 1.5rem; text-align: center;" disabled value="******">
                            <a href="javascript:void(0);" id="resetYourPin" class="ms-3 btn btn-link p-0">@lang('Reset your PIN')</a>
                            @else
                              <a href="javascript:void(0);" id="resetYourPin" class="ms-3 btn btn-link p-0">@lang('Create Your PIN')</a>
                            @endif
                        </div>
                        </div>
                        <div class="row d-none" id="resetPinSection">
                            <div class="col-md-12">
                                <h5 class="mb-3">@lang('Set PIN')</h5>
                                <form action="javascript:void(0);" method="POST" id="setNewPinForm" class="d-flex align-items-end">
                                    @csrf
                                    <div class="mb-3 me-2 flex-grow-1">
                                        <label for="pin" class="form-label">@lang('Transaction PIN')</label>
                                        <input type="password" name="pin" id="pin" class="form--control" maxlength="6" minlength="6" required>
                                    </div>
                                    <button type="submit" id="setNewPinBtn" class="btn btn--base mb-3">@lang('Set PIN')</button>
                                </form>
                            </div>
                            <div class="col-md-12 d-none" id="otpVerificationSection">
                               
                                <form action="javascript:void(0);" id="verifyOtpForm" method="POST" class="d-flex align-items-end">
                                    @csrf
                                    <div class="mb-3 me-2 flex-grow-1">
                                        <label for="otp" class="form-label">@lang('Enter OTP')</label>
                                        <input type="text" name="otp" id="otp" class="form--control" maxlength="6" minlength="4" required>
                                    </div>
                                    <button type="submit" id="verifyOtpFormbtn" class="btn btn--base mb-3">@lang('Verify OTP')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('resetYourPin').addEventListener('click', function() {
                document.getElementById('resetPinSection').classList.toggle('d-none');
            });


         

        </script>
        @endif

            <div class="row justify-content-end mb-4">
                @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT)
                    <a class="btn btn--base w-auto flex-shrink-0" href="{{ route('user.agent.create_user') }}">
                        @lang('Create User')
                    </a>
                @endif
            </div>
            <div class="row justify-content-center mt-4">
                
                <div class="card custom__bg">
                    <div class="card-body">
                        @if (auth()->user()->referrer)
                            <h4 class="mb-2">@lang('You are referred by') {{ auth()->user()->referrer->fullname }}</h4>
                        @endif
                        @php $referredByRole = \App\Models\User::with('referrer')->find(auth()->user()->id)->referrer->user_type??''; 
                        @endphp
                         @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT || $referredByRole !='AGENT' )
                            <div class="col-md-12 mb-4">
                                <label>@lang('Referral Link')</label>
                                <div class="input-group">
                                    <input class="form--control referralURL" name="text" type="text" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly>
                                    <span class="input-group-text copytext copyBoard" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                                </div>
                            </div>
                        @endif

               
                       <div class="table-responsive--md">
                        <table class="custom--table table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('S.N.')</th>
                                    <th scope="col">@lang('Fullname')</th>
                                    <th scope="col">@lang('username')</th>
                                    <th scope="col">@lang('Email')</th>
                                    @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT)
                                    <th scope="col">@lang('Phone')</th>
                                    <th scope="col">@lang('Balance')</th>
                                    @endif
                                    <th scope="col">@lang('Joined At')</th>
                                    @if(isUserAgent(auth()->user()->id))
                                        <th class="text-center" scope="col">@lang('Manage Funds')</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                          $pinSet = 0;
                          if(\App\Models\SecurityPin::where('user_id', auth()->user()->id)->where('is_active', 1)->exists()){
                            $pinSet = 1;
                          }
                          ?>

                                @forelse($referrals as $referral)
                                <tr>
                                    <td> {{ $referrals->firstItem()+ $loop->index }}
                                    </td>
                                    <td>{{ __($referral->fullname) }}</td>
                                    <td>{{ __($referral->username) }}</td>
                                    <td>{{ __($referral->email) }} </td>
                                    @if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT)
                                    <td>+{{ __($referral->dial_code) }}{{ __($referral->mobile) }}
                                    </td>
                                    <td>{{ gs('cur_sym') }}{{ getAmount(@$referral->balance) }}</td>
                                    @endif
                                    <td>{{ showDateTime($referral->created_at) }}</td>
                                    @if(isUserAgent(auth()->user()->id))
                                        <th class="text-center">
                                           @if($pinSet)
                                            <a href="{{ route('user.withdraw.transfer.user',[ 'add',  base64_encode($referral->id)])}}" class="btn btn--base btn-sm">Add</a>
                                            <a href="{{ route('user.withdraw.transfer.user', ['withdraw', base64_encode($referral->id)])}}" class="btn btn--base btn-sm">Withdraw</a>
                                           @else
                                            <label class="text-danger">PIN not set</label>
                                            
                                           @endif
                                            <br/>  <br/>
                                            @if($referral->status == 1)
                                            <a href="{{ url('user/change-referal-status/'.$referral->id.'/block')}}" class="btn btn--base btn-sm">Block User</a>
                                            @else
                                            <a href="{{ url('user/change-referal-status/'.$referral->id.'/active')}}" class="btn btn--base btn-sm">Activate User</a>
                                            @endif
                                        </th>
                                    @endif
                                </tr>
                                @empty
                                    <tr>
                                        <td class="rounded-bottom text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    </div>
                    @if ($referrals->hasPages())
                        <div class="card-footer">
                            {{ $referrals->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-lib')
    <link type="text/css" href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>
    <script>
        (function($) {
            "use strict"
            $('.treeview').treeView();
            $('.copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);


           $('#setNewPinBtn').on('click', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var $form = $('#setNewPinForm');
                $btn.prop('disabled', true).text('Processing...');
                $.ajax({
                    url: '{{ route("user.reset.pin") }}',
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        if (response.status === 403) {
                            $('#jsonResponseMessages').html('<div class="alert alert-danger">' + (response.message || 'You are not permitted to access this') + '</div>');
                            return;
                        }
                        if (response.message) {
                            $('#otpVerificationSection').removeClass('d-none');
                            $form.addClass('d-none');
                            $('#jsonResponseMessages').html('<div class="alert alert-success">' + response.message + '</div>');
                        } else {
                            $('#jsonResponseMessages').html('<div class="alert alert-danger">Something went wrong.</div>'); 
                        }
                    },
                    error: function(xhr) {
                        $('#jsonResponseMessages').html('<div class="alert alert-danger">' + (xhr.responseJSON?.message || 'An error occurred.') + '</div>'); 
                    },
                    complete: function() {

                        $btn.prop('disabled', false).text('@lang("Set PIN")');
                    }
                });
            });

            $('#verifyOtpFormbtn').on('click', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var $form = $('#verifyOtpForm');
                $btn.prop('disabled', true).text('Processing...');
                $.ajax({
                    url: '{{ route("user.verifypin.otp") }}',
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        console.log(response);
                        if (response.success === true) { 
                            $('#jsonResponseMessages').html('<div class="alert alert-success">' + (response.message || 'PIN has been reset successfully.') + '</div>');
                            $('#otpVerificationSection').addClass('d-none');
                            location.reload(); 
                        } else {
                           
                            $('#jsonResponseMessages').html('<div class="alert alert-danger">' + (response.message || 'Invalid OTP or something went wrong.') + '</div>'); 
                        }
                    },
                    error: function(xhr) {
                        $('#jsonResponseMessages').html('<div class="alert alert-danger">' + (xhr.responseJSON?.message || 'An error occurred.') + '</div>');
                        
                    },
                    complete: function() {

                        $btn.prop('disabled', false).text('@lang("Verify OTP")');
                    }
                });
            });
    </script>
@endpush
