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
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h1 class="title-head widget-title">Đơn hàng #{ma_don}
                    </h1>
                    <span class="note order_date"><i>Ngày tạo &mdash; {date_post}</i></span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div id="order_shipping" class="span6 box-address margin-top-20">
                        <div class="box-header">
                            <h2 class="title-head">Thông tin giao hàng</h2>
                            <p>
                                <span class="note">Trạng thái:</span>
                                <i class="status_not fulfilled">
                                    <!-- order.fulfillment_status -->
                                    {trang_thai}
                                </i>
                            </p>
                        </div>
                        <div class="address note">
                            <p><i class="fa fa-user"></i> {ho_ten}</p>
                            <p><i class="fa fa-map-marker"></i>
                                {dia_chi}, {huyen}, {tinh}
                            </p>
                            <p><i class="fa fa-phone"> </i><a href="tel:{dien_thoai}">{dien_thoai}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="table-responsive-block margin-top-20">
                        <table id="order_details" class="table table-cart">
                            <thead class="thead-default">
                                <tr>
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
                        <a href="/don-hang.html" class="btn btn-blues"><i class="fa fa-reply" aria-hidden="true"></i> Danh sách đơn hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {footer}
    {script_footer}
</body>

</html>