@extends('admin.app')
@section('title') {{ 'Lectures' }} @endsection
@section('content')
   <div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ 'Lectures' }}</h1>
            <p>{{ 'list of Course Lecture' }}</p>
        </div>
        <a href="javascript:void(0)" class="btn btn-primary pull-right createLecture">Add New</a>
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
                                <th> Course Name</th>
                                <th> Lecture Title</th>
                                <th> Description</th>
                                <th> Media</th>
                                <th> Status</th>
                                <th> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course->lecture as $key => $lec)
                                <tr>
                                    <td>{{$course->course_name}}</td>
                                    <td>{{$lec->title}}</td>
                                    <td>{!! $lec->description !!}</td>
                                    <td><a href="{{$lec->media}}" target="_blank">{{$lec->media}}</a></td>
                                    <td>
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="is_active" class="checkbox" data-lecture_id="{{$lec->id}}" @if($lec->deleted_at == ''){{'checked'}}@endif>
                                                        <div class="knobs"><span>Inactive</span></div>
                                                        <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary edit-btn" data-id="{{$lec->id}}" data-title="{{$lec->title}}" data-description="{{$lec->description}}" data-media="{{$lec->media}}"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- Add Lecture Modal -->
    <div class="modal fade" id="addLectureModal" tabindex="-1" role="dialog" aria-labelledby="aaddLectureModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLectureModalLabel">Add Lecture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('admin.course.lecture.save',$course->id)}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="form" value="add">
                        <div class="form-group">
                            <label class="control-label" for="title"> Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Title">
                            @error('title') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="media"> Media <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('media') is-invalid @enderror" type="url" name="media" id="media" value="{{ old('media') }}" placeholder="Media Link">
                            @error('media') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="description"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description max(200) character...">{{ old('description') }}</textarea>
                            @error('description') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary reset" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Feature Modal -->
    <div class="modal fade" id="editLectureModal" tabindex="-1" role="dialog" aria-labelledby="editLectureModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLectureModalLabel">Edit Lecture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('admin.course.lecture.update',$course->id)}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="form" value="update">
                        <input type="hidden" name="lectureId" value="0">
                        <div class="form-group">
                            <label class="control-label" for="title1"> Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title1" value="{{ old('title') }}" placeholder="Title">
                            @error('title') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="media1"> Media <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('media') is-invalid @enderror" type="url" name="media" id="media1" value="{{ old('media') }}" placeholder="Media Link">
                            @error('media') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="description1"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description1" placeholder="Description max(200) character...">{{ old('description') }}</textarea>
                            @error('description') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary reset" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <!-- <script type="text/javascript" src="{{ asset('backend/js/plugins/ckeditor/ckeditor.js') }}"></script> -->
@endpush
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});

        $(document).on('click','.createLecture',function(){
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').remove();
            $('#addLectureModal input[name=title]').val('');
            $('#addLectureModal input[name=media]').val('');
            $('#addLectureModal textarea[name=description]').val('');
            $('#addLectureModal').modal('show',{backdrop: 'static', keyboard: false});
        });

        $(document).on('click','.edit-btn',function(){
            var id = $(this).attr('data-id'),title = $(this).attr('data-title'),description = $(this).attr('data-description'),media = $(this).attr('data-media');
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').remove();
            $('#editLectureModal input[name=lectureId]').val(id);
            $('#editLectureModal input[name=title]').val(title);
            $('#editLectureModal input[name=media]').val(media);
            $('#editLectureModal textarea[name=description]').val(description);
            $('#editLectureModal').modal('show',{backdrop: 'static', keyboard: false});
        });

        @if(old('form') == 'add')$('#addLectureModal').modal('show');@endif
        @if(old('form') == 'update')$('#editLectureModal').modal('show');@endif

        $(document).on('change','input[id="toggle-block"]',function(){
            var lectureId = $(this).data('lecture_id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var is_active = 0;
            if($(this).is(":checked")){
                is_active = 1;
            }else{
                is_active = 2;
            }
            $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.course.lecture.delete')}}",
                data:{ _token: CSRF_TOKEN, id:lectureId,courseId:'{{$course->id}}', status:is_active},
                success:function(response)
                {
                    if(response.error == false){
                        swal("Success!", response.message, "success");      
                    }else{
                        swal("Error!", response.message, "error");
                    }
                },
                error: function(response)
                {
                  swal("Error!", response.message, "error");  
                }
            });
        });
    </script>
@endpush