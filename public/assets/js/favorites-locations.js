(function ($) {

    function getCookie(name) {
        let matches = document.cookie.match(
            new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)")
        );
        return matches ? decodeURIComponent(matches[1]) : null;
    }

    function setCookie(name, value, options = {}) {
        options = {
            path: '/',
            ...options
        };

        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }

        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    }

    function loadFavorites() {
        ['tour', 'activity', 'trekking', 'location'].forEach(function (type) {
            let cookieName = `favorite_${type}s`;
            let favorites = getCookie(cookieName);
            if (favorites) {
                let ids = favorites.split(',');
                ids.forEach(id => {
                    let $btn = $(`.js-favorite-btn[data-type="${type}"][data-id="${id}"]`);
                    $btn.addClass('is-favorited');
                    $btn.find('i').addClass('is-favorited-icon');
                });
            }
        });
    }

    function toggleFavorite($btn) {
        let id = $btn.data('id');
        let type = $btn.data('type');
        let cookieName = `favorite_${type}s`;

        let favorites = getCookie(cookieName);
        let ids = favorites ? favorites.split(',') : [];

        if (ids.includes(id.toString())) {
            // remove from favorites
            ids = ids.filter(itemId => itemId !== id.toString());
            $btn.removeClass('is-favorited');
            $btn.find('i').removeClass('is-favorited-icon');
        } else {
            // add to favorites
            ids.push(id.toString());
            $btn.addClass('is-favorited');
            $btn.find('i').addClass('is-favorited-icon');
        }

        if (ids.length > 0) {
            setCookie(cookieName, ids.join(','), { expires: 365 });
        } else {
            setCookie(cookieName, '', { expires: -1 });
        }
    }

    $(document).ready(function () {
        console.log('Favorites system loaded!');
        loadFavorites();

        $(document).on('click', '.js-favorite-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            toggleFavorite($(this));
        });
    });

})(jQuery);
