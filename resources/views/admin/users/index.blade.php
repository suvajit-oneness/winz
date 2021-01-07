@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary pull-right">Add New</a>
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
                                <th> Name</th>
                                <th> Email</th>
                                <th> Phone</th>
                                <th> Membership Plan</th>
                                <th> Gender</th>
                                <th> Status</th>
                                <th class=""> Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        // $('#sampleTable').DataTable({"ordering": false});
        $(function () {
            $('#sampleTable').DataTable({
                lengthMenu: [ 10, 25, 50, 75, 100 ],
                pageLength: 10,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.index') }}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            if(full.mobile.length > 0){
                                return full.mobile;
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            if(full.membership){
                                return full.membership.title;
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {data: 'gender', name: 'gender',
                        render: function( data, type, full, meta ) {
                            if(data == 1){
                                return 'Male';
                            }else if(data == 2){
                                return 'Female';
                            }else{return 'Not Specified';}
                        }
                    },
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            var returnData = '<div class="toggle-button-cover margin-auto"><div class="button-cover"><div class="button-togglr b2" id="button-11"><input id="toggle-block" type="checkbox" name="is_active" class="checkbox" data-user_id="'+data+'"';
                            if(full.is_active == 1){
                                returnData += 'checked';
                            }
                            returnData += '><div class="knobs"><span>Inactive</span></div><div class="layer"></div></div></div></div>';
                            return returnData;
                        }
                    },
                    {data: 'id', name: 'id',orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            var URL = "{{url('admin/users')}}/"+data+'/edit';
                            return '<a href="'+URL+'" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a><div class="btn-group" role="group" aria-label="Second group"><a href="javascript:void(0)" data-id="'+data+'" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div>';
                        }
                    },
                ],
            });

            $(document).on('click','.sa-remove',function(){
                var userid = $(this).data('id');
                swal({
                  title: "Are you sure?",
                  text: "Your will not be able to recover the record!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Yes, delete it!",
                  closeOnConfirm: false
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "users/"+userid+"/delete";
                    } else {
                      swal("Cancelled", "Record is safe", "error");
                    }
                });
            });

            $(document).on('change','input[id="toggle-block"]',function(){
                var user_id = $(this).data('user_id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var is_active = 0;
                if($(this).is(":checked")){
                    is_active = 1;
                }else{
                    is_active = 0;
                }
                $.ajax({
                    type:'POST',
                    dataType:'JSON',
                    url:"{{route('admin.users.updateStatus')}}",
                    data:{ _token: CSRF_TOKEN, id:user_id, is_active:is_active},
                    success:function(response)
                    {
                      swal("Success!", response.message, "success");
                    },
                    error: function(response)
                    {
                        
                      swal("Error!", response.message, "error");
                    }
                });
            });
        });
    </script>
@endpush