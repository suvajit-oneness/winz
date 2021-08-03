@extends('admin.app')

@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-cogs"></i> {{ $pageTitle }}</h1>
                <div class="form-group">
                <button class="btn btn-primary" id="btnSave" type="button"><i class="fa fa-check-circle"></i>Update <span id="btn-name"></span> Settings</button>
                <a class="btn btn-secondary" href="{{ URL::previous() }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
            </div>
        </div>
        <div class="user">
            <div class="col-md-12 nopadding">
                <div class="tile p-0">
                    <ul class="nav nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                        
                        <li class="nav-item"><a class="nav-link" href="#home-seo" data-toggle="tab">Home Page</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about-seo" data-toggle="tab">About Page</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="#contact-seo" data-toggle="tab">Contact Page</a></li> -->
                        <li class="nav-item"><a class="nav-link" href="#faq-seo" data-toggle="tab">Faq Page</a></li>
                        <li class="nav-item"><a class="nav-link" href="#terms-seo" data-toggle="tab">Terms & Conditions Page</a></li>
                        <li class="nav-item"><a class="nav-link" href="#shipping-seo" data-toggle="tab">Privacy Policy Page</a></li>
                        <li class="nav-item"><a class="nav-link" href="#cancellation-seo" data-toggle="tab">Cancellation Policy Page</a></li>
                        <li class="nav-item"><a class="nav-link" href="#replacement-seo" data-toggle="tab">Replacement Policy Page</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="#social-links" data-toggle="tab">Social Links</a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row row-md-body">
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    @include('admin.settings.includes.general')
                </div>
                <div class="tab-pane fade" id="home-seo">
                    @include('admin.settings.includes.homeseo')
                </div>
                <div class="tab-pane fade" id="about-seo">
                    @include('admin.settings.includes.about')
                </div>
                <!-- <div class="tab-pane fade" id="contact-seo">
                    @include('admin.settings.includes.contact')
                </div> -->
                <div class="tab-pane fade" id="faq-seo">
                    @include('admin.settings.includes.faq')
                </div>
                <div class="tab-pane fade" id="shipping-seo">
                    @include('admin.settings.includes.shipping')
                </div>
                <div class="tab-pane fade" id="terms-seo">
                    @include('admin.settings.includes.terms')
                </div>
                <div class="tab-pane fade" id="replacement-seo">
                    @include('admin.settings.includes.replacement')
                </div>

                <div class="tab-pane fade" id="cancellation-seo">
                    @include('admin.settings.includes.cancellation')
                </div>
                
                <div class="tab-pane fade" id="ourcustomer-seo">
                    @include('admin.settings.includes.ourcustomer')
                </div>
                <div class="tab-pane fade" id="payments">
                    @include('admin.settings.includes.payments')
                </div>
                <div class="tab-pane fade" id="Currency">
                    @include('admin.settings.includes.currency')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="{{ asset('backend/js/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
$(function(){
    var hash = $('.nav-tabs a.active').attr('href');
    var activeTab = $('.nav-tabs a.active').text();
    $("#btn-name").text(activeTab);
    //hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $("#btnSave").on("click",function(){
        $(hash+"-form").submit();
    });

    $('.nav-tabs a').click(function (e) {
        activeTab = $(this).text();
        hash = $(this).attr('href');
        $("#btn-name").text(activeTab);
    });
});
</script>
@endpush