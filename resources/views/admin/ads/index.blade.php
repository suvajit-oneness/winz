@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Package</th>
                            <th>Created By</th>
                            <th class="text-center">Status</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($ads as $k=>$ad)
                            @php $key = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $ad->title)); @endphp
                                <tr>
                                    <td>{{ $ad->title }}</td>
                                    <td>{{ Carbon\Carbon::parse($ad->created_at)->format('m/d/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($ad->package_expire_date)->format('m/d/Y') }}</td>
                                    <td>{{ $ad->package_name }}</td>
                                    <td>{{ $ad->email }}</td>
                                    <td class="text-center">
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-10">
                                                <input id="toggle-block" type="checkbox" class="checkbox" data-ad_id="{{ $ad->id }}" {{ $ad->is_blocked == 1 ? 'checked' : '' }}>
                                                <div class="knobs">
                                                    <span>Active</span>
                                                </div>
                                                <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-center">
                                        <a href="{{ route('admin.ads.view', $ad->id) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
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
                  // $('#success-text').text(response.message);
                  // $('#success-msg').show();
                  // $('#success-msg').fadeOut(2000);
                  swal("Success!", response.message, "success");
                },
                error: function(response)
                {
                    // $('#error-text').text("Error! Please try again later");
                    // $('#error-msg').show();
                    // $('#error-msg').fadeOut(2000);
                    swal("Error!", response.message, "error");
                }
              });
        });
    </script>
@endpush