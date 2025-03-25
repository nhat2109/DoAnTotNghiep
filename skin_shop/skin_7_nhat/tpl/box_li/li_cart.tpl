

<li class="item">
    <div class="border_list">
        <div class="image_drop">
            <a class="product-image pos-relative embed-responsive embed-responsive-1by1"
            href="/product/{link}.html" title="{tieu_de}" target="_blank">
                <img loading="lazy" src="/thumbnail.php?w=320&img={minh_hoa}" alt="{tieu_de}"
                    width="'+ '100' +'" \="" />
            </a>
        </div>
        <div class="detail-item">
            <div class="product-details box-info-product">
                <p class="action">
                    <a href="javascript:;" title="Xóa" class="btn fa fa-times btn-link btn-item-delete remove-item-cart" data-id="{id}">
                        </a>
                    </p>
                
                <p class="product-name">
                    <a class="link" href="/product/{link}.html" title="{tieu_de}" target="_blank">{ten_sanpham}</a>
                </p>
            </div>
            <span class="variant-title"></span>
            <div class="product-details-bottom">
                <p class="price">{gia_moi}₫</p>
                <span class="quanlity">x {quantity}</span>
               
            </div>
        </div>
    </div>
</li>
<style>
    .header-right p a {
        color: var(--text-color) !important;
    }
    .header-right a {
        color: var(--header-color);
        display: flex;
        justify-content: flex-start;
    }    
    .search__list a {
        font-size: 12px;
        color: #6c757d;
    }
    
</style>