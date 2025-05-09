<div class="li_product li_product_{id}" sp="{id}">
    <div class="thumbnail">
        <img src="/thumbnail.php?w=320&img={minh_hoa}" alt="{tieu_de}">
    </div>
    <div class="info">
        <div class="name">{tieu_de}</div>
        <div class="price">
            <div class="price-old">{gia_cu}</div>
            <div class="price-new">{gia_moi}</div>
        </div>
        <div class="price_deal">
            <input type="text" name="gia_deal[]" class="price_format" placeholder="Nhập giá khuyến mại" value="{gia_deal}"><span>đ</span> <!-- <span style="padding-right: 20px;padding-left: 20px;">Hoặc</span> <input type="text" name="sale_deal[]" class="price_format" value="{sale_deal}" placeholder="Nhập % khuyến mại"><span>%</span> -->
        </div>
    </div>
    <div class="action">
        <button sp="{id}">Xóa</button>
    </div>
</div>