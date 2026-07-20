// Lightweight content-protection deterrent: blocks right-click, text selection,
// copy/cut/paste, and common DevTools/view-source keyboard shortcuts.
// Deliberately does NOT touch the DOM, redirect, or alert — no SEO/rendering impact,
// and form inputs are explicitly excluded so booking/contact forms keep working.
(function () {
    function isFormField(target) {
        var tag = target && target.tagName;
        return tag === 'INPUT' || tag === 'TEXTAREA' || target.isContentEditable;
    }

    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });

    ['copy', 'cut', 'paste', 'selectstart'].forEach(function (evt) {
        document.addEventListener(evt, function (e) {
            if (isFormField(e.target)) return;
            e.preventDefault();
        });
    });

    document.addEventListener('keydown', function (e) {
        if (isFormField(e.target)) return;

        var key = e.key ? e.key.toUpperCase() : '';
        var blockedCombo =
            key === 'F12' ||
            (e.ctrlKey && key === 'U') ||
            (e.ctrlKey && key === 'S') ||
            ((e.ctrlKey || e.metaKey) && e.shiftKey && ['I', 'J', 'C'].indexOf(key) !== -1);

        if (blockedCombo) {
            e.preventDefault();
        }
    });
})();
