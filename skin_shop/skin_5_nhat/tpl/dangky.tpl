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
                            <strong itemprop="name">Tạo tài khoản</strong>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container mr-bottom-20">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="page-login account-box-shadow">
                    <div id="login">
                        <h1 class="title-head text-center">Tạo tài khoản</h1>
                        <div class="text-center"><span>Nếu chưa có tài khoản vui lòng đăng ký tại đây</span></div>
                        <div class="form-signup clearfix" style="margin-bottom: 30px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Tài khoản<span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Nhập tài khoản">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Họ và tên<span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-lg" name="ho_ten" id="ho_ten" placeholder="Nhập họ và tên">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Điện thoại<span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-lg" name="dien_thoai" id="dien_thoai" placeholder="Nhập họ và tên">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Email<span class="required">*</span></label>
                                        <input type="email" class="form-control form-control-lg" data-validation="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" name="email" id="email" placeholder="Nhập đia chỉ email" />
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Mật khẩu<span class="required">*</span></label>
                                        <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Nhập mật khẩu đăng nhập">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Nhập lại mật khẩu<span class="required">*</span></label>
                                        <input type="password" class="form-control form-control-lg" name="re_password" id="re_password" placeholder="Nhập lại mật khẩu đăng nhập">
                                    </fieldset>
                                </div>
                                <div class="action_bottom text-center">
                                    <button class="btn btn-style btn-blues" style="margin-top: 15px;" type="button" name="dangky">Đăng ký</button>
                                </div>
                                <div class="clearfix"></div>
                                <p class="text-center"></p>
                                <div class="text-center">
                                    <a href="/dang-nhap.html" class="btn-link-style">Đăng nhập</a> | <a href="/quen-mat-khau.html">Quên mật khẩu?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
</body>

</html>