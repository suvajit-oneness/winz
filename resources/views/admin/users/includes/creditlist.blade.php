<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover custom-data-table-style table-striped" id="sampleTable2">
                    <thead>
                        <tr>
                            <th> Sl NO </th>
                            <th> Amount </th>
                            <th> Created On </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $slno=1;  @endphp
                        @if(!empty($userdetails->creditlist))
                        @foreach($userdetails->creditlist as $payment)
                            <tr>
                                <td>{{ $slno }}</td>
                                <td><span>Rs. </span>{{ $payment->amount }}</td>
                                <td>{{ Carbon\Carbon::parse($payment->date)->format('m/d/Y h:i a') }}</td>
                            </tr>
                        @php $slno++;  @endphp
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">$('#sampleTable2').DataTable({"ordering": false});</script>
@endpush