<div class="li_flash_sale">
    <div class="li_flash_sale_content">
        <div class="sale_badge">{discount_percent}%</div>
        <!-- <div class="favorite_icon"><i class="fas fa-heart"></i></div> -->
        <div class="hot_badge">BÁN CHẠY</div>
        <div class="minh_hoa">
            <a href="/product/{link}.html" title="{tieu_de}">
                <img src="{minh_hoa}" alt="{tieu_de}" />
            </a>
        </div>
        <div class="li_flash_sale_info">
            <h4 class="title-product">
                <a class="product-name line-clamp" href="/product/{link}.html" title="{tieu_de}">{tieu_de}</a>
            </h4>
            <div class="price">
                <span class="price-old">{gia_cu}</span>
                <span class="price-new">{gia_moi}</span>
            </div>
            <div class="button-link" style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                opacity: 0;
                transition: opacity 0.3s ease;
                z-index: 10;">
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
                <!-- <button type="submit" class="btn btn-cart btn_buy add_to_cart" id="buy-button" sp_id="{id}" loai=""
                    data-color="{color}" data-size="{size}">
                    <span class="txt-main">Thêm vào giỏ hàng</span>
                </button> -->
            </div>
        </div>
    </div>
</div>