<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 800px;padding: 10px;">
            <div class="box_top_profile">
                <div class="box_timkiem">
                    <a href="/dropship/add-donhang-drop?step=2"><button class="button_timkiem" style="border-radius: 5px;"><i class="fa fa-angle-double-left"></i> Quay lại</button></a>
                </div>
                <div class="box_shopcart"><a href="/dropship/add-donhang-drop?step=2"><i class="icon icon-basket"></i> (<span>{total_cart}</span>)</a></div>
            </div>
            <div style="clear: both;"></div>
            <div class="box_order_info">
                <div class="box_order_info_left box_order_info_left_bt">
                    <div class="page_title">
                        <h1 class="undefined">Thông tin giao hàng</h1>
                        <div class="line"></div>
                        <hr>
                    </div>
                    <div class="col_100">
                        <div style="clear: both;"></div>
                        <div class="form_group">
                            <label for="">Họ và tên <span class="color_red">(*)</span></label>
                            <input type="text" class="form_control" name="ho_ten" value="" placeholder="Nhập tên người nhận...">
                        </div>
                        <div class="form_group">
                            <label for="">Điện thoại <span class="color_red">(*)</span></label>
                            <input type="text" class="form_control" name="dien_thoai" value="" placeholder="Nhập số điện thoại người nhận...">
                        </div>
                        <div class="form_group">
                            <label for="">Địa chỉ</label>
                            <input type="text" class="form_control" name="dia_chi" value="" placeholder="Nhập địa chỉ người nhận...">
                        </div>
                        <div class="form_group">
                            <label for="">Tỉnh/Thành phố</label>
                            <select class="form_control" name="tinh" id="customer_shipping_province_bt">
                                <option value="">Chọn tỉnh/thành phố</option>
                                {option_tinh}
                            </select>
                        </div>
                        <div class="form_group">
                            <label for="">Quận/Huyện</label>
                            <select class="form_control" name="huyen" id="customer_shipping_district_bt">
                                <option value="">Chọn quận/huyện</option>
                            </select>
                        </div>
                        <div class="form_group">
                            <label for="">File đính kèm</label>
                            <input type="file" id="minh_hoa">
                        </div>
                        <div class="form_group">
                            <label for="">File đính kèm</label>
                            <input type="file" id="minh_hoa2">
                        </div>
                        <div class="form_group">
                            <label for="">Ghi chú</label>
                            <textarea name="ghi_chu" class="form_control" placeholder="Nhập ghi chú" style="width: 100%;height: 95px;"></textarea>
                        </div>
                    </div>
                    <div class="box_button">
                        <button class="button_hoanthanh bg_green" name="button_hoanthanh">Hoàn thành</button>
                    </div>
                </div>
                <div class="box_order_info_right">
                    <div class="page_title">
                        <h1 class="undefined">Thông tin đơn hàng</h1>
                        <div class="line"></div>
                        <hr>
                    </div>
                    {list_sanpham}
                    <div class="tongtien">Tổng tiền: <span class="total_price">{total_price}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>