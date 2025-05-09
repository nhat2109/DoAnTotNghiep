<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 1000px;padding: 10px;">
            <div class="box_top_profile">
                <div class="box_timkiem">
                    <a href="/dropship/add-donhang-drop?step=2"><button class="button_timkiem" style="border-radius: 5px;"><i class="fa fa-angle-double-left"></i> Quay lại</button></a>
                </div>
                <div class="box_shopcart"><a href="/dropship/add-donhang-drop?step=2"><i class="icon icon-basket"></i> (<span>{total_cart}</span>)</a></div>
            </div>
            <div style="clear: both;"></div>
            <div class="box_order_info">
                <div class="box_order_info_left box_order_info_left_gop" style="order: 1;width: 100%;padding-bottom: 40px;">
                    <div class="page_title">
                        <h1 class="undefined">DANH SÁCH ĐƠN HÀNG</h1>
                        <div class="line"></div>
                        <hr>
                    </div>
                    <div class="col_100 list_khach_order">
                    </div>
                    <div class="add_order">
                        <button id="add_order"><i class="fa fa-plus"></i> Thêm người nhận</button>
                        <div class="list_doituong">
                            <div class="li_doituong" khach="socdo">Thêm khách hàng</div>
                            <div class="li_doituong" khach="san">Thêm khách hàng sàn TMĐT</div>
                        </div>
                    </div>
                    <div class="box_button">
                        <button class="button_hoanthanh bg_green" name="button_hoanthanh_gop" check_ok="0" style="display: none;">Hoàn thành</button>
                    </div>
                </div>
                <div class="box_order_info_right" style="order: 0;width: 100%;">
                    <div class="page_title">
                        <h1 class="undefined">THÔNG TIN SẢN PHẨM</h1>
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