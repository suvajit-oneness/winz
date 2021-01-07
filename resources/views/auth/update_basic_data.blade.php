<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css')}}">

    <title>Phoneflix</title>
  </head>
  <body>
    <div class="login_wrap">
      <div class="login_left">
        <div class="login_box">
          <img src="{!!asset('frontend/images/logo.png')!!}" class="login_logo">
          <h2>Basic Profile</h2>
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
          <form id="loginForm" method="post" action="{!! URL::to('submit-basic-data') !!}">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <div class="form-group">
              <label class="control-label">Enter Name</label>
              <input type="text" name="name" placeholder="Enter Name" class="form-control" required="required">
            </div>
            <div class="form-group">
              <label class="control-label">Enter Email Id</label>
              <input type="email" name="email" placeholder="Enter Email Id" class="form-control" required="required">
            </div>
            <!-- <div class="form-group">
              <p><a href="#" class="text-uppercase">Forgot Password ?</a></p>
            </div> -->
            <div class="form-group mb-0">
              <input type="submit" name="" value="Continue" class="loginbtn">
            </div>
          </form>
         <!--  <p>Don't have an account? <a href="register.html">Sign Up</a></p> -->
        </div>
      </div>

      <div class="login_right">
        <div class="login_slider">

          <div class="item">
            <div class="login_slides" style="background-image: url({!!asset('frontend/images/banner.png')!!});">
              <div class="slider_content">
                <div class="row">
                  <div class="col-sm-8">
                    <h4>1914 translation by H. Rackham</h4>
                    <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system</p>
                    <a href="#">Watch Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <div class="item">
          <div class="login_slides" style="background-image: url({!!asset('frontend/images/banner2.jpg')!!});">
            <div class="slider_content">
              <div class="row">
                <div class="col-sm-8">
                  <h4>1914 translation by H. Rackham</h4>
                  <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system</p>
                  <a href="#">Watch Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.login_slider').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: true,
          arrows: false,
        });
      });
    </script>
  </body>
</html>