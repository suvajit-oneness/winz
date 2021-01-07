@extends('site.app')
@section('content')


 <div class="container-fluid">
    <div class="row profile-top">
      <div class="col-md-3 lite-bg">
        <div class="profile-box">
         <div class="list-group ">
              
              <a href="{{route('site.profile')}}" class="list-group-item list-group-item-action">Edit Profile</a>
              <a href="{{route('site.allsubscription')}}" class="list-group-item list-group-item-action">All Subscriptions</a>
              <a href="{{route('site.subscription')}}" class="list-group-item list-group-item-action">PPC Subscriptions</a>
              <a href="{!! URL::to('logout') !!}" class="list-group-item list-group-item-action">Logout</a>
            </div> 
          </div>
      </div>

      <div class="col-md-9">
          <div class="card deep-bf">
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-12">
                          <h4 class="line-bottom">All Subscriptions</h4>
                          <hr>
                      </div>
                  </div>
                  
                  
              </div>
              <table class="table tabel-color">
                <thead>
                    <tr>
                      <th scope="col">Sl No</th>
                      <th scope="col">Package Name</th>
                      <th scope="col">Price</th>
                      <th scope="col">Valid Upto</th>
                      <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @php $slno = 1; @endphp
                    @if(count($allsubscription))
                    @foreach($allsubscription as $data)
                    <tr>
                      <th scope="row">{{$slno}}</th>
                      <td>{{$data->package->name}}</td>
                      <td>{{$data->package->offered_price}}</td>
                      <td>{{ date('d-M-Y',strtotime($data->subscription_end_date))}}</td>
                      <td>{{date('d-M-Y',strtotime($data->created_at))}}</td>
                    </tr>
                     @php $slno = $slno + 1; @endphp 
                     @endforeach
                     @else
                     <td colspan="5" style="text-align: center;">No data found</td>
                     @endif
                </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
 @endsection