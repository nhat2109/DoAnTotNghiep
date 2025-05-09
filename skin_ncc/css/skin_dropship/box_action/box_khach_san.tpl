<div class="box_khach_order" loai_box="khach_san" xuly="0">
    <div class="title"><span class="text">Khách hàng <span class="number">1</span></span><span style="display: none;" class="text_xuly">Đang xử lý...</span><span class="min_max"><i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down" style="display: none;"></i></span></div>
    <div class="info_khach_order">
        <div class="info_don_hang">
            <div class="tongtien_don">Tổng tiền: <span></span></div>
        </div>
        <div class="li_group_input">
            <div class="li_input">
                <label for="">Họ và tên <span class="color_red">(*)</span></label>
                <input type="text" name="ho_ten" value="" placeholder="Nhập tên người nhận...">
            </div>
            <div class="li_input">
                <label for="">Điện thoại <span class="color_red">(*)</span></label>
                <input type="text" name="dien_thoai" value="" placeholder="Nhập số điện thoại người nhận...">
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input" style="width: 100%;">
                <label for="">Địa chỉ</label>
                <input type="text" name="dia_chi" value="" placeholder="Nhập địa chỉ người nhận...">
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input">
                <label for="">Tỉnh/Thành phố</label>
                <select name="tinh" id="customer_shipping_province_gop">
                    <option value="">Chọn tỉnh/thành phố</option>
                    {option_tinh}
                </select>
            </div>
            <div class="li_input">
                <label for="">Quận/Huyện</label>
                <select name="huyen" id="customer_shipping_district_gop">
                    <option value="">Chọn quận/huyện</option>
                </select>
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input" style="width: 100%;">
                <label for="">File đính kèm</label>
                <input type="file" id="minh_hoa">
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input" style="width: 100%;">
                <label for="">File đính kèm</label>
                <input type="file" id="minh_hoa2">
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input" style="width: 100%;">
                <label for="">Ghi chú</label>
                <textarea name="ghi_chu" placeholder="Nhập ghi chú"></textarea>
            </div>
        </div>
        <div class="li_group_input">
            <div class="del_khach_order">
                <i class="fa fa-trash-o"></i> xóa
            </div>
        </div>
    </div>
</div>