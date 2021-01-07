<div class="tile">
    <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
        <tbody>
            <tr>
                <td>Order Id</td>
                <td>{{ $booking->unique_code }}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{ $booking->name }}</td>
            </tr>
            <tr>
                <td>Email Id</td>
                <td>{{ $booking->email }}</td>
            </tr>
            <tr>
                <td>Mobile No</td>
                <td>{{ $booking->mobile }}</td>
            </tr>
            <tr>
                <td>MAC Address</td>
                <td>{{ $booking->mac }}</td>
            </tr>
            <tr>
                <td>Order Date</td>
                <td>{{ date("d-M -Y", strtotime($booking->order_date_time) ) }} </td>
            </tr>
            <tr>
                <td>Used Coupon</td>
                <td>{{ $booking->coupon_code }}</td>
            </tr>
            <tr>
                <td>Total Weight</td>
                <td>{{ $booking->total_weight }} gms.</td>
            </tr>
            <tr>
                <td>Basic Amount</td>
                <td>{{ $booking->amount }}</td>
            </tr>
            <tr>
                <td>Discount Amount</td>
                <td>{{ $booking->discount_amount }}</td>
            </tr>
            <tr>
                <td>Tax Amount</td>
                <td>{{ $booking->tax_amount }}</td>
            </tr>
            <tr>
                <td>Shipping Charge</td>
                <td>{{ $booking->shipping_charge }}</td>
            </tr>
            <tr>
                <td>Express Delivery Charge</td>
                <td>{{ $booking->express_charge }}</td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td>{{ $booking->total_amount }}</td>
            </tr>
            <tr>
            <td>Payment Mode</td>
            <td>
                @if($booking->payment_mode==1){{'Online Payment'}}
                @elseif($booking->payment_mode==2){{'With Wallet'}}
                @elseif($booking->payment_mode==3){{'COD'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Payment Done</td>
            <td>
                @if ($booking->is_paid == 1)
                    {{ 'Yes' }} 
                @else 
                    {{ 'No' }} 
                @endif
            </td>
        </tr>
        </tbody>
    </table>
</div>