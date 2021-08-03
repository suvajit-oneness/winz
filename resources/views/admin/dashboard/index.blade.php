@extends('admin.app')
@section('title') Dashboard @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>Users</h4>
                    <p><b>{{$data->userCount}}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon">
                <i class="icon fa fa-thumbs-o-up fa-3x"></i>
                <div class="info">
                    <h4>Teachers</h4>
                    <p><b>{{$data->teacherCount}}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>Courses</h4>
                    <p><b>{{$data->courseCount}}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small danger coloured-icon">
                <i class="icon fa fa-star fa-3x"></i>
                <div class="info">
                    <h4>Total Bookings</h4>
                    <p><b>{{$data->bookingCount}}</b></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>New Bookings</h4>
                    <p><b>{{$data->latestBookingCount}}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon">
                <i class="icon fa fa-thumbs-o-up fa-3x"></i>
                <div class="info">
                    <h4>Membership Bookings</h4>
                    <p><b>{{$data->memberShipBookingCount}}</b></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="py-3">
                    <h4>10 Latest Bookings</h4>
                </div>
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Course</th>
                                <th>Chapter</th>
                                <th>Price</th>
                                <th>Transaction Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->lastTenBookings as $booking)
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="py-3">
                    <h4>10 Latest Membership Bookings</h4>
                </div>
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Transaction Id</th>
                                <th>Membership</th>
                                <th>User</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->lastTenMemberShipBookings as $booking)
                                <tr>
                                    <td>
                                        {{$booking->transactionDetails->transactionId}}
                                    </td>
                                    <td>
                                        {{$booking->membership->title}}( {{$booking->membership->description}} )
                                    </td>
                                    <td>
                                        {{$booking->userDetail->name}}<br />
                                        {{$booking->userDetail->email}}
                                    </td>
                                    <td>
                                        {{round(($booking->price/100), 2)}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection