@extends('admin.app')
@section('title') {{ 'Subject Category' }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ 'Subject Category' }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ 'Create Subject Category' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.subject.category.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.subject.category.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">

                        <div class="form-group">
                            <label class="control-label" for="categoryId"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('categoryId') is-invalid @enderror" name="categoryId" id="categoryId">
                                <option value="">-- Select Category --</option>
                                @foreach($category as $item)
                                <option value="{{$item->id}}" >{{$item->title}}</option>
                                @endforeach
                            </select>
                            @error('categoryId') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="title"> Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="text" name="title" id="title" placeholder="Subject Category Title" value="{{(old('title'))}}">
                            @error('title') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="image"> Image <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="image" id="image">
                            @error('image') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create Subject Category</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.subject.category.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection