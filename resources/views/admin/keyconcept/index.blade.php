@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
            <a href="{{ route('admin.keyconcept.create') }}" class="btn btn-primary pull-right"><i class="fa fa-fw fa-lg fa-plus"></i>Add New</a>
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
                                <!-- <th>Sl No</th> -->
                                <th>Board Name</th>
                                <th>Subject Name</th>
                                <th>Class Name</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Video Link</th>
                                <th> Status </th>
                                <th> Action </th>
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
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        // $('#sampleTable').DataTable({"ordering": false});
        $(function () {
            $('#sampleTable').DataTable({
                lengthMenu: [ 10, 25, 50, 75, 100 ],
                pageLength: 10,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.keyconcept.index') }}",
                columns: [
                    {data: 'board.name', name: 'board.name'},
                    {data: 'subject.name', name: 'subject.name'},
                    {data: 'class.name', name: 'class.name'},
                    {data: 'title', name: 'title'},
                    {data: 'id', name: 'id',orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            if(full.image.length > 0){
                                var imageData = '<img style="width: 150px;height: 100px; display: block !important;" src="{{ asset('keyconcept/')}}/'+full.image+'">';
                                return imageData;    
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {data: 'video_link', name: 'video_link',
                        render: function( data, type, full, meta ) {
                            if(data.length > 0){
                                return '<a href="'+data+'" target="_blank">'+data+'</a>';
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            var returnData = '<div class="toggle-button-cover margin-auto"><div class="button-cover"><div class="button-togglr b2" id="button-11"><input id="toggle-block" type="checkbox" name="status" class="checkbox" data-language_id="'+data+'"';
                            if(full.is_active == 1){
                                returnData += 'checked';    
                            }
                            returnData += '><div class="knobs"><span>Inactive</span></div><div class="layer"></div></div></div></div>';
                            return returnData;
                        }
                    },
                    {data: 'id', name: 'id',orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            var URL = "{{url('admin/keyconcept')}}/"+data+'/edit';
                            return '<div class="btn-group" role="group" aria-label="Second group"><a href="'+URL+'" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-id="'+data+'" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div>';
                        }
                    },
                ],
            });

            $(document).on('click','.sa-remove',function(){
                var languageId = $(this).data('id');
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
                    window.location.href = "keyconcept/"+languageId+"/delete";
                    } else {
                      swal("Cancelled", "Record is safe", "error");
                    }
                });
            });

            $(document).on('change','input[id="toggle-block"]',function(){
                var language_id = $(this).data('language_id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var check_status = 0;
                if($(this).is(":checked")){
                    check_status = 1;
                }else{
                    check_status = 0;
                }
                $.ajax({
                    type:'POST',
                    dataType:'JSON',
                    url:"{{route('admin.keyconcept.updateStatus')}}",
                    data:{ _token: CSRF_TOKEN, id:language_id, check_status:check_status},
                    success:function(response){
                        swal("Success!", response.message, "success");
                    },
                    error: function(response){
                        swal("Error!", response.message, "error");
                    }
                });
            });
        });
    </script>
    
    <script type="text/javascript">
    
    </script>
    <script type="text/javascript">
        
    </script>
@endpush