@extends('admin.app')
@section('title') {{ 'Subject Chapter' }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ 'Subject Chapter' }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ 'Update Subject Chapter' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.subject.chapter.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.subject.chapter.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="sub_chapter_id" value="{{$sub_chapter->id}}">
                    <div class="tile-body">

                        <div class="form-group">
                            <label class="control-label" for="name"> name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Subject chapter name" value="{{(old('name')) ? old('name') : $sub_chapter->name }}">
                            @error('name') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="chapterId"> Chapter <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('chapterId') is-invalid @enderror" name="chapterId" id="chapterId">
                                <option value="">-- Select Chapter --</option>
                                @foreach($chapter as $item)
                                <option value="{{$item->id}}" {{($item->id == $sub_chapter->chapterId)? 'selected' : ''}}>{{$item->chapter}}</option>
                                @endforeach
                            </select>
                            @error('chapterId') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="price"> Topics <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control ckeditor" name="topics" id="description">{{$sub_chapter->topics}}</textarea>
                            @error('topics') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.subject.chapter.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/ckeditor/ckeditor.js') }}"></script>
@endpush