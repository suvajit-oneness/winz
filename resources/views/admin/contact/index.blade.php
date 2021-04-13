@extends('admin.app')
@section('title') {{ 'Contact' }} @endsection
@section('content')
   <div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ ('Contact') }}</h1>
            <p>{{ 'Contact Us Setting' }}</p>
        </div>
    </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form method="post" action="{{route('admin.contact.save')}}">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" required="" placeholder="Email" class="form-control" value="{{$contact->email}}">
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" name="mobile" required="" placeholder="Mobile" class="form-control" value="{{$contact->mobile}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control" placeholder="Address">{{$contact->address}}</textarea>
                            </div>
                        </div>
                        <input type="submit" name="submit" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles') @endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
@endpush