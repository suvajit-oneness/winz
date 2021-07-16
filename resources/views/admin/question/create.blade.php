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
                <h3 class="tile-title">{{ 'Create Question' }} 
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.question.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.question.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="chapterId" value="{{$chapterId}}">
                    <input type="hidden" name="subChapterId" value="{{$subChapterId}}">
                    <div class="tile-body">


                        <div class="form-group">
                            <label class="control-label" for="question"> Question <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="question" id="question">
                            @error('question') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="difficulty"> Difficulty <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('difficulty') is-invalid @enderror" name="difficulty" id="difficulty">
                                <option value="">-- Select Difficulty --</option>
                                <option value="1">Easy</option>
                                <option value="2">Medium</option>
                                <option value="3">Hard</option>
                            </select>
                            @error('difficulty') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="mark_scheme"> Mark Scheme <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="mark_scheme" id="mark_scheme">
                            @error('mark_scheme') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer1"> Answer 1 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="answer1" id="answer1" placeholder="Answer 1" value="{{(old('answer1'))}}">
                            @error('answer1') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer2"> Answer 2 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="answer2" id="answer2" placeholder="Answer 2" value="{{(old('answer2'))}}">
                            @error('answer2') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer3"> Answer 3 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="answer3" id="answer3" placeholder="Answer 3" value="{{(old('answer3'))}}">
                            @error('answer3') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="answer4"> Answer 4 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="answer4" id="answer4" placeholder="Answer 4" value="{{(old('answer4'))}}">
                            @error('answer4') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="description"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control ckeditor" name="description" id="description"></textarea>
                            @error('description') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.question.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


