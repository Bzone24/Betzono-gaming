@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('ID')</th>
                                <th>@lang('Game')</th>
                                <th>@lang('Status')</th>  
                                <th>@lang('Action')</th>  
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gameList as $game)
                            <tr>
                           
                                <td>
                                    <span class="fw-bold" title="{{ @$game->id }}">{{ $game->id }}</span>
                                </td>



                                <td>
                                    <span class="fw-bold" title="{{ @$game->name }}">{{ $game->name }}</span>
                                </td>
 
                                <td>
                                    <span class="fw-bold" title="{{ @$game->status }}">{{ $game->status == Status::ACTIVE ?'Active':'Inactive'}}</span>
                                </td>
 
                                <td> 
                                @if ($game->status == Status::ACTIVE)
                                 
                                     <button class="btn btn-sm btn-outline--danger confirmationBtn" data-id="{{ $game->id }}" data-status="{{ $game->status }}">
                                                    <i class="la la-eye-slash"></i> @lang('Inactive')
                                        </button>
                                                @else
                                <button class="btn btn-sm btn-outline--success confirmationBtn" data-id="{{ $game->id }}" data-status="{{ $game->status }}">
                                                    <i class="la la-eye"></i> @lang('Active')
                                                    </button>
                                @endif
                                
                                @if($game->slug == 'number_prediction')
                                <a target ="_blank"href="{{url($game->slug.'/admin/autologin.php')}}" class="btn btn-danger">Admin Login</a>
                                @elseif($game->slug == 'aviator')
                                <a target ="_blank"href="{{url($game->slug.'/admin-autologin')}}" class="btn btn-danger">Admin Login</a>
                                     @elseif($game->slug == 'color_prediction')
                                <a target ="_blank"href="https://cp.stakeye.com/admin-autologin" class="btn btn-danger">Admin Login</a>
                                
                                @endif
                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
              
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

@endsection
 

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.confirmationBtn').on('click', function() {
                var status = $(this).data('status');
                var id = $(this).data('id');
                var modal = $('#confirmationModal');
                var text = status ? `@lang('Are you sure to inactive this game?')` : `@lang('Are you sure to active this game?')`;
                var url = `{{ route('admin.games.status', '') }}/${id}`;
                modal.find('.modal-body').text(text);
                modal.find('form').attr('action', url);
                modal.modal('show')
            });

        })(jQuery);
    </script>
@endpush