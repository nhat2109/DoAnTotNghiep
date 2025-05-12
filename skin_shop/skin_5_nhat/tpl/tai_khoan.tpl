{header}

<body>
    {box_header}
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row" style="background-color: #fff; box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .1), 0 2px 6px 2px rgba(60, 64, 67, .15); border-radius: 4px;padding-right: 20px; padding-left: 20px;">
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
                            <strong itemprop="name">Tài khoản</strong>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container mr-bottom-20">
        <div class="row" style="background-color: #fff; box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .1), 0 2px 6px 2px rgba(60, 64, 67, .15); border-radius: 4px;padding-right: 20px; padding-left: 20px;">
            <div class="container_member">
                <div class="box_left">
                    <div class="avatar">
                        <img src="{avatar}" alt="Hình đại diện" onerror="this.src='/images/no-images.jpg';">
                    </div>
                    <div class="name">{name}</div>
                    <div class="email">{email}</div>
                    <ul class="list_info">
                        <li class="list-item">
                            <b>Ngày sinh:</b> <a class="pull-right">{ngay_sinh}</a>
                        </li>
                        <li class="list-item">
                            <b>Điện Thoại:</b> <a class="pull-right">{dien_thoai}</a>
                        </li>
                        <li class="list-item">
                            <b>Ngày Tham Gia:</b> <a class="pull-right">{date_reg}</a>
                        </li>
                    </ul>
                    <a href="/doi-mat-khau.html" class="button">Thay đổi mật khẩu</a>
                </div>
                <div class="box_right">
                    <div class="list_action">
                        <div class="action">
                            <a href="/don-hang.html">
                                <img src="/skin/css/images/icon/6.png" alt="Danh sách đơn hàng">
                                <h2>Danh sách đơn hàng</h2>
                            </a>
                        </div>
                        <div class="action">
                            <a href="/tai-khoan.html" class="active">
                                <img src="/skin/css/images/icon/2.png" alt="Thông tin tài khoản">
                                <h2>Thông tin tài khoản</h2>
                            </a>
                        </div>
                        <div class="action">
                            <a href="/doi-avatar.html">
                                <img src="/skin/css/images/icon/3.png" alt="Đổi hình đại diện">
                                <h2>Đổi hình đại diện</h2>
                            </a>
                        </div>
                        <div class="action">
                            <a href="/doi-mat-khau.html">
                                <img src="/skin/css/images/icon/4.png" alt="Đổi mật khẩu">
                                <h2>Đổi mật khẩu</h2>
                            </a>
                        </div>
                        <div class="action">
                            <a href="/tich-diem.html">
                                <img src="/skin/css/images/icon/tich_diem.png" alt="Tích điểm">
                                <h2>Tích điểm</h2>
                            </a>
                        </div>
                        <div class="action">
                            <a href="/lien-he.html">
                                <img src="/skin/css/images/hotro.png" alt="Liên hệ">
                                <h2>Liên hệ</h2>
                            </a>
                        </div>
                    </div>
                    <h1>Thông tin tài khoản</h1>
                    <div class="box_profile" style="width: 800px;">
                        <div class="li_input">
                            <div class="col_30">
                                <label for="">Tài khoản</label>
                                <input type="text" name="username" value="{username}" placeholder="Tài khoản" disabled="">
                            </div>
                            <div class="col_30">
                                <label for="">Họ và tên</label>
                                <input type="text" name="ho_ten" value="{name}" placeholder="Nhập họ và tên">
                            </div>
                            <div class="col_30">
                                <label for="">Email</label>
                                <input type="text" name="email" value="{email}" placeholder="Nhập địa chỉ email">
                            </div>
                        </div>
                        <div class="li_input">
                            <div class="col_30">
                                <label for="">Điện thoại</label>
                                <input type="text" name="dien_thoai" value="{dien_thoai}" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="col_30">
                                <label for="">Ngày sinh</label>
                                <input type="text" name="ngay_sinh" class="datepicker" value="{ngay_sinh}" placeholder="Nhập Ngày/Tháng/Năm">
                            </div>
                            <div class="col_30">
                                <label for="">Địa chỉ</label>
                                <input type="text" name="dia_chi" value="{dia_chi}" placeholder="Nhập địa chỉ">
                            </div>
                        </div>
                        <div class="li_input">
                            <div class="col_100" style="text-align: center;">
                                <button type="button" name="change_profile">Lưu thay đổi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(function() {
        $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: "-60:+0" });
    });
    $.datepicker.setDefaults({
        closeText: "Đóng",
        prevText: "&#x3C;Trước",
        nextText: "Tiếp&#x3E;",
        currentText: "Hôm nay",
        monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
            "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"
        ],
        monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
            "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
        ],
        dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
        dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        weekHeader: "Tu",
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ""
    });
    </script>
</body>

</html>