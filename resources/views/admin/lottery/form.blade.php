@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.lottery.store', @$lottery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <x-image-uploader image="{{ @$lottery->image }}" class="w-100" type="lottery" :required="true" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input class="form-control" name="name" type="text" value="{{ old('name', @$lottery->name) }}" required />
                                </div>
                                <div class="form-group">
                                    <label>@lang('Ticket Price')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{__(gs('cur_sym'))}}</span>
                                        <input class="form-control" name="price" type="number" value="{{ old('price', @$lottery->price) }}" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Instruction')</label>
                                    <textarea class="form-control nicEdit" name="instruction" rows="8">{{ old('instruction', @$lottery->instruction) }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.lottery.index') }}" />
@endpush
@push('style')
    <style>
        .list-group-item:first-child{
            border-top-left-radius:unset;
            border-top-right-radius:unset;
        }
    </style>
@endpush
