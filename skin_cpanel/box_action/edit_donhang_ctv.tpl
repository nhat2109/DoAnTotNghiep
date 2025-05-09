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
                    <p><i class="fa fa-map-marker"></i> {dia_chi},{ten_xa}, {ten_huyen}, {ten_tinh}</p>
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
                        <option value="6">Hoàn đơn</option>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <table id="order_details" class="table table-cart">
                    <thead class="thead-default">
                        <tr>
                            <th align="left">Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        {list_sanpham}
                    </tbody>
                </table>
                <table class="table  totalorders">
                    <tfoot>
                        <tr class="order_summary order_total">
                            <td class="fix-width-200">Tổng tiền:</td>
                            <td class="right"><strong>{tongtien}₫ </strong></td>
                        </tr>
                        <tr class="order_summary order_total">
                            <td class="fix-width-200">Phí ship:</td>
                            <td class="right"><strong>{phi_ship}₫ </strong></td>
                        </tr>
                        <tr class="order_summary order_total">
                            <td class="fix-width-200">Trả phí ship:</td>
                            <td class="right"><strong>{chiu_ship} </strong></td>
                        </tr>
                        <tr class="order_summary order_total">
                            <td class="fix-width-200">Tiền COD:</td>
                            <td class="right color_red"><strong>{cod}₫ </strong></td>
                        </tr>
                        <tr class="order_summary order_total">
                            <td class="fix-width-200">Hoa Hồng:</td>
                            <td class="right"><strong>{hoahong}₫ </strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="form_group">
                    <label for="">Ghi chú:</label>
                    <div>{ghi_chu}</div>
                </div>
            </div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_donhang_ctv" class="button_all"> Lưu thay đổi </button>
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