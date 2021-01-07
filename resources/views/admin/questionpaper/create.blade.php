@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Question Paper</button>
                    <a class="btn btn-secondary" href="{{ route('admin.questionpaper.index') }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12 mx-auto">
            <div class="tile">
                <form action="{{ route('admin.questionpaper.store') }}" method="POST" role="form" enctype="multipart/form-data" id="form1">
                    @csrf
                    <div class="tile-body form-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Select Board </label>
                            <select class="form-control @error('board_id') is-invalid @enderror" name="board_id" id="board_id">
                                <option value="">-- Select Board --</option>
                                @foreach($board as $n)
                                <option value="{{$n->id}}">{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('board_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Select Subject </label>
                            <select class="form-control @error('subject_id') is-invalid @enderror" name="subject_id" id="subject_id">
                                <option value="">-- Select Subject --</option>
                                @foreach($subject as $n)
                                <option value="{{$n->id}}">{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('subject_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Select Class </label>
                            <select class="form-control @error('class_id') is-invalid @enderror" name="class_id" id="class_id">
                                <option value="">-- Select Class --</option>
                                @foreach($class as $n)
                                <option value="{{$n->id}}">{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('class_id') {{ $message }} @enderror
                        </div>    
                        <div class="form-group">
                            <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea name="description" id="description" class="form-control ckeditor @error('description') is-invalid @enderror" rows="8"></textarea>
                            @error('description') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Image / Pdf</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="video_link">Video Link </label>
                            <input class="form-control @error('video_link') is-invalid @enderror" type="text" name="video_link" id="video_link" value="{{ old('video_link') }}"/>
                            @error('video_link') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="difficulty">Difficulty<span class="m-l-5 text-danger"> *</span> </label>
                            <input class="form-control @error('difficulty') is-invalid @enderror" type="text" name="difficulty" placeholder="Enter 1 to 9" maxlength="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="difficulty" value="{{ old('difficulty') }}"/>
                            @error('difficulty') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="video_solution">Video Solution </label>
                            <input class="form-control @error('video_solution') is-invalid @enderror" type="text" name="video_solution" id="video_solution" value="{{ old('video_solution') }}"/>
                            @error('video_solution') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="video_solution2">Video Solution 2 </label>
                            <input class="form-control @error('video_solution2') is-invalid @enderror" type="text" name="video_solution2" id="video_solution2" value="{{ old('video_solution2') }}"/>
                            @error('video_solution2') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="video_solution3">Video Solution 3 </label>
                            <input class="form-control @error('video_solution3') is-invalid @enderror" type="text" name="video_solution3" id="video_solution3" value="{{ old('video_solution3') }}"/>
                            @error('video_solution3') {{ $message }} @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $("#btnSave").on("click",function(){
            $('#form1').submit();
        })
    })
</script>
@endpush