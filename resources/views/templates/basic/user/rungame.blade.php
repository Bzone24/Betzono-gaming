@php 
 $sportsLink = '';
@endphp 
 
@extends($activeTemplate . 'layouts.master-sports')

@section('content') 
@section('fullscreen-button')
 
<a class="fullscreenBtn" href="javascript:void(0) " title="Full screen" style="color: white!important;"> 
    <i class="fas fa-expand"></i> Full Screen
</a>

 
@endsection
@push('script')
<script>
    $('.fullscreenBtn').on('click', function() {
        var framebox = $('#framebox')[0];
        if (framebox.requestFullscreen) {
            framebox.requestFullscreen();
        } else if (framebox.mozRequestFullScreen) { // Firefox
            framebox.mozRequestFullScreen();
        } else if (framebox.webkitRequestFullscreen) { // Chrome, Safari, Opera
            framebox.webkitRequestFullscreen();
        } else if (framebox.msRequestFullscreen) { // IE/Edge
            framebox.msRequestFullscreen();
        }
    });
</script>
@endpush
<div id="framebox" style="padding-bottom: 100px!important;">

    <!-- dashboard section start -->
    @if(!empty($gameUrl))
    <iframe src="{{ $gameUrl }}" width="100%" height="1000px" frameborder="0" allowfullscreen></iframe>
    
    @else
    <div class="text-center">
        <h4 class="text-danger">@lang('Something went wrong.Please try again.')</h4>
        <a href="{{ url()->current() }}" class="btn btn-primary mt-3">@lang('Try Again')</a>
    </div>
    @endif
</div>
 @endsection