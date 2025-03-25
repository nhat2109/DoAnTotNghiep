(function (window, document, callback) {
    var $, state, done = false;
    if (!($ = window.jQuery) || callback($, done)) {
        var script = document.createElement("script");
        script.type = "text/javascript",
            script.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js",
            script.onload = script.onreadystatechange = function () {
                if (!done && (!(state = this.readyState) || state === "loaded" || state === "complete")) {
                    callback(($ = window.jQuery).noConflict(1), done = true);
                    $(script).remove();
                }
            };
        try {
            document.body.appendChild(script);
        }
        catch (ex) {
            try {
                document.documentElement.childNodes[0].appendChild(script);
            }
            catch (ex) { }
        }
    }
})(window, document, function ($, done) {
    var bwaf = getParameterByName('bwaf');
    var cookieExpire =  Number.parseInt('15');
    if (bwaf !== null && bwaf !== "")
        setCookie("_landing_page", "/?bwaf=" + bwaf, cookieExpire);

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }


    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
<!--        d.setTime(d.getTime() + (exdays * 12 * 60 * 60 * 1000));-->
        d.setDate(d.getDate()+exdays);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; SameSite=None; Secure;" + expires + ";path=/";
    }
});
