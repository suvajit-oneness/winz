<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover custom-data-table-style table-striped" id="sampleTable2">
                    <thead>
                        <tr>
                            <th> Sl NO </th>
                            <th> Package </th>
                            <th> Amount </th>
                            <th> User Name </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $slno=1;  @endphp
                        @if(!empty($targetmembership->user))
                        @foreach($targetmembership->user as $payment)
                            <tr>
                                <td>{{ $slno }}</td>
                                <td>{{ empty($targetmembership->title) ? '' : $targetmembership->title }}</td>
                                <td>{{ empty($targetmembership->price) ? '' : $targetmembership->price }}</td>
                                <td>{{ $payment->name }}</td>
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