@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Title </th>
                                <th> Post Date </th>
                                <th> Image </th>
                                <th> Content</th>
                                <th> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
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
                ajax: "{{ route('admin.blog.index') }}",
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'post_date', name: 'post_date'},
                    {data: 'image', name: 'image',
                        render: function( data, type, full, meta ) {
                            if(data.length > 0){
                                return '<img style="width: 150px;height: 100px;" src="{{URL::to('/').'/blogs'}}/'+data+'">';
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {data: 'content', name: 'content'},
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            var returnData = '<div class="toggle-button-cover margin-auto"><div class="button-cover"><div class="button-togglr b2" id="button-11"><input id="toggle-block" type="checkbox" name="status" class="checkbox" data-blog_id="'+data+'"';
                            if(full.is_active == 1){
                                returnData += 'checked';    
                            }
                            returnData += '><div class="knobs"><span>Inactive</span></div><div class="layer"></div></div></div></div>';
                            return returnData;
                        }
                    },
                    {data: 'id', name: 'id',orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            var URL = "{{url('admin/blog')}}/"+data+'/edit';
                            return '<div class="btn-group" role="group" aria-label="Second group"><a href="'+URL+'" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-id="'+data+'" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div>';
                        }
                    },
                ],
            });

            $(document).on('click','.sa-remove',function(){
                var blogid = $(this).data('id');
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
                        window.location.href = "blog/"+blogid+"/delete";
                    } else {
                        swal("Cancelled", "Record is safe", "error");
                    }
                });
            });

            $(document).on('change','input[id="toggle-block"]',function(){
                var blog_id = $(this).data('blog_id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');var is_active = 0;
                if($(this).is(":checked")){
                    is_active = 1;
                }else{
                    is_active = 0;
                }
                $.ajax({
                    type:'POST',
                    dataType:'JSON',
                    url:"{{route('admin.blog.updateStatus')}}",
                    data:{ _token: CSRF_TOKEN, id:blog_id, is_active:is_active},
                    success:function(response){
                        swal("Success!", response.message, "success");
                    },error: function(response){
                        swal("Error!", response.message, "error");
                    }
                });
            });
        });
    </script>
    {{-- New Add --}}
    
    <script type="text/javascript">
    
    </script>
    <script type="text/javascript">
        
    </script>
@endpush