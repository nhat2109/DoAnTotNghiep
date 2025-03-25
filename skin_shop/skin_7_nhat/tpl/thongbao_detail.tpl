{header}

<body>
    {box_header}
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
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
                            <strong itemprop="name">Thông báo</strong>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container mr-bottom-20">
        <div class="row">
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
                            <a href="/tai-khoan.html">
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
                    <h1 style="text-transform: none;">{tieu_de}</h1>
                    <div class="box_profile">
                        <div class="responsive scroll_v">
                            {noi_dung}
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
      $( function() {
        $( ".datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});
      } );
      </script>
</body>

</html>
<style>
    .list-group .list-group-item .mega-menu {
        height: 200% !important;
    }
</style>