<div class="col-xs-6 col-sm-4 col-md-3 col-lg-15">
    <div class="product-item">
        <div class="product-item-container grid-view-item">
            <div class="left-block product-image-container product-image">
                <a class="grid-view-item__link image-ajax" href="/product/{link}.html" title="{tieu_de}">
                    <img class="first-img img-responsive center-block" src="/thumbnail.php?w=320&img={minh_hoa}" data-src="{minh_hoa}" alt="{tieu_de}" />
                </a>
                {label_sale}
                {icon_label}
                <div class="button-link">
                    <button disabled="disabled" class="btn_df tt-btn-addtocart btn-cart btn btn-gray left-to" loai="{loai}" title="Hết hàng" type="button">
                        <i class="ion ion-md-redo"></i> Hết hàng
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