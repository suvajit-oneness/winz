@extends('admin.app')
@section('title') Questions @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file-text"></i> Questions</h1>
                <p>list of Questions</p>
            </div>
            
            <a href="{{ route('admin.question.create',[$chapterId,$subChapterId]) }}" class="btn btn-primary pull-right">Add New</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body" style="margin-top: 55px;">
                    <table class="table table-hover custom-data-table-style table-striped" id="">
                        <thead>
                        <tr>
                            <td width="15%">Question</td>
                            <td>Subject Category</td>
                            <td>Sub Chapter</td>
                            <td>Answers1</td>
                            <td>Answers1</td>
                            <td>Answers1</td>
                            <td>Answers1</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td><img src="{{asset($question->question)}}" height="100" width="200"></td>
                                    <td>{{$question->chapter->name}}</td>
                                    <td>{{$question->subChapter->name}}</td>
                                    <td>
                                        @if($question->answer1 != '')
                                        <a href="{{$question->answer1}}" target="_blank">Answer 1</a>
                                        @else
                                        {{('N/A')}}
                                        @endif
                                    </td>
                                    <td>
                                        {{($question->answer1 ? !!'<a href="$question->answer1" target="_blank">Answer 1</a>' : 'N/A')}}
                                    </td>
                                    <td>
                                        {{($question->answer1 ? !!'<a href="$question->answer1" target="_blank">Answer 1</a>' : 'N/A')}}
                                    </td>
                                   <td>
                                        {{($question->answer1 ? !!'<a href="$question->answer1" target="_blank">Answer 1</a>' : 'N/A')}}
                                    </td>
                                    <th><a href="{{route('admin.question.edit',[$question->chapter->id,$question->subchapter->id,$question->id])}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" data-id="{{$question->id}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div></th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {!! $questions->links() !!}
  

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

        $(document).on('click','.sa-remove',function(){
                var questionId = $(this).data('id');
                swal({
                  title: "Are you sure?",
                  text: "Your will not be able to recover the record!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Yes, delete it!",
                  closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = questionId+"/delete";
                    } else {
                      swal("Cancelled", "Record is safe", "error");
                    }
                });
            });
    </script>
@endpush