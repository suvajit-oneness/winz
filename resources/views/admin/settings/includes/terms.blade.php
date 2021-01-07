<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="terms-seo-form">
        @csrf
        <h3 class="tile-title">Terms Page Seo</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="terms_meta_title">India Meta Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Title"
                    id="terms_meta_title"
                    name="terms_meta_title"
                    value="{{ $setting::get('terms_meta_title') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="terms_meta_keywords">India Meta Keywords</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Keywords"
                    id="terms_meta_keywords"
                    name="terms_meta_keywords"
                    value="{{ $setting::get('terms_meta_keywords') }}"
                />
            </div>
            
            <div class="form-group">
                <label class="control-label" for="terms_meta_description">India Meta Description</label>
                <textarea class="form-control" name="terms_meta_description" id="terms_meta_description">{{ $setting::get('terms_meta_description') }}</textarea>
            </div>
            
        </div>
    </form>
</div>