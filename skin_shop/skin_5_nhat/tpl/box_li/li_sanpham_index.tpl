<!-- // minhthem2404 -->
<div class="li_sanpham swiper-slide">
    <div class="minh_hoa">
        {label_sale}
        {icon_label}
        <div class="button-link">
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
        <a href="/product/{link}.html">
            <img src="{minh_hoa}" alt="{tieu_de}">
        </a>
    </div>
    <div class="info">
        <h4><a href="/product/{link}.html" title="{tieu_de}">{tieu_de}</a></h4>
        <div class="price">
            <span class="price-old">{gia_cu}₫</span>
            <span class="price-new">{gia_moi}₫</span>            
        </div>
    </div>
</div>