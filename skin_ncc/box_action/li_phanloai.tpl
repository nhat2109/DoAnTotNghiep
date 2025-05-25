<div class="li_phanloai">
    <div class="info_ma">
        <input type="text" name="ma[]" placeholder="Mã" value="{ma_sp}">
    </div>
    <div class="info_name">
        <input type="text" name="size[]" giatri="{size}" placeholder="Kích cỡ" value="{ten_size}">
        <input type="hidden" name="ten_size[]" giatri="{size}" value="{ten_size}">
        <div class="list_goiy scroll"></div>
    </div>
    <div class="info_mau">
        <input type="text" name="color[]" giatri="{color}" placeholder="Màu sắc" value="{ten_color}">
        <input type="hidden" name="ten_color[]" value="{ten_color}" giatri="{color}">
        <input type="hidden" name="ma_mau[]" value="{ten_color}" giatri="{color}" ma_mau="{ma_mau}">
        <div class="list_goiy scroll"></div>
    </div>
    <div class="info_can_nang">
        <input type="text" name="can_nang[]" placeholder="Trọng lượng" value="{can_nang}">
    </div>
    <div class="info_gia">
        <input type="text" name="gia_cu[]" class="price_format" placeholder="Giá niêm yết" value="{gia_cu}">
    </div>
    <div class="info_gia">
        <input type="text" name="gia_moi[]" class="price_format" placeholder="Giá bán" value="{gia_moi}">
    </div>
    <div class="info_kho_sanpham_shop">
        <input type="text" name="kho_sanpham_shop[]" class="price_format" placeholder="Số hàng trong kho"
            value="{kho_sanpham_shop}">
    </div>
    <div class="info_trongluongtinhship">
        <input type="text" name="trongluongtinhship[]" class="price_format" readonly value="{can_nang_tinhship}">
    </div>
    <div class="info_action"><i class="fa fa-trash-o"></i></div>
    <div class="info_action_copy"><i class="fa fa-files-o"></i></div>
</div>