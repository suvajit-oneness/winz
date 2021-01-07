@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1>{{ $single_ad->title }}
                </h1>
                @if ($single_ad->is_blocked ==  false)
                    <span class="badge badge-success badge-top">Active</span>
                @else
                    <span class="badge badge-danger badge-top">Block</span>
                @endif
                <div class="form-group">
                    <a class="btn btn-secondary" href="{{ URL::previous() }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
                <span class="id-number"><strong>Ad ID:</strong> {{ $single_ad->unique_id }}  <i class="bullet-circle"></i>  <strong>Expiry Date:</strong> {{ Carbon\Carbon::parse($single_ad->package_expire_date)->format('m/d/Y') }}</span>
            </div>
        </div>
        @include('admin.partials.flash')
        <div class="user">
            <div class="col-md-12 nopadding">
                <div class="tile p-0">
                    <ul class="nav nav-tabs user-tabs">
                        <li class="nav-item nav-item-top"><a class="nav-link active" href="#details" data-toggle="tab">Details</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#gallery" data-toggle="tab">Gallery</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#messages" data-toggle="tab">Messages</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#reports" data-toggle="tab">Reports</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-md-body">
        <div class="alert alert-success" id="success-msg" style="display: none;">
            <span id="success-text"></span>
        </div>
        <div class="alert alert-danger" id="error-msg" style="display: none;">
            <span id="error-text"></span>
        </div>
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="details">
                    @include('admin.ads.includes.details')
                </div>
                <div class="tab-pane fade" id="gallery">
                    @include('admin.ads.includes.gallery')
                </div>
                <div class="tab-pane fade" id="messages">
                    @include('admin.ads.includes.messages')
                </div>
                <div class="tab-pane fade" id="reports">
                    @include('admin.ads.includes.reports')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
          var ad_id = $(this).data('ad_id');
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var check_block_status = 0;
          if($(this).is(":checked")){
              check_block_status = 1;
          }else{
            check_block_status = 0;
          }
          $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.ads.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, ad_id:ad_id, is_blocked:check_block_status},
                success:function(response)
                {
                  $('#success-text').text(response.message);
                  $('#success-msg').show();
                  $('#success-msg').fadeOut(2000);
                },
                error: function()
                {
                    $('#error-text').text("Error! Please try again later");
                    $('#error-msg').show();
                    $('#error-msg').fadeOut(2000);
                }
              });
        });
    </script>
@endpush