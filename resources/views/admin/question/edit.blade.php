@extends('admin.app')
@section('title') {{ 'Question' }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ 'Question' }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ 'Update Question' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.question.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.question.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <input type="hidden" id="chapter_id" value="{{$question->chapterId}}">
                    <div class="tile-body">

                        <img src="{{asset($question->question)}}" height="100" width="200">
                        <div class="form-group">
                            <label class="control-label" for="question"> Question <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="question" id="question">
                            @error('question') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="subjectCategoryId"> Subject Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('subjectCategoryId') is-invalid @enderror" name="subjectCategoryId" id="subjectCategoryId">
                                <option value="">-- Select Subject Category --</option>
                                @foreach($sub_category as $item)
                                <option value="{{$item->id}}" {{($item->id == $question->subjectCategoryId)? 'selected' : ''}}>{{$item->categoryId}} - {{$item->title}}</option>
                                @endforeach
                            </select>
                            @error('subjectCategoryId') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="chapterId"> Chapter <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('chapterId') is-invalid @enderror" name="chapterId" id="chapterId">
                                <option value="">-- Select Chapter --</option>
                            </select>
                            @error('chapterId') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="description"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control ckeditor" name="description" id="description">{{$question->description}}</textarea>
                            @error('description') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="difficulty"> Difficulty <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('difficulty') is-invalid @enderror" name="difficulty" id="difficulty">
                                <option value="">-- Select Difficulty --</option>
                                <option value="1" {{($question->difficulty == 1)? 'selected': ''}}>Easy</option>
                                <option value="2" {{($question->difficulty == 2)? 'selected': ''}}>Medium</option>
                                <option value="3" {{($question->difficulty == 3)? 'selected': ''}}>Hard</option>
                            </select>
                            @error('difficulty') {{ $message }} @enderror
                        </div>

                        <img src="{{asset($question->mark_scheme)}}" height="100" width="200">
                        <div class="form-group">
                            <label class="control-label" for="mark_scheme"> Mark Scheme <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="mark_scheme" id="mark_scheme">
                            @error('mark_scheme') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer1"> Answer 1 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="answer1" id="answer1" placeholder="Answer 1" value="{{(old('answer1')) ? old('answer1') : $question->answer1 }}">
                            @error('answer1') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="answer2"> Answer 2 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="answer2" id="answer2" placeholder="Answer 1" value="{{(old('answer2')) ? old('answer2') : $question->answer2 }}">
                            @error('answer2') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="answer3"> Answer 3 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="answer3" id="answer3" placeholder="Answer 1" value="{{(old('answer3')) ? old('answer3') : $question->answer3 }}">
                            @error('answer3') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="answer4"> Answer 4 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="answer4" id="answer4" placeholder="Answer 1" value="{{(old('answer4')) ? old('answer4') : $question->answer4 }}">
                            @error('answer4') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.question.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            var subjectCategoryId = $('#subjectCategoryId').val();
            $('#chapterId').empty();
            $.ajax({
                url: "{{route('get.chapters.data')}}",
                type: "POST",
                data: {
                    '_token': "{{csrf_token()}}",
                    'subjectCategoryId': subjectCategoryId
                },
                success:function(data){
                    console.log(data.data);
                    var chapterId = '';
                    $.each(data.data, function(i, val) {
                        if ($('#chapter_id').val() == val.id) {
                            console.log('selected');
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        chapterId += "<option value='"+val.id+"'"+selected+">"+val.chapter+"</option>";
                    });
                    $('#chapterId').append(chapterId);
                }
            });
        });
        $('#subjectCategoryId').change(function() {
            var subjectCategoryId = $('#subjectCategoryId').val();
            $('#chapterId').empty();
            $.ajax({
                url: "{{route('get.chapters.data')}}",
                type: "POST",
                data: {
                    '_token': "{{csrf_token()}}",
                    'subjectCategoryId': subjectCategoryId
                },
                success:function(data){
                    var chapterId = '';
                    $.each(data.data, function(i, val) {
                        if ($('#chapter_id').val() == val.id) {
                            console.log('selected');
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        chapterId += "<option value='"+val.id+"'"+selected+">"+val.chapter+"</option>";
                    });
                    $('#chapterId').append(chapterId);
                }
            });
        });
    </script>
@endpush