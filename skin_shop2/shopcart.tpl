{header}
<body>
    {box_header}
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="/" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1">
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">Giỏ hàng của bạn</strong>
                            <meta itemprop="position" content="2">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container white collections-container margin-bottom-20">
        <div class="white-background">
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">
                        <div class="visible-md visible-lg">
                            <div class="shopping-cart-table">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="lbl-shopping-cart lbl-shopping-cart-gio-hang">Giỏ hàng <span>(<span class="count_item_pr"><?php echo count($_SESSION['cart']);?></span> sản phẩm)</span></h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-main cart_desktop_page cart-page">
                                        <div class="cart page_cart cart_des_page hidden-xs-down">
                                            <div class="col-xs-9 cart-col-1">
                                                <div class="cart-tbody">
                                                    {list_shopcart}
                                                </div>
                                            </div>
                                            <div class="col-xs-3 cart-col-2 cart-collaterals cart_submit">
                                                <div id="right-affix">
                                                    <div class="each-row">
                                                        <div class="box-style fee">
                                                            <p class="list-info-price"><span>Tạm tính: </span><strong class="totals_price price _text-right text_color_right1">{tamtinh}₫</strong></p>
                                                        </div>
                                                        <div class="box-style fee">
                                                            <div class="total2 clearfix"><span class="text-label">Thành tiền: </span>
                                                                <div class="amount">
                                                                    <p><strong class="totals_price">{tongtien}₫</strong></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="button btn-proceed-checkout btn btn-large btn-block btn-danger btn-checkout" title="Thanh toán ngay" type="button" onclick="window.location.href='/checkout.html?step=1'">Thanh toán ngay</button>
                                                        <button class="button btn-proceed-checkout btn btn-large btn-block btn-danger btn-checkouts" title="Tiếp tục mua hàng" type="button" onclick="window.location.href='/san-pham.html'">Tiếp tục mua hàng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="visible-sm visible-xs">
                            <div class="cart-mobile">
                                <div class="header-cart">
                                    <div class="title-cart">
                                        <h3>Giỏ hàng của bạn</h3>
                                    </div>
                                </div>
                                <div class="header-cart-content">
                                    <div class="cart_page_mobile content-product-list">
                                        {list_shopcart_mobile}
                                    </div>
                                    <div class="header-cart-price" style="">
                                        <div class="title-cart ">
                                            <h3 class="text-xs-left">Tổng tiền</h3><a class="text-xs-right totals_price_mobile">{tongtien}₫</a>
                                        </div>
                                        <div class="checkout">
                                            <button class="btn-proceed-checkout-mobile" title="Thanh toán ngay" type="button" onclick="window.location.href='/checkout.html?step=1'">
                                                <span>Thanh toán ngay</span>
                                            </button>
                                        </div>
                                        <button class="btn btn-proceed-continues-mobile" title="Tiếp tục mua hàng" type="button" onclick="window.location.href='/san-pham.html'">Tiếp tục mua hàng</button>
                                    </div>
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