@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Id </th>
                                <th> Package Name </th>
                                <th> Price </th>
                                <th> User Details </th>
                                <th> Created At </th>
                                <th> Valid Upto </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->id }}</td>
                                    <td>{{ $subscription->package->name }}</td>
                                    <td>{{ $subscription->package->offered_price }}</td>
                                    <td>{{ $subscription->user->name }}<br>{{ $subscription->user->mobile }}</td>
                                    <td>{{ date("d-M-Y, h:i a",strtotime($subscription->created_at)) }}</td>
                                    <td>{{ date("d-M-Y",strtotime($subscription->subscription_end_date)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
@endpush