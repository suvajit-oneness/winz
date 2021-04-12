@extends('admin.app')
@section('title') Zoom Meeting @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> Zoom Meeting</h1>
            <p>List of zoom meetings</p>
        </div>
        <a href="{{ route('admin.zoom.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                        <tr>
                            <td>UUID</td>
                            <td>Meeting Id</td>
                            <td>Attendee Name</td>
                            <td>Attendee Email</td>
                            <td>Organizer Name</td>
                            <td>Organizer Email</td>
                            <td>Topic</td>
                            <td>Start Date and Time</td>
                            <td>Agenda</td>
                            <td>Join URL</td>
                            <td>Password</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($zoom as $key => $meeting)
                                <tr>
                                    <td>{{$meeting->uuid}}</td>
                                    <td>{{$meeting->meetingId}}</td>
                                    <td>@if($meeting->userData){{$meeting->userData->name}}@else{{('N/A')}}@endif</td>
                                    <td>@if($meeting->userData){{$meeting->userData->email}}@else{{('N/A')}}@endif</td>
                                    <td>@if($meeting->teacherData){{$meeting->teacherData->name}}@else{{('N/A')}}@endif</td>
                                    <td>@if($meeting->teacherData){{$meeting->teacherData->email}}@else{{('N/A')}}@endif</td>
                                    <td>{{$meeting->topic}}</td>
                                    <td>{{$meeting->start_time}}</td>
                                    <td>{{$meeting->agenda}}</td>
                                    <td><a href="{{$meeting->join_url}}" target="_blank">{{$meeting->join_url}}</a></td>
                                    <td>{{$meeting->password}}</td>
                                    <td><a href="javascript:void(0)" class="text-danger deleteMeeting" data-id="{{$meeting->id}}" data-meeting_id="{{$meeting->meetingId}}" >Delete</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});

        $(document).on('click','.deleteMeeting',function(){
            var Id = $(this).attr('data-id'),meetingId = $(this).attr('data-meeting_id');
            swal({
              title: "Are you sure?",
              text: "you want to delete the meeting!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
            },
            function(isConfirm){
                if (isConfirm) {
                    let request = {_token:'{{csrf_token()}}',zoomMeetingId:Id,meetingId,meetingId};
                    deleteMeeting(request);
                }
            });
        });

        function deleteMeeting(argument) {
            $.ajax({
                url : '{{route('admin.zoom.delete')}}',
                type : 'post',
                data : argument,
                success:function(d){
                    if(d.error == false){
                        window.location.reload();
                    }else{
                        alert('something went wrong please try after some time');
                    }
                }
            });
        }
    </script>
@endpush