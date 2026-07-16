@if(config('services.recaptcha.site_key'))
    {{-- In-form reCAPTCHA v3 disclosure. Google allows hiding the floating badge
         as long as this notice is shown near the submit action of each form. --}}
    <div class="recaptcha-notice text-13">
        <img src="https://www.gstatic.com/recaptcha/api2/logo_48.png" alt="reCAPTCHA" width="24" height="24">
        <span>
            Protected by reCAPTCHA &mdash; Google
            <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a>
            and
            <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms</a>
            apply.
        </span>
    </div>
@endif
