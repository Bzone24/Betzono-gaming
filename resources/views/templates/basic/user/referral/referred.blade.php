@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="pt-100 pb-100">
        <div class="container">
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
                                    <th scope="col">@lang('Email')</th>
                                    <th scope="col">@lang('Phone')</th>
                                    <th scope="col">@lang('Balance')</th>
                                    <th scope="col">@lang('Joined At')</th>
                                    @if(isUserAgent(auth()->user()->id))
                                        <th class="text-center" scope="col">@lang('Manage Funds')</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($referrals as $referral)
                                <tr>
                                    <td> {{ $referrals->firstItem()+ $loop->index }}
                                    </td>
                                    <td>{{ __($referral->fullname) }}</td>
                                    <td>{{ __($referral->email) }} </td>
                                    <td>+{{ __($referral->dial_code) }}{{ __($referral->mobile) }}
                                    </td>
                                    <td>{{ gs('cur_sym') }}{{ getAmount(@$referral->balance) }}</td>
                                    <td>{{ showDateTime($referral->created_at) }}</td>
                                    @if(isUserAgent(auth()->user()->id))
                                        <th class="text-center">
                                            <a href="{{ route('user.withdraw.transfer.user',[ 'add',  base64_encode($referral->id)])}}" class="btn btn--base btn-sm">Add</a>
                                            <a href="{{ route('user.withdraw.transfer.user', ['withdraw', base64_encode($referral->id)])}}" class="btn btn--base btn-sm">Withdraw</a>
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
    </script>
@endpush
