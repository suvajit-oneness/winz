@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
        </div>
    </div>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Course</th>
                                <th>Chapter</th>
                                <th>Price</th>
                                <th>Transaction Id</th>
                                <th>Booking Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>
                                        {{$booking->userDetail->name}}<br />
                                        {{$booking->userDetail->email}}
                                    </td>
                                    <td>
                                        {{$booking->course->course_name}}
                                    </td>
                                    <td>
                                        {{$booking->chapter->name}}
                                    </td>
                                    <td>
                                        {{$booking->price}}
                                    </td>
                                    <td>
                                        {{$booking->transaction->transactionId}}
                                    </td>
                                    <td>{{date('d M, Y H:i:A',strtotime($booking->created_at))}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pb-5">
                        <div class="float-right">{!! $bookings->links() !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
