{header}

<style>
    .overlay {
        display: none; /* Ẩn mặc định */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Màu xám với độ mờ 50% */
        z-index: 999; /* Đảm bảo overlay nằm dưới popup nhưng trên nội dung khác */
    }
    
    /* Hiển thị overlay khi popup mở */
    .overlay.show {
        display: block;
    }
    /* Container chính của popup */
.box_pop {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    width: 400px;
    max-width: 90%;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    padding: 15px; /* Giảm padding từ 20px xuống 15px */
    text-align: center;
    font-family: Arial, sans-serif;
    height: 300px;
}

/* Nội dung popup */
.pop_content {
    margin-bottom: 10px; /* Giảm từ 15px xuống 10px */
}

.li_input {
    margin: 5px 0; /* Giảm từ 10px xuống 5px */
    font-style: italic;
    text-align: center;
}

.li_input span#title_confirm {
    font-size: 18px; /* Giảm từ 20px xuống 18px */
    color: #dc3545;
    font-weight: 700;
    display: block;
}

.li_input span {
    font-size: 13px; /* Giảm từ 14px xuống 13px */
    color: #333;
}

/* Form nhập lý do */
.form-group {
    margin: 10px 0; /* Giảm từ 15px xuống 10px */
}

#cancel_reason {
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 6px; /* Giảm từ 8px xuống 6px */
    font-size: 13px; /* Giảm từ 14px xuống 13px */
    resize: vertical;
    min-height: 60px; /* Giảm từ 80px xuống 60px */
    transition: border-color 0.3s ease;
}

#cancel_reason:focus {
    border-color: #dc3545;
    outline: none;
    box-shadow: 0 0 5px rgba(220, 53, 69, 0.3);
}

/* Nút hành động */
.pop_button {
    margin-top: 15px; /* Giảm từ 20px xuống 15px */
}

.text_center {
    display: flex;
    justify-content: center;
    gap: 8px; /* Giảm từ 10px xuống 8px */
}

button {
    padding: 8px 18px; /* Giảm từ 10px 20px xuống 8px 18px */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 13px; /* Giảm từ 14px xuống 13px */
    font-weight: 600;
    transition: all 0.3s ease;
}

#button_thuchien {
    background: linear-gradient(to right, #dc3545, #ff6f61);
    color: #fff;
}

#button_thuchien:hover {
    background: linear-gradient(to right, #c82333, #e65c00);
    transform: translateY(-2px);
}

.button_cancel.bg_blue {
    background: #007bff;
    color: #fff;
}

.button_cancel.bg_blue:hover {
    background: #0056b3;
    transform: translateY(-2px);
}

/* Overlay nền khi popup mở */
.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

/* Hiển thị popup và overlay khi cần */
.show {
    display: block;
}
    /* Định dạng chung cho hàng trong bảng */
    tr {
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s ease;
    }

    tr:hover {
        background-color: #f9f9f9;
        /* Hiệu ứng hover nhẹ */
    }

    /* Định dạng cột hình ảnh */
    .minh_hoa {
        padding: 10px;
        width: 100px;
        /* Chiều rộng cố định cho cột hình ảnh */
        text-align: center;
    }

    .minh_hoa img {
        max-width: 100%;
        /* Đảm bảo hình ảnh không vượt quá cột */
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }


    [data-title="Tên"] {
        padding: 10px;
        vertical-align: middle;
    }

    [data-title="Tên"] a {
        color: #62aaf8;
        text-decoration: none;
        font-size: 14px;
        line-height: 1.4;
    }

    [data-title="Tên"] a:hover {
        text-decoration: none;
        color: #0056b3;
    }

    .numeric {
        padding: 10px;
        text-align: right;
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }

    .numeric::after {
        content: "₫";
        margin-left: 2px;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        tr {
            display: block;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        td {
            display: block;
            text-align: left !important;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        td:last-child {
            border-bottom: none;
        }

        .minh_hoa {
            width: 100%;
            text-align: center;
        }

        .minh_hoa img {
            max-width: 150px;
            /* Điều chỉnh kích thước hình ảnh trên mobile */
        }

        [data-title]:before {
            content: attr(data-title) ": ";
            font-weight: bold;
            color: #555;
        }
    }

    .btn-cancel {
        padding: 3px 3px !important;
    }

    /* Thêm vào CSS hiện có */
    .cancel-message {
        margin-top: 10px;
        padding: 10px 15px;
        border-radius: 4px;
        background-color: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
        font-size: 13px;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .alert i {
        margin-right: 5px;
    }

    .message-container {
        margin: 15px 0;
    }

    .btn-cancel {
        background-color: #dc3545;
        /* Red */
        color: #fff;
        border: none;

        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.2s ease;
    }

    .btn-cancel:hover {
        background-color: #c82333;
        /* Darker red */
        cursor: pointer;
    }

    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-bottom: 15px;
        text-align: center;
    }

    .status-request-cancel {
        color: #fd7e14;
        /* Cam đậm */
        font-weight: bold;
    }
   .status-request-refunded {color: #fd7e14; font-weight: bold};

    .status-received {
        color: #007bff;
        /* Xanh dương */
        font-weight: bold;
    }

    .status-shipping {
        color: #17a2b8;
        /* Xanh cyan */
        font-weight: bold;
    }

    .status-cancelled {
        color: #dc3545;
        /* Đỏ */
        font-weight: bold;
    }

    .status-success {
        color: #28a745;
        /* Xanh lá */
        font-weight: bold;
    }

    .status-refunded {
        color: #6f42c1;
        /* Tím */
        font-weight: bold;
    }

    .status-pending {
        color: #ffc107;
        /* Vàng */
        font-weight: bold;
    }

    .status-completed {
        color: green !important;
        font-weight: bold;
    }

    .status-failed {
        color: red !important;
        font-weight: bold;
    }

    .status-pending {
        color: orange !important;
        font-weight: bold;
    }

    /* Container chính */
    .col-xs-12.col-sm-12.col-md-6 {
        padding: 0 15px;
        box-sizing: border-box;
    }

    /* Box thông tin giao hàng và thanh toán */
    .box-address {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    /* Header của box */
    .box-header {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e6e6e6;
    }

    .title-head {
        font-size: 18px;
        font-weight: 600;
        color: #333333;
        margin: 0;
        line-height: 1.4;
    }

    /* Trạng thái */
    .box-header p {
        margin: 5px 0 0;
        font-size: 13px;
        color: #737373;
    }

    .note {
        font-weight: 500;
        color: #333333;
    }

    .status_not.fulfilled {
        color: #ff6d6d;
        font-style: italic;
        font-weight: 500;
    }

    /* Nội dung thông tin */
    .address.note {
        font-size: 14px;
        color: #333333;
        line-height: 1.6;
    }

    .address.note p {
        margin: 8px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Icon */
    .address.note i {
        font-size: 16px;
        color: #4CAF50;
        width: 20px;
        text-align: center;
    }

    /* Liên kết số điện thoại */
    .address.note a {
        color: #338dbc;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .address.note a:hover {
        color: #4CAF50;
        text-decoration: underline;
    }

    /* Khoảng cách trên mobile */
    .margin-top-20 {
        margin-top: 20px;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .box-address {
            padding: 15px;
        }

        .title-head {
            font-size: 16px;
        }

        .address.note {
            font-size: 13px;
        }

        .address.note i {
            font-size: 14px;
            width: 18px;
        }
    }

    @media (min-width: 768px) {
        .col-md-6 {
            width: 50%;
            float: left;
        }
    }
</style>

<body>
    {box_header}
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row"
                style="background-color: #fff; box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .1), 0 2px 6px 2px rgba(60, 64, 67, .15); border-radius: 4px;padding-right: 20px; padding-left: 20px;">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="/" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="/account">
                                <span itemprop="name">Trang Tài khoản</span>
                                <meta itemprop="position" content="2" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li class="active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">#{ma_don}</strong>
                            <meta itemprop="position" content="3" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="login panel-login account-page  margin-bottom-20">
        <div class="container">
            <div class="row"
                style="background-color: #fff; box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .1), 0 2px 6px 2px rgba(60, 64, 67, .15); border-radius: 4px;     padding-right: 20px; padding-left: 20px;">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h1 class="title-head widget-title">Đơn hàng #{ma_don}
                    </h1>
                    <span class="note order_date"><i>Ngày tạo &mdash; {date_post}</i></span>
                </div>
                <div class="row">
                    <!-- Thông tin giao hàng -->
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="box-address margin-top-20">
                            <div class="box-header">
                                <h2 class="title-head">Thông tin giao hàng</h2>
                                <p>
                                    <span class="note">Trạng thái:</span>
                                    <i class="{trang_thai_class}">{trang_thai}</i>


                                </p>
                            </div>
                            <div class="address note">
                                <p><i class="fa fa-user"></i> {ho_ten}</p>
                                <p><i class="fa fa-map-marker"></i> {dia_chi}, {huyen}, {tinh}</p>
                                <p><i class="fa fa-phone"></i> <a href="tel:{dien_thoai}">{dien_thoai}</a></p>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin thanh toán -->
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="box-address margin-top-20">
                            <div class="box-header">
                                <h2 class="title-head">Thông tin thanh toán</h2>
                                <p>

                                    <span class="note">Trạng thái:</span>
                                    <i class="{tinhtrang_class}">{tinhtrang}</i>

                                </p>
                            </div>
                            <div class="address note">
                                <p><i class="fa fa-credit-card"></i>Phương thức: <strong>{phuongthuc}</strong></p>
                                <!-- <p><i class="fa fa-university"></i> {nganhang}</p> -->
                                <p><i class="fa fa-barcode"></i> Mã giao dịch: <strong>{transaction_id}</strong></p>
                                <p><i class="fa fa-calendar-alt"></i> Ngày thanh toán: <strong>{ngaythanhtoan}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {cancel_message_html}
                {refund_message_html}
                {refund_button_html}
                {cancel_button_html}
                <div class="message-container">
                    <div class="message-container">
                        {success_message_html}
                        {error_message_html}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="table-responsive-block margin-top-20">
                        <table id="order_details" class="table table-cart">
                            <thead class="thead-default" style="border-top: 1px solid #ddd;">
                                <tr>
                                    <th>Minh họa</th>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                {list_sanpham}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
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
                                <td class="total money right">{phiship}₫</td>
                            </tr>
                            <tr class="order_summary order_total">
                                <td class="fix-width-200">Tổng tiền:</td>
                                <td class="right"><strong>{tongtien}₫ </strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="text-center margin-bottom-20">
                        <a href="/don-hang.html" class="btn btn-blues"><i class="fa fa-reply" aria-hidden="true"></i>
                            Danh sách đơn hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="overlay"></div>
    <div class="box_pop" id="box_pop_content">
        <div class="pop_content">
            <div class="li_input" style="font-style: italic;text-align: center;">
                <span style="font-style: italic;text-align: center;font-size: 20px;color: red;font-weight: 700;"
                    id="title_confirm"></span>
            </div>
        </div>
        <div class="li_input" style="font-style: italic;text-align: center;">
            <span style="font-style: italic;font-family: Arial"></span>
        </div>
        <div class="form-group" style="margin: 15px 0;">
            <textarea id="cancel_reason" rows="3" style="width: 100%; border-radius: 5px; border: 1px solid #ccc; padding: 8px;" placeholder="Nhập lý do ..." required></textarea>
        </div>
        <div class="pop_button">
            <div class="text_center">
                <button id="button_thuchien" action="" post_id="">Thực hiện</button>
                <button class="button_cancel bg_blue">Hủy</button>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Form hủy đơn hàng
        const cancelForm = document.querySelector('form[name="cancel_form"]');
        if (cancelForm) {
            cancelForm.addEventListener('submit', function (e) {
                e.preventDefault();
                showCancelOrderConfirm(function(confirmed, lydo) {
                    if (confirmed) {
                        const lydoInput = document.createElement('input');
                        lydoInput.type = 'hidden';
                        lydoInput.name = 'lydo';
                        lydoInput.value = lydo;
                        cancelForm.appendChild(lydoInput);
                        cancelForm.submit();
                    }
                });
            });
        }

        // Form hoàn đơn hàng
        const refundForm = document.querySelector('form[name="refund_form"]');
            if (refundForm) {
                refundForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    showRefundOrderConfirm(function(confirmed, lydo) {
                        if (confirmed) {
                            const lydoInput = document.createElement('input');
                            lydoInput.type = 'hidden';
                            lydoInput.name = 'lydo';
                            lydoInput.value = lydo;
                            refundForm.appendChild(lydoInput);
                            refundForm.submit();
                        }
                    });
                });
            }
        });

    function showCancelOrderConfirm(callback) {
        $("#title_confirm").html("Xác nhận hủy đơn hàng");
        $("#box_pop_content .li_input span").eq(1).html("Bạn có chắc muốn yêu cầu hủy đơn hàng này?");
        $("#cancel_reason").val(""); // reset textarea mỗi lần mở
        $("#box_pop_content").fadeIn();
        document.querySelector('.overlay').classList.add('show');
        $("#button_thuchien").off("click").on("click", function() {
            var lydo = $("#cancel_reason").val().trim();
            if (!lydo) {
                $("#cancel_reason").focus();
                $("#cancel_reason").css("border", "1.5px solid #dc3545");
                return; 
            }
            $("#cancel_reason").css("border", "1px solid #ccc");
            $("#box_pop_content").fadeOut();
            document.querySelector('.overlay').classList.remove('show');
            callback(true, lydo);
        });
        $("#box_pop_content .button_cancel").off("click").on("click", function() {
            $("#box_pop_content").fadeOut();
            document.querySelector('.overlay').classList.remove('show');
            callback(false, null);
        });
    }   

     function showRefundOrderConfirm(callback) {
        $("#title_confirm").html("Xác nhận hoàn đơn hàng");
        $("#box_pop_content .li_input span").eq(1).html("Bạn có chắc muốn yêu cầu hoàn đơn hàng này?");
        $("#cancel_reason").val(""); // reset textarea mỗi lần mở
        $("#box_pop_content").fadeIn();
        document.querySelector('.overlay').classList.add('show');
        $("#button_thuchien").off("click").on("click", function() {
            var lydo = $("#cancel_reason").val().trim();
            if (!lydo) {
                $("#cancel_reason").focus();
                $("#cancel_reason").css("border", "1.5px solid #dc3545");
                return;
            }
            $("#cancel_reason").css("border", "1px solid #ccc");
            $("#box_pop_content").fadeOut();
            document.querySelector('.overlay').classList.remove('show');
            callback(true, lydo);
        });
        $("#box_pop_content .button_cancel").off("click").on("click", function() {
            $("#box_pop_content").fadeOut();
            document.querySelector('.overlay').classList.remove('show');
            callback(false, null);
        });
    }   

    function showCustomNotice(message, reload = false) {
        $(".load_overlay").show();
        $(".load_process").fadeIn();
        setTimeout(function () {
            $(".load_note").html(message);
        }, 500);
        setTimeout(function () {
            $(".load_process").hide();
            $(".load_note").html("Hệ thống đang xử lý");
            $(".load_overlay").hide();
            if (reload) window.location.reload();
        }, 2500);
    }
</script>