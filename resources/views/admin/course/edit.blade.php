@extends('admin.app')
@section('title') {{ 'Course' }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ 'Course' }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ 'Create Course' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.course') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.course.update',$course->id) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">



                        <div class="form-group">
                            <label class="control-label" for="categoryId"> Category {{$course->subjectCategoryId}} <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('categoryId') is-invalid @enderror" name="categoryId" id="categoryId">
                                <option value="">-- Select Category --</option>
                                @foreach($category as $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                            @error('categoryId') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="subjectCategoryId"> Subject Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('subjectCategoryId') is-invalid @enderror" name="subjectCategoryId" id="subjectCategoryId">
                                <option value="">-- Select Subject Category --</option>
                            </select>
                            @error('subjectCategoryId') {{ $message }} @enderror
                        </div>




                        <div class="form-group">
                            <label class="control-label" for="teacherId"> Teacher <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('teacherId') is-invalid @enderror" name="teacherId" id="teacherId">
                                <option value="">-- Select Teacher --</option>
                                @foreach($teacher as $teacherow)
                                <option value="{{$teacherow->id}}">{{$teacherow->name}}</option>
                                @endforeach
                            </select>
                        </div>





                        <img src="{{asset($course->course_image)}}" height="200" width="200">
                        <div class="form-group">
                            <label class="control-label" for="image"> Image <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="image" id="image">
                            @error('image') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="name"> Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{(old('name')) ? old('name') : $course->course_name }}" placeholder="Course Name">
                            @error('name') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="price"> Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{(old('price')) ? old('price') : $course->course_price }}" placeholder="Course Price in Doller ($)" onkeypress="return isNumberKey(event)" maxlength="5">
                            @error('price') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="price"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control ckeditor" name="description" id="description">{{(old('description')) ? old('description') : $course->course_description }}</textarea>
                            @error('description') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Course</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.course') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
$('#categoryId').change(function() {
    var categoryId = $('#categoryId').val();
    $('#subjectCategoryId').empty();
    $.ajax({
        url: "{{route('get.subject.categories.data')}}",
        type: "POST",
        data: {
            '_token': "{{csrf_token()}}",
            'categoryId': categoryId
        },
        success:function(data){
            var sucCategory = '';
            $.each(data.data, function(i, val) {
                if ($('#sub_cat_id').val() == val.id) {
                    console.log('selected');
                    selected = 'selected';
                } else {
                    selected = '';
                }
                sucCategory += "<option value='"+val.id+"'"+selected+">"+val.title+"</option>";
            });
            $('#subjectCategoryId').append(sucCategory);
        }
    });
})
</script>
@endpush