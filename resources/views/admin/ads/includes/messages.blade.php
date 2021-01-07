<div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable_msg">
                        <thead>
                        <tr>
                            <th>Posted By</th>
                            <th>Message</th>
                            <th>Messaged On</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $key => $message)
                                <tr>
                                    <td>{{ $message->email }}</td>
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
                                        <strong>{{ $subject_string }}</strong><br />{{ $msg_string }}</td>
                                    <td>{{ Carbon\Carbon::parse($message->created_at)->format('m/d/Y h:i a') }}</td>
                                    <td>
                                        <a href="javascript:void(0)"  data-toggle="modal" data-target="#messageDetails{{$message->id}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>

                    @foreach($messages as $key => $message)
                        <div class="modal fade gallery_modal" id="messageDetails{{$message->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-body full-bx">
                            <div class="modal-header modal--popup">
                                <h4 class="modal-title" id="exampleModalLabel"><!-- {{$message->ad->title}} -->
                                {{ empty($message->subject)? null:$message->subject }}
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            <div class="row">
<!--
                                <p style="margin-left: 4%;">Ad Id : {{$message->ad->unique_id}}</p>
                                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                                    <tbody>
                                        <tr>
                                            <td>Posted By</td>
                                            <td><a href="mailto:{{ empty($message->email)? null:$message->email }}">{{ empty($message->email)? null:$message->email }}</a></td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td><a href="tel:{{ empty($message->phone)? null:$message->phone }}">{{ empty($message->phone)? null:$message->phone }}</a></td>
                                        </tr>
                                        <tr>
                                            <td>Subject</td>
                                            <td>{{ empty($message->subject)? null:$message->subject }}</td>
                                        </tr>
                                        <tr>
                                            <td>Message</td>
                                            <td>{{ empty($message->message)? null:$message->message }}</td>
                                        </tr>
                                        <tr>
                                            <td>Posted On</td>
                                            <td>{{ Carbon\Carbon::parse($message->created_at)->format('m/d/Y h:i a') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
-->
                                <div class="modal-block modal-popup-inner">
                                  <div class="sender-details">
                                      <strong>From:</strong> <a href="mailto:{{ empty($message->email)? null:$message->email }}">{{ empty($message->email)? null:$message->email }}</a> <i class="bullet">&nbsp;</i><strong>Phone:</strong> <a href="tel:{{ empty($message->phone)? null:$message->phone }}">{{ empty($message->phone)? null:$message->phone }}</a>
                                  </div>
                                  <div class="sender-msg">
                                      {{ empty($message->message)? null:$message->message }}
                                  </div>
                                  <div class="posted-date">
                                      <span>Posted On :</span>
                                       {{ Carbon\Carbon::parse($message->created_at)->format('m/d/Y h:i a') }}
                                  </div>
                               </div>
                                <!--modalblockend-->
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
    <script type="text/javascript">$('#sampleTable_msg').DataTable({"ordering": false});
</script>
@endpush