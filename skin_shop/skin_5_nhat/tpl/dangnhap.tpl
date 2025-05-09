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
                    <div id="login">
                        <div class="text-center">
                            <h1 class="title-head"><span>Tài khoản</span></h1>
                        </div>
                        <div class="form-signup clearfix">
                            <fieldset class="form-group margin-bottom-20">
                                <label>Tài khoản/Email<span class="required">*</span></label>
                                <input type="email" class="form-control form-control-lg" value="" name="email" id="customer_email" placeholder="Nhập Tài khoản hoặc Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$"/>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Mật khẩu<span class="required">*</span></label>
                                <input type="password" class="form-control form-control-lg" value="" name="password" id="customer_password" placeholder="Mật khẩu đăng nhập" />
                            </fieldset>
                            <div class="pull-xs-left text-center" style="margin-top: 15px;">
                                <button class="btn btn-style btn-blues" type="button" name="login">Đăng nhập</button>
                            </div>
                            <div class="clearfix"></div>
                            <p class="text-center">
                                <a href="/quen-mat-khau.html" class="btn-link-style">Quên mật khẩu?</a>
                            </p>
                            <div class="text-login text-center">
                                <p>
                                    Bạn chưa có tài khoản. Đăng ký <a href="/dang-ky.html">tại đây.</a>
                                </p>
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