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
                <h3 class="tile-title">{{ 'Edit Teacher' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.users.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.teacher.update',$user->id) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name"> Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="@if(old('name')){{ old('name') }}@else{{$user->name}}@endif" placeholder="Name">
                            @error('name') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"> Email <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="@if(old('email')){{old('email')}}@else{{$user->email}}@endif" placeholder="Email">
                            @error('email') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="mobile"> Mobile <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" id="mobile" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="@if(old('mobile')){{ old('mobile') }}@else{{$user->mobile}}@endif" placeholder="Mobile">
                            @error('mobile') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="gender">Gender <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="gender">
                                <option value="1" @if($user->gender == 1){{('selected')}}@endif>Male</option>
                                <option value="2" @if($user->gender == 2){{('selected')}}@endif>Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="price"> Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{$user->teacher->price_per_hour}}" placeholder="Price Per Hour in Doller ($)">
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