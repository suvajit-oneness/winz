@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.testimonial.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$targetTestimonial->id}}">
                    <div class="tile-body">
                        <div class="form-group">
                        <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name',$targetTestimonial->name) }}"/>
                        @error('name') {{ $message ?? '' }} @enderror
                       </div>

                       <div class="form-group">
                        <label class="control-label" for="name">Designation <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('designation') is-invalid @enderror" type="text" name="designation" id="designation" value="{{ old('designation',$targetTestimonial->designation) }}"/>
                        @error('designation') {{ $message ?? '' }} @enderror
                       </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetTestimonial->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('testimonials/'.$targetTestimonial->image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label"> Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" value="{{ old('image', $targetTestimonial->image) }}"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="control-label" for="name">Content <span class="m-l-5 text-danger"> *</span></label>
                        <textarea class="form-control ckeditor" name="content" id="content">{{ old('content', $targetTestimonial->content) }}</textarea>
                        @error('content') {{ $message ?? '' }} @enderror
                    </div>
                    </div>
                    
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Blog</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.testimonial.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('backend/js/plugins/ckeditor/ckeditor.js') }}"></script>
@endpush