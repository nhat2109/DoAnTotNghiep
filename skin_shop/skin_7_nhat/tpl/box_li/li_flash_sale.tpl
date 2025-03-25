
<div  class="col-12 col-12_mobile col-xl-3 product-col col-xl-3_lienquan">
    
    <!-- <div class="item product-col col-4 col-md-5 col-lg-15 "> -->
    <div class="item_product_main"  style="    border-radius: 10px;
    padding: 10px;
    border: 1px solid #d6d3d3;">
    
        <form action="/cart/add" method="post" class="variants product-action"
            data-id="product-actions-36595067" enctype="multipart/form-data">
            <div class="product-thumbnail pos-relative">
                <a class="image_thumb pos-relative embed-responsive embed-responsive-4by3"
                href="/product/{link}.html" title="{tieu_de}">
                    <img loading="lazy" class="img-fetured has-second-img" width="480"
                        height="480" style="--image-scale: 1"
                        src="/thumbnail.php?w=320&img={minh_hoa}" data-src="{minh_hoa}" alt="{tieu_de}"/>
                    <img loading="lazy"
                        class="product-thumbnail__img product-thumbnail__img--secondary"
                        width="480" height="480" style="--image-scale: 1"
                        src="/thumbnail.php?w=320&img={minh_hoa}" data-src="{minh_hoa}" alt="{tieu_de}"/>
                </a>
                <!-- <div class="label_product">
                    <div class="label_wrapper">{label_sale}
                        {icon_label}</div>
                </div> -->
                <input type="hidden" name="variantId" value="122127255" />
                <div class="action-bar">
                    <a href="/product/{link}.html"
                        class="action-child btn-circle btn-views btn_view btn right-to m-0">
                        <img width="20" height="20" class="icon-option"
                        src="/uploads/minh-hoa/icon-options.png"
                        alt="icon-option" />
                        <span class="action-name">Tùy chọn</span>
                    </a>

                    <a sp_id="{id}" loai="{loai}" class="action-child xem_nhanh btn-circle btn-views btn_view btn right-to quick-view xem-nhanh">
                        <i class="fas fa-eye"></i>
                        <span sp_id="{id}" loai="{loai}" class="action-name xem_nhanh_title">Xem nhanh</span>
                    </a>
                    
                </div>
            </div>
            <div class="product-info">
                <span class="product-vendor"></span>
                <span class="product-name">
                    <a class="link" href="/product/{link}.html" title="{tieu_de}">{tieu_de}</a>
                </span>
                <div class="sapo-product-reviews-badge" data-id="36595067"></div>
                <div class="product-item-cta position-relative">
                    <div class="price-box">
                        

                        <span class="price">{gia_moi}₫</span>

                        <span class="compare-price">{gia_cu}₫</span>

                        <!-- <div class="label_product d-inline-block">
                            <div class="label_wrapper">{label_sale}
                                {icon_label}</div>
                        </div> -->
                    </div>
                </div>

                <div class="item-color-chosen">
                </div>

              
            </div>
        </form>
    </div>
</div>


<div id="xem_nhanh" class="modal">
    <div class="modal-content">
        <!-- <span class="close">&times;</span> -->
        <div id="quick_view_content">
            <!-- Dữ liệu sản phẩm sẽ được AJAX cập nhật vào đây -->
        </div>
    </div>
</div>
<style>
    /* Định dạng cho mobile */
@media (max-width: 767px) {
    .col-12_mobile {
        flex: 0 0 50% !important;
    }
}
/* Định dạng cho tablet */
@media (min-width: 768px) and (max-width: 1023px) {
    .col-12_mobile {
        flex: 0 0 50% !important;
    }
}
</style>