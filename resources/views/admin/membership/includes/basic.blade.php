<div class="tile">
    <table class="table table-hover custom-data-table-style table-striped table-col-width" id="basic">
        <tbody>
            <tr>
                <td>Package Name</td>
                <td>{{ $targetmembership->title }}</td>
            </tr>
            <tr>
                <td>Details</td>
                <td>{!! $targetmembership->description !!}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>{{ $targetmembership->price }}</td>
            </tr>
        </tbody>
    </table>
</div>