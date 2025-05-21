{header}

<body>
    {box_header}
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row" style="background-color: #fff; box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .1), 0 2px 6px 2px rgba(60, 64, 67, .15); border-radius: 4px;padding-right: 20px; padding-left: 20px; ">
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
                            <strong itemprop="name">Liên hệ</strong>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container contact">
        <div class="row" style="margin-bottom: 10px; background-color: #fff; box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .1), 0 2px 6px 2px rgba(60, 64, 67, .15); border-radius: 4px;padding-right: 20px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px;" >
            <div class="col-md-4">
                <div class="widget-item info-contact in-fo-page-content">
                    <h1 class="title-head">Thông tin liên hệ</h1>
                    <!-- End .widget-title -->
                    {lienhe}
                    <!-- End .widget-menu -->
                </div>
                <div class="box-maps margin-top-10 margin-bottom-10">
                    {ban_do}
                </div>
            </div>
            <div class="col-md-8">
                <div class="page-login">
                    <div id="login">
                        <h3 class="title-head text-center">Liên hệ chúng tôi</h3>
                        <div class="form-signup clearfix">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <fieldset class="form-group">
                                        <label>Họ tên<span class="required">*</span></label>
                                        <input type="text" name="ho_ten" id="name" class="form-control  form-control-lg" />
                                    </fieldset>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <fieldset class="form-group">
                                        <label>Email<span class="required">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control form-control-lg"/>
                                    </fieldset>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <fieldset class="form-group">
                                        <label>Chủ đề<span class="required">*</span></label>
                                        <input type="text" name="tieu_de" id="tel" class="number-sidebar form-control form-control-lg"/>
                                    </fieldset>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <fieldset class="form-group">
                                        <label>Nội dung<span class="required">*</span></label>
                                        <textarea name="noi_dung" id="comment" class="form-control form-control-lg" rows="5" ></textarea>
                                    </fieldset>
                                    <div class="pull-xs-left" style="margin-top:20px;">
                                        <input type="hidden" name="shop" value="{shop}">
                                        <button type="button" name="button_lienhe" class="btn btn-blues btn-style btn-style-active">Gửi liên hệ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .box-maps {
        height: 350px;
        overflow: hidden;
    }

    footer.footer-other {
        margin-top: 0;
    }

    .search-more {
        margin-top: 0;
    }
    </style>
    {footer}
    {script_footer}
</body>

</html>