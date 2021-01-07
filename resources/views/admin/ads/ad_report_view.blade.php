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
                <h3 class="tile-title">{{$ad_title}}</h3>
                <table class="table table-hover custom-data-table-style table-striped dataTable table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Ad ID</td>
                            <td>{{ empty($ad_uniqueID)? null:$ad_uniqueID }}</td>
                        </tr>
                    
                        <tr>
                            <td>Posted By</td>
                            <td>{{ empty($single_ad_report->user->name)? null:$single_ad_report->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Reason</td>
                            <td>{{ empty($single_ad_report->reason)? null:$single_ad_report->reason }}</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>{{ Carbon\Carbon::parse($single_ad_report->created_at)->format('m/d/Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
