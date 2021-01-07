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
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Ad Title</th>
                            <th>Ad Id</th>
                            <th>Reported By</th>
                            <th>Reason</th>
                            <th>Reported On</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $key=>$report)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $report->ad->title }}</td>
                                    <td>{{ $report->ad->unique_id }}</td>
                                    <td>{{ $report->user->name }}</td>
                                    <td>{{ $report->reason }}</td>
                                    <td>{{ Carbon\Carbon::parse($report->created_at)->format('d/m/Y h:i a') }}</td>
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