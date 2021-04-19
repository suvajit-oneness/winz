@extends('admin.app')
@section('title') {{ 'Course' }} @endsection
@section('content')
   <div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ 'Course' }}</h1>
            <p>{{ 'list of Courses' }}</p>
        </div>
        <a href="{{ route('admin.course.create') }}" class="btn btn-primary pull-right">Add New</a>
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
                                <th> Image</th>
                                <th> Name</th>
                                <th> Description</th>
                                <th> Price</th>
                                <th> Lectures</th>
                                <th> Features</th>
                                <th> Status</th>
                                <th> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course as $key => $cou)
                                <tr>
                                    <td><img src="{{asset($cou->course_image)}}" height="100" width="100"></td>
                                    <td>{{$cou->course_name}}</td>
                                    <td>{!! $cou->course_description !!}</td>
                                    <td>{{$cou->course_price}}</td>
                                    <th><a href="{{route('admin.course.lecture',$cou->id)}}">{{count($cou->lecture)}}</a></th>
                                    <th><a href="{{route('admin.course.feature',$cou->id)}}">{{count($cou->feature)}}</a></th>
                                    <th>
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="is_active" class="checkbox" data-course_id="{{$cou->id}}" @if($cou->deleted_at == ''){{'checked'}}@endif>
                                                        <div class="knobs"><span>Inactive</span></div>
                                                        <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <a href="{{route('admin.course.edit',$cou->id)}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a>
                                    </th>
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
            var courseId = $(this).data('course_id');
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
                url:"{{route('admin.course.delete')}}",
                data:{ _token: CSRF_TOKEN, id:courseId, status:is_active},
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