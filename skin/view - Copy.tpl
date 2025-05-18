{header}

<body>
    {box_header}
    <div class="bread-crumb mb-3">
        <span class="crumb-border"></span>
        <div class="container">
            <div class="row">
                <div class="col-12 a-left">
                    <ul class="breadcrumb m-0 px-0" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <a href="/" target="_self" itemprop="item"><span itemprop="name">Trang chủ</span></a>
                            <meta itemprop="position" content="1">
                            <span class="mr_lr">&nbsp;/&nbsp;</span>
                        </li>
                        <li>
                            <a href="/san-pham.html">
                                <span> Sản phẩm </span></a>
                            <span class="mr_lr">&nbsp;/&nbsp;</span>
                        </li>
                        <li class="active"><span>{tieu_de}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="box_product_detail">
        <div class="container">
            <div class="row">
                <div class="product_img">
                    <div class="big" id="big">
                        {img_big}
                    </div>
                    <div class="small">
                        <div class="swiper-container slide_small">
                            <div class="swiper-wrapper">
                                {list_big}
                            </div>
                        </div>
                    </div>
                </div>
                <script src="/dist/jquery.magnific-popup.min.js"></script>
                <link rel="stylesheet" type="text/css" href="/dist/magnific-popup.css">
                <script type="text/javascript">
                $(document).ready(function() {
                    $('.slide_small').magnificPopup({
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
                    $('#big').magnificPopup({
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
                .bk-btn-paynow{
                    width: 75%;
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                .bk-btn-installment{
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                </style>
                <div class="product_info">
                    <h1 class="product_title bk-product-name">{tieu_de}</h1>
                    <div class="row">
                        <div class="left_info">
                            <div class="group-status">
                                {thuong_hieu}
                                <span class="first_status status_2">
                                    Tình trạng:
                                    <span class="status_name available">
                                        {tinh_trang}
                                    </span>
                                </span>
                            </div>
                            <div class="price-box">
                                <span class="special-price"><span class="price product-price bk-product-price">{gia_moi}₫</span>
                                </span> <!-- Giá Khuyến mại -->
                                <span class="old-price">
                                    <del class="price product-price-old sale">{gia_cu}₫</del>
                                </span> <!-- Giá gốc -->
                            </div>
                            {box_flash_sale}
                            <div class="form-product">
                                <div class="form_button_details margin-top-15 w-100">
                                    <div class="form_product_content type1 ">
                                        {option_mau}
                                        {option_size}
                                        <div class="soluong soluong_type_1 show">
                                            <label>Số lượng:</label>
                                            <div class="custom-btn-number">
                                                <button type="button" class="button_minus">-</button>
                                                <input type="text" name="quantity" class="bk-product-qty" id="quantity_view" value="1" maxlength="3">
                                                <button type="button" class="button_plus">+</button>
                                            </div>
                                        </div>
                                        <div class="button_actions clearfix">
                                            <button type="button" {disabled} class="btn btn_base btn_add_cart btn-cart add_to_cart" sp_id="{sp_id}" loai="{loai}">
                                                <span class="text_1">{text_button}</span>
                                            </button>
                                        </div>
                                        <!-- <div class='bk-btn' style="display: flex;margin-top: 10px;"></div> -->
                                    </div>
                                </div>
                            </div>
                            <!--                             <div class="box_noibat scroll">
                                {noi_bat}
                            </div> -->
                        </div>
                        <div class="right_info">
                            <div class="product-policises-wrapper noi_bat">
                                <h5>
                                    ĐẶC ĐIỂM NỔI BẬT:
                                </h5>
                                {noi_bat}
                            </div>
                            <div class="product-policises-wrapper" style="margin-top: 10px;">
                                <h5>
                                    CHỈ CÓ Ở SOCDO.VN:
                                </h5>
                                <ul class="product-policises">
                                    <li class="media">
                                        <div class="mr-3">
                                            <img class="img-fluid lazyload loaded" src="//theme.hstatic.net/1000410088/1000745150/14/policy_product_image_2.png?v=128" data-src="//theme.hstatic.net/1000410088/1000745150/14/policy_product_image_2.png?v=128" alt="Bảo hành chính hãng" data-was-processed="true">
                                        </div>
                                        <div class="media-body">
                                            Bảo hành chính hãng.
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="mr-3">
                                            <img class="img-fluid lazyload loaded" src="//theme.hstatic.net/1000410088/1000745150/14/policy_product_image_2.png?v=128" data-src="//theme.hstatic.net/1000410088/1000745150/14/policy_product_image_2.png?v=128" alt="111% bồi hoàn nếu phát hiện hàng giả hoặc kém chất lượng" data-was-processed="true">
                                        </div>
                                        <div class="media-body">
                                            111% bồi hoàn nếu phát hiện hàng giả hoặc kém chất lượng
                                        </div>
                                    </li>
                                    <!--                                     <li class="media">
                                        <div class="mr-3">
                                            <img class="img-fluid lazyload loaded" src="//theme.hstatic.net/1000410088/1000745150/14/policy_product_image_3.png?v=128" data-src="//theme.hstatic.net/1000410088/1000745150/14/policy_product_image_3.png?v=128" alt="Tích điểm tất cả sản phẩm" data-was-processed="true">
                                        </div>
                                        <div class="media-body">
                                            Tích điểm tất cả sản phẩm
                                        </div>
                                    </li> -->
<!--                                     <li class="media">
                                        <div class="mr-3">
                                            <img class="img-fluid lazyload loaded" src="//theme.hstatic.net/1000410088/1000745150/14/policy_product_image_4.png?v=128" data-src="//theme.hstatic.net/1000410088/1000745150/14/policy_product_image_4.png?v=128" alt="Giảm 5% khi thanh toán online" data-was-processed="true">
                                        </div>
                                        <div class="media-body">
                                            Giảm 5% khi chuyển khoản trước
                                        </div>
                                    </li> -->
                                </ul>
                            </div>
                            <!--                             <div class="product-trustbadge">
                                <a href="javascript:;" title="Phương thức thanh toán">
                                    <img class="lazyload img-fluid loading" src="//theme.hstatic.net/1000410088/1000745150/14/product_trustbadge.jpg?v=128" alt="Phương thức thanh toán" data-was-processed="true">
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {box_deal_soc}
    <div class="box_product_detail">
        <div class="container">
            <div class="box_title">
                <h2>Mô tả sản phẩm</h2>
            </div>
            <div class="box_content">
                <div class="noidung">
                    {noidung}
                </div>
                <div class="thongso">
                    <table>
                        <tr>
                            <th colspan="2">Thông số kỹ thuật</th>
                        </tr>
                        {list_thongso}
                    </table>
                    <div style="margin-top: 10px;">
<!--                         <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7667437466339231"
                             crossorigin="anonymous"></script>
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-7667437466339231"
                             data-ad-slot="2193067812"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                        <script>
                             (adsbygoogle = window.adsbygoogle || []).push({});
                        </script> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
    <script src="/js/bk.js"></script>
    <!-- <script src="https://pc.baokim.vn/js/bk_plus_v2.popup.js"></script> -->
    <script>
    var galleryTop = new Swiper('.slide_big', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.big .next',
            prevEl: '.big .prev',
        },
        loop: true,
        loopedSlides: 4
    });
    var galleryThumbs = new Swiper('.slide_small', {
        spaceBetween: 10,
        centeredSlides: true,
        slidesPerView: 4,
        touchRatio: 0.2,
        slideToClickedSlide: true,
        loop: true,
        loopedSlides: 4
    });
    galleryTop.controller.control = galleryThumbs;
    galleryThumbs.controller.control = galleryTop;
    </script>
    <div id='bk-modal'></div>
</body>

</html>