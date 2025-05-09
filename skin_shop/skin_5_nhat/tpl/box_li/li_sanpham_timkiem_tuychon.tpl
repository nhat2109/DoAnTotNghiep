<div class="col-xs-6 col-sm-4 col-md-3 col-lg-15">
    <div class="product-item">
        <div class="product-item-container grid-view-item">
            <div class="left-block product-image-container product-image">
                <a class="grid-view-item__link image-ajax" href="/product/{link}.html" title="{tieu_de}">
                    <img class="first-img img-responsive center-block" src="{minh_hoa}" data-src="{minh_hoa}" alt="{tieu_de}" />
                </a>
                {label_sale}
                {icon_label}
                <!-- <div class="button-link">
                    <button class="btn_df tt-btn-addtocart btn-cart btn btn-gray left-to" title="Chọn sản phẩm" loai="{loai}" type="button" onclick="window.location.href='/products/{link}.html'">
                        <i class="ion ion-md-basket"></i> Mua ngay
                    </button>
                </div> -->
                <button class="btn_df tt-btn-quickview btn-buy btn-cart btn btn-gray left-to quick-view" data-id="{id}"
            data-color="{color}" data-size="{size}" data-link="{link}" title="Xem nhanh" style="
            padding: 2px -5px !important;
            font-size: 14px;
            background-color: #ff5722;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <i class="ion ion-md-eye" style="font-size: 16px; margin-right: 5px"></i>Xem nhanh
        </button>
            </div>
            <div class="right-block">
                <h4 class="title-product">
                    <a class="product-name line-clamp" href="/product/{link}.html" title="{tieu_de}">{tieu_de}</a>
                </h4>
                <div class="price">
                    <span class="price-old">{gia_cu}₫</span>
                    <span class="price-new">{gia_moi}₫</span>
                </div>
            </div>
        </div>
    </div>
</div>