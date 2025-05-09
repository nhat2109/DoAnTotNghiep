<div class="owl-item swiper-slide">
    <div class="product-item">
        <div class="product-item-container grid-view-item">
            <div class="left-block product-image-container product-image">
                <a class="grid-view-item__link image-ajax" href="/product/{link}.html" title="{tieu_de}">
                    <img class="first-img img-responsive center-block" src="{minh_hoa}" data-src="{minh_hoa}" alt="{tieu_de}">
                </a>
                {label_sale}
                {icon_label}
                <div class="button-link">
                    <button class="btn_df tt-btn-addtocart btn-cart btn btn-gray left-to" title="Chọn sản phẩm" loai="{loai}" type="button" onclick="window.location.href='/product/{link}.html'">
                        <i class="ion ion-md-redo"></i> Tùy chọn
                    </button>
                </div>
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