@extends($activeTemplate.'layouts.master')

@section('content')
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-deposit custom__bg">
                        <div class="card-body  ">
                            <form action="{{ route('user.deposit.manual.update') }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-primary">
                                            <p class="mb-0"><i
                                                    class="las la-info-circle"></i> @lang('You are requesting')
                                                <b>{{ showAmount($data['amount'])  }}</b> @lang('to deposit.') @lang('Please pay')
                                                <b>{{showAmount($data['final_amount'],currencyFormat:false) .' '.$data['method_currency'] }} </b> @lang('for successful payment.')
                                            </p>
                                        </div>
                                        <div class="gateway-desc mb-3">@php echo  $data->gateway->description @endphp</div>
                                    </div>

                                    <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}"/>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('style')
    <style>
        .gateway-desc{
            color: #4141b1;
        }
    </style>
@endpush
