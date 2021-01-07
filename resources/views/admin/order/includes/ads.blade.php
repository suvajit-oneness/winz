<div class="tile">
    <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
        <tbody>
            <tr>
                <td>Address</td>
                <td>{{ $booking->billing_address }}</td>
            </tr>
            <tr>
                <td>Pin Code</td>
                <td>{{ $booking->billing_pin }}</td>
            </tr>
            <tr>
                <td>Landmark</td>
                <td>{{ $booking->billing_landmark }}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{ $booking->billing_city }}</td>
            </tr>
            <tr>
                <td>State</td>
                <td>{{ $booking->billing_state }}</td>
            </tr>
            <tr>
                <td>Country</td>
                <td>{{ $booking->billing_country }}</td>
            </tr>
        </tbody>
    </table>
</div>