@extends('admin.app')
@section('title') {{ 'Teacher' }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ 'Teacher' }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ 'Create Teacher' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.users.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.teacher.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">

                        <div class="form-group">
                            <label class="control-label" for="name"> Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Name">
                            @error('name') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"> Email <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email') }}" placeholder="Email">
                            @error('email') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="mobile"> Mobile <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" id="mobile" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ old('mobile') }}" placeholder="Mobile">
                            @error('mobile') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password"> Password <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{ old('password') }}" placeholder="Password">
                            @error('password') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="gender">Gender <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="gender">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="price"> Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{ old('price') }}" placeholder="Price Per Hour in Doller ($)">
                            @error('price') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save User</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.teacher.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection