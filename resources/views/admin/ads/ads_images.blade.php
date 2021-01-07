@extends('admin.app')
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css" rel="stylesheet">
<style type="text/css">
    .demo-gallery > ul {
		margin-bottom: 0;
	}
		
	.demo-gallery > ul > li a {
		border: 3px solid #FFF;
		border-radius: 3px;
		display: block;
		overflow: hidden;
		position: relative;
		float: left;
        background: #fff;
		margin: 0;
	}
	.demo-gallery > ul > li a > img {
		-webkit-transition: -webkit-transform 0.15s ease 0s;
		-moz-transition: -moz-transform 0.15s ease 0s;
		-o-transition: -o-transform 0.15s ease 0s;
		transition: transform 0.15s ease 0s;
		-webkit-transform: scale3d(1, 1, 1);
		transform: scale3d(1, 1, 1);
		min-height: 60px;
		height: 100%;
		width: 100%;
	}
	.demo-gallery > ul > li a:hover > img {
		-webkit-transform: scale3d(1.1, 1.1, 1.1);
		transform: scale3d(1.1, 1.1, 1.1);
	}
	.demo-gallery > ul > li a:hover .demo-gallery-poster > img {
		opacity: 1;
	}
	.demo-gallery > ul > li a .demo-gallery-poster {
		background-color: rgba(0, 0, 0, 0.1);
		bottom: 0;
		left: 0;
		position: absolute;
		right: 0;
		top: 0;
		-webkit-transition: background-color 0.15s ease 0s;
		-o-transition: background-color 0.15s ease 0s;
		transition: background-color 0.15s ease 0s;
	}
	.demo-gallery > ul > li a .demo-gallery-poster > img {
		left: 50%;
		margin-left: -10px;
		margin-top: -10px;
		opacity: 0;
		position: absolute;
		top: 50%;
		-webkit-transition: opacity 0.3s ease 0s;
		-o-transition: opacity 0.3s ease 0s;
		transition: opacity 0.3s ease 0s;
	}
	.demo-gallery > ul > li a:hover .demo-gallery-poster {
		background-color: rgba(0, 0, 0, 0.5);
	}
	.demo-gallery .justified-gallery > a > img {
		-webkit-transition: -webkit-transform 0.15s ease 0s;
		-moz-transition: -moz-transform 0.15s ease 0s;
		-o-transition: -o-transform 0.15s ease 0s;
		transition: transform 0.15s ease 0s;
		-webkit-transform: scale3d(1, 1, 1);
		transform: scale3d(1, 1, 1);
		height: 100%;
		width: 100%;
	}
	.demo-gallery .justified-gallery > a:hover > img {
		-webkit-transform: scale3d(1.1, 1.1, 1.1);
		transform: scale3d(1.1, 1.1, 1.1);
	}
	.demo-gallery .justified-gallery > a:hover .demo-gallery-poster > img {
		opacity: 1;
	}
	.demo-gallery .justified-gallery > a .demo-gallery-poster {
		background-color: rgba(0, 0, 0, 0.1);
		bottom: 0;
		left: 0;
		position: absolute;
		right: 0;
		top: 0;
		-webkit-transition: background-color 0.15s ease 0s;
		-o-transition: background-color 0.15s ease 0s;
		transition: background-color 0.15s ease 0s;
	}
	.demo-gallery .justified-gallery > a .demo-gallery-poster > img {
		left: 50%;
		margin-left: -10px;
		margin-top: -10px;
		opacity: 0;
		position: absolute;
		top: 50%;
		-webkit-transition: opacity 0.3s ease 0s;
		-o-transition: opacity 0.3s ease 0s;
		transition: opacity 0.3s ease 0s;
	}
	.demo-gallery .justified-gallery > a:hover .demo-gallery-poster {
		background-color: rgba(0, 0, 0, 0.5);
	}
	.demo-gallery .video .demo-gallery-poster img {
		height: 48px;
		margin-left: -24px;
		margin-top: -24px;
		opacity: 0.8;
		width: 48px;
	}
	.demo-gallery.dark > ul > li a {
		border: 3px solid #04070a;
	}
	.home .demo-gallery {
		padding-bottom: 80px;
	}
</style>
@endpush
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <p>{{ $subTitle }}</p>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead style="display:none;">
							<tr>
								<th>Title</th>
							</tr>
                        </thead>
                        <tbody>
                            @foreach($images as $ad)
							<tr>
								<td>
									<div class="demo-gallery">
										<h4>{{$ad->title}}</h4>
										<ul id="lightgallery-{{$ad->id}}" class="lightgallery add-gallery list-unstyled row">
											@forelse($ad->images as $ad_image)
											<li class="gallery-card" data-src="{{ asset('storage/'.$ad_image->image) }}" data-sub-html="">
												<a href="">
													<img class="img-responsive" src="{{ asset('storage/'.$ad_image->getResizeImage('60x60')) }}">
												</a>
											</li>
											@empty
											No Image
											@endforelse
											@if (count($ad->images) > 5)
											<div class="form-group gallery-bx clearfix">
											<a href="javascript:void(0)" class="more_images" id="more_image" data-target="{{$ad->id}}">+ More Images</a>
											</div>
											@endif
										</ul>
									</div>
								</td>
							</tr>
                            @endforeach
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/picturefill/3.0.3/picturefill.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery-all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
   <script type="text/javascript">
        $(document).ready(function(){
            $('.lightgallery').lightGallery();
        });

		$(document).on("click", "#more_image", function(){
			var target = $(this).data('target');
			var target_gallery = "lightgallery-"+target;
			$("#"+target_gallery+" a:first-child > img").trigger("click");
		});
    </script>
    
@endpush