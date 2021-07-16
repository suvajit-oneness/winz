@extends('admin.app')
@section('title') Chapters @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file-text"></i> Chapters</h1>
                <p>list of Chapter</p>
            </div>
            <a href="{{ route('admin.course.chapters.create',$courseId) }}" class="btn btn-primary pull-right">Add New</a>
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
                                <td>Course</td>
                                <td>Chapter</td>
                                <td width="5%">Price</td>
                                <td width="5%">Subject Chapters</td>
                                <td width="5%">Questions</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chapters as $key => $item)
                                <tr>
                                    <td width="5%">{{$key+1}}</td>
                                    <td>{{$item->course->course_name}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>&dollar;{{$item->price}}</td>
                                    <td><a href="{{route('admin.subject.chapter.index', $item->id)}}">{{count($item->subChapter)}}</a></td>
                                    <td><a href="{{route('admin.question.index', $item->id)}}">{{count($item->questions)}}</a></td>
                                    <th><a href="{{route('admin.course.chapters.edit',[$item->courseId,$item->id])}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a><a href="javascript:void(0)" data-id="{{$item->id}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div></th>
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
                var chapterId = $(this).data('id');
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
                        window.location.href = "chapters/"+chapterId+"/delete";
                    } else {
                      swal("Cancelled", "Record is safe", "error");
                    }
                });
            });
    </script>
@endpush