@extends('admin.app')
@section('title') {{ 'Features' }} @endsection
@section('content')
   <div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ 'Features' }}</h1>
            <p>{{ 'list of Course Features' }}</p>
        </div>
        <a href="{{route('admin.course')}}" class="pull-right">Back to Course</a>
        <a href="javascript:void(0)" class="btn btn-primary pull-right createFeature">Add New</a>
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
                                <th> Feature</th>
                                <th> Status</th>
                                <th> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course->feature as $key => $feat)
                                <tr>
                                    <td>{{$course->course_name}}</td>
                                    <td>{{$feat->feature}}</td>
                                    <td>
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="is_active" class="checkbox" data-feature_id="{{$feat->id}}" @if($feat->deleted_at == ''){{'checked'}}@endif>
                                                        <div class="knobs"><span>Inactive</span></div>
                                                        <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary edit-btn" data-id="{{$feat->id}}" data-feature="{{$feat->feature}}"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Feature Modal -->
    <div class="modal fade" id="addFeatureModal" tabindex="-1" role="dialog" aria-labelledby="addFeatureModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFeatureModalLabel">Add Feature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('admin.feature.save',$course->id)}}">
                    @csrf
                    <input type="hidden" name="form" value="add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" for="feature"> Feature <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('feature') is-invalid @enderror" type="text" name="feature" id="feature" value="{{ old('feature') }}" placeholder="Feature Name">
                            @error('feature') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
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
    <div class="modal fade" id="editFeatureModal" tabindex="-1" role="dialog" aria-labelledby="editFeatureModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFeatureModalLabel">Edit Feature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('admin.feature.update',$course->id)}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="form" value="update">
                            <input type="hidden" name="featureId" value="">
                            <label class="control-label" for="feature_name"> Feature <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('feature_name') is-invalid @enderror" type="text" name="feature_name" id="feature_name" value="{{ old('feature_name') }}" placeholder="Feature Name">
                            @error('feature_name') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
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
@endpush
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});
        $(document).on('click','.createFeature',function(){
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').remove();
            $('#addFeatureModal input[name=feature]').val('');
            $('#addFeatureModal').modal('show');
        });

        $(document).on('click','.edit-btn',function(){
            var id = $(this).attr('data-id'),feature = $(this).attr('data-feature');
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').remove();
            $('#editFeatureModal input[name=featureId]').val(id);
            $('#editFeatureModal input[name=feature_name]').val(feature);
            $('#editFeatureModal').modal('show');
        });

        @if(old('form') == 'add')$('#addFeatureModal').modal('show');@endif
        @if(old('form') == 'update')$('#editFeatureModal').modal('show');@endif

        $(document).on('change','input[id="toggle-block"]',function(){
            var featureId = $(this).data('feature_id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var is_active = 2;
            if($(this).is(":checked")){
                is_active = 1;
            }
            $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.course.feature.delete')}}",
                data:{ _token: CSRF_TOKEN, id:featureId,courseId:'{{$course->id}}', status:is_active},
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