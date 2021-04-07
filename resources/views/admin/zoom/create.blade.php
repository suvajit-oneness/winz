@extends('admin.app')
@section('title') Create Zoom Meeting @endsection
@section('content')
    <style type="text/css">small{color: #ff0000;font-size: 15px;}</style>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i>Create Zoom Meeting</h1>
            <p>Create Zoom Meeting</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form method="post" action="{{route('admin.zoom.save')}}">
                        @csrf
                        <div class="form-group">
                            <label>Topic <small>*</small></label>
                            <input type="text" name="topic" placeholder="Topic of the Meeting" class="form-control" required value="{{old('topic')}}">
                            @error('topic')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Start Date and Time <small>*</small></label>
                            <input type="datetime-local" name="startime" class="form-control" onkeypress="return false;" required value="{{old('startime')}}">
                            @error('startime')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Agenda</label>
                            <input type="text" name="agenda" placeholder="Agenda of the Meeting" class="form-control" value="{{old('agenda')}}">
                            @error('agenda')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Teacher</label>
                            <select name="teacher" class="form-control" required>
                                <option value="" selected="">Select Teacher</option>
                                @foreach($teachers as $key => $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->name}} ({{$teacher->email}})</option>
                                @endforeach
                            </select>
                            @error('teacher')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Atendee</label>
                            <select name="user" class="form-control" required>
                                <option value="" selected="">Select Student</option>
                                @foreach($users as $key => $student)
                                    <option value="{{$student->id}}">{{$student->name}} ({{$student->email}})</option>
                                @endforeach
                            </select>
                            @error('user')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <input type="submit" name="" class="btn btn-success" value="Create">
                    </form>
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
@endpush