<div class="li_shopcart">
    <div class="minh_hoa">
        <a href="/product/{link}.html">
            <img src="/thumbnail.php?w=320&img={minh_hoa}" alt="{tieu_de}">
        </a>
    </div>
    <div class="info">
        <div class="tieude">
            <a href="/product/{link}.html">{tieu_de}</a>
            <a href="javascript:;" class="remove_cart" sp_id="{id}">Xóa</a>
        </div>
        <div class="list_size">
            {list_size}
        </div>
        <div class="list_color">
            {list_color}
        </div>
        <div class="box_quantity">
            <button type="button" class="button_minus" sp_id="{id}">–</button>
            <input type="text" name="quantity" size="4" sp_id="{id}" value="{quantity}">
            <button type="button" class="button_plus" sp_id="{id}">+</button>
        </div>
        <div class="price"><span class="text_price">Giá: </span>{gia_nhap}₫</div>
        <div class="thanhtien"><span class="text_price">Thành tiền: </span>{thanhtien}₫</div>
    </div>
</div>