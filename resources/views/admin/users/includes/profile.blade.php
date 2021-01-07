<div class="tile">
    <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
        <tbody>
            <tr>
                <td>Name</td>
                <td>{{ $userdetails->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td><a href="mailto:{{ $userdetails->email }}">{{ $userdetails->email }}</a></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><a href="tel:{{ empty($userdetails->mobile)? null:$userdetails->mobile }}">{{ empty($userdetails->mobile)? null:$userdetails->mobile }}</a></td>
            </tr>
            <tr>
                <td>Membership Plan</td>
                <td>{{ empty($userdetails->membership)? null: $userdetails->membership->title }}</td>
            </tr>
        </tbody>
    </table>
</div>