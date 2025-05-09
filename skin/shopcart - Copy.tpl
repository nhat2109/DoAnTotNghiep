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
                        <li class="active"><span>Giỏ hàng</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="box_shopcart">
        <div class="container">
            <div class="row">
                <div class="shopcart_left">
                    <h1>Giỏ hàng của bạn <span class="count_shopcart">(<?php echo count($_SESSION['cart']);?> sản phẩm)</span></h1>
                    <div class="list_shopcart">
                        {list_shopcart}
                    </div>
                    <div class="list_note_gop">
                        <div class="note_gop">Bạn hãy cố gắng mua thêm sản phẩm để tạo đơn: <b class="color_red">SIÊU GỘP ĐƠN</b>, nhận thêm nhiều ưu đãi cực lớn!</div>
                        <div class="box_gopdon">
                            <div class="box_gopdon_content">
                                <div class="tieu_de">
                                    CHẤN ĐỘNG GIÁ - SIÊU GỘP ĐƠN CHỈ CÓ TẠI SOCDO.VN
                                </div>
                                <div class="chinh_sach">
                                    Ngoài việc giúp Khách hàng được <b>mua LẺ với giá SỈ</b>. Sóc Đỏ tiếp tục ra mắt chương trình <b>SIÊU GỘP ĐƠN</b> cực hời tới toàn bộ cộng đồng nhà bán. Giảm giá bán trực tiếp cho <b>đơn hàng có từ 2 sản phẩm bất kỳ trở lên</b>, cụ thể:<br>
                                    <ul>
                                        <li>Giảm thêm 3% cho sản phẩm thứ 2 bất kỳ</li>
                                        <li>Giảm thêm 6% cho sản phẩm thứ 3 bất kỳ</li>
                                        <li>Giảm thêm 7% cho sản phẩm thứ 4 bất kỳ</li>
                                        <li>Giảm thêm 8% cho sản phẩm thứ 5 bất kỳ</li>
                                    </ul>
                                    <i class="color_red bold">Lưu ý : Áp dụng cho một đơn hàng không quá 05 sản phẩm và có sự điều chỉnh tỷ lệ chiết khấu đối với Nhà Bán hàng chuyên nghiệp.</i><br>
                                    <b>Mọi thông tin chi tiết:</b><br>
                                    <b>Website:</b> <b class="color_red">https://socdo.vn</b><br>
                                    <b>Hotline / Zalo:</b> <b class="color_red">0943.051.818/ 0966.279.109</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shopcart_right">
                    <div class="li_shopcart_right">
                        <div class="text_left">Tạm tính:</div>
                        <div class="text_right tamtinh">{tamtinh} đ</div>
                    </div>
                    <div class="li_shopcart_right border_top">
                        <div class="text_left">Thành tiền:</div>
                        <div class="text_right total_price">{tongtien} đ</div>
                    </div>
                    <div class="li_shopcart_right">
                        <button onclick="window.location.href='/checkout.html?step=1'" class="checkout" type="button" title="Thanh toán ngay">Thanh toán ngay</button>
                    </div>
                    <div class="li_shopcart_right">
                        <button onclick="window.location.href='/checkout-gopdon.html?step=1'" class="checkout bg_green" style="border:none;" type="button" title="Siêu gộp đơn">Siêu gộp đơn</button>
                    </div>
                    <div class="li_shopcart_right">
                        <button onclick="window.location.href='/san-pham.html'" class="checkouts" type="button" title="Tiếp tục mua hàng">Tiếp tục mua hàng</button>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
</body>

</html>