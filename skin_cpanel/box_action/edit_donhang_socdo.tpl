<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="col_100">
                <div class="page_title">
                    <h1 class="undefined">Thông tin giao hàng</h1>
                    <div class="line"></div>
                    <hr>
                </div>
                <div class="address note">
                    <p><i class="fa fa-user"></i> {ho_ten}</p>
                    <p><i class="fa fa-map-marker"></i> {dia_chi}, {huyen}, {tinh}</p>
                    <p><i class="fa fa-phone"> </i><a href="tel:{dien_thoai}"> {dien_thoai}</a></p>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="page_title">
                <h1 class="undefined">Chi tiết đơn hàng</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Mã đơn: #{ma_don}</label>
                </div>
                <div class="form_group">
                    <label for="">Ngày tạo: </label>{date_post}
                </div>
                <div class="form_group">
                    <label for="">Tình trạng</label>
                    <select class="form_control" name="status">
                        <option value="0">Chờ xử lý</option>
                        <option value="1">Đã tiếp nhận đơn</option>
                        <option value="2">Đã giao đơn vị vận chuyển</option>
                        <option value="3">Yêu cầu hủy đơn</option>
                        <option value="4">Xác nhận hủy đơn</option>
                        <option value="5">Giao thành công</option>
                        <option value="6">Đã hoàn đơn</option>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <table id="order_details" class="table table-cart">
                    <thead class="thead-default">
                        <tr>
                            <th align="left">Sản phẩm</th>
                            <th style="width: 100px;">Giá</th>
                            <th style="width: 100px;">Giảm</th>
                            <th style="width: 80px;">Số lượng</th>
                            <th style="width: 100px;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        {list_sanpham}
                    </tbody>
                </table>
                <table class="table  totalorders">
                    <tfoot>
                        <tr class="order_summary ">
                            <td class="fix-width-200">Tạm tính:</td>
                            <td class="total money right">{tamtinh}₫</td>
                        </tr>
                        <tr class="order_summary discount">
                            <td class="fix-width-200"> Giảm:</td>
                            <td class="total money right">{giam}₫</td>
                        </tr>
                        <tr class="order_summary ">
                            <td class="fix-width-200" colspan="">Phí vận chuyển (Giao hàng tận nơi):</td>
                            <td class="total money right">{phi_ship}₫</td>
                        </tr>
                        <tr class="order_summary order_total">
                            <td class="fix-width-200">Tổng tiền:</td>
                            <td class="right"><strong>{tongtien}₫ </strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_donhang" class="button_all"> Lưu thay đổi </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var status = '{status}';
    $('select[name=status]').val(status);
</script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_donhang'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>