<div class="li_product li_muakem swiper-slide">
    <div class="product-content">
        <div class="product-thumbnail">
            <a href="/product/{link}.html">
                <img class="minh_hoa" src="/thumbnail.php?w=320&img={minh_hoa}">
            </a>
            {label_sale}
        </div>
        <div class="product-info">
            <h3 class="product-name"><a href="/product/{link}.html" title="{tieu_de}"> {tieu_de}</a></h3>
            <div class="price-box">
                <span class="price">{gia_moi}₫</span>
                <span class="compare-price">{gia_cu}₫</span>
            </div>
            <div class="check_product">
                <input type="checkbox" name="sub_id[]" value="{id}" checked="checked" id="product_{id}" name="check_product">
                <label for="product_{id}"><i class="fa fa-square-o"></i><i class="fa fa-check-square"></i>Chọn sản phẩm</label>
            </div>
        </div>
    </div>
</div>