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
                        </li>
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
                                <div class="relative product-image-block">
                                    <div class="large-image" id="large-image" style="max-width: 400px; max-height: 400px; width: 100%; height: 0; padding-bottom: 100%; position: relative; overflow: hidden;">
                                        <a class="large_image_url" href="{minh_hoa}">
                                            <img id="zoom_01" src="{minh_hoa}" alt="{tieu_de}" class="img-responsive center-block" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;">
                                        </a>
                                    </div>
                                    <div id="gallery_01"
                                        class="owl-carousel owl-theme thumbnail-product margin-top-15 owl-loaded owl-drag"
                                        data-md-items="4" data-sm-items="4" data-xs-items="4" data-xss-items="3"
                                        data-margin="10" data-nav="true">
                                        <div class="owl-stage-outer">
                                            <div class="owl-stage swiper-container slide_photo"
                                                style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s;">
                                                <div class="swiper-wrapper">
                                                    {list_photo}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="owl-nav">
                                            <div class="owl-prev"><i class="fa fa-angle-left" aria-hidden="true"></i>
                                            </div>
                                            <div class="owl-next"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6 details-pro">
                                <div class="product-top clearfix">
                                    <h1 class="title-head">{tieu_de}</h1>
                                </div>
                                <div class="inventory_quantity" style="display: flex; justify-content: space-between; padding-bottom: 10px;">
                                    <span> {thuong_hieu}</span>
                                    <span class="a-stock" id="stock-status">
                                        <link itemprop="availability" href="http://schema.org/InStock" />{tinh_trang}
                                    </span>
                                </div>
                                <div class="price-box clearfix" itemscope itemtype="http://schema.org/Offer">
                                    <link itemprop="url" href="{link_xem}" />
                                    <meta itemprop="priceValidUntil" content="2030-11-05" />
                                    <div class="special-price">
                                        <span class="price-label">Giá:</span>
                                        <span class="price product-price" id="price">{gia_moi}</span>
                                        <span class="currency">₫</span>
                                        <meta itemprop="price" content="{gia_moi}">
                                        <meta itemprop="priceCurrency" content="VND">
                                    </div>
                                    <div class="old-price" itemprop="priceSpecification" itemscope
                                        itemtype="http://schema.org/priceSpecification">
                                        <span class="price product-price-old">Giá cũ: <span
                                                id="old-price" style="text-decoration: line-through;" >{gia_cu}</span>₫</span>
                                        <meta itemprop="price" content="{gia_cu}">
                                        <meta itemprop="priceCurrency" content="VND">
                                    </div>
                                </div>

                                <div class="form-product box-product-change">
                                    <div class="options-row"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <div class="color-options" style="flex: 1;">
                                            <div class="color-swatches">
                                                {option_mau}
                                            </div>
                                        </div>
                                        <div class="size-options" style="flex: 1; text-align: right;">
                                            {option_size}
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <div class="custom custom-btn-number form-control">
                                            <label>Số lượng</label>
                                            <button
                                                onclick="var result = document.getElementById('quantity_view'); var qty = result.value; if( !isNaN(qty) && qty > 1 ) result.value--;return false;"
                                                class="btn-minus btn-cts" type="button">–</button>
                                            <input type="text" class="qty input-text" id="quantity_view" name="quantity"
                                                size="4" value="1" />
                                                <button
                                                onclick="var result = document.getElementById('quantity_view'); var qty = result.value; if( !isNaN(qty)) result.value++;return false;"
                                                class="btn-plus btn-cts" type="button">+</button>
                                        </div>
                                            {box_flash_sale}
                                        <div style="clear: both;"></div>
                                        <div class="clearfix">
                                            <button type="submit"
                                                class="btn btn-lg btn-gray btn-cart btn_buy add_to_cart {disabled}"
                                                id="buy-button" sp_id="{sp_id}" loai="{loai}">
                                                <span class="txt-main">{text_button}</span>
                                            </button>
                                        </div>
                                        
                                        <div class="support-container">
                                            <div class="hotline_support">
                                                <a href="tel:0943051818" class="hotline_button">
                                                    <i class="fa fa-phone"></i>
                                                    Hotline
                                                </a>
                                            </div>
                                            <div class="zalo_support">
                                                <a href="https://zalo.me/{hotline_number}" class="zalo-button">
                                                    <i class="zalo-icon"></i> Tư vấn miễn phí Zalo
                                                </a>
                                            </div>
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
                                                    <span class="more-text"> Thu gọn<i
                                                            class="fa fa-chevron-down"></i></span>
                                                    <span class="less-text">Xem thêm <i
                                                            class="fa fa-chevron-up"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Section -->
                                <div id="tab-2" class="tab-content-reviews">
                                    <div class="product-reviews">
                                        <!-- <div class="review-stats">
                                            <span>{total_reviews}</span>
                                            <span class="review-avg">{average_rating}</span>
                                        </div> -->
                                        <div class="review-form-container">
                                            <div id="review-message" style="display:none; margin-bottom:15px;"></div>
                                            {review_form}
                                        </div>
                                        <div class="reviews-list">
                                            {list_reviews}
                                        </div>
                                    </div>
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
                        <div
                            class="section-tour-owl owl-carousel not-dqowl products-view-grid owl-loaded owl-drag box_daxem">
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
    </section>

    <style>
        .details-product .form-product .form-group button
        {
            border-radius: 6px !important;
        }
        .details-product .product-top .title-head {
            text-transform: capitalize;
        }

        .breadcrumb {
            padding: 0;
        }

        .color-options {
            margin-bottom: 8px;
        }

        .color-options label {
            display: block;
            margin-bottom: 4px;
            font-size: 11px;
            font-weight: 500;
        }

        .color-swatches {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .color-swatch {
            position: relative;
        }

        .color-swatch input[type="radio"] {
            display: none;
        }

        .color-swatch label {
            display: block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
            padding: 0;
            text-indent: -9999px;
            overflow: hidden;
        }

        .color-swatch input[type="radio"]:checked+label {
            border-color: #333;
            box-shadow: 0 0 0 1px #fff, 0 0 0 2px #333;
            transform: scale(1.05);
        }

        .color-swatch label:hover {
            transform: scale(1.05);
            border-color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .size-options {
            margin-bottom: 20px;
        }

        .size-options label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: start;
            margin: 0;
            padding: 2px 0px 2px 0;
        }

        .size-swatches {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .size-swatch {
            position: relative;
        }

        .size-swatch input[type="radio"] {
            display: none;
        }

        .size-swatch label {
            display: inline-block;
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 60px;
            text-align: center;
            background: #fff;
        }

        .size-swatch input[type="radio"]:checked+label {
            border-color: #333;
            background-color: #f5f5f5;
        }

        .size-swatch label:hover {
            border-color: #333;
        }

        .size-swatch .crossed-out,
        .size-swatch .img-check {
            display: none;
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            z-index: 2;
        }

        .support-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .support-container>div {
            flex: 1;
        }

        .support-container a {
            display: block;
            text-align: center;
            padding: 3px 0;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            border-radius: 2px;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .support-container a:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .zalo_support a {
            background: #0068ff;
        }

        .hotline_support a {
            background-color: #EF4B4C;
        }

        .btn_buy {
            display: inline-block;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(45deg, #2196F3, #1976D2);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.2);
            margin-bottom: 15px;
            width: 100%;
            text-align: center;
        }

        .btn_buy:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.3);
            background: linear-gradient(45deg, #1976D2, #1565C0);
        }

        .btn_buy:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .support-container {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .support-container a {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .hotline_support a {
            background: linear-gradient(45deg, #FF4B4B, #E53935);
            box-shadow: 0 4px 15px rgba(229, 57, 53, 0.2);
        }

        .hotline_support a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 57, 53, 0.3);
            background: linear-gradient(45deg, #E53935, #D32F2F);
        }

        .zalo_support a {
            background: linear-gradient(45deg, #0068FF, #0052CC);
            box-shadow: 0 4px 15px rgba(0, 104, 255, 0.2);
        }

        .zalo_support a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 104, 255, 0.3);
            background: linear-gradient(45deg, #0052CC, #0047B3);
        }

        .support-container a i {
            margin-right: 8px;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .support-container {
                flex-direction: column;
                gap: 10px;
            }

            .support-container a {
                width: 100%;
                padding: 10px 15px;
            }

            .options-row {
                /* flex-direction: column !important; */
                align-items: flex-start !important;
            }

            .size-options {
                text-align: left !important;
                margin-top: 5px;
            }
        }

        .swatch-element {
            display: block;
        }

        body,
        .product,
        .details-product,
        .details-pro,
        .form-product,
        .product-bottom {
            background: #fff;
        }

        .form-product.box-product-change{
            padding-left: 10px ;
        }

        .bread-crumb {
            background: #f8f9fa;
            padding: 15px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .breadcrumb li {
            display: flex;
            align-items: center;
            color: #6c757d;
        }

        .flashsale__label {
            text-align: center;
        }

        .breadcrumb li:not(:last-child)::after {
            content: '/';
            margin: 0 10px;
            color: #dee2e6;
        }

        .breadcrumb a {
            color: #495057;
            text-decoration: none;
            transition: color 0.3s ease;
        }


        .breadcrumb a:hover {
            color: #2196F3;
        }

        .breadcrumb strong {
            color: #212529;
            font-weight: 500;
        }

        .details-product .product-tab .product-well {
            border: 1px solid #d6cece;
        }

        .title-head {
            font-size: 28px;
            font-weight: 600;
            color: #212529;
            margin: 0;
            line-height: 1.3;
            text-align: left;
            text-transform: none;
        }

        .inventory_quantity {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .inventory_quantity span {
            font-size: 14px;
            color: #495057;
        }

        .a-stock {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .price-box {
            margin: 20px 0;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .special-price {
            font-size: 24px;
            font-weight: 600;
            color: #dc3545;
            margin-bottom: 5px;
        }

        .old-price {
            font-size: 16px;
            color: #6c757d;
            margin-right: 12px;
        }

        .old-price del {
            text-decoration: line-through;
        }

        .product-image-block {
            margin-bottom: 30px;
        }

        .large-image {
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .large-image img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .large-image:hover img {
            transform: scale(1.02);
        }

        .thumbnail-product {
            margin-top: 20px;
        }

        .thumbnail-product .swiper-slide {
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .thumbnail-product .swiper-slide:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .thumbnail-product img {
            width: 100%;
            height: auto;
        }

        .owl-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
        }

        .owl-prev,
        .owl-next {
            width: 30px;
            height: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .owl-prev:hover,
        .owl-next:hover {
            background: #fff;
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .owl-prev i,
        .owl-next i {
            font-size: 18px;
            color: #495057;
        }

        @media screen and (max-width: 768px) {
            .support-container {
                gap: 8px;
                margin-top: 10px;
                display: flex;
                flex-wrap: nowrap;
                justify-content: flex-end;
                align-items: center;
                align-content: stretch;
                flex-direction: row;
            }
        }

        .details-pro {
            padding: 10px;
        }

        .inventory_quantity {
            margin: 0;
        }

        .price-box {
            margin: 15px 0;
            background: #fff;
        }

        .color-options {
            margin-bottom: 10px;
        }

        .color-swatches {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .n-sd.swatch-element label {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ddd;
        }

        .size-options {
            margin-bottom: 10px;
        }

        .size-swatches {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .size-swatch label {
            padding: 4px 8px;
            min-width: 30px;
            font-size: 11px;
        }

        .support-container {
            gap: 8px;
            margin-top: 10px;
        }

        .support-container a {
            padding: 8px 12px;
            font-size: 13px;
        }

        .price-box .special-price {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
        }

        .price-box .price-label {
            font-size: 16px;
            font-weight: normal;
            color: #333;
        }

        .price-box .price.product-price {
            font-size: 24px;
            font-weight: 600;
            color: #d70018;
        }

        .price-box .currency {
            font-size: 16px;
            font-weight: normal;
            color: #333;
        }

        .special-price .price.product-price {
            color: #d70018 !important;
        }

        @media (max-width: 768px) {
            .details-pro {
                padding: 8px;
            }
        }

        .price-box { 
            display: flex;
            align-items: center;
            margin: 20px 0;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .special-price,
        .old-price {
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .special-price {
            font-size: 24px;
            font-weight: 600;
            color: #dc3545;
        }

        .old-price {
            font-size: 16px;
            color: #6c757d;
        }

        .price.product-price,
        .price.product-price-old {
            display: inline-block;
            line-height: 1.5;
        }

        .details-product .details-pro .price-box {
            padding: 0;
        }

        @media (max-width: 576px) {
            .price-box {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }

        /* Review Section Styles */
        .product-reviews {
            padding: 20px;
            background: #fafbfc;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            margin-bottom: 30px;
        }
        .review-stats {
            font-size: 18px;
            margin-bottom: 18px;
            color: #e53935;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .review-avg {
            background: #ffd700;
            color: #222;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 16px;
            margin-left: 6px;
        }
        .review-form {
            margin-bottom: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        }
        .review-form .form-group {
            margin-bottom: 15px;
        }
        .review-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
        }
        .rating input {
            display: none;
        }
        .rating label {
            cursor: pointer;
            font-size: 32px;
            color: #ddd;
            padding: 5px;
            transition: color 0.2s;
        }
        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #ffd700;
        }
        .review-item {
            border-bottom: 1px solid #eee;
            padding: 20px 0 10px 0;
            background: #fff;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .reviewer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #eee;
        }
        .reviewer-name {
            font-weight: 500;
            color: #333;
        }
        .review-rating {
            display: flex;
            gap: 2px;
        }
        .star {
            color: #ddd;
            font-size: 20px;
        }
        .star.filled {
            color: #ffd700;
        }
        .review-content {
            margin: 10px 0 0 0;
            color: #444;
        }
        .review-images {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        .review-images img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #eee;
            transition: box-shadow 0.2s;
        }
        .review-images img:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }
        .review-date {
            color: #888;
            font-size: 12px;
            margin-top: 4px;
        }
        .no-reviews {
            text-align: center;
            padding: 20px;
            color: #888;
        }
        @media (max-width: 768px) {
            .product-reviews {
                padding: 10px;
            }
            .review-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .review-images img {
                width: 70px;
                height: 70px;
            }
        }
    </style>
    <style type="text/css">
        .image-source-link {
            color: #98C3D1;
        }

        .mfp-with-zoom .mfp-container,
        .mfp-with-zoom.mfp-bg {
            opacity: 0;
            -webkit-backface-visibility: hidden;
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
    {script_variants}
    <script src="/dist/jquery.magnific-popup.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/dist/magnific-popup.css">
    <script type="text/javascript">
        $(document).ready(function () {
            $('.slide_photo').magnificPopup({
                delegate: 'a',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: { verticalFit: true },
                gallery: { enabled: true },
                zoom: {
                    enabled: true,
                    duration: 300,
                    opener: function (element) { return element.find('img'); }
                }
            });
            $('.large-image').magnificPopup({
                delegate: 'a',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: { verticalFit: true },
                gallery: { enabled: true },
                zoom: {
                    enabled: true,
                    duration: 300,
                    opener: function (element) { return element.find('img'); }
                }
            });
        });
    </script>
   
    {footer}
    {script_footer}
    <script>
        var slide_recent = new Swiper('.slide_photo', {
            direction: 'horizontal',
            slidesPerView: 1,
            loop: false,
            observer: true,
            observeParents: true,
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
            navigation: {
                nextEl: '#gallery_01 .owl-next',
                prevEl: '#gallery_01 .owl-prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        })
        var slide_recent = new Swiper('.slide_lienquan', {
            direction: 'horizontal',
            slidesPerView: 1,
            loop: true,
            observer: true,
            observeParents: true,
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
            navigation: {
                nextEl: '.related-product .owl-next',
                prevEl: '.related-product .owl-prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        })
        var slide_banner = new Swiper('.slide_daxem', {
            direction: 'horizontal',
            slidesPerView: 1,
            loop: true,
            observer: true,
            observeParents: true,
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
            navigation: {
                nextEl: '.box_daxem .owl-next',
                prevEl: '.box_daxem .owl-prev',
            },
        })
    </script>
    <script type="text/javascript" charset="utf-8">
        $(function () {
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

    <script>
        // Review Form Handler
            $(document).ready(function () {
                $('#review-form').on('submit', function (e) {
                    e.preventDefault();
        
                    // Hiển thị overlay và thông báo đang xử lý
                    $(".load_overlay").show();
                    $(".load_process").show();
                    $(".load_note").html("Đang xử lý...");
        
                    var formData = new FormData(this);
                    formData.append('action', 'submit_review');
        
                    $.ajax({
                        url: '/process.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            try {
                                var result = JSON.parse(response);
                                
                                // Hiển thị thông báo trả về từ server sau 1 giây
                               
        
                                // Ẩn overlay và thông báo sau 2 giây
                                setTimeout(function () {
                                    $(".load_process").hide();
                                    $(".load_note").html("Hệ thống đang xử lý");
                                    $(".load_overlay").hide();
        
                                    if (result.success) {
                                      //  alert('Cảm ơn bạn đã đánh giá sản phẩm!');
                                        setTimeout(function () {
                                            $(".load_note").html(result.thongbao || 'Cảm ơn bạn đã đánh giá sản phẩm!');
                                        }, 3000);
                                        location.reload();
                                    } else {
                                        alert(result.message || 'Có lỗi xảy ra, vui lòng thử lại!');
                                    }
                                }, 2000);
                            } catch (e) {
                                $(".load_process").hide();
                                $(".load_note").html("Hệ thống đang xử lý");
                                $(".load_overlay").hide();
                                alert('Có lỗi xảy ra, vui lòng thử lại!');
                            }
                        },
                        error: function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
                            alert('Có lỗi xảy ra, vui lòng thử lại!');
                        }
                    });
                });
        
                // Image preview
                       
            // Image preview
            $('input[type="file"]').on('change', function() {
                var files = this.files;
                var preview = $('<div class="image-preview"></div>');
                for(var i = 0; i < files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.append('<img src="' + e.target.result + '">');
                    }
                    reader.readAsDataURL(files[i]);
                }
                $(this).after(preview);
            });
        });
    </script>
  
    
</body>

</html>