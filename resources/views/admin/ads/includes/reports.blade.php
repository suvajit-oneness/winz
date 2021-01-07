<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover custom-data-table-style table-striped" id="sampleTable2">
                    <thead>
                    <tr>
                        <th>Reported By</th>
                        <th>Reason</th>
                        <th>Reported On</th>
                        <th>View</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $key=>$report)
                            <tr>
                                <td>{{ $report->user->name }}</td>
                                <td>{{ substr($report->reason,0,15) }}...</td>
                                <td>{{ Carbon\Carbon::parse($report->created_at)->format('m/d/Y h:i a') }}</td>
                                <td>
                                    <a href="javascript:void(0)"  data-toggle="modal" data-target="#reportDetails{{$report->id}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @foreach($reports as $key => $report)
                        <div class="modal fade gallery_modal" id="reportDetails{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-body full-bx">
                            <div class="modal-header modal--popup">
                                <h4 class="modal-title aa" id="exampleModalLabel">{{$report->ad->title}}</h4>
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            <div class="row">
<!--                                <p style="margin-left: 4%;">Ad Id : {{$report->ad->unique_id}}</p>-->
<!--
                                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                                    <tbody>
                                        <tr>
                                            <td>Reported By</td>
                                            <td>{{ empty($report->user->name)? null:$report->user->name }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Reason</td>
                                            <td>{{ empty($report->reason)? null:$report->reason }}</td>
                                        </tr>
                                        <tr>
                                            <td>Reported On</td>
                                            <td>{{ Carbon\Carbon::parse($report->created_at)->format('m/d/Y h:i a') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
-->
                               <div class="modal-block modal-popup-inner">
                                   <div class="sender-details">
                                      <strong>Reported By:</strong> {{ empty($report->user->name)? null:$report->user->name }} 
                                  </div>
                                  <div class="sender-msg">
                                     <strong>Reason: </strong>
                                      {{ empty($report->reason)? null:$report->reason }}
                                  </div>
                                  <div class="posted-date">
                                      <span>Reported On:</span>
                                       {{ Carbon\Carbon::parse($report->created_at)->format('m/d/Y h:i a') }}
                                  </div>
                               </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable2').DataTable({"ordering": false});
</script>
@endpush