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
                                <th>Transaction Id</th>
                                <th>Membership</th>
                                <th>User</th>
                                <th>Price</th>
                                <th>Booking Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
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
