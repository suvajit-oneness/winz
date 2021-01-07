@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Keyconcept</button>
                    <a class="btn btn-secondary" href="{{ route('admin.keyconcept.index') }}"><i class="fa fa-fw fa-lg fa fa-angle-left"></i>Back</a>
                </div>
            </div>
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
        <div class="col-md-12 mx-auto">
            <div class="tile">
                <form action="{{ route('admin.keyconcept.update') }}" method="POST" role="form" enctype="multipart/form-data" id="form1">
                    @csrf
                    <div class="tile-body form-body">

                        <div class="form-group">
                            <label class="control-label" for="name">Select Board <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('board_id') is-invalid @enderror" name="board_id" id="board_id">
                                <option value="">-- Select Board --</option>
                                @foreach($board as $n)
                                <option value="{{$n->id}}"@if($n->id == $targetkeyconcept->board_id){{'selected'}} @endif>{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('board_id') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="name">Select Subject <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('subject_id') is-invalid @enderror" name="subject_id" id="subject_id">
                                <option value="">-- Select Subject --</option>
                                @foreach($subject as $n)
                                <option value="{{$n->id}}"@if($n->id == $targetkeyconcept->subject_id){{'selected'}} @endif>{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('subject_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Select Class <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('class_id') is-invalid @enderror" name="class_id" id="class_id">
                                <option value="">-- Select Class --</option>
                                @foreach($class as $n)
                                <option value="{{$n->id}}"@if($n->id == $targetkeyconcept->class_id){{'selected'}} @endif>{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('class_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetkeyconcept->title) }}"/>
                            <input type="hidden" name="id" value="{{ $targetkeyconcept->id }}">
                            @error('title') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea name="description" id="description" class="form-control ckeditor @error('description') is-invalid @enderror" rows="8">{{ $targetkeyconcept->description }}</textarea>
                            @error('description') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetkeyconcept->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('keyconcept/'.$targetkeyconcept->image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" value="{{ old('image', $targetkeyconcept->image) }}"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="video_link">Video Link </label>
                            <input class="form-control @error('video_link') is-invalid @enderror" type="text" name="video_link" id="video_link" value="{{ old('video_link',$targetkeyconcept->video_link) }}"/>
                            @error('video_link') {{ $message }} @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("#btnSave").on("click",function(){
            $('#form1').submit();
        })
    </script>
@endpush