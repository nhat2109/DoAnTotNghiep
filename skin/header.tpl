<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="vi">
<!--<![endif]-->

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>{title}</title>
    <meta name="description" content="{description}" />
    <meta name="keywords" content="{description}" />
    <meta name="robots" content="noodp,index,follow" />
    <meta property="og:url" content="{link_xem}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content='{title}' />
    <meta property="og:description" content='{description}' />
    <meta property="og:image" content="{minh_hoa}" />
    <meta property="fb:app_id" content="641938006744130" />
    <meta property="fb:pages" content="2012309395755985" />
    <meta property="fb:pages" content="344265373160890" />
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:100:300,400,500,700,900|Material+Icons|Open Sans:bold,regular|Tinos:bold,regular|Cormorant Upright:bold,regular|Roboto:bold,regular|Baloo Bhaina:bold,regular|Lobster:bold,regular&display=swap" as="style">
    <link rel="stylesheet" type="text/css" href="/fonts/font-awesome-5.15.14/css/all.min.css">
    <link rel="stylesheet" href="/skin/css/font-awesome.css">
    <link rel="stylesheet" href="/skin/css/codechuan-icon.css">
    <link rel="stylesheet" type="text/css" href="/fonts/icofont/icofont/icofont.min.css">
    <link href='/skin/css/icomoon.min.css' rel='stylesheet' />
    <link href='/skin/css/themify-icons.css' rel='stylesheet' />
    <link rel="stylesheet" href="/skin/css/bk.css">
    <link rel="stylesheet" href="/swiper/swiper.min.css">
    <link rel="stylesheet" href="/skin/css/style.css?t=<?php echo time();?>">
    <link rel="stylesheet" href="/carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/carousel/assets/owl.theme.default.min.css">
    <script src="/js/jquery-3.2.1.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JJTPJMXVXB"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-JJTPJMXVXB');
    </script>
    <!-- Meta Pixel Code -->
    <script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1907352116373463');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1907352116373463&ev=PageView&noscript=1" /></noscript>
    <meta name="facebook-domain-verification" content="sw9kkazj77l3x2mutgozpnn5mw98me" />
    <!-- End Meta Pixel Code -->
    <!-- Event snippet for Lượt mua hàng (1) conversion page -->
    <script>
    gtag('event', 'conversion', {
        'send_to': 'AW-10796853678/vtYdCKLm88IZEK7Tq5wo',
        'transaction_id': ''
    });
    </script>
    <!-- End Meta Pixel Code -->
    <!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "74d19b09-2737-4d7e-8545-693fd202500d",
    });
  });
</script> -->
<!-- <script>
document.addEventListener("DOMContentLoaded", function () {
  const lazyImages = document.querySelectorAll('img.lazy-image');

  if ("IntersectionObserver" in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.onload = () => img.classList.add('loaded');
          observer.unobserve(img);
        }
      });
    });

    lazyImages.forEach(img => {
      imageObserver.observe(img);
    });
  } else {
    // Fallback nếu không hỗ trợ IntersectionObserver
    lazyImages.forEach(img => {
      img.src = img.dataset.src;
      img.onload = () => img.classList.add('loaded');
    });
  }
});
</script> -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const lazyImages = document.querySelectorAll("img.lazy-image");

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.onload = () => img.classList.add("loaded");
          obs.unobserve(img); // Chỉ load 1 lần
        }
      });
    }, {
      rootMargin: "0px 0px 100px 0px", // preload trước 100px nếu muốn
      threshold: 0.01
    });

    lazyImages.forEach(img => observer.observe(img));
  });
</script>
</head>