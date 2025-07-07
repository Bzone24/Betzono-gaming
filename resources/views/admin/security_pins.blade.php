@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive--md  table-responsive">
          <table class="table table--light style--two">
            <thead>
              <tr>
                <th>@lang('Id')</th>
                <th>@lang('Username')</th>
                <th>@lang('Pin')</th>
                <th>@lang('Status')</th>
                <th>@lang('CreatedAt')</th> 
              </tr>
            </thead>
            <tbody>
              @forelse($pins as $key => $pin)
                <tr>
                  <td>{{$key+1}}</td>
                    <td>
                    @if(!empty($pin->user_id))
                      
                      {{ $pin->user?$pin->user->username:'' }}
                    @elseif(!empty($pin->admin_id))
                      {{ $pin->admin?$pin->admin->username:'' }} (ADMIN)
                  
                    @else
                    -- 
                    @endif
                  </td>
                    <td class="text-center ">   @if(!empty($pin->user_id))
                      {{ @$pin->pin }}
                    @else 
                  ******
                @endif</td>
                    <td><span class="badge badge--{{ $pin->is_active == 1?'success':'danger' }}">{{ @$pin->is_active == 1?'Active':'Expired' }}</span></td>
                    
                    <td>{{ showDateTime($pin->created_at) }}</td>
                </tr>
              @empty
                <tr>
                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                </tr>
              @endforelse
            </tbody>
          </table><!-- table end -->
        </div>
      </div>
    </div>
  </div>
</div>

 



<div class="modal fade" id="bugModal" tabindex="-1" role="dialog" aria-labelledby="bugModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bugModalLabel">@lang('Report & Request')</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <i class="las la-times"></i>
        </button>
      </div>
      <div class="messages-section">
        
      </div>
      <form id="generatePinForm" action="javascript:void(0)" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
        <label>@lang('Pin')</label>
        <input type="text" class="form-control" name="pin" minlength="6" maxlength="6" required placeholder="@lang('Enter Pin')">
          </div>
      
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn--primary w-100 h-45" id="submitPinBtn">@lang('Submit')</button>
        </div>
      </form>

      <form id="otpVerifyForm" action=" " method="post" style="display:none;">
        @csrf
        <div class="modal-body">
          <div class="form-group">
        <label>@lang('Enter OTP')</label>
        <input type="text" class="form-control" name="otp" maxlength="6" required placeholder="@lang('Enter OTP sent to your email')">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn--success w-100 h-45">@lang('Verify OTP')</button>
        </div>
      </form>
@push('script')
      <script>
        $(document).ready(function () {
          var $generatePinForm = $('#generatePinForm');
          var $otpVerifyForm = $('#otpVerifyForm');

          $generatePinForm.on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
              url: "{{ route('admin.generate-admin-pin-otp') }}",
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
              },
              success: function (data) {
                if (data.success) {
                  $generatePinForm.hide();
                  $otpVerifyForm.show();
                    $('.messages-section').html("<div class=\"alert alert-success\">We have triggered an OTP to your email.</div>");
                
                } else{
                      $('.messages-section').html("<div class=\"alert alert-danger\">Something went wrong.Please try after sometime.</div>");
                }
              },
              error: function () {
                alert('Something went wrong!');
              }
            });
          });

          $otpVerifyForm.on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
              url: "{{ route('admin.generate-admin-pin-otp-verify') }}",
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
              },
              success: function (data) {
                if (data.success) {
                  $('.messages-section').html("<div class=\"alert alert-success\">Pin generated successfully.</div>");
                  setTimeout(function() {
                    location.reload();
                  }, 1500);
                }  else {
                  $('.messages-section').html("<div class=\"alert alert-danger\">" + (data.message ? data.message : "Something went wrong. Please try after sometime.") + "</div>");
                }
              },
              error: function () {
                alert('Something went wrong!');
              }
            });
          });
        });
      </script>
    </div>
  </div>
</div>
@endpush
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--warning" data-bs-toggle="modal" data-bs-target="#bugModal">   <i class="las la-bug"></i> @lang('Generate Admin Pin')</button>
   
@endpush
