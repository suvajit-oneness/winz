<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="cancellation-seo-form">
        @csrf
        <h3 class="tile-title">Cancellation Policy Page</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="cancellation_meta_title">Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Title"
                    id="cancellation_meta_title"
                    name="cancellation_meta_title"
                    value="{{ $setting::get('cancellation_meta_title') }}"/>
            </div>
            <div class="form-group">
                <label class="control-label" for="cancellation_meta_keywords">Keywords</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Keywords"
                    id="cancellation_meta_keywords"
                    name="cancellation_meta_keywords"
                    value="{{ $setting::get('cancellation_meta_keywords') }}"/>
            </div>
            
            <div class="form-group">
                <label class="control-label" for="cancellation_meta_description">Description</label>
                <textarea class="form-control ckeditor" name="cancellation_meta_description" id="cancellation_meta_description">{{ $setting::get('cancellation_meta_description') }}</textarea>
            </div>
            
        </div>
    </form>
</div>