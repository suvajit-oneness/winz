@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css" rel="stylesheet">
<style type="text/css">
    .demo-gallery > ul {
		margin-bottom: 0;
	}
		
	.demo-gallery > ul > li a {
		border: 1px solid #ccc;
		border-radius: 3px;
		display: block;
		overflow: hidden;
		position: relative;
		float: left;
		margin: 5px 0 10px;
	}
	.demo-gallery > ul > li a > img {
		-webkit-transition: -webkit-transform 0.15s ease 0s;
		-moz-transition: -moz-transform 0.15s ease 0s;
		-o-transition: -o-transform 0.15s ease 0s;
		transition: transform 0.15s ease 0s;
		-webkit-transform: scale3d(1, 1, 1);
		transform: scale3d(1, 1, 1);
		max-height: 350px;
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

<div class="tile">
	<div class="demo-gallery">
		<ul id="lightgallery" class="lightgallery list-unstyled row">
			@forelse($single_ad->images as $key=>$image)
			<li class="col-md-3" data-src="{{ asset('storage/'.$image->image) }}" data-sub-html="">
				<a href="">
					<img class="img-responsive" src="{{ asset('storage/'.$image->getResizeImage('350x350')) }}">
				</a>
			</li>
			@empty
			No Image
			@endforelse
		</ul>
	</div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/picturefill/3.0.3/picturefill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery-all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.lightgallery').lightGallery();
	});
</script>
@endpush