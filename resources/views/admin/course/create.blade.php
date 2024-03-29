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
                <form action="{{ route('admin.course.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">


                      

                        <div class="form-group">
                            <label class="control-label" for="teacherId"> Teacher <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('teacherId') is-invalid @enderror" name="teacherId" id="teacherId">
                                <option value="">-- Select Teacher --</option>
                                @foreach($teacher as $teacherow)
                                <option value="{{$teacherow->id}}">{{$teacherow->name}}</option>
                                @endforeach
                            </select>
                        </div>




                        <div class="form-group">
                            <label class="control-label" for="image"> Image <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="image" id="image">
                            @error('image') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="name"> Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Course Name">
                            @error('name') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="price"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control ckeditor" name="description" id="description">{{old('description')}}</textarea>
                            @error('description') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Course</button>
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
   
@endpush