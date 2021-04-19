@extends('admin.app')
@section('title') {{ 'Lectures' }} @endsection
@section('content')
   <div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ 'Lectures' }}</h1>
            <p>{{ 'list of Course Lecture' }}</p>
        </div>
        <!-- <a href="{{ route('admin.course.create') }}" class="btn btn-primary pull-right">Add New</a> -->
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
                                        <!-- <a href="{{route('admin.course.edit',$lec->id)}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a> -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});
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