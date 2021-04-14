<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="home-seo-form">
        @csrf
        <h3 class="tile-title">Homepage Seo</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="meta_title">Meta Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Title"
                    id="meta_title"
                    name="meta_title"
                    value="{{ $setting::get('meta_title') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="meta_keywords">Meta Keywords</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Keywords"
                    id="meta_keywords"
                    name="meta_keywords"
                    value="{{ $setting::get('meta_keywords') }}"
                />
            </div>
            
            <div class="form-group">
                <label class="control-label" for="meta_description">Meta Description</label>
                <textarea class="form-control ckeditor" name="meta_description" id="meta_description">{{ $setting::get('meta_description') }}</textarea>
            </div>
            
        </div>
    </form>
</div>