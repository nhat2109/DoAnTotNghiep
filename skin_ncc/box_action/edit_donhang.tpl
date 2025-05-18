<style>
    .page_body .box_right .box_right_content .box_profile
    {
        width: 100%!important;
    }
    .box_right_content {
        width: 100%;
    }
    
    /* Tiêu đề */
    .page_title {
        margin-bottom: 20px;
    }
    
    .undefined {
        font-size: 24px;
        font-weight: 600;
        color: #dc3545;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .line {
        height: 3px;
        background: linear-gradient(to right, #dc3545, #ff6f61);
        width: 50px;
        margin: 10px 0;
    }
    
    hr {
        border: none;
        border-top: 1px solid #eee;
        margin: 10px 0;
    }
    
    /* Bố cục chính */
    .main-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }
    
    .order-details {
        padding-right: 10px;
    }
    
    .sidebar {
        padding-left: 10px;
    }
    
    /* Thông tin giao hàng, thanh toán và trạng thái */
    .box-address {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        padding: 15px;
        margin-bottom: 15px;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
    }
    
    .box-address:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .box-header {
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .title-head {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }
    
    .box-header .note {
        font-size: 13px;
        color: #666;
    }
    
    .address.note {
        font-size: 13px;
        color: #444;
    }
    
    .address.note p {
        margin: 8px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .address.note i {
        color: #28a745;
        font-size: 14px;
    }
    
    .address.note .label {
        font-weight: 500;
        min-width: 80px;
    }
    
    .address.note a {
        color: #007bff;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .address.note a:hover {
        color: #0056b3;
        text-decoration: underline;
    }
    
    /* Trạng thái đơn hàng */
    .order-info .form_group {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .order-info .form_group label {
        font-weight: 500;
        color: #444;
        min-width: 80px;
    }
    
    .order-info .form_group span {
        font-size: 13px;
        color: #333;
    }
    
    .form_control {
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 13px;
        width: 100%;
        outline: none;
        transition: border-color 0.2s ease;
    }
    
    .form_control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 4px rgba(220, 53, 69, 0.3);
    }
    
    /* Bảng sản phẩm */
    .table-cart {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        font-size: 13px;
        border: 1px solid #eee;
        border-radius: 6px;
        overflow: hidden;
    }
    
    .thead-default {
        background: linear-gradient(to right, #dc3545, #ff6f61);
        color: #fff;
        text-transform: uppercase;
    }
    
    .table-cart th,
    .table-cart td {
        padding: 10px 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    .table-cart th {
        font-weight: 600;
    }
    
    .table-cart td {
        background: #fff;
    }
    
    .table-cart tbody tr:hover {
        background: #f8f9fa;
    }
    
    /* Tổng tiền */
    .totalorders {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        border: 1px solid #eee;
        border-radius: 6px;
        overflow: hidden;
    }
    
    .order_summary {
        background: #fff;
    }
    
    .order_summary td {
        padding: 10px 12px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .summary-label {
        font-weight: 500;
        color: #444;
        width: 150px;
    }
    
    .summary-value {
        text-align: right;
        font-weight: 500;
    }
    
    .order_total .summary-value {
        color: #dc3545;
        font-weight: 700;
        font-size: 16px;
    }
    
    /* Nút hành động */
    .button_all {
        background: linear-gradient(to right, #dc3545, #ff6f61);
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, background 0.3s ease;
        display: block;
        width: 100%;
        text-align: center;
        margin-top: 10px;
    }
    
    .button_all:hover {
        background: linear-gradient(to right, #c82333, #e65c00);
        transform: translateY(-2px);
    }
    
    /* Trạng thái */
    .status-request-cancel { color: #fd7e14; font-weight: bold; }
    .status-received { color: #007bff; font-weight: bold; }
    .status-shipping { color: #17a2b8; font-weight: bold; }
    .status-cancelled { color: #dc3545; font-weight: bold; }
    .status-success { color: #28a745; font-weight: bold; }
    .status-pending { color: #ffc107; font-weight: bold; }
    .status-completed { color: #28a745; font-weight: bold; }
    .status-failed { color: #dc3545; font-weight: bold; }
    .status-refunded { color: #6f42c1; font-weight: bold; }
    .status-request-refunded {color: #fd7e14; font-weight: bold;}
    
    /* Responsive */
    @media (max-width: 768px) {
        .box_right {
            margin: 10px;
            padding: 10px;
            border-radius: 8px;
        }
    
        .undefined {
            font-size: 18px;
        }
    
        .main-container {
            grid-template-columns: 1fr;
        }
    
        .order-details,
        .sidebar {
            padding: 0;
        }
    
        .address.note {
            font-size: 12px;
        }
    
        .table-cart th,
        .table-cart td {
            padding: 6px 8px;
            font-size: 12px;
        }
    
        .summary-label {
            width: 120px;
        }
    
        .summary-value,
        .total.money.right,
        .right {
            font-size: 12px;
        }
    
        .button_all {
            padding: 8px 16px;
            font-size: 12px;
        }
    }
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <!-- Tiêu đề -->
            <div class="page_title">
                <h1 class="undefined">Chi tiết đơn hàng</h1>
                <div class="line"></div>
                <hr>
            </div>

            <!-- Bố cục chính -->
            <div class="main-container">
                <!-- Chi tiết đơn hàng -->
                <div class="order-details">
                    <table id="order_details" class="table table-cart">
                        <thead class="thead-default">
                            <tr>
                                <!-- <th align="left">Mã</th> -->
                                <th align="left">Minh họa</th>
                                <th align="left">Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            {list_sanpham}
                        </tbody>
                    </table>
                    <table class="table totalorders">
                        <tfoot>
                            <tr class="order_summary">
                                <td class="summary-label">Tạm tính:</td>
                                <td class="summary-value">{tamtinh}₫</td>
                            </tr>
                            <tr class="order_summary">
                                <td class="summary-label">Giảm:</td>
                                <td class="summary-value">{giam}₫</td>
                            </tr>
                            <tr class="order_summary">
                                <td class="summary-label">Phí vận chuyển:</td>
                                <td class="summary-value">{phi_ship}</td>
                            </tr>
                            <tr class="order_summary order_total">
                                <td class="summary-label">Tổng tiền:</td>
                                <td class="summary-value"><strong>{tongtien}₫</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Thông tin phụ -->
                <div class="sidebar">
                    <div class="box-address">
                        <div class="box-header">
                            <h2 class="title-head">Trạng thái đơn hàng</h2>
                        </div>
                        <div class="order-info">
                            <div class="form_group">
                                <label>Mã đơn:</label> <span>#{ma_don}</span>
                            </div>
                            <div class="form_group">
                                <label>Ngày tạo:</label> <span>{date_post}</span>
                            </div>
                            <div class="form_group">
                                <label>Tình trạng:</label>
                                <select class="form_control" name="status">
                                    <option value="0">Chờ xử lý</option>
                                    <option value="1">Đã tiếp nhận đơn</option>
                                    <option value="2">Đã giao đơn vị vận chuyển</option>
                                    <option value="3">Yêu cầu hủy đơn</option>
                                    <option value="4">Xác nhận hủy đơn</option>
                                    <option value="5">Giao thành công</option>
                                    <option value="6">Yêu cầu hoàn đơn</option>
                                    <option value="7">Đã hoàn đơn</option>  
                                </select>
                            </div>
                            <input type="hidden" name="id" value="{id}">
                            <button name="edit_donhang" class="button_all">Lưu thay đổi</button>
                        </div>
                    </div>
                    <div class="box-address">
                        <div class="box-header">
                            <h2 class="title-head">Thông tin giao hàng</h2>
                        </div>
                        <div class="address note">
                            <p><i class="fa fa-user"></i> <span class="label">Họ tên:</span> {ho_ten}</p>
                            <p><i class="fa fa-map-marker"></i> <span class="label">Địa chỉ:</span> {dia_chi}, {huyen}, {tinh}</p>
                            <p><i class="fa fa-phone"></i> <span class="label">Điện thoại:</span> <a href="tel:{dien_thoai}">{dien_thoai}</a></p>
                        </div>
                    </div>
                    <div class="box-address">
                        <div class="box-header">
                            <h2 class="title-head">Thông tin thanh toán</h2>
                            <p>
                                <span class="note">Trạng thái:</span>
                                <i class="{tinhtrang_class}">{tinhtrang}</i>
                            </p>
                        </div>
                        <div class="address note">
                            <p><i class="fa fa-credit-card"></i> <span class="label">Phương thức:</span> <strong>{phuongthuc}</strong></p>
                            <p><i class="fa fa-barcode"></i> <span class="label">Mã giao dịch:</span> <strong>{transaction_id}</strong></p>
                            <p><i class="fa fa-calendar-alt"></i> <span class="label">Ngày thanh toán:</span> <strong>{ngaythanhtoan}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var status = '{status}';
    $('select[name=status]').val(status);
</script>