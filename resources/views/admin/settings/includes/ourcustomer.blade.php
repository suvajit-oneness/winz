<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" id="ourcustomer-seo-form">
        @csrf
        <h3 class="tile-title">Faq Page Seo</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="ourcustomer_meta_title">India Meta Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Title"
                    id="ourcustomer_meta_title"
                    name="ourcustomer_meta_title"
                    value="{{ $setting::get('ourcustomer_meta_title') }}"
                />
            </div>
            <div class="form-group">
                <label class="control-label" for="ourcustomer_meta_keywords">India Meta Keywords</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter Meta Keywords"
                    id="ourcustomer_meta_keywords"
                    name="ourcustomer_meta_keywords"
                    value="{{ $setting::get('ourcustomer_meta_keywords') }}"
                />
            </div>
            
            <div class="form-group">
                <label class="control-label" for="ourcustomer_meta_description">India Meta Description</label>
                <textarea class="form-control" name="ourcustomer_meta_description" id="ourcustomer_meta_description">{{ $setting::get('ourcustomer_meta_description') }}</textarea>
            </div>
            
        </div>
    </form>
</div>