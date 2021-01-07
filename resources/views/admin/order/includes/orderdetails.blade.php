<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover custom-data-table-style table-striped" id="sampleTable1">
                    <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Unit Cost</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $slno = 1; @endphp
                        @foreach($bookingProducts as $ad)
                            <tr>
                                <td> {{ $slno }} </td>
                                <td> {{ $ad->product_name }} </td>
                                <td> {{ $ad->product_brand }} </td>
                                <td> {{ $ad->quantity }} </td>
                                <td> {{ $ad->price }} </td>
                                <td> {{ $ad->price * $ad->quantity }} </td>
                            </tr>
                            @php $slno ++; @endphp
                        @endforeach

                               <tr>
                                <td colspan="4"></td>
                                <td>Basic Amount</td>
                                <td>{{  $booking->amount }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>GST</td>
                                <td>{{  $booking->tax_amount }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Discount Amount</td>
                                <td>{{  $booking->discount_amount }}</td>
                            </tr>
                             <tr>
                                <td colspan="4"></td>

                                <td>Shipping Charge<br><span style="display: block;font-size: 10px;">(Weight : {{ $booking->total_weight}} gm.)</span></td>
                                <td>{{  $booking->shipping_charge }}</td>
                            </tr>
                             <tr>
                                <td colspan="4"></td>
                                <td>Express Delivery Charge</td>
                                <td>{{  $booking->express_charge }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>COD Charge</td>
                                <td>{{  $booking->cod_charge }}</td>
                            </tr>

                            <tr>
                                <td colspan="4"></td>
                                <td>Total Amount</td>
                                <td>{{  $booking->total_amount + $booking->tax_amount }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Paid Amount</td>
                                <td>{{  $booking->paid_amount }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Due Amount</td>
                                <td>{{  ($booking->total_amount + $booking->tax_amount) - $booking->paid_amount }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">$('#sampleTable1').DataTable({"ordering": false});</script>
@endpush