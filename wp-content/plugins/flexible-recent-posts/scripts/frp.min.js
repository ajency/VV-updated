jQuery(document).ready(function (b) {
    var d = b("#wpbody-content .wrap");
    d.on("click", ".frp-form-group .frp-form-button", function () {
        if ("undefined" != typeof frpOptions) {
            var a, c;
            for (c in frpOptions.shortcodes)if (frpOptions.shortcodes.hasOwnProperty(c) && b(this).hasClass("frp-form-button-" + c)) {
                a = frpOptions.shortcodes[c];
                break
            }
            a && b(this).parent().next("textarea").replaceSelectedText(a)
        }
    });
    d.on("click", ".frp-form-group-title .frp-form-toggle-taxonomies", function () {
        b(this).parent().next(".frp-taxonomies").children(".frp-taxonomies-all").toggleClass("hidden");
        b(this).toggleClass("visible")
    });
    d.on("click", ".frp-taxonomies .categorychecklist input", function () {
        var a = b(this), c = a.closest(".frp-taxonomies"), a = a.closest(".categorychecklist"), d = a.prev(".frp-all-taxonomies").children("input");
        b(":disabled", c).prop("disabled", !1);
        b("input", c).not(b("input", a)).prop("checked", !1);
        b(".frp-taxonomy", c).val(d.val())
    });
    d.on("click", ".frp-taxonomies .frp-all-taxonomies input", function () {
        var a = b(this), c = a.closest(".frp-taxonomies");
        b(":disabled", c).prop("disabled", !1);
        b("input", c).not(a).prop("checked", !1);
        if (a.is(":checked")) {
            var d = a.closest(".frp-all-taxonomies").next(".categorychecklist");
            b("input", d).prop("disabled", !0);
            b(".frp-taxonomy", c).val(a.val())
        }
    });
    d.on("click", ".frp-form-themes-button", function () {
        b(this).next(".frp-form-themes").slideToggle()
    });
    d.on("click", ".frp-form-theme:not(.frp-active)", function () {
        var a = b(this), c = a.attr("data-theme-name");
        a.parent().children(".frp-active").removeClass("frp-active");
        a.addClass("frp-active");
        a.nextAll("input").attr("value",
            c);
        a = a.parent().next("textarea");
        a.hasClass("frp-user-modified") && !confirm(frpOptions.confirmReplace) || a.val(frpOptions.themes[c].template).removeClass("frp-user-modified")
    });
    d.on("change keyup", ".frp-form-group textarea:not(.frp-user-modified)", function () {
        b(this).addClass("frp-user-modified")
    })
});
