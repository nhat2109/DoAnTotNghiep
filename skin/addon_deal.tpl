{header}

<body>
    {box_header}
    <div class="bread-crumb mb-3">
        <span class="crumb-border"></span>
        <div class="container">
            <div class="row">
                <div class="col-12 a-left">
                    <ul class="breadcrumb m-0 px-0" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <a href="/" target="_self" itemprop="item"><span itemprop="name">Trang chủ</span></a>
                            <meta itemprop="position" content="1">
                            <span class="mr_lr">&nbsp;/&nbsp;</span>
                        </li>
                        <li class="active"><span>Mua thêm deal sốc</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="box_shopcart">
        <div class="container">
            <div class="row">
                <div class="shopcart_left" style="width: 100%;">
                    <h1>Mua thêm deal sốc</h1>
                    <div class="list_muakem">
                        <div class="li_muakem" style="background: rgba(255, 243, 237, 0.4);">
                            <div class="check_product">
                                <input type="checkbox" checked="checked" name="main_product" value="{sp_id}">
                                <label for="product_{sp_id}"><i class="fa fa-square-o"></i><i class="fa fa-check-square"></i></label>
                            </div>
                            <div class="minh_hoa">
                                <a href="/product/{link}.html">
                                    <img src="{minh_hoa}" alt="{tieu_de}">
                                </a>
                            </div>
                            <div class="info">
                                <div class="tieude">
                                    <a href="/product/{link}.html">{tieu_de}</a>
                                </div>
                                <div class="price-old">{gia_cu}₫</div>
                                <div class="thanhtien">{gia_moi}₫</div>
                            </div>
                        </div>
                        {list_muakem}
                    </div>
                    <div class="action_muakem"><button class="add_muakem"><i class="fa fa-shopping-cart"></i> mua hàng</button></div>
                </div>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
</body>

</html>