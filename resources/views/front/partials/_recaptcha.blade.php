@if(config('services.recaptcha.site_key'))
<style>
    /* Hide Google's floating badge; the required disclosure is shown inside each
       form via the _recaptcha_notice partial instead. */
    .grecaptcha-badge { visibility: hidden; }

    .recaptcha-notice {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #6b7280;
        line-height: 1.4;
        margin-top: 15px;
    }
    .recaptcha-notice img { flex-shrink: 0; }
    .recaptcha-notice a { color: #6b7280; text-decoration: underline; }
    .recaptcha-notice a:hover { color: #044cb8; }
</style>
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
