<div class="tile">
    <form id="analytics-form" action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">Currenry</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="currency_name">Currenry Name</label>
                <textarea
                    class="form-control"
                    rows="4"
                    placeholder="Enter google analytics code"
                    id="currency_name"
                    name="currency_name"
                >{!! $setting::get('currency_name') !!}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="curreny_code">Currenry Code</label>
                <textarea
                    class="form-control"
                    rows="4"
                    placeholder="Enter facebook pixel code"
                    id="curreny_code"
                    name="curreny_code"
                >{!! $setting::get('curreny_code') !!}</textarea>
            </div>
        </div>
    </form>
</div>