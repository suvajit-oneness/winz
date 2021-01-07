@extends('site.app')
@section('content')
@php
$words = explode(" ", Auth::guard('web')->user()->name);
$acronym = "";

foreach ($words as $w) {
  $acronym .= $w[0];
}
@endphp
 <div class="container-fluid">
    <div class="row profile-top">
      <div class="col-md-3 lite-bg">
        <div class="profile-box">
         <div class="list-group ">
              
              <a href="{{route('site.profile')}}" class="list-group-item list-group-item-action">Edit Profile</a>
              <a href="{{route('site.allsubscription')}}" class="list-group-item list-group-item-action">All Subscriptions</a>
              <a href="{{route('site.subscription')}}"class="list-group-item list-group-item-action">PPC Subscriptions</a>
              <a href="{!! URL::to('logout') !!}" class="list-group-item list-group-item-action">Logout</a>
            </div> 
          </div>
      </div>

      <div class="col-md-9">
          <div class="card deep-bf">
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-12">
                          <h4 class="line-bottom">Your Profile</h4>
                          <hr>
                      </div>
                      <div class="col-md-6">
                         
                      @if(session()->has('message'))
                        <div class="alert alert-success">
                           {{ session()->get('message') }}
                        </div>
                      @endif
                      @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                      @endif
                    </div>
                  </div>
                  <div class="row">

                    <div class="col-md-4">
                      <div class="media">
                        <div class="round mr-3">{{$acronym}} </div>
                        <div class="media-body">
                            <h5 class="mt-0 hello">Hello</h5>
                            {{Auth::guard('web')->user()->mobile}}
                            <!--<p class="edit">Edit Profile</p>-->
                        </div>
                      </div>
                    </div>

                    <div class="col-md-8">
                        <form action="{{route('site.profileupdate')}}" method="post">
                            @csrf
                              <div class="form-group row">
                                <label for="username" class="col-4 col-form-label">Name*</label> 
                                <div class="col-8">
                                  <input id="username" name="name" placeholder="Name" class="form-control here" required="required" type="text" value="{{ old('name',Auth::guard('web')->user()->name) }}">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="name" class="col-4 col-form-label">Email</label> 
                                <div class="col-8">
                                  <input id="email" name="email" placeholder="Email" class="form-control here" required="required" type="text" value="{{ old('email',Auth::guard('web')->user()->email) }}" readonly>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="country" class="col-4 col-form-label">Country</label> 
                                <div class="col-8">
                                  <input id="country" name="country" placeholder="Country" class="form-control here" required="required" type="text" value="{{ old('country',Auth::guard('web')->user()->country) }}">
                                </div>
                              </div>
                              
                              <div class="form-group row">
                                <label for="city" class="col-4 col-form-label">City</label> 
                                <div class="col-8">
                                  <input id="city" name="city" placeholder="City" class="form-control here" required="required" type="text" value="{{ old('city',Auth::guard('web')->user()->city) }}">
                                </div>
                              </div>
                              
                              <div class="form-group row">
                                <label for="address" class="col-4 col-form-label">Address</label> 
                                <div class="col-8">
                                  <textarea id="address" name="address" cols="40" rows="6" required="required" class="form-control">{{ old('address',Auth::guard('web')->user()->address) }}</textarea>
                                </div>
                              </div>
                              
                              <div class="form-group row">
                                <div class="offset-4 col-8">
                                  <button type="submit" class="loginbtn mt-40">Update My Profile</button>
                                </div>
                              </div>
                            </form>
                    </div>

                  </div>
                  
              </div>
              
          </div>
      </div>
    </div>
  </div>

 @endsection

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.pricing_slider').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: true,
          arrows: false,
        });

        $('.banner_slider').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          slidesToShow: 1,
          centerMode: true,
          variableWidth: true,
          autoplay: true,
          arrows: false,
        });
        $(".movies_slider").slick({
          dots: false,
          slidesToShow: 5,
          slidesToScroll: 1,
          centerMode: true,
        });
        $(".comming_slider").slick({
        dots: false,
          slidesToShow: 8,
          slidesToScroll: 1,
          centerMode: true,
        });

        $(document).on("click", ".toggle_search" , function() {
          $('.header_search').toggleClass('open');
          $('body').toggleClass('hide_scroll');
        });
        $(document).on("click", ".header_search .close" , function() {
          $('.header_search').toggleClass('open');
          $('body').toggleClass('hide_scroll');
        });
        $(document).on("click", ".toggle_menu" , function() {
          $(this).toggleClass('open');
          $('.full_menu').toggleClass('show');
          $('body').toggleClass('hide_scroll');
        });
      });
    </script>
  </body>
</html>