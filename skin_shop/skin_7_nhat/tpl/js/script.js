(function (window, document, callback) {
    let $,
        state,
        done = false;
    if (!($ = window.jQuery) || callback($, done)) {
        let script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js";
        script.onload = script.onreadystatechange =
            function () {
                if (!done && (!(state = this.readyState) || state === "loaded" || state === "complete")) {
                    callback(($ = window.jQuery).noConflict(1), (done = true));
                    $(script).remove();
                }
            };
        try {
            document.body.appendChild(script);
        } catch (ex) {
            try {
                document.documentElement.childNodes[0].appendChild(script);
            } catch (ex) {}
        }
    }
})(window, document, function ($, done) {
    let currentScript = document.currentScript;
    if (!currentScript) {
        console.error("current browser not support document.currentScript api");
        return;
    }
    let appOrigin;
    try {
        let url = new URL(currentScript.src);
        appOrigin = url.origin;
    } catch (e) {
        console.error("Can't parse url", e);
        return;
    }
    let alias = getAlias(Bizweb.store);
    let productConfig;
    let badgeEls = $(".sapo-combo-badge[data-id]");

    //Get store config
    $.ajax({
        url: appOrigin + "/api/client/config?storeAlias=" + alias,
        type: "POST",
        async: false,
        success: function (data) {
            if (data.product_list) {
                productConfig = data.product_list;
                setupAssets();
            } else {
                if (data.error) {
                    console.log(data.error);
                } else {
                    console.log("Có lỗi xảy ra vui lòng thử lại sau");
                }
            }
        },
        error: function (e) {
            console.log("Có lỗi xảy ra vui lòng thử lại sau");
        },
    });

    //Add badge icon & label
    function setupAssets() {
        if (productConfig.type === 2) {
            let css_inline = `<style>
                .sapo-combo-badge .label-text {
                    background: ${productConfig.label_background};
                    color: ${productConfig.label_color};
                }
            </style>`;
            $("body").append(css_inline);
        }
        checkBadge();
    }

    function checkBadge() {
        let ids = badgeEls.map(function () {
            return $(this).attr("data-id");
        });
        if (ids.length > 0) {
            $.ajax({
                url: appOrigin + "/api/client/badges?productIds=" + ids.splice(0).toString() + "&storeAlias=" + alias,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.apply != null && data.apply !== "" && data.apply === "all") {
                        badgesAllCallback();
                    } else {
                        badgesCallback(data);
                    }
                },
                error: function (e) {
                    console.log(e.error);
                },
            });
        }
    }

    function badgesAllCallback() {
        badgeEls.each(function () {
            let $this = $(this);
            addBadge($this);
        });
    }

    function badgesCallback(data) {
        badgeEls.each(function () {
            let $this = $(this),
                id = $this.data("id"),
                badge = filterBadge(data.product_mappings, id);
            if (badge != null) {
                addBadge($this);
            }
        });
    }

    function filterBadge(badges, id) {
        let len = badges.length;
        for (let i = 0; i < len; i++) {
            if (badges[i].sapo_product_id === id) {
                return badges[i];
            }
        }
        return null;
    }

    function addBadge(elem) {
        let imgIcon, labelTag, labelIcon;
        switch (productConfig.type) {
            case 1:
                imgIcon = $("<img/>", {
                    src: productConfig.icon_promotion_custom,
                    class: "icon-combo",
                });
                $(elem).append(imgIcon);
                break;
            case 2:
                labelTag = "<span class='label-text'>" + productConfig.label_title + "</span>";
                $(elem).append(labelTag);
                break;
            case 3:
                labelIcon = $("<img/>", {
                    src: productConfig.label_promotion,
                    class: "label-combo",
                });
                $(elem).append(labelIcon);
                break;
        }
    }

    function getAlias(domain) {
        domain = domain.replace(".mysapo.net", "");
        domain = domain.replace("http://", "");
        domain = domain.replace("https://", "");
        return domain;
    }

    function render(props) {
        return function (tok, i) {
            return i % 2 ? props[tok] : tok;
        };
    }
});
