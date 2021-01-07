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
                        <a class="btn btn-secondary" href="{{ route('admin.packages.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.packages.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$package->id}}">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name',$package->name) }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description',$package->description) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="name">Valid Upto<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('valid_upto') is-invalid @enderror" type="text" name="valid_upto" id="valid_upto" value="{{ old('valid_upto',$package->valid_upto) }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                            @error('valid_upto') {{ $message ?? '' }} @enderror
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="control-label" for="name">Price<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{ old('price',$package->price) }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                            @error('price') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Offered Price<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('offered_price') is-invalid @enderror" type="text" name="offered_price" id="offered_price" value="{{ old('offered_price',$package->offered_price) }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                            @error('offered_price') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Show</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.packages.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection