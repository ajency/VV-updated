jQuery(document).ready(function ($) {
    var $contentWrapper = $('#wpbody-content .wrap');

    // Template shortcodes buttons click listener.
    $contentWrapper.on('click', '.frp-form-group .frp-form-button', function () {
        if (typeof frpOptions != 'undefined') {
            var shortcode;

            for (var option in frpOptions.shortcodes) {
                if (!frpOptions.shortcodes.hasOwnProperty(option))
                    continue;

                if ($(this).hasClass('frp-form-button-' + option)) {
                    shortcode = frpOptions.shortcodes[option];
                    break;
                }
            }

            if (shortcode) {
                $(this).parent().next('textarea').replaceSelectedText(shortcode);
            }
        }
    });

    $contentWrapper.on('click', '.frp-form-group-title .frp-form-toggle-taxonomies', function () {
        $(this).parent().next('.frp-taxonomies').children('.frp-taxonomies-all').toggleClass('hidden');
        $(this).toggleClass('visible');
    });

    $contentWrapper.on('click', '.frp-taxonomies .categorychecklist input', function () {
        var $this = $(this);
        var $list = $this.closest('.frp-taxonomies');
        var $terms = $this.closest('.categorychecklist');
        var $taxonomy = $terms.prev('.frp-all-taxonomies').children('input');

        $(':disabled', $list).prop('disabled', false);
        $('input', $list).not($('input', $terms)).prop('checked', false);
        $('.frp-taxonomy', $list).val($taxonomy.val());
    });

    $contentWrapper.on('click', '.frp-taxonomies .frp-all-taxonomies input', function () {
        var $this = $(this);
        var $list = $this.closest('.frp-taxonomies');
        $(':disabled', $list).prop('disabled', false);
        $('input', $list).not($this).prop('checked', false);

        if ($this.is(':checked')) {
            var $terms = $this.closest('.frp-all-taxonomies').next('.categorychecklist');
            $('input', $terms).prop('disabled', true);
            $('.frp-taxonomy', $list).val($this.val());
        }
    });

    $contentWrapper.on('click', '.frp-form-themes-button', function () {
        $(this).next('.frp-form-themes').slideToggle();
    });

    $contentWrapper.on('click', '.frp-form-theme:not(.frp-active)', function () {
        var $elem = $(this);
        var themeName = $elem.attr('data-theme-name');

        $elem.parent().children('.frp-active').removeClass('frp-active');
        $elem.addClass('frp-active');
        $elem.nextAll('input').attr('value', themeName);
        $elem = $elem.parent().next('textarea');

        // Check that text area wasn't modified so we can safely replace its contents or show confirm box.
        if (!$elem.hasClass('frp-user-modified') || confirm(frpOptions.confirmReplace)) {
            $elem.val(frpOptions.themes[themeName].template).removeClass('frp-user-modified');
        }
    });

    // Detect text area modifications.
    $contentWrapper.on('change keyup', '.frp-form-group textarea:not(.frp-user-modified)', function () {
        $(this).addClass('frp-user-modified');
    });
});