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
                <h3 class="tile-title">{{ 'Create Chapter' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.course.chapters.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.course.chapters.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">





                        <div class="form-group">
                            <label class="control-label" for="courseId"> Courses <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('courseId') is-invalid @enderror" name="courseId" id="courseId">
                                <option value="">-- Select Courses --</option>
                                @foreach($courses as $courserow)
                                <option value="{{$courserow->id}}" >{{$courserow->course_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="chapter"> Chapter <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Chapter Name" value="{{(old('chapter'))}}">
                            @error('chapter') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="price"> Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="number" name="price" id="price" placeholder="Chapter Price" value="{{(old('price'))}}">
                            @error('price') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Chapter</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.course.chapters.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

