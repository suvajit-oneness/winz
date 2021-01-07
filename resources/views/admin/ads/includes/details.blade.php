<div class="tile">
    <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
        <tbody>
            <tr>
                <td>Category</td>
                <td>{{ empty($single_ad->category->name)? null:$single_ad->category->name }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{{ empty($single_ad->description)? null:$single_ad->description }}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td><span>£</span>{{ empty($single_ad->payment[0]->amount)? null:$single_ad->payment[0]->amount }}</td>
            </tr>
            <tr>
                <td>Package</td>
                <td>{{ empty($single_ad->package_name)? null:$single_ad->package_name }}</td>
            </tr>
            <tr>
                <td>Add On</td>
                <td>
                    @if(count($add_on_details))
                    <ol class="adon-list">
                        @foreach ($add_on_details as $add_on_detail) 
                        <li>
                            {{$add_on_detail->add_on_name}} (Expiry Date: {{ Carbon\Carbon::parse($add_on_detail->expiry_date)->format('m/d/Y') }})   
                        </li>    
                        @endforeach                   
                    </ol>
                    @else
                    N/A  
                    @endif
                </td>
            </tr>
            <tr>
                <td>Country</td>
                <td>{{ empty($single_ad->country->name)? null:$single_ad->country->name }}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{ empty($single_ad->city)? null:$single_ad->city }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><a href="tel:{{ empty($single_ad->phone)? null:$single_ad->phone }}">{{ empty($single_ad->phone)? null:$single_ad->phone }}</a></td>
            </tr>
            <tr>
                <td>Website</td>
                <td><a href="{{ empty($single_ad->website)? null:$single_ad->website }}" target="_blank">{{ empty($single_ad->website)? null:$single_ad->website }}</a></td>
            </tr>
            
        </tbody>
    </table>
</div>