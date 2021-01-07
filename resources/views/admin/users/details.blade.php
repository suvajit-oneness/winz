@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1>{{$userdetails->name}}</h1>
                @if ($userdetails->is_active == 1)
                    <span class="badge badge-success badge-top">Active</span>
                @else
                    <span class="badge badge-danger badge-top">Block</span>
                @endif
                <div class="form-group">
                    <a class="btn btn-secondary" href="{{ URL::previous() }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
            </div>
        </div>
    @include('admin.partials.flash')
        <div class="user">
            <div class="col-md-12 nopadding">
                <div class="tile p-0">
                    <ul class="nav nav-tabs user-tabs">
                        <li class="nav-item nav-item-top"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link " href="#creditlist" data-toggle="tab">Credit List</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-md-body">
        <div class="alert alert-success" id="success-msg" style="display: none;">
            <span id="success-text"></span>
        </div>
        <div class="alert alert-danger" id="error-msg" style="display: none;">
            <span id="error-text"></span>
        </div>
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="profile">
                    @include('admin.users.includes.profile')
                </div>
                <div class="tab-pane" id="creditlist">
                    @include('admin.users.includes.creditlist')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
@endpush