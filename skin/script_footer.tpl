<button class="button_top" id="go_button">TOP</button>
<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<!-- <script type="text/javascript" src="/js/lazyload.min.js"></script> -->
<script src="/js/process.js?t=<?php echo time();?>"></script>
<script src="https://chat.schat.vn/js/chat.js"></script>
<script>
    chatAI('669de6d558c3be9f968e32fb');
</script>
<div class="load_overlay" style="display: none;"></div>
<div class="load_process" style="display: none;">
    <div class="load_content">
        <img src="/images/load.gif" alt="loading" width="70">
        <div class="load_note">Hệ thống đang xử lý</div>
    </div>
</div>
{mobile_menu}
<div class="box_pop" id="box_pop_confirm">
    <div class="box_pop_content">
        <div class="pop_content">
            <div class="li_input" style="font-style: italic;text-align: center;">
                <span style="font-style: italic;text-align: center;font-size: 20px;color: red;font-weight: 700;"
                    id="title_confirm"></span>
            </div>
        </div>
        <div class="li_input text_note" style="font-style: italic;text-align: center;width: 100%;">
            <span style="font-style: italic;font-family: Arial">Bạn có chắc chắn thực hiện hàng động này!</span>
        </div>
        <div class="pop_button">
            <div class="text_center">
                <button id="button_thuchien" action="" post_id="" loai="">Thực hiện</button>
                <button class="button_cancel bg_blue">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div id="popup-cart" class="modal fade in" role="dialog" style="display: none;z-index: 99999;">
    <div id="popup-cart-desktop" class="clearfix">
        <div class="title-popup-cart">
            <i class="ion ion-md-notifications-outline" aria-hidden="true"></i> Bạn đã thêm <span
                class="cart-popup-name"></span> vào giỏ hàng
        </div>
        <div class="title-quantity-popup">
            <a href="/gio-hang.html">Giỏ hàng của bạn có <span class="cart-popup-count">{total_cart}</span> sản phẩm</a>
        </div>
        <div class="content-popup-cart clearfix">
            <div style="overflow-x: auto;" class="scroll">
                <div style="width: 800px">
                    <div class="thead-popup">
                        <div style="width: 55%;" class="text-left">Sản phẩm</div>
                        <div style="width: 15%;" class="text-center">Đơn giá</div>
                        <div style="width: 15%;" class="text-center">Số lượng</div>
                        <div style="width: 15%;" class="text-center">Thành tiền</div>
                    </div>
                    <div class="tbody-popup"></div>
                </div>
            </div>
            <div class="tfoot-popup">
                <div class="tfoot-popup-1 clearfix">
                    <!-- <div class="pull-left popupcon">
                        <a class="btn-continue" title="Tiếp tục mua hàng"><span><span><i class="fa fa-caret-left"
                                        aria-hidden="true"></i> Tiếp tục mua hàng</span></span></a>
                    </div> -->
                    <div class="pull-right popup-total">
                        <p>Thành tiền: <span class="total-price">{tongtien}₫</span></p>
                    </div>
                </div>
                <div class="tfoot-popup-2 clearfix list_button_action">
                    <a class="button" style="width: calc(99% - 5px);border-radius: 4px !important;" title="Giỏ hàng"
                        href="/gio-hang.html"><span>Giỏ hàng</span></a>
                    <a class="button btn-proceed-checkout bg_blue" title="Thanh toán đơn hàng"
                        href="/gio-hang.html"><span>Thanh toán đơn hàng</span></a>
                </div>
            </div>
        </div>
        <a title="Close" class="quickview-close close-window" href="javascript:;"><i class="ion ion-ios-close"></i></a>
    </div>
</div>


<div class="box_note">
    <div class="note_title">Thông báo <i class="fa fa-close"></i></div>
    <div class="note_content"></div>
</div>


<div class="box_quickview">
    <div class="box_quickview_content">
        <div class="content">
            <a title="Close" class="quickview-close close-window" href="javascript:;"><i class="fa fa-times"></i></a>
            <div class="left_content">
                <div class="big">
                    <div class="swiper-container quickview_big">
                        <div class="swiper-wrapper"></div>
                        <div class="prev"><button><i class="fa fa-angle-left"></i></button></div>
                        <div class="next"><button><i class="fa fa-angle-right"></i></button></div>
                    </div>
                </div>
                <div class="small">
                    <div class="swiper-container quickview_small">
                        <div class="swiper-wrapper"></div>
                    </div>
                </div>
            </div>
            <div class="right_content">
                <h2>{tieu_de}</h2>
                <div class="group_status">
                    <span>Thương hiệu: <span class="status">{thuong_hieu}</span></span> <span>|</span> <span>Tình trạng:
                        <span class="status">{tinh_trang}</span></span>
                </div>
                <div class="price_box">
                    <span class="price">{gia_moi}₫</span><span class="old_price"><del>{gia_cu}₫</del></span>
                </div>
                <!-- Thêm cấu trúc chọn màu và size -->
                <div class="box_phanloai">
                    <div class="attribute_group">
                        <div class="attribute_container">
                            <div class="title">Màu sắc: <span class="color_active"></span></div>
                            <div class="list_phanloai kq_mau"></div>
                        </div>
                        <div class="attribute_container">
                            <div class="title">Kích cỡ: <span class="size_active"></span></div>
                            <div class="list_phanloai kq_size"></div>
                        </div>
                    </div>
                </div>
                <div class="quantity-info-wrap">
                    <div class="soluong soluong_type_1 show">
                        <label>Số lượng:</label>
                        <div class="custom-btn-number">
                            <button type="button" class="button_minus">-</button>
                            <input type="text" name="quantity" id="q_view" value="1" maxlength="3">
                            <button type="button" class="button_plus">+</button>
                        </div>
                    </div>
                    <div class="infomation">
                        <div class="zalo_support">
                            <a href="https://zalo.me/0943.051.818" class="zalo-button">
                                <i class="zalo-icon"></i> Tư vấn miễn phí ngay
                            </a>
                        </div>
                        <div class="hotline_support">
                            <a href="tel:0943051818" class="hotline_button">
                                <i class="fa fa-phone"></i> 0943.051.818
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box_note_giaohang"
                    style="padding: 5px;border: 1px rgb(229, 229, 229) solid; background-color: #e4dfdf; border-radius: 8px; margin-bottom: 4px;">
                    <div class="title" style="font-weight: bold;">Miễn phí giao hàng nhanh toàn quốc cho mọi đơn hàng
                        bất kỳ</div>
                    <div class="li_note"> <img src="/skin/css/images/fast_1.png"> Nội thành Hà Nội nhận hàng trong 1 - 2
                        ngày</div>
                    <div class="li_note"> <img src="/skin/css/images/time_1.png"> Ở tỉnh thành khác nhận hàng từ 2 - 5
                        ngày</div>
                </div>
                <div class="button_actions clearfix" style="display: flex;">
                    <button type="button" style="background-color: #ee3900;"
                        class="btn btn_base btn_add_cart btn-cart q_add_to_cart" sp_id="{id}" pl="{pl}">
                        <span class="text_1"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng </span>
                    </button>
                    <a style="margin-left: 40px;background-color: #2c7abe;" class="btn btn_base btn-proceed-checkout"
                        sp_id="{id}" pl="{pl}">
                        <span class="text_1"><i class="fa fa-credit-card"></i> Mua ngay</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="box_nnc">
    <div class="box_nnc_content">
        <div class="content">
            <div class="box_title">Đăng ký Nhà Cung Cấp <span><i class="fa fa-close"></i></span></div>
            <div class="form_nnc">
                <div class="tr_form" style="font-style: italic;">
                    Quý đối tác muốn hợp tác phân phối sản phẩm trên nền tảng của Sóc Đỏ, vui lòng để lại thông tin!
                    Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất! <br>Xin chân thành cảm ơn!
                </div>
                <div class="tr_form">
                    <div class="col_tr_50">
                        <label>Họ và tên <span class="color_red">(*)</span>:</label>
                        <input type="text" name="ho_ten" placeholder="Nhập họ và tên">
                    </div>
                    <div class="col_tr_50">
                        <label>Số điện thoại <span class="color_red">(*)</span>:</label>
                        <input type="text" name="dien_thoai" placeholder="Nhập số điện thoại liên hệ">
                    </div>
                </div>
                <div class="tr_form">
                    <label>Địa chỉ <span class="color_red">(*)</span>:</label>
                    <input type="text" name="dia_chi" placeholder="Nhập địa chỉ liên hệ">
                </div>
                <div class="tr_form">
                    <div class="col_tr_50">
                        <label>Email <span class="color_red">(*)</span>:</label>
                        <input type="text" name="email" placeholder="Nhập địa chỉ email liên hệ">
                    </div>
                    <div class="col_tr_50">
                        <label>Website công ty <span class="color_red">(*)</span>:</label>
                        <input type="text" name="cong_ty" placeholder="Nhập website công ty">
                    </div>
                </div>
                <div class="tr_form">
                    <label>Ngành hàng kinh doanh <span class="color_red">(*)</span>:</label>
                    <textarea name="nganh_hang" placeholder="Nhập ngành hàng kinh doanh"></textarea>
                </div>
                <div class="tr_form">
                    <label>Ghi chú:</label>
                    <textarea name="ghi_chu" placeholder="Nhập nội dung ghi chú"></textarea>
                </div>
                <div class="tr_form">
                    <button name="dangky_nnc">Hoàn Thành</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box_show_login">
    <div class="box_show_login_content">
        <div class="content">
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <div class="box_title">Đăng nhập tài khoản <span><i class="fa fa-close"></i></span></div>
            <div class="form_login">
                <div class="box_left_login">
                    <div class="desc">Đăng nhập để không bỏ lỡ quyền lợi tích lũy và hoàn tiền cho bất kỳ đơn hàng nào
                    </div>
                    <div class="box_login_mxh">
                        <div class="title_mxh">Đăng nhập hoặc đăng ký(Miễn phí)</div>
                        <div class="list_mxh">
                            <a href="javascript:;" onclick="signInWithGoogle();"><img
                                    src="/skin/css/images/logo_google.jpg" alt=""></a>
                            <!-- <a href="javascript:;"><img src="/skin/css/images/logo_facebook.png" alt=""></a> -->
                        </div>
                    </div>
                    <div class="line_login"><span>Hoặc</span></div>
                    <div class="li_input">
                        <input type="text" name="email" placeholder="Email/Số ĐT của bạn">
                    </div>
                    <div class="li_input">
                        <input type="password" name="password" placeholder="Mật khẩu">
                    </div>
                    <div class="li_input">
                        <button type="button" class="button_login" name="login">Đăng nhập</button>
                    </div>
                    <div class="li_input">
                        <div class="text-center">
                            <a href="/dang-ky.html">Đăng ký</a> | <a href="/quen-mat-khau.html">Quên mật khẩu?</a>
                        </div>
                    </div>
                </div>
                <div class="box_right_login">
                    <img src="/skin/css/images/banner_login.png" alt="Banner login">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box_show_update"></div>
<div class="box_kichhoat_baohanh">
    <div class="box_kichhoat_baohanh_content">
        <div class="content">
            <div class="box_title">Kích hoạt bảo hành <span><i class="fa fa-close"></i></span></div>
            <div class="content_scroll">
                <div class="box_noidung">
                    Xin chào <strong>Quý Khách Hàng!</strong><br><br>
                    <b>Công ty cổ phần Sóc Đỏ</b> xin gửi lời cảm ơn chân thành đến quý khách hàng đã tin tưởng và đặt
                    mua sản phẩm trên hệ thống Sóc Đỏ.<br><br>
                    Để đảm bảo quyền lợi, quý khách hàng vui lòng kích hoạt bảo hành điện tử theo hướng dẫn:<br><br>
                    <div class="list_step_kichhoat_baohanh">
                        <div class="step">
                            <img src="/images/step_1.png">
                        </div>
                        <div class="step">
                            <img src="/images/step_2.png">
                        </div>
                        <div class="step">
                            <img src="/images/step_3.png">
                        </div>
                    </div>
                    Nếu quý khách cần hỗ trợ hoặc giải đáp các thắc mắc, vui lòng liên hệ hotline: <b>0943.051.818</b>
                    <br>hoặc gửi email về hòm thư <b>socdogroup@gmail.com</b><br><br>
                    <strong>Trân trọng!</strong>
                </div>
                <div class="box_form">
                    <div class="title">Thông tin bảo hành</div>
                    <div class="li_input">
                        <label>Họ tên(*)</label>
                        <input type="text" name="ho_ten" placeholder="Họ và tên">
                    </div>
                    <div class="li_input">
                        <label>Điện thoại(*)</label>
                        <input type="text" name="dien_thoai" placeholder="Số điện thoại">
                    </div>
                    <div class="li_input">
                        <label>File đơn hàng(*)</label>
                        <input type="file" class="custom-file-input" name="file" id="file_donhang"
                            placeholder="Chọn file đơn hàng">
                    </div>
                    <div class="li_input">
                        <label></label>
                        <button id="save_baohanh">Hoàn thành</button>
                    </div>
                </div>
                <div class="box_chucmung">
                    <div class="text_chucmung">Chúc mừng!</div>
                    <div class="text_chucmung_description">Yêu cầu kích hoạt bảo hành thành công!</div>
                    <div class="text_account" style="display: none;">Đăng nhập Sóc Đỏ để quản lý thông tin:</div>
                    <div class="text_username" style="display: none;">Tài khoản: <span></span></div>
                    <div class="text_password" style="display: none;">Mật khẩu: <span></span></div>
                    <div class="text_coupon">Để tri ân quý khách hàng đã tin tưởng và lựa chọn Socdo.vn là nơi mua sắm
                        của mình, chúng tôi xin gửi tới quý khách mã giảm giá sử dụng cho lần mua hàng kế tiếp tại
                        Socdo.vn</div>
                    <div class="title_coupon">Thông tin mã giảm giá</div>
                    <div class="coupon">Mã voucher: <span></span></div>
                    <div class="coupon_expired">Hạn sử dụng tới: <span>12:00 30/04/2023</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box_up_index">
    <div class="box_up_index_content">
        <div class="content">
            <div class="close"><i class="fa fa-close"></i></div>
            <div class="text">
                <div class="logo_pop">
                    <img src="/skin/css/images/logofooter.png">
                </div>
                <div class="tieu_de">Nhu cầu của bạn với Sóc Đỏ?</div>
                <div class="list_button">
                    <a href="javascript:;" class="button_1">
                        <div class="content_button">
                            <h2>NGƯỜI MUA HÀNG</h2>
                            <div class="note">(MUA LẺ với GIÁ SỈ)</div>
                        </div>
                    </a>
                    <a href="javascript:;" class="button_2">
                        <div class="content_button">
                            <h2>NHÀ BÁN HÀNG</h2>
                            <div class="note">(Đối tác kinh doanh cùng Sóc Đỏ)<br>Cơ hội có thêm thu nhập tối thiểu
                                6.000.000 đ/tháng</div>
                        </div>
                    </a>
                    <a href="javascript:;" class="button_3">
                        <div class="content_button">
                            <h2>NHÀ CUNG CẤP</h2>
                            <div class="note">(Tiếp cận hàng triệu nhà bán đến từ Sóc Đỏ)</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(window).scroll(function () {
            if ($(window).width() > 979) {
                if ($(this).scrollTop() > 120) {
                    $('#go_button').fadeIn();
                    $('.top_ok').hide();
                    $('.sub-header').hide();
                    $('.top-header').hide();

                } else {
                    $('#go_button').fadeOut();
                    $('.top_ok').show();
                    $('.sub-header').show();
                    $('.top-header').show();
                }
            }

        });
        $('#go_button').on('click', function () {
            var top_download = $('body').offset().top;
            $('html,body').stop().animate({ scrollTop: top_download - 150 }, 500, 'swing', function () { });
        });
        if ($('.note_top').length > 0) {
            setTimeout(function () {
                $.ajax({
                    url: '/process.php',
                    type: 'post',
                    data: {
                        action: 'load_note',
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $('.note_top .num').show();
                        $('.note_top .num').html(info.total);
                    }
                });
            }, 1200);
        }
    });
</script>
<script>
    var quickview_Top = new Swiper('.quickview_big', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.box_quickview .next',
            prevEl: '.box_quickview .prev',
        },
        slidesPerView: 1,
        centeredSlides: true,
        centeredSlidesBounds: true,
        loop: true,
        loopedSlides: 4
    });
    var quickview_Thumbs = new Swiper('.quickview_small', {
        spaceBetween: 10,
        centeredSlides: true,
        slidesPerView: 4,
        centeredSlidesBounds: true,
        touchRatio: 0.2,
        slideToClickedSlide: true,
        loop: true,
        loopedSlides: 4
    });
    quickview_Top.controller.control = quickview_Thumbs;
    quickview_Thumbs.controller.control = quickview_Top;
</script>
<a href="https://chat.zalo.me/?phone={hotline_number}" id="linkzalo" target="_blank" rel="noopener noreferrer">
    <div class="fcta-zalo-vi-tri-nut">
        <div id="fcta-zalo-tracking" class="fcta-zalo-nen-nut">
            <div id="fcta-zalo-tracking" class="fcta-zalo-ben-trong-nut"> <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 460.1 436.6">
                    <path fill="currentColor" class="st0"
                        d="M82.6 380.9c-1.8-.8-3.1-1.7-1-3.5 1.3-1 2.7-1.9 4.1-2.8 13.1-8.5 25.4-17.8 33.5-31.5 6.8-11.4 5.7-18.1-2.8-26.5C69 269.2 48.2 212.5 58.6 145.5 64.5 107.7 81.8 75 107 46.6c15.2-17.2 33.3-31.1 53.1-42.7 1.2-.7 2.9-.9 3.1-2.7-.4-1-1.1-.7-1.7-.7-33.7 0-67.4-.7-101 .2C28.3 1.7.5 26.6.6 62.3c.2 104.3 0 208.6 0 313 0 32.4 24.7 59.5 57 60.7 27.3 1.1 54.6.2 82 .1 2 .1 4 .2 6 .2H290c36 0 72 .2 108 0 33.4 0 60.5-27 60.5-60.3v-.6-58.5c0-1.4.5-2.9-.4-4.4-1.8.1-2.5 1.6-3.5 2.6-19.4 19.5-42.3 35.2-67.4 46.3-61.5 27.1-124.1 29-187.6 7.2-5.5-2-11.5-2.2-17.2-.8-8.4 2.1-16.7 4.6-25 7.1-24.4 7.6-49.3 11-74.8 6zm72.5-168.5c1.7-2.2 2.6-3.5 3.6-4.8 13.1-16.6 26.2-33.2 39.3-49.9 3.8-4.8 7.6-9.7 10-15.5 2.8-6.6-.2-12.8-7-15.2-3-.9-6.2-1.3-9.4-1.1-17.8-.1-35.7-.1-53.5 0-2.5 0-5 .3-7.4.9-5.6 1.4-9 7.1-7.6 12.8 1 3.8 4 6.8 7.8 7.7 2.4.6 4.9.9 7.4.8 10.8.1 21.7 0 32.5.1 1.2 0 2.7-.8 3.6 1-.9 1.2-1.8 2.4-2.7 3.5-15.5 19.6-30.9 39.3-46.4 58.9-3.8 4.9-5.8 10.3-3 16.3s8.5 7.1 14.3 7.5c4.6.3 9.3.1 14 .1 16.2 0 32.3.1 48.5-.1 8.6-.1 13.2-5.3 12.3-13.3-.7-6.3-5-9.6-13-9.7-14.1-.1-28.2 0-43.3 0zm116-52.6c-12.5-10.9-26.3-11.6-39.8-3.6-16.4 9.6-22.4 25.3-20.4 43.5 1.9 17 9.3 30.9 27.1 36.6 11.1 3.6 21.4 2.3 30.5-5.1 2.4-1.9 3.1-1.5 4.8.6 3.3 4.2 9 5.8 14 3.9 5-1.5 8.3-6.1 8.3-11.3.1-20 .2-40 0-60-.1-8-7.6-13.1-15.4-11.5-4.3.9-6.7 3.8-9.1 6.9zm69.3 37.1c-.4 25 20.3 43.9 46.3 41.3 23.9-2.4 39.4-20.3 38.6-45.6-.8-25-19.4-42.1-44.9-41.3-23.9.7-40.8 19.9-40 45.6zm-8.8-19.9c0-15.7.1-31.3 0-47 0-8-5.1-13-12.7-12.9-7.4.1-12.3 5.1-12.4 12.8-.1 4.7 0 9.3 0 14v79.5c0 6.2 3.8 11.6 8.8 12.9 6.9 1.9 14-2.2 15.8-9.1.3-1.2.5-2.4.4-3.7.2-15.5.1-31 .1-46.5z">
                    </path>
                </svg></div>
            <div id="fcta-zalo-tracking" class="fcta-zalo-text">Chat ngay</div>
        </div>
    </div>
</a>
<div data-drop="{dropship}" class="notification-icon bell-icon" style="max-width: 150px;">
    <div class="bell-container" onclick="togglePopup()">
        <span class="register-text">Đăng ký <br> Dropship</span>
    </div>

    <div class="notification-popup" id="notificationPopup">
        <div id="notificationContent">
            <button id="closePopupBtn">❌</button>
            <ul>
                <li style="text-align: center; font-weight: bold; font-size: 16px;">Trở thành đối tác kinh doanh cùng
                    Sóc Đỏ !</li>
                <li>💰 THU NHẬP TRỌN ĐỜI không giới hạn !</li>
                <li>🧠 Cung cấp miễn phí các CÔNG CỤ bán hàng !</li>
                <li>🛠️ Đào tạo và xây dựng NHÂN HIỆU bán hàng miễn phí !</li>
                <li>👥 Kinh doanh online với mô hình Dropshipping 04 KHÔNG !</li>
            </ul>
            <button id="xemThemBtn">Xem thêm</button>
        </div>

        <div class="img" id="notificationImage" style="display: none; text-align: center;">
            <p style="font-weight: bold; color: red; font-size: 18px; text-align: center; margin-bottom: 10px;">
                🏆 Đăng ký để trở thành nhà bán
            </p>
            <img class="img-auto loaded" src="/skin/css/images/mo-hinh.jpg" alt=""
                style="max-width: 100%; height: auto;">
            <br>
            <a href="/dangky-banhang.html" class="register-btn">Đăng ký ngay</a>
        </div>
    </div>

</div>
<div data-drop="{dropship}" class="notification-icon home-icon">
    <a href="/dropship/dashboard.html" class="home-icon">
        <div class="home-icon_banhang">
            <span class="squirrel-icon"><img src="/skin/css/images/socdo.jpg"
                    style="border-radius:5px; transform: scaleX(-1);" alt=""></span>
            <div class="text-container">
                <span class="text" style="font-size: 11px !important; width: 109px;">Đến kênh dropship</span>
                <span class="arrow-moving">----------&gt;</span> <!-- Mũi tên động -->
            </div>
        </div>
    </a>
</div>


<!-- css cho mobile -->
<style>
    /* Overlay nền làm mờ */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        /* z-index của overlay nền */
        display: none;
    }

    /* Overlay loading toàn trang */
    .full-page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 100000;
        /* Cao hơn #popup-cart */
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .success-notification {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 100001;
        /* Cao hơn .full-page-loader */
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .full-page-loader.show {
        opacity: 1;
    }

    .success-notification.show {
        display: block;
        opacity: 1;
    }

    .loader-content {
        text-align: center;
        color: #fff;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #fff;
        border-top: 4px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 10px;
    }

    .loader-text {
        font-size: 16px;
        font-weight: bold;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* CSS cho màu sắc */
    .select-swatch {
        margin-bottom: 15px;
    }

    .select-swatch .header {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .select-swap {
        display: flex;
        gap: 10px;
        /* Khoảng cách giữa các vòng tròn màu */
    }

    .swatch-element.color-swatch {
        position: relative;
    }

    .swatch-element.color-swatch input {
        display: none;
    }

    .swatch-element.color-swatch label {
        display: block;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #fff;
        /* Viền trắng xung quanh để tạo khoảng trắng */
        box-shadow: 0 0 0 2px transparent;
        /* Viền ngoài mặc định là trong suốt */
        transition: box-shadow 0.3s, opacity 0.3s;
    }

    .swatch-element.color-swatch input:checked+label {
        box-shadow: 0 0 0 2px #007bff;
        /* Viền ngoài màu xanh dương khi được chọn */
    }

    .swatch-element.color-swatch input:disabled+label {
        opacity: 0.5;
        /* Làm mờ khi hết hàng */
        cursor: not-allowed;
        /* Con trỏ chuột không cho phép */
    }

    /* CSS cho kích cỡ (giữ nguyên như trước) */
    .swatch-element.size-swatch {
        position: relative;
    }

    .swatch-element.size-swatch input {
        display: none;
    }

    .swatch-element.size-swatch label {
        display: block;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        transition: border 0.3s, opacity 0.3s;
    }

    .swatch-element.size-swatch input:checked+label {
        border: 2px solid #007bff;
        /* Viền xanh dương khi được chọn */
    }

    .swatch-element.size-swatch input:disabled+label {
        opacity: 0.5;
        /* Làm mờ khi hết hàng */
        cursor: not-allowed;
        border: 1px solid #ccc;
    }

    /* Định dạng chung cho nhóm thuộc tính (Màu sắc và Kích cỡ) */
    .box_quickview .box_phanloai {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        /* Tăng khoảng cách giữa các nhóm */
        align-items: center;
        justify-content: flex-start;
        margin: 15px 0;
    }

    .box_quickview .attribute_group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .box_quickview .attribute_container {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: nowrap;
    }

    .box_quickview .title {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        white-space: nowrap;
    }

    /* Định dạng chung cho danh sách màu sắc và kích cỡ */
    .box_quickview .list_phanloai {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        /* Tăng khoảng cách giữa các ô */
    }

    /* Định dạng cho phần màu sắc */
    .box_quickview .kq_mau .li_color {
        min-width: 60px;
        /* Tăng chiều rộng */
        height: 40px;
        /* Tăng chiều cao */
        padding: 0 15px;
        border: 2px solid #e0e0e0;
        /* Viền đậm hơn */
        border-radius: 6px;
        /* Bo góc mềm hơn */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        background: #fff;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        /* Thêm bóng nhẹ */
    }

    /* Hiệu ứng hover cho màu sắc */
    .box_quickview .kq_mau .li_color:hover:not(.disabled) {
        border-color: #ff6200;
        color: #ff6200;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    /* Trạng thái được chọn (active) cho màu sắc */
    .box_quickview .kq_mau .li_color.active {
        border-color: #ff6200;
        background: #fff;
        color: #ff6200;
        font-weight: 600;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    /* Dấu tick khi màu được chọn */
    .box_quickview .kq_mau .li_color.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 0;
        height: 0;
        border: solid 0 0 12px 12px;
        /* Dấu tick lớn hơn */
        border-color: transparent transparent #ff6200 transparent;
    }

    /* Trạng thái hết hàng (disabled) cho màu sắc */
    .box_quickview .kq_mau .li_color.disabled {
        background: #f5f5f5;
        border-color: #e0e0e0;
        color: #999;
        cursor: not-allowed;
        position: relative;
        opacity: 0.7;
    }

    /* Đường gạch chéo khi hết hàng */
    .box_quickview .kq_mau .li_color.disabled::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 10px;
        right: 10px;
        border-top: 2px solid #ccc;
        /* Đường gạch đậm hơn */
        transform: rotate(-45deg);
    }

    /* Định dạng cho phần kích cỡ */
    .box_quickview .list_phanloai.kq_size {
        gap: 10px;
    }

    .box_quickview .kq_size .li_size {
        min-width: 60px;
        /* Tăng chiều rộng */
        height: 40px;
        /* Tăng chiều cao */
        padding: 0 15px;
        border: 2px solid #e0e0e0;
        /* Viền đậm hơn */
        border-radius: 6px;
        /* Bo góc mềm hơn */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        background: #fff;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        /* Thêm bóng nhẹ */
    }

    /* Hiệu ứng hover cho kích cỡ */
    .box_quickview .kq_size .li_size:hover:not(.disabled) {
        border-color: #ff6200;
        color: #ff6200;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    /* Trạng thái được chọn (active) cho kích cỡ */
    .box_quickview .kq_size .li_size.active {
        border-color: #ff6200;
        background: #fff;
        color: #ff6200;
        font-weight: 600;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    /* Dấu tick khi kích cỡ được chọn */
    .box_quickview .kq_size .li_size.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 0;
        height: 0;
        border: solid 0 0 12px 12px;
        /* Dấu tick lớn hơn */
        border-color: transparent transparent #ff6200 transparent;
    }

    /* Trạng thái hết hàng (disabled) cho kích cỡ */
    .box_quickview .kq_size .li_size.disabled {
        background: #f5f5f5;
        border-color: #e0e0e0;
        color: #999;
        cursor: not-allowed;
        position: relative;
        opacity: 0.7;
    }

    /* Định dạng cho input bị disabled */
    .swatch-element input:disabled+label {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Xử lý nút thông báo */
    .home-icon {
        max-width: 160px !important;
        /* Điều chỉnh kích thước */
        position: relative;
        display: inline-block;
        text-decoration: none;
    }

    /* Nền xanh, chữ trắng, kiểu hộp chat */
    .home-icon_banhang {
        background-color: #007bff;
        /* Màu xanh */
        color: white;
        /* Chữ trắng */
        padding: 4px 3px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: bold;
        position: relative;
        display: flex;
        /* Dùng flexbox để căn chỉnh */
        align-items: center;
        gap: 10px;
        /* Khoảng cách giữa icon và text */
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    /* Con sóc lớn và quay ngược */
    .squirrel-icon {

        /* font-size: 40px; Kích thước lớn hơn */
        transform: scaleX(-1);
        /* Quay ngược lại */
    }

    /* Chia text và mũi tên thành 2 dòng */
    .text-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-right: 1px;
    }

    /* Căn chỉnh chữ */
    .text {
        font-size: 16px;
        font-weight: bold;
    }

    /* Mũi tên động (nằm dưới) */
    .arrow-moving {
        line-height: 5px;
        display: block;
        font-size: 14px;
        font-weight: bold;
        margin-top: 3px;
        overflow: hidden;
        white-space: nowrap;
        animation: moveArrow 1.5s linear infinite, blinkText 1.5s infinite;
    }

    /* Hiệu ứng mũi tên di chuyển */
    @keyframes moveArrow {
        0% {
            transform: translateX(-10px);
            opacity: 0.5;
        }

        50% {
            transform: translateX(0px);
            opacity: 1;
        }

        100% {
            transform: translateX(10px);
            opacity: 0.5;
        }
    }

    /* Hiệu ứng chữ nhấp nháy */
    @keyframes blinkText {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }
    }

    /* Hiệu ứng hover */
    .home-icon:hover .home-icon_banhang {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* Hiệu ứng click */
    .home-icon:active .home-icon_banhang {
        transform: scale(0.95);
    }


    @media screen and (max-width: 768px) {
        .home-icon {
            bottom: 25px !important;
        }

        .notification-popup {
            margin-bottom: 12px;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            width: 92%;
            max-width: 320px;
            font-size: 14px;
            padding: 12px;
        }

        #notificationPopup {
            left: 117%;
            transform: translateX(-50%);
            width: 92%;
            max-width: 370px;
            padding: 15px;
        }

        #notificationContent {
            font-size: 14px;
            line-height: 1.7;
            text-align: left;
        }

        .register-btn {
            padding: 10px 20px;
            font-size: 14px;
        }

        #xemThemBtn {
            margin-left: auto;
            margin-right: auto;
            display: block;
            text-align: center;
            width: 40%;
            font-size: 14px;
            padding: 10px;
            margin-left: 0px !important;
            margin-right: 100px;
        }

        .notification-icon {
            bottom: 15px;
            right: 15px;
        }


        .bell-container {
            width: 69px ;
            height: 69px ;
            border: 1.5px solid red !important;
        }


        .bell-container::before {
            border: 1.5px solid rgba(255, 0, 0, 0.8);
            box-shadow: 0 0 5px 3px rgba(255, 0, 0, 0.6);
        }



        #notificationImage {
            width: 100vw;
            height: 100vh;
            padding: 0;
        }

        /* .image-container {
            max-width: 95%;
        } */

        #notificationImage img {
            width: 95%;
            max-height: 95vh;
        }

        .custom-image-container {
            width: 95% !important;

        }

        #linkzalo,
        .fcta-zalo-vi-tri-nut {
            width: 45px !important;
            height: 45px !important;
            position: fixed;
            bottom: 70px;
            z-index: 9999 !important;
        }

        #linkzalo {
            right: 10px;
        }

        .fcta-zalo-vi-tri-nut {
            right: 10px;
        }

    }

    @media screen and (max-width: 768px) {
        .bell-container {
            width: 69px !important;
            height: 69px !important;
            border: 1.5px solid red !important;
        }
    }
</style>

<style>
    #closePopupBtn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 15px;
        cursor: pointer;
        color: red;
        font-weight: bold;
    }

    #xemThemBtn {
        float: right;
        padding: 8px 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    #xemThemBtn:hover {
        background-color: #0056b3;
    }

    .register-btn {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 20px;
        background: red;
        color: white;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        text-align: center;
    }

    .register-btn:hover {
        background-color: #5584b6;
    }

    .notification-icon {
        position: fixed;
        bottom: 20px;
        right: 20px;
    }


    .bell-container {
        width: 80px;
        height: 80px;
        padding: 8px 15px;
        background: radial-gradient(circle at center, #ff0000 0%, #ff4d4d 70%, #ff6666 100%);
        border: 2px solid #fff;
        border-radius: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        position: relative;
        bottom: -15px;
    }

    .bell-container::before {
        content: "";
        position: absolute;
        border: 2px solid rgba(255, 0, 0, 0.8);
        border-radius: 40px;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: radial-gradient(circle at center, rgba(255, 0, 0, 0.8) 0%, rgba(255, 0, 0, 0.4) 50%, rgba(255, 0, 0, 0) 100%);
        animation: glow 2s infinite ease-in-out;
    }

    .register-text {
        color: white;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        white-space: nowrap;
        z-index: 1;
    }

    @keyframes glow {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        25% {
            transform: scale(1.2);
            opacity: 0.9;
        }

        50% {
            transform: scale(1.4);
            opacity: 0.7;
        }

        75% {
            transform: scale(1.6);
            opacity: 0.4;
        }

        85% {
            transform: scale(1.8);
            opacity: 0;
        }
    }

    .notification-popup {
        position: absolute;
        bottom: 50px;
        left: 50px;
        width: 220px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 10px;
        display: none;
        font-size: 14px;
        padding: 10px;
    }

    .notification-popup.show {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }

    #notificationImage {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
    }

    #notificationImage img {
        width: 90vw;
        height: auto;
        max-height: 90vh;
        border-radius: 10px;
    }

    #notificationPopup {
        position: absolute;
        width: 500px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    #notificationContent {
        font-size: 14px;
        line-height: 2;
    }

    #notificationPopup p {
        font-size: 18px;
        font-weight: bold;
    }


    #xemThemBtn {
        display: block;
        margin-top: 10px;
        margin-left: 140px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        font-size: 14px;
    }

    #xemThemBtn:hover {
        background: #0056b3;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
<!-- Xử lý nút thông báo dropship -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const bellIcon = document.querySelector(".bell-icon");
        const homeIcon = document.querySelector(".home-icon");

        const dataDrop = bellIcon.getAttribute("data-drop");

        if (dataDrop === "1") {
            bellIcon.style.display = "none"; // Ẩn chuông
            homeIcon.style.display = "block"; // Hiện icon home
        } else {
            bellIcon.style.display = "block"; // Hiện chuông
            homeIcon.style.display = "none"; // Ẩn icon home
        }
    });

</script>
<!-- xử lí hiện popup -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let popup = document.getElementById("notificationPopup");
        let closeBtn = document.getElementById("closePopupBtn");

        if (closeBtn) {
            closeBtn.addEventListener("click", function () {
                popup.style.display = "none";
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        let popup = document.getElementById("notificationPopup");
        let bell = document.querySelector(".bell-container");
        let xemThemBtn = document.getElementById("xemThemBtn");

        let autoCloseTimeout;
        let userClickedBell = false;
        const POPUP_INTERVAL = 21600000;

        let overlay = document.createElement("div");
        overlay.id = "imageOverlay";
        overlay.style.position = "fixed";
        overlay.style.top = "0";
        overlay.style.left = "0";
        overlay.style.width = "100%";
        overlay.style.height = "100%";
        overlay.style.backgroundColor = "rgba(0, 0, 0, 0.7)";
        overlay.style.display = "none";
        overlay.style.justifyContent = "center";
        overlay.style.alignItems = "center";
        overlay.style.zIndex = "9999";
        document.body.appendChild(overlay);

        let imageContainer = document.createElement("div");
        imageContainer.classList.add("custom-image-container");
        imageContainer.style.position = "relative";
        imageContainer.style.background = "#fff";
        imageContainer.style.padding = "15px";
        imageContainer.style.borderRadius = "10px";
        imageContainer.style.display = "flex";
        imageContainer.style.flexDirection = "column";
        imageContainer.style.alignItems = "center";
        imageContainer.style.textAlign = "center";
        imageContainer.style.width = "70%";
        imageContainer.style.boxShadow = "0px 4px 10px rgba(0, 0, 0, 0.2)";
        overlay.appendChild(imageContainer);

        let titleText = document.createElement("p");
        titleText.innerHTML = "";
        titleText.style.fontWeight = "bold";
        titleText.style.color = "red";
        titleText.style.fontSize = "18px";
        titleText.style.textAlign = "center";
        titleText.style.marginBottom = "10px";
        imageContainer.appendChild(titleText);

        let image = document.querySelector("#notificationImage img");
        image.style.display = "block";
        image.style.maxWidth = "100%";
        image.style.height = "auto";
        image.style.borderRadius = "5px";
        imageContainer.appendChild(image);

        let closeBtn = document.createElement("button");
        closeBtn.innerHTML = "&#10006;";
        closeBtn.style.position = "absolute";
        closeBtn.style.top = "10px";
        closeBtn.style.right = "10px";
        closeBtn.style.width = "30px";
        closeBtn.style.height = "30px";
        closeBtn.style.border = "none";
        closeBtn.style.background = "transparent";
        closeBtn.style.fontSize = "20px";
        closeBtn.style.cursor = "pointer";
        closeBtn.style.color = "red";
        imageContainer.appendChild(closeBtn);

        let registerBtn = document.querySelector(".register-btn");
        let newRegisterBtn = registerBtn.cloneNode(true);
        newRegisterBtn.style.marginTop = "10px";
        imageContainer.appendChild(newRegisterBtn);

        // ===== Thêm các box nội dung dưới ảnh =====
        let infoBoxContainer = document.createElement("div");
        infoBoxContainer.style.display = "flex";
        infoBoxContainer.style.justifyContent = "center";
        infoBoxContainer.style.gap = "15px";
        infoBoxContainer.style.marginTop = "20px";

        let boxData = [

        ];

        boxData.forEach(data => {
            let infoBox = document.createElement("div");
            infoBox.style.background = "#f8f9fa";
            infoBox.style.border = "1px solid #ddd";
            infoBox.style.padding = "10px";
            infoBox.style.width = "30%";
            infoBox.style.textAlign = "center";
            infoBox.style.borderRadius = "8px";
            infoBox.style.boxShadow = "0px 2px 5px rgba(0, 0, 0, 0.1)";

            let title = document.createElement("h3");
            title.innerHTML = data.title;
            title.style.fontSize = "16px";
            title.style.color = "#d9534f";
            title.style.marginBottom = "5px";

            let desc = document.createElement("p");
            desc.innerHTML = data.desc;
            desc.style.fontSize = "14px";
            desc.style.color = "#333";

            infoBox.appendChild(title);
            infoBox.appendChild(desc);
            infoBoxContainer.appendChild(infoBox);
        });

        imageContainer.appendChild(infoBoxContainer);
        // ===== Kết thúc phần thêm box nội dung =====

        function showPopup(autoClose = true) {
            popup.style.display = "block";

            localStorage.setItem("lastPopupTime", Date.now());

            if (autoClose) {
                autoCloseTimeout = setTimeout(hidePopup, 3000);
            }
        }

        function hidePopup() {
            popup.style.display = "none";
        }

        function showImage() {
            hidePopup();
            overlay.style.display = "flex";
        }

        function closeImage() {
            overlay.style.display = "none";
        }

        function togglePopup() {
            clearTimeout(autoCloseTimeout);
            userClickedBell = true;

            if (popup.style.display === "block") {
                hidePopup();
            } else {
                showPopup(false);
            }
        }

        function checkAndShowPopup() {
            let lastPopupTime = localStorage.getItem("lastPopupTime");

            if (!lastPopupTime || Date.now() - lastPopupTime >= POPUP_INTERVAL) {
                showPopup();
            }
        }

        checkAndShowPopup();

        if (bell) {
            bell.addEventListener("click", togglePopup);
        }

        if (xemThemBtn) {
            xemThemBtn.addEventListener("click", showImage);
        }

        closeBtn.addEventListener("click", closeImage);
        overlay.addEventListener("click", function (event) {
            if (event.target === overlay) {
                closeImage();
            }
        });
    });

</script>





<style>
    @media all AND (max-width: 480px) {
        /* #linkzalo {
            display: none;
        } */

        #fb-root {
            display: none;
        }

        #go_button {
            display: none;
        }
    }

    @keyframes zoom {
        0% {
            transform: scale(.5);
            opacity: 0
        }

        50% {
            opacity: 1
        }

        to {
            opacity: 0;
            transform: scale(1)
        }
    }

    @keyframes lucidgenzalo {
        0% to {
            transform: rotate(-25deg)
        }

        50% {
            transform: rotate(25deg)
        }
    }

    .jscroll-to-top {
        bottom: 100px
    }

    .fcta-zalo-ben-trong-nut svg path {
        fill: #fff
    }

    .fcta-zalo-vi-tri-nut {
        position: fixed;
        bottom: 50px;
        right: 20px;
        z-index: 999
    }

    .notification-icon {
        position: fixed;
        bottom: 50px;
        left: 20px;
        z-index: 999
    }

    .fcta-zalo-nen-nut,
    div.fcta-zalo-mess {
        box-shadow: 0 1px 6px rgba(0, 0, 0, .06), 0 2px 32px rgba(0, 0, 0, .16)
    }

    .fcta-zalo-nen-nut {
        width: 50px;
        height: 50px;
        text-align: center;
        color: #fff;
        background: #0068ff;
        border-radius: 50%;
        position: relative
    }

    .fcta-zalo-nen-nut::after,
    .fcta-zalo-nen-nut::before {
        content: "";
        position: absolute;
        border: 1px solid #0068ff;
        background: #0068ff80;
        z-index: -1;
        left: -20px;
        right: -20px;
        top: -20px;
        bottom: -20px;
        border-radius: 50%;
        animation: zoom 1.9s linear infinite
    }

    .fcta-zalo-nen-nut::after {
        animation-delay: .4s
    }

    .fcta-zalo-ben-trong-nut,
    .fcta-zalo-ben-trong-nut i {
        transition: all 1s
    }

    .fcta-zalo-ben-trong-nut {
        position: absolute;
        text-align: center;
        width: 60%;
        height: 60%;
        left: 10px;
        bottom: 25px;
        line-height: 70px;
        font-size: 25px;
        opacity: 1
    }

    .fcta-zalo-ben-trong-nut i {
        animation: lucidgenzalo 1s linear infinite
    }

    .fcta-zalo-nen-nut:hover .fcta-zalo-ben-trong-nut,
    .fcta-zalo-text {
        opacity: 0
    }

    .fcta-zalo-nen-nut:hover i {
        transform: scale(.5);
        transition: all .5s ease-in
    }

    .fcta-zalo-text a {
        text-decoration: none;
        color: #fff
    }

    .fcta-zalo-text {
        position: absolute;
        top: 6px;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 700;
        transform: scaleX(-1);
        transition: all .5s;
        line-height: 1.5
    }

    .fcta-zalo-nen-nut:hover .fcta-zalo-text {
        transform: scaleX(1);
        opacity: 1
    }

    div.fcta-zalo-mess {
        position: fixed;
        bottom: 55px;
        left: 58px;
        z-index: 99;
        background: #fff;
        padding: 7px 25px 7px 15px;
        color: #0068ff;
        border-radius: 0px 50px 50px 0px;
        font-weight: 700;
        font-size: 15px
    }

    .fcta-zalo-mess span {
        color: #0068ff !important
    }

    span#fcta-zalo-tracking {
        font-family: Roboto;
        line-height: 1.5
    }

    .fcta-zalo-text {
        font-family: Roboto
    }




    /* Styling cho nút Zalo */
    .zalo_support {
        margin-top: 20px;
        text-align: center;
    }

    .quantity-info-wrap {
        position: relative;
        /* Nếu muốn căn chỉnh chiều cao hoặc thêm khoảng cách, có thể set thêm padding/margin */
    }

    .infomation {
        position: absolute;
        top: -5px;
        /* Hoặc điều chỉnh theo vị trí mong muốn */
        right: 0px;
        /* Căn sát bên phải */
        display: flex;
        gap: 1px;
        z-index: 10;
        /* Đảm bảo nằm trên các phần tử khác */
    }


    .zalo_support,
    .hotline_support {
        margin-top: 0;
        margin-left: 0;
    }

    .zalo-button,
    .hotline_button {
        padding: 5px 10px;
        font-size: 12px;
    }

    .zalo-button {
        margin-top: 21px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 7px;
        background-color: #0084FF;
        color: white;
        font-size: 11px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Hiệu ứng đổ bóng */
    }

    .btn_add_cart[style*="background-color: black"]:hover {
        background-color: #444444;
        /* Màu đen sáng hơn khi hover */
        transform: translateY(-2px);
        /* Hiệu ứng nâng nút lên */
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
        /* Đổ bóng khi hover */
    }

    .btn_add_cart[style*="background-color: #ff0101"]:hover {
        background-color: #d60000;
        /* Màu đỏ đậm hơn */
        transform: translateY(-2px);
        /* Nút phóng to khi hover */
        box-shadow: 0px 8px 15px rgba(255, 0, 0, 0.4);
        /* Đổ bóng màu đỏ nhạt */
    }

    .zalo-button:hover {
        background-color: #005BB5;
        /* Màu xanh đậm hơn khi hover */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        /* Hiệu ứng đổ bóng lớn hơn */
        transform: translateY(-2px);
        /* Hiệu ứng nổi lên */
    }

    /* Icon Zalo */
    .zalo-icon {
        background: url('https://img.icons8.com/color/48/000000/zalo.png') no-repeat center center;
        background-size: contain;
        width: 24px;
        height: 24px;

        /* Khoảng cách giữa icon và text */
    }

    .fa-shopping-cart:before {
        content: "\f07a";
        font-size: 25px;
        margin-right: 13px;
    }

    .fa-credit-card:before {
        content: "\f09d";
        font-size: 25px;
        margin-right: 13px;
    }

    .fa-phone {
        width: 29px;
        font-size: 22px;
        height: 24px;
        margin-right: 0px;
        /* Khoảng cách giữa icon và text */
    }

    .quantity-info-wrap .infomation .hotline_support {
        margin-left: 20px;
        margin-top: 31px;
        text-align: center;
    }

    .hotline_button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 7px;
        background-color: #17b72c;
        font-size: 11px;
        color: white;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Hiệu ứng đổ bóng */
    }

    .hotline_button:hover {
        background-color: #18c74a;
        /* Màu xanh đậm hơn khi hover */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        /* Hiệu ứng đổ bóng lớn hơn */
        transform: translateY(-2px);
        /* Hiệu ứng nổi lên */
    }

    .zalo_support a,
    .hotline_support a {
        max-width: 120%;
    }
</style>

<script>
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) { document.getElementById("linkzalo").href = "https://zalo.me/{hotline_number}"; }
</script>