<div class="li_donhang {class_status} {active}">
    <div class="li_donhang_top">
        <div class="li_donhang_top_left">
            <div class="ma_don">#{ma_don}</div>
            <div class="time">{date_post}</div>
        </div>
        <div class="li_donhang_top_right">
            <div class="status">{trang_thai}</div>
            <div class="status_icon">0</div>
        </div>
    </div>
    <div class="li_donhang_sanpham">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th></th>
                    <th>Số lượng</th>
                    <th>Giá niêm yết</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                {list_sanpham}
            </tbody>
        </table>
    </div>
    <div class="li_donhang_action">
        <button class="action_btn">Đổi/ trả hàng</button>
        <button class="action_btn">Cần hỗ trợ</button>
        <button class="action_btn">Mua lại</button>
        <a href="/order-detail.html?id={ma_don}"><button class="action_btn">Xem chi tiết</button></a>
    </div>
</div>
<style>
   /* Container chính của mỗi đơn hàng */
.li_donhang {
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 8px;
}

/* Tiêu đề đơn hàng */
.li_donhang_top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    background-color: #f5a623; /* Màu cam */
    padding: 10px 15px;
    border-radius: 8px 8px 0 0; /* Bo góc trên */
}

.li_donhang_top_left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.ma_don {
    font-size: 16px;
    font-weight: bold;
    color: #ffffff;
}

.time {
    font-size: 14px;
    color: #fff; /* Đổi màu chữ thành trắng để nổi trên nền cam */
}

.li_donhang_top_right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.status {
    font-size: 14px;
    font-weight: bold;
    color: #fff; /* Đổi màu chữ thành trắng để nổi trên nền cam */
}

.status_icon {
    width: 20px;
    height: 20px;
    background-color: #fff; /* Đổi màu nền thành trắng */
    color: #f5a623; /* Đổi màu chữ thành cam */
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

/* Danh sách sản phẩm */
.li_donhang_sanpham {
    margin-bottom: 15px;
    padding: 0 15px; /* Thêm padding để căn chỉnh với tiêu đề */
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background-color: #f5a623;
    color: #fff;
    padding: 10px;
    text-align: center;
    font-size: 14px;
}

.table td {
    padding: 10px;
    vertical-align: middle;
    font-size: 14px;
}

/* Cột hình ảnh */
.table td:nth-child(1) {
    width: 100px;
    text-align: center;
}

.product_image {
    width: 80px;
    height: auto;
    border-radius: 4px;
}

/* Cột thông tin sản phẩm */
.table td:nth-child(2) {
    width: 40%;
}

.table td:nth-child(2) a {
    color: #333;
    text-decoration: none;
    font-weight: bold;
}

.table td:nth-child(2) a:hover {
    color: #e74c3c;
    
}

.table td:nth-child(2) div {
    color: #666;
    font-size: 13px;
}

/* Cột số lượng */
.table td:nth-child(3) {
    width: 10%;
    text-align: center;
}

/* Cột giá */
.table td:nth-child(4) {
    width: 20%;
    text-align: center;
}

.old_price {
    color: #999;
    text-decoration: line-through;
    font-size: 13px;
}

.new_price {
    color: #e74c3c;
    font-weight: bold;
    font-size: 14px;
}

/* Cột thành tiền */
.table td:nth-child(5) {
    width: 20%;
    text-align: center;
    font-weight: bold;
    color: #333;
}

/* Nút hành động */
.li_donhang_action {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 0 15px 15px; /* Thêm padding để căn chỉnh với tiêu đề */
}

.action_btn {
    padding: 8px 15px;
    border: 1px solid #ddd;
    background-color: #fff;
    color: #333;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action_btn:hover {
    background-color: #f5f5f5;
    border-color: #bbb;
}
</style>