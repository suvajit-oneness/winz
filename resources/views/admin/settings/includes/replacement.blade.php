<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="replacement-seo-form">
        @csrf
        <h3 class="tile-title">Cancellation Policy Page Seo</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="replacement_meta_title">India Meta Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Title"
                    id="replacement_meta_title"
                    name="replacement_meta_title"
                    value="{{ $setting::get('replacement_meta_title') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="replacement_meta_keywords">India Meta Keywords</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Keywords"
                    id="replacement_meta_keywords"
                    name="replacement_meta_keywords"
                    value="{{ $setting::get('replacement_meta_keywords') }}"
                />
            </div>
            
            <div class="form-group">
                <label class="control-label" for="replacement_meta_description">India Meta Description</label>
                <textarea class="form-control" name="replacement_meta_description" id="replacement_meta_description">{{ $setting::get('replacement_meta_description') }}</textarea>
            </div>
            
        </div>
    </form>
</div>