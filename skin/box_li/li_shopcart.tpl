<div class="li_shopcart">
    <div class="name">
        <div class="minh_hoa">
            <a href="/product/{link}.html" title="{tieu_de}">
                <img src="{minh_hoa}" alt="{tieu_de}">
            </a>
        </div>
        <div class="info">
            <div class="tieu_de">
                <a href="/product/{link}.html">{ten_sanpham}</a>
            </div>
            <div class="color">
                {ten_size}
                {ten_color}
            </div>
            <div class="action" sp_id="{sp_id}" data-pl="{pl}">Xóa</div>
        </div>
    </div>
    <div class="so_luong">
        <div class="so_luong_content">
            <button sp_id="{sp_id}_{pl}"><i class="fa fa-minus"></i></button>
            <input type="text" name="so_luong" value="{quantity}" sp_id="{sp_id}_{pl}">
            <button sp_id="{sp_id}_{pl}"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="gia">
        <div class="gia_content">
            <div class="price_new">{gia_moi} đ</div>
            <div class="price_old">{gia_cu} đ</div>
        </div>
    </div>
</div>
<style>
    .action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 12px;
        background-color: #ff4d4d;
        color: white;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .action i { font-size: 16px; }
    .action:hover { background-color: #e60000; transform: scale(1.05);}
    .action:active { transform: scale(0.95);}
    .list_shopcart { max-height: 250px; overflow-y: auto; overflow-x: hidden;}
</style>