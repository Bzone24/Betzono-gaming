@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>#</h4>
                    <a href="{{ route('admin.frontend.banner.create') }}" class="btn btn--dark">
                        <i class="fas fa-plus"></i> Add Banner
                    </a>
                </div>
                <div class="card-body p-0">

                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('ID')</th>
                                <th>@lang('Image')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Link')</th>
                                <th>@lang('Players')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Order')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tbody id="sortable">
                                @foreach($sliders as $slider)
                                <tr data-id="{{ $slider->id }}">
                                    <td>{{ $slider->id }}</td>
                                    <td>
                                        <div class="customer-details d-block">
                                            <a class="thumb" href="javascript:void(0)">
                                                <img src="{{ getImage(getFilePath('lottery') . '/' . @$slider->image_path, getFileSize('lottery')) }}" alt="image">
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $categories[$slider->category] ?? $slider->category }}</td>
                                    <td>
                                        <a href="{{ $slider->link_url }}" target="_blank">View Link</a>
                                    </td>
                                    <td>{{ $slider->players_count }}</td>
                                    <td>
                                        <span class="badge badge--{{ $slider->is_active ? 'success' : 'danger' }}">
                                            {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $slider->sort_order }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{route('admin.frontend.banner.edit',$slider->id)}}" class="btn btn-sm btn--primary mr-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{route('admin.frontend.banner.delete',$slider->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn--dark" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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