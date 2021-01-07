@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
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
                        <li class="nav-item nav-item-top"><a class="nav-link active" href="#profile" data-toggle="tab">Basic</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#ads" data-toggle="tab">Billing</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#payments" data-toggle="tab">Shipping</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#Courier" data-toggle="tab">Courier</a></li>
                        <li class="nav-item nav-item-top"><a class="nav-link" href="#orderdetails" data-toggle="tab">Order Details</a></li>
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
                    @include('admin.order.includes.profile')
                </div>
                 <div class="tab-pane fade" id="ads">
                    @include('admin.order.includes.ads')
                </div>
                <div class="tab-pane fade" id="payments">
                    @include('admin.order.includes.payment')
                </div> 
                <div class="tab-pane fade" id="Courier">
                    @include('admin.order.includes.courier')
                </div>
                <div class="tab-pane fade" id="orderdetails">
                    @include('admin.order.includes.orderdetails')
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
    <script type="text/javascript">
    </script>
@endpush