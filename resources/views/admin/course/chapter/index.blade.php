@extends('admin.app')
@section('title') {{ 'Chapters' }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file-text"></i> {{ 'Chapters' }}</h1>
                <p>{{ 'list of  Chapters' }}</p>
            </div>
            <a href="{{route('admin.course')}}" class="pull-right">Back to Course</a>
            <a href="javascript:void(0)" class="btn btn-primary pull-right createFeature">Add New</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>

    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Sl No</th>
                                <th> Chapter Name</th>
                                <th> Price</th>
                                <th class=""> Action</th>

                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($chapters as $chapter )
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$chapter->name}}</td>
                                    <td>{{$chapter->price}}</td>
                                           <td><a href="{{route('admin.chapters.edit',[$chapter->id,$chapter->courseId])}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a><a href="javascript:void(0)" data-id="{{$chapter->id}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div></td>
                              
                                    
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




@endsection

