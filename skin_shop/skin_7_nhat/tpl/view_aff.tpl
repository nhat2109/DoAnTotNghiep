{header}

<body>
    {box_header}
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="/" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="/san-pham.html" title="Sản phẩm">
                                <span itemprop="name">Sản phẩm</span>
                                <meta itemprop="position" content="2" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <strong><span itemprop="name">{tieu_de}</span></strong>
                            <meta itemprop="position" content="3" />
                        <li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="product">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 details-product">
                    <div class="row product-bottom">
                        <div class="clearfix padding-bottom-10">
                            <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6">
                                <div class="relative product-image-block ">
                                    <div class="large-image" id="large-image">
                                        <a class="large_image_url" href="{minh_hoa}">
                                            <img id="zoom_01" src="{minh_hoa}" alt="{tieu_de}" class="img-responsive center-block">
                                        </a>
                                    </div>
                                    <div id="gallery_01" class="owl-carousel owl-theme thumbnail-product margin-top-15 owl-loaded owl-drag" data-md-items="4" data-sm-items="4" data-xs-items="4" data-xss-items="3" data-margin="10" data-nav="true">
                                        <div class="owl-stage-outer">
                                            <div class="owl-stage swiper-container slide_photo" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s;">
                                                <div class="swiper-wrapper">
                                                    {list_photo}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="owl-nav">
                                            <div class="owl-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
                                            <div class="owl-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script src="/dist/jquery.magnific-popup.min.js"></script>
                            <link rel="stylesheet" type="text/css" href="/dist/magnific-popup.css">
                            <script type="text/javascript">
                            $(document).ready(function() {
                                $('.slide_photo').magnificPopup({
                                    delegate: 'a',
                                    type: 'image',
                                    closeOnContentClick: false,
                                    closeBtnInside: false,
                                    mainClass: 'mfp-with-zoom mfp-img-mobile',
                                    image: {
                                        verticalFit: true
                                    },
                                    gallery: {
                                        enabled: true
                                    },
                                    zoom: {
                                        enabled: true,
                                        duration: 300, // don't foget to change the duration also in CSS
                                        opener: function(element) {
                                            return element.find('img');
                                        }
                                    }

                                });
                                $('.large-image').magnificPopup({
                                    delegate: 'a',
                                    type: 'image',
                                    closeOnContentClick: false,
                                    closeBtnInside: false,
                                    mainClass: 'mfp-with-zoom mfp-img-mobile',
                                    image: {
                                        verticalFit: true
                                    },
                                    gallery: {
                                        enabled: true
                                    },
                                    zoom: {
                                        enabled: true,
                                        duration: 300, // don't foget to change the duration also in CSS
                                        opener: function(element) {
                                            return element.find('img');
                                        }
                                    }

                                });
                            });
                            </script>
                            <style type="text/css">
                            .image-source-link {
                                color: #98C3D1;
                            }

                            .mfp-with-zoom .mfp-container,
                            .mfp-with-zoom.mfp-bg {
                                opacity: 0;
                                -webkit-backface-visibility: hidden;
                                /* ideally, transition speed should match zoom duration */
                                -webkit-transition: all 0.3s ease-out;
                                -moz-transition: all 0.3s ease-out;
                                -o-transition: all 0.3s ease-out;
                                transition: all 0.3s ease-out;
                            }

                            .mfp-with-zoom.mfp-ready .mfp-container {
                                opacity: 1;
                            }

                            .mfp-with-zoom.mfp-ready.mfp-bg {
                                opacity: 0.8;
                            }

                            .mfp-with-zoom.mfp-removing .mfp-container,
                            .mfp-with-zoom.mfp-removing.mfp-bg {
                                opacity: 0;
                            }
                            </style>
                            <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6 details-pro">
                                <div class="product-top clearfix">
                                    <h1 class="title-head">{tieu_de}</h1>
                                </div>
                                <div class="price-box clearfix" itemscope itemtype="http://schema.org/Offer">
                                    <link itemprop="url" href="{link_xem}" />
                                    <meta itemprop="priceValidUntil" content="2030-11-05" />
                                    <div class="special-price">
                                        <span class="price product-price">{gia_moi}₫</span>
                                        <meta itemprop="price" content="{gia_moi}₫">
                                        <meta itemprop="priceCurrency" content="">
                                    </div> <!-- Giá -->
                                    <span class="old-price" itemprop="priceSpecification" itemscope="" itemtype="http://schema.org/priceSpecification">
                                        <del class="price product-price-old">{gia_cu}₫</del>
                                        <meta itemprop="price" content="{gia_cu}₫">
                                        <meta itemprop="priceCurrency" content="">
                                    </span>
                                </div>
                                {thuong_hieu}
                                <div class="inventory_quantity">
                                    <span class="stock-brand-title"><strong>Tình trạng:</strong></span>
                                    <span class="a-stock">
                                        <link itemprop="availability" href="http://schema.org/InStock" />Còn hàng</span>
                                </div>
                                <div class="form-product">
                                    {option_size}
                                    {option_mau}
                                    <div class="form-group ">
                                        <div style="clear: both;"></div>
                                        {box_flash_sale}
                                        <div class="clearfix margin-bottom-20"></div>
                                        <div class="clearfix">
                                            <a href="{link_aff}" target="_blank"><button type="submit" class="btn btn-lg btn-gray btn-cart"><span class="txt-main">Mua Ngay</span></button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {box_deal_soc}
                    <div class="row margin-top-10">
                        <div class="col-md-12">
                            <div class="product-tab e-tabs padding-bottom-10">
                                <div class="border-ghghg">
                                    <ul class="tabs tabs-title clearfix">
                                        <li class="tab-link current" id="li_tab_1">
                                            <h3><span>Mô tả chi tiết</span></h3>
                                        </li>
                                    </ul>
                                </div>
                                <div id="tab-1" class="tab-content current">
                                    <div class="rte">
                                        <div class="product-well" style="padding: 10px;">
                                            <div class="ba-text-fpt" id="fancy-image-view">
                                                {noi_dung}
                                            </div>
                                            <div class="show-more">
                                                <a class="btn btn-default btn--view-more">
                                                    <span class="more-text">Xem thêm <i class="fa fa-chevron-down"></i></span>
                                                    <span class="less-text">Thu gọn <i class="fa fa-chevron-up"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="fb-comments" data-href="{link_xem}" data-numposts="5" data-lazy="true" data-width="100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="module_service_details margin-bottom-30">
                        <div class="wrap_module_service" style="padding: 10px;">
                            <div class="title_right" style="font-weight: 700;font-size: 18px;">Đặc điểm nổi bật</div>
                            {noi_bat}
                        </div>
                    </div>
                    <div class="module_service_details margin-bottom-30">
                        <div class="wrap_module_service" style="padding: 10px;">
                            <div class="title_right" style="font-weight: 700;font-size: 18px;">Thông số sản phẩm</div>
                            <table class="product_info">{list_thongso}</table>
                        </div>
                    </div>
                    <!--                     <div class="module_service_details margin-bottom-30">
                        <div class="wrap_module_service">
                            <div class="item_service">
                                <div class="wrap_item_">
                                    <div class="image_service">
                                        <img src="/skin_shop/css/images/loader.svg?v=508" data-src="/skin_shop/css/images/policy_image_1.png" alt="Giao hàng trong 24h" />
                                    </div>
                                    <div class="content_service">
                                        <p>Giao hàng trong 24h</p>
                                        <span>Với đơn hàng trên 500.000 đ</span>
                                    </div>
                                </div>
                            </div>
                            <div class="item_service">
                                <div class="wrap_item_">
                                    <div class="image_service">
                                        <img src="/skin_shop/css/images/loader.svg?v=508" data-src="/skin_shop/css/images/policy_image_2.png" alt="Bảo đảm chất lượng" />
                                    </div>
                                    <div class="content_service">
                                        <p>Bảo đảm chất lượng</p>
                                        <span>Sản phẩm bảo đảm chất lượng.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="item_service">
                                <div class="wrap_item_">
                                    <div class="image_service">
                                        <img src="/skin_shop/css/images/loader.svg?v=508" data-src="/skin_shop/css/images/policy_image_3.png" alt=" Hỗ trợ 24/7" />
                                    </div>
                                    <div class="content_service">
                                        <p> Hỗ trợ 24/7</p>
                                        <span>Hotline: <a href="tel:{hotline_number}">{hotline}</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="item_service">
                                <div class="wrap_item_">
                                    <div class="image_service">
                                        <img src="/skin_shop/css/images/loader.svg?v=508" data-src="/skin_shop/css/images/policy_image_4.png" alt="Sản phẩm chính hãng" />
                                    </div>
                                    <div class="content_service">
                                        <p>Sản phẩm chính hãng</p>
                                        <span>Sản phẩm nhập khẩu chính hãng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="row margin-top-20">
                <div class="col-lg-12">
                    <div class="related-product">
                        <div class="home-title">
                            <h2><a href="/all">Sản phẩm cùng loại</a></h2>
                        </div>
                        <div class="section-tour-owl owl-carousel not-dqowl products-view-grid owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage swiper-container slide_lienquan">
                                    <div class="swiper-wrapper">
                                        {list_lienquan}
                                    </div>
                                </div>
                            </div>
                            <div class="owl-nav">
                                <div class="owl-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
                                <div class="owl-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margin-top-20">
                <div class="col-lg-12">
                    <div class="related-product">
                        <div class="home-title">
                            <h2><a href="/all">Sản phẩm đã xem</a></h2>
                        </div>
                        <div class="section-tour-owl owl-carousel not-dqowl products-view-grid owl-loaded owl-drag box_daxem">
                            <div class="owl-stage-outer">
                                <div class="owl-stage swiper-container slide_daxem">
                                    <div class="swiper-wrapper">
                                        {list_daxem}
                                    </div>
                                </div>
                            </div>
                            <div class="owl-nav">
                                <div class="owl-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
                                <div class="owl-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--             <div class="row recent_products-row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-hg-12">
                    <div class="recent_products">
                        <div class="module-header">
                            <h2 class="title-head module-title">
                                <span>Sản phẩm bạn đã xem</span>
                            </h2>
                        </div>
                        <div class="module-content">
                            <div class="recent_items">
                                <div id="recent-content" class="not-dqowl owl-theme owl-carousel owl-loaded owl-drag">
                                    <div class="owl-stage-outer">
                                        <div class="owl-stage swiper-container slide_daxem">
                                            <div class="swiper-wrapper">
                                                {list_daxem}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="owl-nav">
                                        <div class="owl-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
                                        <div class="owl-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
    {footer}
    {script_footer}
    <script>
    var slide_recent = new Swiper('.slide_photo', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 1,
        loop: false,
        observer: true,
        observeParents: true,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 5,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 5,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 5,
            },
        },
        // Navigation arrows
        navigation: {
            nextEl: '#gallery_01 .owl-next',
            prevEl: '#gallery_01 .owl-prev',
            disabledClass: 'hide_button',
            hiddenClass: 'hide_button'
        },
    })
    var slide_recent = new Swiper('.slide_lienquan', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 1,
        loop: true,
        observer: true,
        observeParents: true,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 10,
            },
        },
        // Navigation arrows
        navigation: {
            nextEl: '.related-product .owl-next',
            prevEl: '.related-product .owl-prev',
            disabledClass: 'hide_button',
            hiddenClass: 'hide_button'
        },
    })
    var slide_banner = new Swiper('.slide_daxem', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 1,
        loop: true,
        observer: true,
        observeParents: true,
        // If we need pagination
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 10,
            },
        },
        // Navigation arrows
        navigation: {
            nextEl: '.box_daxem .owl-next',
            prevEl: '.box_daxem .owl-prev',
        },
    })
    </script>
    <script type="text/javascript" charset="utf-8">
    $(function() {
        var currentDate = new Date(),
            finished = false,
            availiableExamples = {
                set5ngay: 15 * 24 * 60 * 60 * 1000,
                set2gio: 2 * 60 * 60 * 1000,
                set5phut: 5 * 60 * 1000,
                set1phut: 1 * 60 * 1000
            };

        function callback(event) {
            $this = $(this);
            switch (event.type) {
                case "seconds":
                case "minutes":
                case "hours":
                case "days":
                case "weeks":
                case "daysLeft":
                    $this.find('#' + event.type).html(event.value);
                    if (finished) {
                        $this.fadeTo(0, 1);
                        finished = false;
                    }
                    break;
                case "finished":
                    $this.fadeTo('slow', .5);
                    finished = true;
                    break;
            }
        }

        $('div#clock').countdown(availiableExamples.set2gio + currentDate.valueOf(), callback);
    });
    </script>
</body>

</html>
<style>
    .list-group .list-group-item .mega-menu {
        height: 200% !important;
    }
</style>