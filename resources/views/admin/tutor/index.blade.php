@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.tutor.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Board Name</th>
                            <th>Subject Name</th>
                            <th>Topic Name</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
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
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        // $('#sampleTable').DataTable({"ordering": false});
        $(function () {
            $('#sampleTable').DataTable({
                lengthMenu: [ 5,10, 25, 50, 75, 100 ],
                pageLength: 5,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.tutor.index') }}",
                columns: [
                    {data: 'id', name: 'tutors.id'},
                    {data: 'board.name', name: 'board.name'},
                    {data: 'subject.name', name: 'subject.name'},
                    {data: 'topic.name', name: 'topic.name'},
                    {data: 'name', name: 'name'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'email', name: 'email'},
                    {data: 'id', name: 'tutors.id',orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            var returndata = '<div class="toggle-button-cover margin-auto"><div class="button-cover"><div class="button-togglr b2" id="button-11"><input id="toggle-block" type="checkbox" name="is_active" class="checkbox" data-category_id="'+data+'"';
                            if(full.is_active == true){
                                returndata += 'checked';
                            }
                            returndata += '><div class="knobs"><span>Inactive</span></div><div class="layer"></div></div></div></div>';
                            return returndata;
                        }
                    },
                    {data: 'id', name: 'tutors.id',orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            var URL = "{{url('admin/tutor')}}/"+data+'/edit';
                            return '<div class="btn-group" role="group" aria-label="Second group"><a href="'+URL+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-id="'+data+'" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div>';
                        }
                    },
                ],
            });

            $(document).on('click','.sa-remove',function(){
                var categoryId = $(this).data('id');
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
                    window.location.href = "tutor/"+categoryId+"/delete";
                    } else {
                      swal("Cancelled", "Record is safe", "error");
                    }
                });
            });

            $(document).on('change','input[id="toggle-block"]',function(){
                var category_id = $(this).data('category_id');
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
                    url:"{{route('admin.tutor.updateStatus')}}",
                    data:{ _token: CSRF_TOKEN, id:category_id, is_active:is_active},
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
@endpush