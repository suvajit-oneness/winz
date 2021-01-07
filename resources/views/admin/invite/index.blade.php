@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.invite.create') }}" class="btn btn-primary pull-right">Send Invitation</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Email </th>
                                <th> Created At </th>
                                <th class="text-center"> Invitation Link </th>
                                <!-- <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invitations as $invitation)
                                    <tr>
                                        <td>{{ $invitation->email }}</td>
                                        <td>{{ $invitation->created_at }}</td>
                                        <td>{{ $invitation->getLink() }}</td>
                                        <!-- <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{-- route('admin.categories.edit', $category->id) --}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="{{-- route('admin.categories.delete', $category->id) --}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td> -->
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
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush