<div class="li_sanpham swiper-slide">
    <div class="minh_hoa">
        {label_sale}
        {icon_label}
        <div class="button-link">
            <button disabled="disabled" loai="{loai}" title="Hết hàng">
                <i class="ion ion-md-redo"></i> Hết hàng
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