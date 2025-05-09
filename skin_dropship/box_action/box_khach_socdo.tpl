<div class="box_khach_order" loai_box="khach_socdo" xuly="0">
    <div class="title"><span class="text">Khách hàng <span class="number">1</span></span><span style="display: none;" class="text_xuly">Đang xử lý...</span><span class="min_max"><i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down" style="display: none;"></i></span></div>
    <div class="info_khach_order">
        <div class="li_group_input">
            <div class="li_input" style="width: 100%;">
                <label for="">Tiền COD <span class="color_red">(*)</span></label>
                <input type="text" class="form_control price_format" name="cod" value="" placeholder="Nhập số tiền cod...">
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input">
                <label for="">Họ và tên khách hàng <span class="color_red">(*)</span></label>
                <input type="text" class="form_control" name="ho_ten" value="" placeholder="Nhập tên người nhận...">
            </div>
            <div class="li_input">
                <label for="">Điện thoại khách hàng<span class="color_red">(*)</span></label>
                <input type="text" class="form_control" name="dien_thoai" value="" placeholder="Nhập số điện thoại người nhận...">
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input">
                <label for="">Công ty vận chuyển <span class="color_red">(*)</span></label>
                <select class="form_control" name="congty_ship">
                    <option value="">Chọn dịch vụ</option>
                    <option value="ninja_van">NINJA VAN</option>
                    <option value="viettel_post" selected="selected">VIETTEL POST</option>
                </select>
            </div>
            <div class="li_input">
                <label for="">Tỉnh/Thành phố <span class="color_red">(*)</span></label>
                <select class="form_control" name="tinh" id="customer_shipping_province_gop">
                    <option value="">Chọn tỉnh/thành phố</option>
                    {option_tinh}
                </select>
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input">
                <label for="">Quận/Huyện <span class="color_red">(*)</span></label>
                <select class="form_control" name="huyen" id="customer_shipping_district_gop">
                    <option value="">Chọn quận/huyện</option>
                </select>
            </div>
            <div class="li_input">
                <label for="">Xã/Phường <span class="color_red">(*)</span></label>
                <select class="form_control" name="xa" id="customer_shipping_ward_gop">
                    <option value="">Chọn xã/phường</option>
                </select>
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input" style="width: 100%;">
                <label for="">Địa chỉ <span class="color_red">(*)</span></label>
                <input type="text" class="form_control" name="dia_chi" value="" placeholder="Nhập địa chỉ người nhận...">
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input">
                <label for="">Dịch vụ giao hàng <span class="color_red">(*)</span></label>
                <select class="form_control" name="dichvu_ship">
                    <option value="">Chọn dịch vụ</option>
                </select>
            </div>
            <div class="li_input">
                <label for="">Phí giao hàng <span class="color_red">(*)</span></label>
                <select class="form_control" name="chiu_ship">
                    <option value="khach">Khách hàng chịu phí</option>
                    <option value="shop">Người bán chịu phí</option>
                </select>
            </div>
        </div>
        <div class="li_group_input">
            <div class="li_input" style="width: 100%;">
                <label for="">Ghi chú</label>
                <textarea name="ghi_chu" placeholder="Nhập ghi chú"></textarea>
            </div>
        </div>
        <div class="info_don_hang" box="">
            <div class="li_info_donhang tongtien_don" total_price="">Tạm tính: <span></span></div>
            <div class="li_info_donhang phiship_don" phi="">Phí ship: <span></span></div>
            <div class="li_info_donhang hoahong_don">Hoa hồng: <span></span></div>
        </div>
        <div class="li_group_input">
            <div class="del_khach_order">
                <i class="fa fa-trash-o"></i> xóa
            </div>
        </div>
    </div>
</div>