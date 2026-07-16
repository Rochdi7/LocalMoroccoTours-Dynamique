@if(config('services.recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" defer></script>
<script>
    // Attaches an invisible reCAPTCHA v3 token to every <form data-recaptcha-action="...">
    // right before submit. The action name must match the `recaptcha:<action>` middleware
    // argument on the matching route (see routes/web.php) so Google's action check passes.
    document.addEventListener('DOMContentLoaded', function () {
        var siteKey = @json(config('services.recaptcha.site_key'));

        document.querySelectorAll('form[data-recaptcha-action]').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (form.dataset.recaptchaVerified === 'true') {
                    return;
                }

                event.preventDefault();
                var action = form.dataset.recaptchaAction;

                if (typeof grecaptcha === 'undefined') {
                    form.dataset.recaptchaVerified = 'true';
                    form.submit();
                    return;
                }

                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, { action: action }).then(function (token) {
                        var input = form.querySelector('input[name="g-recaptcha-response"]');
                        if (!input) {
                            input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'g-recaptcha-response';
                            form.appendChild(input);
                        }
                        input.value = token;
                        form.dataset.recaptchaVerified = 'true';
                        form.submit();
                    });
                });
            });
        });
    });
</script>
@endif
