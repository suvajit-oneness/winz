<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="general-form">
        @csrf
        <h3 class="tile-title">General</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="site_name">Site Name</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter site name"
                    id="site_name"
                    name="site_name"
                    value="{{ $setting::get('site_name') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="site_title">Site Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter site title"
                    id="site_title"
                    name="site_title"
                    value="{{ $setting::get('site_title') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="default_email_address">Default Email Address</label>
                <input
                    class="form-control"
                    type="email"
                    placeholder="Enter default email address"
                    id="default_email_address"
                    name="default_email_address"
                    value="{{ $setting::get('default_email_address') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="phone">Phone Number</label>
                <input
                    class="form-control"
                    type="email"
                    placeholder="Enter Phone Number"
                    id="phone"
                    name="phone"
                    value="{{ $setting::get('phone') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_symbol">Address</label>
                <textarea class="form-control" name="address" id="address">{{ $setting::get('address') }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_code">Home</label>
                <textarea class="form-control" name="homepage" id="homepage">{{ $setting::get('homepage') }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_code">About</label>
                <textarea class="form-control" name="aboutpage" id="aboutpage">{{ $setting::get('aboutpage') }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_code">Faq</label>
                <textarea class="form-control" name="faqpage" id="faqpage">{{ $setting::get('faqpage') }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_code">Contact</label>
                <textarea class="form-control" name="contactpage" id="contactpage">{{ $setting::get('contactpage') }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_code">Privacy</label>
                <textarea class="form-control" name="Privacy" id="Privacy">{{ $setting::get('Privacy') }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_symbol">Terms & Conditions</label>
                <textarea class="form-control" name="terms" id="terms">{{ $setting::get('terms') }}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_symbol">Cancellation policy</label>
                <textarea class="form-control" name="cancellation" id="cancellation">{{ $setting::get('cancellation') }}</textarea>
            </div>
        </div>
    </form>
</div>