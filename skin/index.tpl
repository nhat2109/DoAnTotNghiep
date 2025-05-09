{header}
<style>
    body {
        opacity: 0;
        transition: opacity 0.1s ease-in-out;
    }

    header {
        width: 100%;
        display: inline-block;
        z-index: 1000;
        position: fixed;
        margin-top: 50px;
    }

    .banner-container {
        width: 100%;
        max-width: 1280px;
        /* Giữ cố định 1280px */
        margin: 0 auto;
        padding: 15px;
        position: relative;
        box-sizing: border-box;
        /* Đảm bảo padding không làm vượt kích thước */
    }

    .silde_banner {
        margin: 0;
        margin-top: 160px;
    }

    .banner_wrapper {
        display: flex;
        gap: 5px;
        /* Giữ gap nhỏ như trong hình */
        margin-bottom: 40px;
        width: 100%;
        /* Đảm bảo chiếm toàn bộ chiều ngang container */
    }

    .banner_index .box_top_index {
        background: none;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: -70px;
    }

    .banner_index .owl-carousel {
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .banner_index .owl-stage-outer {
        overflow: hidden;
    }

    .owl-carousel .owl-item img {
        display: block;
        width: 100%;
        margin-bottom: 67px;
        border-radius: 10px;
    }

    .banner_index {
        width: calc(75% - 3.75px);
        /* 75% của 1280px là 960px, trừ đi 3.75px (5px * 75%) để vừa khung sau khi có gap */
        position: relative;
    }

    .banner_index img {
        width: 100%;
        height: 300px;
        /* Giảm chiều cao xuống 300px để trông cân đối như trong hình */
        object-fit: cover;
        /* Đảm bảo ảnh vừa khung, có thể bị cắt nhẹ để giữ tỷ lệ */
        border-radius: 8px;
        transition: transform 0.3s ease;
        object-position: center;
    }

    /* .banner_index img:hover {
        transform: scale(1.02);
    } */

    .home_brand .list_brand {
        width: 100%;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: -50px;
    }

    .list_brand_tren_duoi {
        width: calc(25% - 1.25px);
        /* 25% của 1280px là 320px, trừ đi 1.25px (5px * 25%) để vừa khung sau khi có gap */
        display: flex;
        flex-direction: column;
        gap: 5px;
        /* Giảm khoảng cách giữa các banner trong list_brand_tren_duoi */
        height: 300px;
        /* Đồng bộ chiều cao với banner_index */
    }

    .list_brand_tren_duoi .li_banner {
        width: 100%;
        flex: 1;
    }

    .list_brand_tren_duoi .li_banner a {
        display: block;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        overflow: hidden;
    }

    .list_brand_tren_duoi .li_banner img {
        width: 100%;
        height: 100%;
        /* Đảm bảo ảnh lấp đầy khung */
        object-fit: cover;
        /* Đảm bảo ảnh vừa khung, có thể bị cắt nhẹ để giữ tỷ lệ */
        border-radius: 8px;
        transition: transform 0.3s ease;
        object-position: center;
    }

    /* .list_brand_tren_duoi .li_banner img:hover {
        transform: scale(1.02);
    } */

    .list_brand {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin: 15px 0;
    }

    .list_brand .li_banner {
        flex: 1;
        max-width: calc(33.33% - 10px);
    }

    .list_brand .li_banner a {
        display: block;
        width: 100%;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .list_brand .li_banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
        object-position: center;
    }

    .list_brand .li_banner img:hover {
        transform: scale(1.02);
    }

    .box_danhmuc_noibat .container {
        max-width: 1280px;
        padding: 0 15px;
        margin-top: -40px;
    }

    .title_box {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px 0;
        font-size: 20px;
        font-weight: bold;
    }

    .title_box img {
        width: 30px;
        height: 30px;
    }

    .list_danhmuc {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .box_thuonghieu_noibat .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .list_thuonghieu_noibat {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .home_box .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .home_box .title_box {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .home_box .title_box h2 {
        font-size: 20px;
    }

    .home_box .title_box a {
        text-decoration: none;
        color: #007bff;
    }

    .tab_box {
        display: flex;
        gap: 15px;
    }

    .box_news_left {
        width: 50%;
    }

    .box_news_right {
        width: 50%;
    }

    .list_news {
        max-height: 400px;
        overflow-y: auto;
    }

    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    @media (max-width: 768px) {
        .banner_wrapper {
            flex-direction: column;
            gap: 10px;
        }

        .banner_index {
            width: 100%;
            margin-left: 0;
        }

        .banner_index img {
            height: auto;
            aspect-ratio: 3 / 1;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .list_brand_tren_duoi {
            display: none;
        }

        .list_brand {
            display: none;
        }

        .list_danhmuc {
            flex-direction: column;
        }

        .tab_box {
            flex-direction: column;
        }

        .box_news_left,
        .box_news_right {
            width: 100%;
        }
    }

    .banner_index .owl-item img {
        border-radius: 2px;
    }

    .thuong-hieu-slide {
        margin-left: 0px;
        display: flex !important;
        flex-wrap: nowrap !important;
    }

    #slide_danhmuc_noibat .swiper-slide {
        border-radius: 8px;
        /* Áp dụng border-radius cho các slide */
        overflow: hidden;
        /* Đảm bảo nội dung bên trong bị cắt đúng theo border-radius */
    }

    #slide_danhmuc_noibat .swiper-slide img {
        border-radius: 8px;
        /* Áp dụng border-radius cho ảnh trong slide */
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Đảm bảo ảnh vừa khung */
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.body.style.opacity = "1";
    });
</script>

<body class="body_scroll">
    {box_header}
    <div class="home_brand">
        <div class="banner-container">
            <div class="silde_banner">
                <div class="banner_wrapper">
                    <div class="banner_index">
                        <div class="owl-carousel">
                            {banner_index}
                        </div>
                    </div>
                    <div class="list_brand_tren_duoi">
                        {banner_doitac_hai}
                    </div>
                </div>
            </div>
            <div class="list_brand">
                {banner_big}
            </div>
        </div>
    </div>
    <div class="box_danhmuc_noibat">
        <div class="container">
            <div class="title_box" style="--background: url('{bg_box_noibat}')">
                <img src="{icon_box_noibat}" alt=""> Danh mục nổi bật
            </div>
            <div class="list_danhmuc swiper-container" id="slide_danhmuc_noibat">
                <div class="swiper-wrapper">
                    {list_danhmuc_noibat}
                </div>
            </div>
        </div>
    </div>
    {box_deal}
    <script>
        $(document).ready(function () {
            if ($(window).width() < 768) {
                sl = 1;
                sl_nb = 3;
            } else {
                sl = 2;
                sl_nb = 10;
            }

            var $carousel = $('.banner_index .owl-carousel');
            var slideCount = $carousel.find('.box_top_index').length;

            $carousel.owlCarousel({
                items: 1,
                loop: slideCount > 1,
                nav: slideCount > 1,
                dots: false,
                autoplay: slideCount > 1,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                margin: 0, /* Đặt margin về 0 để không có khoảng cách thừa */
                stagePadding: 0, /* Đặt stagePadding về 0 */
                autoWidth: false,
                autoHeight: false,
                navText: [
                    '<i class="mdi mdi-chevron-left"></i>',
                    '<i class="mdi mdi-chevron-right"></i>'
                ],
                responsive: {
                    0: { nav: false },
                    768: { nav: slideCount > 1 }
                }
            });

            var slide_danhmuc_noibat = new Swiper('#slide_danhmuc_noibat', {
                direction: 'horizontal',
                slidesPerView: sl_nb,
                slidesPerColumn: 2,
                slidesPerColumnFill: 'column',
                spaceBetween: 0,
                loop: false,
                observer: true,
                observeParents: true,
                autoplay: { delay: 3000 }
            });
            $('.box_danhmuc_noibat').show();
        });
    </script>
    <div class="box_thuonghieu_noibat">
        <div class="container">
            <div class="title_box" style="--background: url('{bg_box_noibat}')">
                <img src="uploads/img-icon/sirdsotimiddtrsnrr20220328211053thuonghieu.png" alt="" width="30"
                    height="30">
                <h3>THƯƠNG HIỆU NỔI BẬT</h3>
            </div>
            <div class="list_thuonghieu_noibat swiper-container" id="slide_thuonghieu_noibat">
                {list_cac_thuong_hieu}
            </div>
        </div>
    </div>
    <script src="/carousel/owl.carousel.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            if ($(window).width() < 768) {
                sl = 1;
                sl_nb = 3;
            } else {
                sl = 2;
                sl_nb = 10;
            }
            var slide_danhmuc_noibat = new Swiper('#slide_danhmuc_noibat', {
                direction: 'horizontal',
                slidesPerView: sl_nb,
                slidesPerColumn: 2,
                slidesPerColumnFill: 'column',
                spaceBetween: 0,
                loop: false,
                observer: true,
                observeParents: true,
                autoplay: { delay: 3000 }
            });
            $('.box_danhmuc_noibat').show();

            $('.banner_index .owl-carousel').owlCarousel({
                items: 1,
                loop: true,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                navText: [
                    '<i class="mdi mdi-chevron-left"></i>',
                    '<i class="mdi mdi-chevron-right"></i>'
                ],
                responsive: {
                    0: { nav: false },
                    768: { nav: true }
                }
            });

            var slide_brand_top_doitac = new Swiper('.slide_brand_top_doitac', {
                direction: 'vertical',
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                observer: true,
                observeParents: true,
                autoplay: { delay: 5000 },
                navigation: {
                    nextEl: '.slide_brand_top_doitac .next',
                    prevEl: '.slide_brand_top_doitac .prev'
                },
                breakpoints: {
                    320: {
                        direction: 'horizontal',
                        slidesPerView: 1
                    },
                    768: {
                        direction: 'vertical',
                        slidesPerView: 1
                    }
                }
            });

            var slide_brand_top_doitac_2 = new Swiper('.slide_brand_top_doitac_2', {
                direction: 'vertical',
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                observer: true,
                observeParents: true,
                autoplay: { delay: 5000 },
                navigation: {
                    nextEl: '.slide_brand_top_doitac_2 .next',
                    prevEl: '.slide_brand_top_doitac_2 .prev'
                },
                breakpoints: {
                    320: {
                        direction: 'horizontal',
                        slidesPerView: 1
                    },
                    768: {
                        direction: 'vertical',
                        slidesPerView: 1
                    }
                }
            });

            var slide_brand_top_doitac_3 = new Swiper('.slide_brand_top_doitac_3', {
                direction: 'vertical',
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                observer: true,
                observeParents: true,
                autoplay: { delay: 5000 },
                navigation: {
                    nextEl: '.slide_brand_top_doitac_3 .next',
                    prevEl: '.slide_brand_top_doitac_3 .prev'
                },
                breakpoints: {
                    320: {
                        direction: 'horizontal',
                        slidesPerView: 1
                    },
                    768: {
                        direction: 'vertical',
                        slidesPerView: 1
                    }
                }
            });
        });
    </script>
    {box_goiy}
    <div class="home_box">
        <div class="container">
            <div class="title_box">
                <h2><a href="/bai-viet/tin-tuc.html" class="link">Tin tức mới nhất</a></h2>
                <a href="/bai-viet/tin-tuc.html" class="more_right">Xem tất cả <i class="fa fa-chevron-right"></i></a>
            </div>
            <div class="tab_box">
                <div class="tab" style="padding-bottom: 0px; display: flex;">
                    <div class="box_news_left">
                        {tintuc_big}
                    </div>
                    <div class="box_news_right">
                        <div class="list_news scroll">
                            {tintuc_small}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
    <script>
        var slide_recent = new Swiper('.slide_category', {
            direction: 'horizontal',
            slidesPerView: 5,
            loop: true,
            observer: true,
            observeParents: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            autoplay: { delay: 3000 },
            navigation: {
                nextEl: '.slide_category .next',
                prevEl: '.slide_category .prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            }
        });

        if ($(window).width() < 480) {
            var sl = 2;
        } else {
            var sl = 3;
        }

        var slide_product = new Swiper('.slide_product', {
            direction: 'horizontal',
            slidesPerView: sl,
            loop: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: {
                nextEl: '.slide_product .next',
                prevEl: '.slide_product .prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            }
        });

        var slide_banner = new Swiper('.slide_top', {
            direction: 'horizontal',
            slidesPerView: 1,
            loop: true,
            observer: true,
            observeParents: true,
            autoplay: { delay: 3000 },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: {
                nextEl: '.box_slide .next',
                prevEl: '.box_slide .prev'
            }
        });

        var slide_brand_top_doitac_hai = new Swiper('.slide_brand_top_doitac_hai', {
            direction: 'horizontal',
            slidesPerView: 2,
            spaceBetween: 10,
            loop: true,
            observer: true,
            observeParents: true,
            autoplay: { delay: 5000 },
            navigation: {
                nextEl: '.home_brand_doitac_hai .next',
                prevEl: '.home_brand_doitac_hai .prev'
            },
            breakpoints: {
                320: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 2 }
            }
        });

        var tomorrow = new Date();
        var newdate = new Date();
        newdate.setDate(tomorrow.getDate() + 1);
        next_day = (newdate.getMonth() + 1) + ' ' + newdate.getDate() + ', ' + newdate.getFullYear();
        var countDownDate = new Date(next_day + " 23:59:59").getTime();
        var x = setInterval(function () {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            if (hours < 10) hours = '0' + hours;
            if (minutes < 10) minutes = '0' + minutes;
            if (seconds < 10) seconds = '0' + seconds;
            document.getElementById("ega-badge-ctd").innerHTML = '<div><div class="ega-badge-ctd__item ega-badge-ctd__h">' + hours + '</div><span>Giờ</span></div><div class="ega-badge-ctd__colon"> : </div><div><div class="ega-badge-ctd__item  ega-badge-ctd__m">' + minutes + '</div><span>Phút</span></div><div class="ega-badge-ctd__colon"> : </div><div><div class="ega-badge-ctd__item ega-badge-ctd__s">' + seconds + '</div><span>Giây</span></div>';
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("ega-badge-ctd").innerHTML = '<div><div class="ega-badge-ctd__item ega-badge-ctd__h">00</div><span>Giờ</span></div><div class="ega-badge-ctd__colon"> : </div><div><div class="ega-badge-ctd__item  ega-badge-ctd__m">00</div><span>Phút</span></div><div class="ega-badge-ctd__colon"> : </div><div><div class="ega-badge-ctd__item ega-badge-ctd__s">00</div><span>Giây</span></div>';
            }
        }, 1000);
    </script>
</body>

</html>