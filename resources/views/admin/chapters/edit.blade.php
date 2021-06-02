@extends('admin.app')
@section('title') {{ 'Chapter' }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ 'Chapter' }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ 'Update Chapter' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.chapters.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.chapters.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="chapter_id" value="{{$chapter->id}}">
                    <input type="hidden" id="sub_cat_id" value="{{$chapter->subjectCategoryId}}">
                    <div class="tile-body">

                        <div class="form-group">
                            <label class="control-label" for="categoryId"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('categoryId') is-invalid @enderror" name="categoryId" id="categoryId">
                                <option value="">-- Select Category --</option>
                                @foreach($category as $item)
                                <option value="{{$item->id}}" {{($item->id == $chapter->categoryId)? 'selected' : ''}}>{{$item->title}}</option>
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
                            <label class="control-label" for="chapter"> Chapter <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="chapter" id="chapter" placeholder="Chapter Name" value="{{(old('chapter')) ? old('chapter') : $chapter->chapter }}">
                            @error('chapter') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="price"> Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="number" name="price" id="price" placeholder="Chapter Price" value="{{(old('price')) ? old('price') : $chapter->price }}">
                            @error('price') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Chapter</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.chapters.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>
$(document).ready(function() {
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