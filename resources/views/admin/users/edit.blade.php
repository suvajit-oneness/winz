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
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        {{-- <button class="btn btn-primary" id="update" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update User</button> --}}
                        <a class="btn btn-secondary" href="{{ route('admin.users.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.users.update') }}" method="POST" role="form" enctype="multipart/form-data" id="useredit">
                    @csrf
                    <input type="hidden" name="id" value="{{$targetUser->id}}">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Membership <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('membership_id') is-invalid @enderror" name="membership_id" id="membership_id">
                            <option value="">-- Select Membership Plan --</option>
                            @if(count($membership))
                            @foreach($membership as $memberships)
                            <option value="{{$memberships->id}}"@if($targetUser->membership_id == $memberships->id) {{ 'selected' }} @endif>{{$memberships->title}}</option>
                            @endforeach
                            @endif
                            </select>
                            @error('membership_id') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="name"> Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name',$targetUser->name) }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name"> Email <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email',$targetUser->email) }}"/ readonly>
                            @error('email') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name"> Mobile <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" id="mobile" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ old('mobile',$targetUser->mobile) }}"/>
                            @error('mobile') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save User</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.users.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection