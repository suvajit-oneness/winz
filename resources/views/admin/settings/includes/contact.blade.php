<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="contact-seo-form">
        @csrf
        <h3 class="tile-title">Contact Page Seo</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="contact_meta_title">India Meta Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Title"
                    id="contact_meta_title"
                    name="contact_meta_title"
                    value="{{ $setting::get('contact_meta_title') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="contact_meta_keywords">India Meta Keywords</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Keywords"
                    id="contact_meta_keywords"
                    name="contact_meta_keywords"
                    value="{{ $setting::get('contact_meta_keywords') }}"
                />
            </div>
            
            <div class="form-group">
                <label class="control-label" for="contact_meta_description">India Meta Description</label>
                <textarea class="form-control" name="contact_meta_description" id="contact_meta_description">{{ $setting::get('contact_meta_description') }}</textarea>
            </div>
            
        </div>
    </form>
</div>