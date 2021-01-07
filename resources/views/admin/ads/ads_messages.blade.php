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
                            <th>Posted By</th>
                            <th>Ad Title</th>
                            <th>Subject/Message</th>
                            <th>Messaged On</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $key => $message)
                                <tr>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->ad->title }}</td>
                                    <td>
                                        <?php
                                            $msg_length = strlen($message->message);
                                            $msg_string = "";
                                            if($msg_length>10)
                                            {
                                                $msg_string=substr($message->message, 0,25)."...";
                                            }else{
                                                $msg_string=$message->message;
                                            }
                                            $subject_length = strlen($message->subject);
                                            $subject_string = "";
                                            if($subject_length>10)
                                            {
                                                $subject_string=substr($message->subject, 0,15)."...";
                                            }else{
                                                $subject_string=$message->subject;
                                            }
                                        ?>
                                        <b>{{ $subject_string }}</b>-{{ $msg_string }}</td>
                                    <td>{{ Carbon\Carbon::parse($message->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.ads.view_msg', $message->id) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
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
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
@endpush