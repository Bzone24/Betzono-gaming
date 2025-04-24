@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Lottery Name')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Total Phase')</th>
                                    <th>@lang('Total Draw')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lotteries as $key => $lottery)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            <div class="customer-details d-block">
                                                <a class="thumb" href="javascript:void(0)">
                                                    <img src="{{ getImage(getFilePath('lottery') . '/' . @$lottery->image, getFileSize('lottery')) }}" alt="image">
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ __($lottery->name) }}</td>
                                        <td>{{ showAmount($lottery->price) }}</td>
                                        <td>{{ $lottery->phase->count() }}</td>
                                        <td>{{ $lottery->phase->where('draw_status', Status::COMPLETE)->count() }}</td>
                                        <td> @php echo $lottery->statusBadge @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary editBtn" href="{{ route('admin.lottery.edit', $lottery->id) }}">
                                                    <i class="la la-pen"></i> @lang('Edit')
                                                </a>
                                                @if ($lottery->status == Status::ACTIVE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-id="{{ $lottery->id }}" data-status="{{ $lottery->status }}">
                                                        <i class="la la-eye-slash"></i> @lang('Inactive')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn" data-id="{{ $lottery->id }}" data-status="{{ $lottery->status }}">
                                                        <i class="la la-eye"></i> @lang('Active')
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-outline--info dropdown-toggle" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                                    <i class="la la-ellipsis-v"></i>@lang('More')
                                                </button>

                                                <div class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item editBtn text--info" href="{{ route('admin.lottery.win.bonus', $lottery->id) }}">
                                                            <i class="las la-trophy"></i> @lang('Set Win Bonus')
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item editBtn text--warning" href="{{ route('admin.lottery.phase.single.lottery', $lottery->id) }}">
                                                            <i class="fas fa-layer-group"></i> @lang('Ticket phases')
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($lotteries->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($lotteries) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmationModal" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">@lang('Confirmation Alert!')</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--dark" data-bs-dismiss="modal" type="button">@lang('No')</button>
                        <button class="btn btn--primary" type="submit">@lang('Yes')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endSection
@push('breadcrumb-plugins')
    <x-search-form placeholder='Search lottery' />
    <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.lottery.create') }}"><i class="la la-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.confirmationBtn').on('click', function() {
                var status = $(this).data('status');
                var id = $(this).data('id');
                var modal = $('#confirmationModal');
                var text = status ? `@lang('Are you sure to inactive this lottery?')` : `@lang('Are you sure to active this lottery?')`;
                var url = `{{ route('admin.lottery.status', '') }}/${id}`;
                modal.find('.modal-body').text(text);
                modal.find('form').attr('action', url);
                modal.modal('show')
            });

        })(jQuery);
    </script>
@endpush
