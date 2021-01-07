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
                        <a class="btn btn-secondary" href="{{ route('admin.couponcode.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.couponcode.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $couponCode->id }}" >
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="coupon_name"> Coupon Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('coupon_name') is-invalid @enderror" type="text" name="coupon_name" id="coupon_name" value="{{ $couponCode->coupon_name }}"/>
                            @error('coupon_name') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="coupon_code"> Coupon Code <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('coupon_code') is-invalid @enderror" type="text" name="coupon_code" id="coupon_code" value="{{ $couponCode->coupon_code }}"/>
                            @error('coupon_code') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="start_date"> Start Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('start_date') is-invalid @enderror" type="date" name="start_date" id="start_date" value="{{ $couponCode->start_date }}"/>
                            @error('start_date') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="end_date"> End Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('end_date') is-invalid @enderror" type="date" name="end_date" id="end_date" value="{{ $couponCode->end_date }}"/>
                            @error('end_date') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="offer_rate"> Offer Rate <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('offer_rate') is-invalid @enderror" type="text" name="offer_rate" id="offer_rate" value="{{ $couponCode->offer_rate }}"/>
                            @error('offer_rate') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="maximum_time_of_use"> Maximum Time Of Use <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('maximum_time_of_use') is-invalid @enderror" type="text" name="maximum_time_of_use" id="maximum_time_of_use" value="{{ $couponCode->maximum_time_of_use }}"/>
                            @error('maximum_time_of_use') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="maximum_user_can_use"> maximum user can use <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('maximum_user_can_use') is-invalid @enderror" type="text" name="maximum_user_can_use" id="maximum_user_can_use" value="{{ $couponCode->maximum_user_can_use }}"/>
                            @error('maximum_user_can_use') {{ $message ?? '' }} @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="link">Select Offer Type<span class="m-l-5 text-danger"> *</span></label>
                            <label class="radio-inline">
                            <input type="radio" class="grey" name="offer_type" value="1"@if($couponCode->offer_type==1){{'checked'}} @endif>
                            Fixed Amount
                            </label>
                            <label class="radio-inline">
                            <input type="radio" class="grey" name="offer_type" value="2"@if($couponCode->offer_type==2){{'checked'}} @endif>
                            Offer In Percentage
                            </label>
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save couponcode</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.couponcode.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection