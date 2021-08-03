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
                                <th>Transaction Id</th>
                                <th>Membership</th>
                                <th>User</th>
                                <th>Price</th>
                                {{-- <th>Action</th> --}}
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
                                    {{-- <td>
                                        <div class="btn-group" role="group" aria-label="Second group"><a href="#" class="btn btn-sm btn-primary">Details <i class="fa fa-eye"></i></a>
                                    </td> --}}
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
