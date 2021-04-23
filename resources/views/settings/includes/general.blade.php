<div class="tile">
    <form action="{{ route('settings.update') }}" method="POST" role="form">
        {{-- CSRF: Cross-site request forgery --}}
        @csrf
        <h3 class="tile-title">{{ __('General Settings') }}</h3>
        <hr>
        <div class="tile-body">            
            <div class="form-group">
                <label class="control-label" for="default_email_address">{{ __('Email Address') }}</label>
                <input class="form-control" type="text" placeholder="Enter email address" name="default_email_address"
                    id="default_email_address" value="{{ config('settings.default_email_address') }}">
            </div>
            <div class="form-group">
                <label class="control-label" for="phone_no">{{ __('Contact No') }}</label>
                <input class="form-control" type="text" placeholder="Enter Contact No" name="phone_no" id="phone_no"
                    value="{{ config('settings.phone_no') }}">
            </div>
            <div class="form-group">
                <label class="control-label" for="contact_address">{{ __('Contact Address') }}</label>
                <input class="form-control" type="text" placeholder="Enter Contact Address" name="contact_address"
                    id="contact_address" value="{{ config('settings.contact_address') }}">
            </div>           
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('Update
                        Settings') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>