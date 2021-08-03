<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="replacement-seo-form">
        @csrf
        <h3 class="tile-title">Refund Policy Page</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="replacement_meta_title">Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Title"
                    id="replacement_meta_title"
                    name="replacement_meta_title"
                    value="{{ $setting::get('replacement_meta_title') }}"/>
            </div>
            <div class="form-group">
                <label class="control-label" for="replacement_meta_keywords">Keywords</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Keywords"
                    id="replacement_meta_keywords"
                    name="replacement_meta_keywords"
                    value="{{ $setting::get('replacement_meta_keywords') }}"/>
            </div>
            
            <div class="form-group">
                <label class="control-label" for="replacement_meta_description">Description</label>
                <textarea class="form-control ckeditor" name="replacement_meta_description" id="replacement_meta_description">{{ $setting::get('replacement_meta_description') }}</textarea>
            </div>
            
        </div>
    </form>
</div>