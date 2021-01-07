@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <form action="" method="POST" role="form">
                    <h3 class="tile-title">{{$ad_title}}</h3>
                    <hr>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="ad_title">Ad Title</label>
                            <input
                                class="form-control"
                                type="text"
                                id="ad_title"
                                name="ad_title"
                                value="{{ empty($ad_title)? null:($ad_title) }}"
                                readonly
                            />
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="posted_by">Posted By</label>
                            <input
                                class="form-control"
                                type="text"
                                id="posted_by"
                                name="posted_by"
                                value="{{ empty($single_ad_msg->email)? null:$single_ad_msg->email }}"
                                readonly
                            />
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone">Phone</label>
                            <input
                                class="form-control"
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ empty($single_ad_msg->phone)? null:$single_ad_msg->phone }}"
                                readonly
                            />
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="subject">Subject</label>
                            <input
                                class="form-control"
                                type="text"
                                id="subject"
                                name="subject"
                                value="{{ empty($single_ad_msg->subject)? null:$single_ad_msg->subject }}"
                                readonly
                            />
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="message">Message</label>
                            <textarea class="detail_ad form-control" id="message" readonly>{{ empty($single_ad_msg->message)? null:$single_ad_msg->message }}</textarea>
                        </div>
                        
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
@endpush