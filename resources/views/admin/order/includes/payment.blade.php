<div class="tile">
    <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
        <tbody>
            <tr>
                <td>Address</td>
                <td>{{ $booking->shipping_address }}</td>
            </tr>
            <tr>
                <td>Pin Code</td>
                <td>{{ $booking->shipping_pin }}</td>
            </tr>
            <tr>
                <td>Landmark</td>
                <td>{{ $booking->shipping_landmark }}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{ $booking->shipping_city }}</td>
            </tr>
            <tr>
                <td>State</td>
                <td>{{ $booking->shipping_state }}</td>
            </tr>
            <tr>
                <td>Country</td>
                <td>{{ $booking->shipping_country }}</td>
            </tr>
        </tbody>
    </table>
</div>