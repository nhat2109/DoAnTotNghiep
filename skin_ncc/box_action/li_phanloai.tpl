<div class="li_phanloai">
    <div class="info_ma">
        <input type="text" name="ma[]" placeholder="Mã" value="{ma_sp}">
    </div>
    <div class="info_name">
        <input type="text" name="size[]" giatri="{size_socdo}" placeholder="Kích cỡ" value="{ten_size_socdo}">
        <input type="hidden" name="ten_size[]" giatri="{size_socdo}" value="{ten_size_socdo}">
        <div class="list_goiy scroll"></div>
    </div>
    <div class="info_mau">
        <input type="text" name="color[]" giatri="{color_socdo}" placeholder="Màu sắc" value="{ten_color_socdo}">
        <input type="hidden" name="ten_color[]" value="{ten_color_socdo}" giatri="{color_socdo}">
        <input type="hidden" name="ma_mau[]" value="{ten_color_socdo}" giatri="{color_socdo}" ma_mau="{ma_mau}">
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
    <div class="info_gia">
        <input type="text" name="gia_drop[]" class="price_format" placeholder="Giá Nhà Bán Chuyên Nghiệp"
            value="{gia_drop}">
    </div>
    <div class="info_gia">
        <input type="text" name="gia_ctv[]" class="price_format" placeholder="Giá Hội Viên" value="{gia_ctv}">
    </div>
    <div class="info_gia">
        <input type="text" name="gia_socdo[]" class="price_format" placeholder="Giá trên Sóc Đỏ" value="{gia_socdo}">
    </div>
    <div class="info_kho_sanpham_shop">
        <input type="text" name="kho_sanpham_shop[]" class="price_format" placeholder="Số hàng trong kho"
            value="{kho_sanpham_shop}">
    </div>
    <div class="info_trongluongtinhship">
        <input type="text" name="trongluongtinhship[]" class="price_format" readonly value="{can_nang_tinhship}">
    </div>
    <div class="info_action"><i class="fa fa-trash-o"></i> Xóa</div>
    <div class="info_action_copy"><i class="fa fa-files-o"></i> Sao chép</div>
</div>