@extends('admin.app')
@section('title') Subject Categories @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file-text"></i> Subject Categories</h1>
                <p>list of Subject Category</p>
            </div>
            <a href="{{ route('admin.subject.category.create') }}" class="btn btn-primary pull-right">Add New</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                        <tr>
                            <td width="5%">Id</td>
                            <td>Category</td>
                            <td>Title</td>
                            <td>Image</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($sub_categories as $key => $category)
                                <tr>
                                    <td width="5%">{{$key+1}}</td>
                                    <td>{{$category->category->title}}</td>
                                    <td>{{$category->title}}</td>
                                    <td><img src="{{asset($category->image)}}" height="100" width="100"></td>
                                    <th><a href="{{route('admin.subject.category.edit',$category->id)}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a><a href="javascript:void(0)" data-id="{{$category->id}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div></th>
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
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});

        $(document).on('click','.sa-remove',function(){
                var languageId = $(this).data('id');
                console.log(languageId);
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
                        window.location.href = "categories/"+languageId+"/delete";
                    } else {
                      swal("Cancelled", "Record is safe", "error");
                    }
                });
            });
    </script>
@endpush