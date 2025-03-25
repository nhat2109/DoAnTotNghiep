<!-- Header -->
<head>
    <meta name="theme-color" content="#EC720E" />
    <link rel="canonical" href="{link_xem}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="revisit-after" content="2 days" />

    <meta name="robots" content="noodp,index,follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <meta name="description" content="{description}">
    <title>{title}</title>
    <meta name="keywords" content="{title}" />

    <meta property="og:type" content="website">
    <meta property="og:title" content="{title}">
    <meta property="og:image" content="{logo}">
    <meta property="og:image:secure_url" content="{logo}">
    <meta property="og:description" content="">
    <meta property="og:url" content="{link_xem}">
    <meta property="og:site_name" content="{site_name}">
    <link rel="icon" href="/images/favicon.png" type="image/x-icon" />
   
    

    

        <link rel="preload" as="style" type="text/css" href="/skin_shop/skin_7_nhat/tpl/css/bootstrap-4-3-min.css?t=<?php echo time();?>" onload="this.rel='stylesheet'" />
        <link href='/skin_shop/skin_7_nhat/tpl/css/bootstrap-4-3-min.css?t=<?php echo time();?>' rel='stylesheet' type='text/css' media='all' />


    <script src="/skin_shop/skin_7_nhat/tpl/js/jquery.js" type="text/javascript"></script>
    

    <link rel="preload" as="style" type="text/css" href="/skin_shop/skin_7_nhat/tpl/css/styles.css?t=<?php echo time();?>" onload="this.rel='stylesheet'" />
    <link href='/skin_shop/skin_7_nhat/tpl/css/styles.css?t=<?php echo time();?>' rel='stylesheet' type='text/css' media='all' />
    <style>
        :root {
            --text-color: #090302;
            --body-background: #f8f8f8;
            --text-secondary-color: #666666;
            --primary-color: #ec720e;
            --secondary-color: #292929;
            --price-color: #e9330d;
            --subheader-background: #e5677d;
            --subheader-color: #f9f9f6;
            --header-category-bg: #a50a06;
            --header-category-color: #fff3f4;
            --label-background: #e9330d;
            --label-color: #ffffff;
            --footer-bg: #292929;
            --footer-color: #fff;
            --show-loadmore: none !important;
            --order-loadmore: -1 !important;
            --sale-pop-color: #ec720e;
            --addtocart-bg: #090302;
            --addtocart-text-color: #ffffff;
            --cta-color: #090302;
            --section-coupon-bg: #ffffff;
            --coupon-title-color: #372720;
            --coupon-button-color: #ec720e;
            --col-menu: 4;
            --border-color: #f1f1f1;
            --link-color: #ec720e;
            --link-hover-color: #ec720e;
            --coupon-code-background: #ffffff;
            --coupon-lite-border: #ec720e;
            --product-promotion-bg: #f33828;
            --policies-bg: #ec720e;
            --policies-color: #fff;
            --policies-border: #ffffff;
            --product-promotion-color: #090302;
            --reviewBg: #8b572a;
            --starColor: #f5cb23;
        }

        .modal-scrollbar-measure {
            display: none;
        }

        @font-face {
            font-family: "Be Vietnam Pro";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/bevietnampro-regular.woff?1727322848954) format("woff");
        }

        @font-face {
            font-family: "Be Vietnam Pro";
            font-style: italic;
            font-weight: 400;
            font-display: swap;
            src: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/bevietnampro-italic.woff?1727322848954) format("woff");
        }

        @font-face {
            font-family: "Be Vietnam Pro";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/bevietnampro-semibold.woff?1727322848954) format("woff");
        }

        @font-face {
            font-family: "Mulish";
            font-style: italic;
            font-weight: 600;
            font-display: swap;
            src: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/bevietnampro-semibolditalic.woff?1727322848954) format("woff");
        }
    </style>
    <style>
        .swatch-element {
            position: relative;
            /**margin: 8px 10px 0px 0px; **/
        }

        .swatch-element:not(.color) {
            overflow: hidden;
        }

        .swatch-element-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .swatch-div {
            margin-bottom: 30px;
        }

        .swatch-element.color {
            /**margin: 8px 15px 0px 0px;**/
        }

        .swatch-element.color .xanh-den {
            background-color: #2e314e;
        }


        .swatch-element.color+.tooltip {
            z-index: -1;
            white-space: nowrap;
        }

        .swatch-element.color:hover+.tooltip {
            opacity: 1;
            z-index: 100;
            top: -30px;
            min-width: 30px;
            background: #000;
            color: #fff;
            padding: 4px 6px;
            font-size: 10px;
            border-radius: 4px;
        }

        .swatch-element.color:hover+.tooltip:after {
            content: "";
            position: absolute;
            left: 16px;
            bottom: -3px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 3px 2.5px 0 2.5px;
            border-color: #000 transparent transparent transparent;
        }

        .swatch-element.color:hover label {
            box-shadow: 0 0 0 1px #000, inset 0 0 0 4px #fff;
            transform: scale(1.1);
        }

        .swatch-element label {
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            height: 30px !important;
            min-width: auto !important;
            white-space: nowrap;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .swatch-element input {
            width: 100%;
            height: 100%;
            opacity: 0;
            position: absolute;
            z-index: 3;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .swatch .swatch-element:not(.color) input:checked+label {
            border-color: var(--primary-color) !important;
            color: var(--primary-color);
            position: relative;
        }

        .swatch .swatch-element:not(.color) input:checked+label:after {
            content: "";
            background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfkCw8RJSHXzNuNAAAAfElEQVQoz7WRsQ2CYBQGLwRCaLRkDwqdwcLCSZjCmj2AgtoJXMbEUquzEAz+8Je89r675sGG59ka0ig+0ZFbJDGbgRwoAXemi/hb1QZw793ebB739cPgTdV2qvzZAFY+VL+VwB4nB59j5RLYhBVXcTBZw7NJDAN49LrFyz67GnkMHStx0wAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0xMS0xNVQxNzozNzozMyswMDowMGfDTJEAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMTEtMTVUMTc6Mzc6MzMrMDA6MDAWnvQtAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAABJRU5ErkJggg==");
            background-repeat: no-repeat;
            background-size: contain;
            position: absolute;
            top: 0px;
            right: 0;
            width: 6px;
            height: 6px;
        }

        .swatch .swatch-element:not(.color) input:checked+label:before {
            content: "";
            padding: 4px;
            font-size: 10px;
            line-height: 1;
            position: absolute;
            top: -15px;
            right: -13px;
            background: var(--primary-color);
            width: 26px;
            height: 24px;
            transform: rotate(45deg);
            border-radius: 100%;
        }

        .swatch .color label {
            width: 33px;
            min-width: unset !important;
            height: 33px !important;
            line-height: 33px !important;
            border-radius: 6px !important;
            border: 1px solid #eee;
        }

        .swatch .color label:before {
            content: none;
        }

        .swatch {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .swatch .header {
            font-weight: bold;
            color: #333;
            flex: 0 0 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .swatch .color label {
            position: relative;
            z-index: 2;
            border-radius: 100% !important;
            transition: box-shadow 0.25s ease, transform 0.25s ease;
            border: none;
        }

        .swatch .color span {
            content: "";
            position: absolute;
            width: calc(100% + 1px);
            height: calc(100% + 1px);
            border-radius: 100%;
            background: #fff;
            top: 50%;
            left: 50%;
            z-index: 0;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
        }

        .swatch .color input:checked+label {
            box-shadow: 0 0 0 1px #000, inset 0 0 0 4px #fff;
        }

        .swatch .color input:checked~span {
            opacity: 1;
            border: 1px solid #ccc;
        }

        .quick-view-product .swatch {
            padding: var(--block-spacing) 0;
        }

        .item_product_main .swatch-element.color {
            margin-right: 5px;
            margin-top: 5px;
        }

        .item_product_main .swatch .color label {
            width: 26px;
            height: 26px !important;
            line-height: 26px !important;
            padding: 0;
        }

        .swatch-color .swatch-element.color:hover+.tooltip {
            opacity: 1;
            z-index: 100;
            min-width: 30px;
            background: #000;
            color: #fff;
            padding: 4px 12px;
            border-radius: 4px;
            top: auto;
            bottom: calc(100% + 12px);
            left: calc(50%);
            transform: translateX(-50%);
            font-size: 12px;
        }

        .swatch-color .swatch-element.color:hover+.tooltip:after {
            border-style: solid;
            border-width: 3px 2.5px 0 2.5px;
            border-color: #000 transparent transparent transparent;
            background: #333333;
            content: "";
            height: 8px;
            position: absolute;
            transform: rotate(45deg);
            width: 8px;
            left: calc(50% - 4px);
            bottom: -4px;
        }

        span.swatch-value {
            font-weight: normal;
            font-size: 14px;
        }
    </style>

    <script>
        var Bizweb = Bizweb || {};
        Bizweb.store = "ega-furniture.mysapo.net";
        Bizweb.id = 491756;
        Bizweb.theme = {
            id: 956460,
            name: "{title}_v1.0_20240806",
            role: "main",
        };
        Bizweb.template = "index";
        if (!Bizweb.fbEventId)
            Bizweb.fbEventId = "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
                /[xy]/g,
                function (c) {
                    var r = (Math.random() * 16) | 0,
                        v = c == "x" ? r : (r & 0x3) | 0x8;
                    return v.toString(16);
                }
            );
    </script>
    <script>
        (function () {
            function asyncLoad() {
                var urls = [
                    "/skin_shop/skin_7_nhat/tpl/js/productreviews.min.js",
                    "/skin_shop/skin_7_nhat/tpl/js/scripttag.js",
                    "/skin_shop/skin_7_nhat/tpl/js/script.v2.js",
                    "/skin_shop/skin_7_nhat/tpl/js/script.js",
                ];
                for (var i = 0; i < urls.length; i++) {
                    var s = document.createElement("script");
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = urls[i];
                    var x = document.getElementsByTagName("script")[0];
                    x.parentNode.insertBefore(s, x);
                }
            }
            window.attachEvent
                ? window.attachEvent("onload", asyncLoad)
                : window.addEventListener("load", asyncLoad, false);
        })();
    </script>

    <script>
        window.BizwebAnalytics = window.BizwebAnalytics || {};
        window.BizwebAnalytics.meta = window.BizwebAnalytics.meta || {};
        window.BizwebAnalytics.meta.currency = "VND";
        window.BizwebAnalytics.tracking_url = "/s";

        var meta = {};

        for (var attr in meta) {
            window.BizwebAnalytics.meta[attr] = meta[attr];
        }
    </script>

    <!-- <script src="/dist/js/stats.min.js?v=96f2ff2"></script>z -->

    <!--
			Theme Information
			--------------------------------------
			Theme ID: {title}
			Version: v1.0.0_20240806
			Company: EGANY
			changelog: //bizweb.dktcdn.net/100/491/756/themes/956460/assets/ega-changelog.js?1727322848954
			---------------------------------------
		-->
    <script>
        var ProductReviewsAppUtil = ProductReviewsAppUtil || {};
        ProductReviewsAppUtil.store = { name: "{title}" };
    </script>
    <style>
        .section_brand .row {
            display: grid;
            grid-template-columns: repeat(var(--item-display, 6), 1fr);
            grid-gap: 10px;
        }

        @media (max-width: 767px) {
            .section_brand .row.slick-slider {
                display: block;
            }
        }

        @media (min-width: 991px) {
            .home-slider__dot-fake.mobile {
                display: none;
            }

            .home-slider__dot-fake.desktop {
                display: flex;
            }
        }
        
    </style>

    <script>
        window.themeScripts = [
            "/skin_shop/skin_7_nhat/tpl/js/slick-min.js",
        ];
        window.sectionScripts = [
            "/skin_shop/skin_7_nhat/tpl/js/index.js",

            
        ];
        window.themeCss = [
          
            
        ];
    </script>

<script src="/skin_shop/skin_7_nhat/tpl/js/process.js"></script>
<!-- <script src="/skin_shop/skin_7_nhat/tpl/js/process.js?t=<?php echo time();?>"></script> -->

    <!-- <link href="/skin_shop/skin_7_nhat/tpl/css/appcombo.css
" rel="stylesheet" type="text/css" media="all" /> -->

</head>
<style>
    .list-group .list-group-item .mega-menu {
        height: 200% !important;
    }
</style>