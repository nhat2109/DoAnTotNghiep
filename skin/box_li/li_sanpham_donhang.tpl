<div class="li_donhang">
    <div class="donhang-header">
        <div class="ma_don">Mã đơn: #{ma_don}</div>
        <div class="trang_thai status {class_status}">{trang_thai}</div>
        <div class="date_post">Ngày đặt: {date_post}</div>
    </div>
    <div class="donhang-products">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Thông tin sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                {list_sanpham}
            </tbody>
        </table>
    </div>
    <div class="donhang-footer">
        <div class="tongtien">Tổng tiền: {tongtien} đ</div>
        <a href="/order_detail.html?id={ma_don}" class="btn btn-primary">Xem chi tiết</a>
    </div>
</div>
<style>
    .li_donhang {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
    }
    .donhang-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .donhang-header .ma_don {
        font-weight: bold;
        font-size: 16px;
    }
    .donhang-header .trang_thai {
        padding: 5px 10px;
        border-radius: 5px;
        color: white;
    }
    .donhang-header .trang_thai.wait { background-color: #ff9800; }
    .donhang-header .trang_thai.xac_nhan { background-color: #008cff; }
    .donhang-header .trang_thai.request_cacnel { background-color: #f44336; }
    .donhang-header .trang_thai.cancel { background-color: #9e9e9e; }
    .donhang-header .trang_thai.success { background-color: #4caf50; }
    .donhang-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }
    .donhang-footer .tongtien {
        font-weight: bold;
        font-size: 16px;
    }
</style>