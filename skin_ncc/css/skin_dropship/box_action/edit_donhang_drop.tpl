<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: calc(100% - 40px);">
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
                    <label for="">Tình trạng: <span class="color_red">{status}</span></label>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_100">
                <table id="order_details" class="table table-cart">
                    <thead class="thead-default">
                        <tr>
                            <th align="left" width="100">Mã</th>
                            <th align="left">Sản phẩm</th>
                            <th width="100">Giá</th>
                            <th width="100">Giảm</th>
                            <th width="80">Số lượng</th>
                            <th width="120">Thành tiền</th>
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
                        <tr class="order_summary ">
                            <td class="fix-width-200" colspan="">Phí vận chuyển (Giao hàng tận nơi):</td>
                            <td class="total money right">{phi_ship}</td>
                        </tr>
                        <tr class="order_summary order_total">
                            <td class="fix-width-200">Tổng tiền:</td>
                            <td class="right"><strong>{tongtien}₫ </strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var status = '{status}';
    $('select[name=status]').val(status);
</script>