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
                            <strong itemprop="name">Tài khoản</strong>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container margin-bottom-30">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="page-login account-box-shadow">
                    <div id="recover-password" class="form-signup">
                        <div class="text-center">
                            <h1 class="title-head"><span>Đặt lại mật khẩu</span></h1>
                        </div>
                        <span class="block text-center">
                            Bạn quên mật khẩu? Nhập địa chỉ email để lấy lại mật khẩu qua email.
                        </span>
                        <div class="form-signup clearfix">
                            <fieldset class="form-group">
                                <label>Email<span class="required">*</span></label>
                                <input type="email" class="form-control form-control-lg" value="" name="Email" id="recover-email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" />
                            </fieldset>
                        </div>
                        <div class="action_bottom text-center">
                            <button class="btn btn-style btn-blues" style="margin-top: 15px;" type="button" name="quen_matkhau">Lấy lại mật khẩu</button>
                        </div>
                        <div class="clearfix"></div>
                        <p class="text-center">
                            <a href="/dang-nhap.html" class="btn-link-style">Đăng nhập</a> | <a href="/dang-ky.html">Đăng ký</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
</body>

</html>