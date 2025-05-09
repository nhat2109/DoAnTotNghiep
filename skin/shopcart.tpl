{header}
<style>
	body {
		opacity: 0;
		/* Ẩn toàn bộ trang */
		transition: opacity 0.1s ease-in-out;
		/* Hiệu ứng mượt khi hiển thị lại */
	}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		document.body.style.opacity = "1"; // Hiển thị lại trang sau khi load xong
	});

</script>
<body>
    {box_header}
    <div class="bread-crumb mb-3">
        <span class="crumb-border"></span>
        <!-- <div class="container">
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
        </div> -->
    </div>
    <div class="box_shopcart">
        <div class="container">
            <div class="box_shopcart_content">
                <div class="shopcart_left">
                    <!-- <div class="box_welcome">
                        <div class="text_welcome">Hi, {name}</div>
                        <div class="tongdon">
                            <div class="text">Tổng đơn ({total_cart} sản phẩm)</div>
                            <div class="money">{tamtinh} đ</div>
                        </div>
                         <div class="hoantien" style="display: none;">
                            <div class="text">Hoàn tiền</div>
                            <div class="money">
                                <img src="/skin/css/images/hatde-hover.svg"> <span>{hat_de}</span> đ
                            </div>
                        </div> 
                    </div> -->
                    <div class="box_thongtin_khach">
                        <div class="title">
                            <div class="text">Thông tin vận chuyển</div>
                            <!-- <div class="action" id="show_diachi"><img src="/skin/css/images/notebook.png"> Chọn từ sổ
                                địa chỉ</div> -->
                        </div>
                        <div class="li_group_input col_2">
                            <div class="li_input">
                                <label><span class="required">*</span> Bắt buộc</label>
                                <input type="text" placeholder="Họ và tên" name="ho_ten" value="{ho_ten}">
                            </div>
                            <div class="li_input">
                                <label><span class="required">*</span> Bắt buộc</label>
                                <input type="text" name="dien_thoai" value="{dien_thoai}" placeholder="Điện thoại">
                            </div>
                        </div>
                        <style>
                            @media (max-width: 512px) {
                                .box_shopcart .shopcart_right .box_giohang .list_shopcart .li_shopcart .name .info .action {
                                    width: 70px;
                                    display: flex;
                                    justify-content: flex-end;
                                    align-items: center;
                                    height: 25px;
                                    margin-left: 30px;
                                    gap: 5px;
                                }
                            }
                        </style>
                        <style>
                            .li_input label {
                                color: red;
                                margin-left: 10px;
                                font-size: 13px;
                            }
                        </style>
                        <div class="li_input">
                            <label><span class="required">*</span> Bắt buộc</label>
                            <input type="text" name="dia_chi" value="{dia_chi}" placeholder="Địa chỉ">
                        </div>
                        <div class="li_group_input col_3">
                            <div class="li_input">
                                <label class="field-label" for="customer_shipping_province"><span class="required">*</span></label>
                                <select class="field-input" id="customer_shipping_province" name="tinh" value="{tinh}">
                                    <option value="">Chọn tỉnh/TP</option>
                                    {option_tinh}
                                </select>
                            </div>
                            <div class="li_input">
                                <label class="field-label" for="customer_shipping_district"><span class="required">*</span></label>
                                <select class="field-input" id="customer_shipping_district" name="huyen" value="{huyen}">
                                    <option value="">Chọn Quận/huyện</option>
                                    {option_huyen}
                                </select>
                            </div>
                            <div class="li_input">
                                <label class="field-label" for=""><span class="required">*</span></label>
                                <select name="xa">
                                    <option value="">Chọn Xã/phường</option>
                                    {option_xa}
                                </select>
                            </div>
                        </div>
                        <div class="li_input">
                            <input type="text" name="email" value="{email}" placeholder="Email">
                        </div>
                        <div class="li_input">
                            <input type="text" name="ghi_chu" placeholder="Ghi chú">
                        </div>
                    </div>

                    <div class="box_phuongthuc">
                        <div class="title">
                            <div class="text">Hình thức thanh toán</div>
                        </div>
                        <div class="list_phuongthuc">
                            <div class="li_phuongthuc">
                                <input type="radio" name="phuongthuc" checked="checked" value="cod" id="cod">
                                <label for="cod">
                                    <img src="/skin/css/images/cod.png">
                                    <div class="text">Thanh toán khi nhận hàng</div>
                                </label>
                            </div>
                            <div class="li_phuongthuc">
                                <input type="radio" name="phuongthuc" value="momo" id="momo">
                                <label for="momo">
                                    <img src="/skin/css/images/momo.png">
                                    <div class="text">Thanh toán Momo</div>
                                </label>
                            </div>
                            <div class="li_phuongthuc">
                                <input type="radio" name="phuongthuc" value="vnpay" id="vnpay">
                                <label for="vnpay">
                                    <img src="/skin/css/images/vnpay.png">
                                    <div class="text">Ví điện tử VNPAY/ VNPAY QR</div>
                                </label>
                            </div>
                            <div class="li_phuongthuc">
                                <input type="radio" name="phuongthuc" value="qr" id="qr">
                                <label for="qr">
                                    <img src="/skin/css/images/qr.png">
                                    <div class="text">Quét QR và thanh toán bằng ứng dụng ngân hàng<br>Mở ứng dụng ngân
                                        hàng để thanh toán</div>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="shopcart_right">
                    <div class="box_giohang">
                        <div class="title">Giỏ hàng</div>
                        <div class="list_shopcart">
                            <div class="th_shopcart">
                                <div class="name">Mô tả sản phẩm</div>
                                <div class="so_luong">Số lượng</div>
                                <div class="gia">Giá</div>
                            </div>
                            {list_shopcart}
                        </div>
                    </div>
        
                    <div class="box_tamtinh">
                        <div class="li_tamtinh">
                            <div class="li_tamtinh_left">Tạm tính</div>
                            <div class="li_tamtinh_right">
                                <div class="tamtinh">{tamtinh} đ</div>
                            </div>
                        </div>
                        <div class="li_tamtinh">
                            <div class="li_tamtinh_left">Giảm giá</div>
                            <div class="li_tamtinh_right">
                                <div class="giam">{giam} đ</div>
                            </div>
                        </div>
                        <div class="li_tamtinh">
                            <div class="li_tamtinh_left">Tổng phí giao hàng</div>
                            <div class="li_tamtinh_right">
                                <div class="tong_phi_ship">0 đ</div> <!-- Thêm dòng này -->
                            </div>
                        </div>
                    </div>
                    <div class="box_tong">
                        <div class="li_tong">
                            <div class="li_tong_left">Tổng</div>
                            <div class="li_tong_right">
                                <div class="tongtien">{tongtien} đ</div>
                            </div>
                        </div>
                    </div>
                    <button class="button_thanhtoan">Thanh toán {tongtien} đ</button>
                </div>
            </div>
        </div>
    </div>

    
    <!-- icon xoay xoay load load  -->
    <div id="loading"
        style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:9999;">
        <i class="fa fa-spinner fa-spin fa-3x"></i>
    </div>
    <!-- icon xoay xoay load load  -->

    
    {footer}
    {script_footer}
    <script type="text/javascript">
        if ($(window).width() < 480) {
            var sl = 1;
        } else if ($(window).width() < 768) {
            var sl = 2;
        } else if ($(window).width() < 960) {
            var sl = 4;
        }
        else {
            var sl = 5;
        }
        var slide_quatang = new Swiper('.slide_quatang', {
            // Optional parameters
            direction: 'horizontal',
            slidesPerView: 1,
            loop: true,
            observer: true,
            observeParents: true,
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            /*            autoplay: {
                            delay: 3000,
                          },*/
            // Navigation arrows
            navigation: {
                nextEl: '.box_quatang .next',
                prevEl: '.box_quatang .prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        })
        var slide_voucher = new Swiper('.slide_voucher', {
            // Optional parameters
            direction: 'horizontal',
            spaceBetween: 10,
            slidesPerView: sl,
            loop: true,
            observer: true,
            observeParents: true,
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            /*            autoplay: {
                            delay: 3000,
                          },*/
            // Navigation arrows
            navigation: {
                nextEl: '.box_voucher .next',
                prevEl: '.box_voucher .prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        });
// nhatthem
        


        //
    </script>
    <script>
        $(document).ready(function () {
            const $provinceSelect = $('#customer_shipping_province[name="tinh"]');
            const $districtSelect = $('#customer_shipping_district[name="huyen"]');
        
            function formatCurrency(amount) {
                return amount.toLocaleString('vi-VN') + ' đ';
            }
        
            function updateTotal() {
                const tamtinh = parseInt($('.tamtinh').text().replace(/[.,đ\s]/g, '')) || 0;
                const giam = parseInt($('.giam').text().replace(/[.,đ\s]/g, '')) || 0;
                const phi_ship = parseInt($('.tong_phi_ship').text().replace(/[.,đ\s]/g, '')) || 0;
                const tong = tamtinh + phi_ship - giam;
                $('.tongtien').text(formatCurrency(tong));
                $('.button_thanhtoan').text(formatCurrency(tong));
            }
        
            function getFeeShipForAllShops() {
                const receiver_province = $provinceSelect.find("option:selected").text();
                const receiver_district = $districtSelect.find("option:selected").text();
        
                if (!receiver_province || !receiver_district) {
                    $('.fee-ship b').text('0 đ');
                    $('.tong_phi_ship').text('0 đ');
                    updateTotal();
                    return;
                }
        
                let totalFeeShip = 0;
                let ajaxCount = 0;
                let ajaxDone = 0;
        
                $('.shopcart-shop-shipping').each(function () {
                    ajaxCount++;
                    const footer = $(this).closest('.shopcart-shop-footer');
                    const shippingSpan = $(this).find('.fee-ship');
                    const $totalSpan = footer.find('.subtotal b');
        
                    const sender_province = shippingSpan.data('tinh');
                    const sender_district = shippingSpan.data('huyen');
                    const weight = parseFloat(shippingSpan.data('trongluong')) || 0;
                    const amountString = shippingSpan.data('subtotal') + '';
                    const amount = parseInt(amountString.replace(/[.,]/g, '')) || 0;
        
                    if (!sender_province || !sender_district || !weight || !amount) {
                        shippingSpan.find('b').text('0 đ');
                        ajaxDone++;
                        if (ajaxDone === ajaxCount) {
                            $('.tong_phi_ship').text(formatCurrency(totalFeeShip));
                            updateTotal();
                        }
                        return;
                    }
        
                    $.ajax({
                        url: '/process.php',
                        method: 'POST',
                        data: {
                            action: 'fee_ship',
                            sender_province: sender_province,
                            sender_district: sender_district,
                            receiver_province: receiver_province,
                            receiver_district: receiver_district,
                            weight: weight,
                            amount: amount
                        },
                        success: function (response) {
                            try {
                                const info = JSON.parse(response);
                                let fee = 0;
                                if (info.ok == 1) {
                                    fee = parseInt(info.fee) || 0;
                                    shippingSpan.find('b').text(formatCurrency(fee));
                                    $totalSpan.text(formatCurrency(amount + fee));
                                } else {
                                    shippingSpan.find('b').text('0 đ');
                                }
                                totalFeeShip += fee;
                            } catch (e) {
                                shippingSpan.find('b').text('0 đ');
                            }
                            ajaxDone++;
                            if (ajaxDone === ajaxCount) {
                                $('.tong_phi_ship').text(formatCurrency(totalFeeShip));
                                updateTotal();
                            }
                        },
                        error: function () {
                            shippingSpan.find('b').text('0 đ');
                            ajaxDone++;
                            if (ajaxDone === ajaxCount) {
                                $('.tong_phi_ship').text(formatCurrency(totalFeeShip));
                                updateTotal();
                            }
                        }
                    });
                });
            }
        
            //$provinceSelect.on('change', getFeeShipForAllShops);
            $districtSelect.on('change', getFeeShipForAllShops);
        
            getFeeShipForAllShops();
        });
        </script>
</body>

</html>