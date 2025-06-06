@php 
 $sportsLink = '';
@endphp 
 
@extends($activeTemplate . 'layouts.master-sports')

@section('content') 
<div style="text-align: right;margin-right: 20px">
    <button id="fullscreenBtn" class="btn btn-success mb-3" title="Full screen">
        <i class="fas fa-expand"></i>
    </button>
</div>

<script>
    document.getElementById('fullscreenBtn').addEventListener('click', function() {
        const framebox = document.getElementById('framebox');
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