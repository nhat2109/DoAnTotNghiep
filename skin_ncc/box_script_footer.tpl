<!-- <script type="text/javascript" src="/js/jquery.nicescroll.min.js"></script> -->
<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<script src="/js/process_ncc.js?t=<?php echo time();?>"></script>
<div class="load_overlay" style="display: none;"></div>
<div class="load_process">
    <div class="load_content">
        <img src="/images/load.gif" alt="loading" width="70">
        <div class="load_note">Hệ thống đang xử lý...</div>
    </div>
</div>
<div class="load_overlay2"></div>
<div class="load_process_2" style="display: none;">
    <div class="load_content">
        <div class="loading">
            <div class="loading-container loading-control abslt">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
                <div class="shape shape-4"></div>
            </div>
        </div>
        <div class="load_note">
            <span>Hệ thống đang xử lý</span>
            <div class="list_dot">
                <div class="loading-dot dot1"></div>
                <div class="loading-dot dot2"></div>
                <div class="loading-dot dot3"></div>
            </div>
        </div>
    </div>
</div>
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
<div class="box_pop" id="box_pop_confirm_action_domain">
    <div class="box_pop_content">
        <div class="pop_content">
            <div class="li_input" style="font-style: italic;text-align: center;">
                <span style="font-style: italic;text-align: center;font-size: 20px;color: red;font-weight: 700;"
                    class="title_confirm"></span>
            </div>
        </div>
        <div class="li_input" style="font-style: italic;text-align: center;width: 100%;">
            <span style="font-style: italic;font-family: Arial" id="text_note_pop"><strong>Lưu ý</strong>:Mỗi tài khoản
                chỉ sử dụng được một tên miền!</span>
        </div>
        <div class="pop_button">
            <div class="text_center">
                <button class="" style="display: none;" id="button_ok_domain">Thực hiện hành động</button>
                <button id="button_thuchien_action_domain" action="" post_id="" loai="">Thực hiện</button>
                <button class="button_cancel bg_blue">Hủy</button>
            </div>
        </div>
    </div>
</div>
<div class="box_pop" id="box_pop_confirm_action">
    <div class="box_pop_content">
        <div class="pop_content">
            <div class="li_input" style="font-style: italic;text-align: center;">
                <span style="font-style: italic;text-align: center;font-size: 20px;color: red;font-weight: 700;"
                    class="title_confirm"></span>
            </div>
        </div>
        <div class="li_input" style="font-style: italic;text-align: center;width: 100%;">
            <span style="font-style: italic;font-family: Arial">Bạn có chắc chắn thực hiện hành động này!</span>
        </div>
        <div class="pop_button">
            <div class="text_center">
                <button class="" style="display: none;" id="button_ok">Thực hiện hành động</button>
                <button id="button_thuchien_action" action="" post_id="" loai="">Thực hiện</button>
                <button class="button_cancel bg_blue">Hủy</button>
            </div>
        </div>
    </div>
</div>
<div id="popup-cart" class="modal fade in" role="dialog" style="display: none; z-index: 99999;">
    <div id="popup-cart-desktop" class="clearfix">
        <div class="title-popup-cart"><i class="ion ion-md-notifications-outline" aria-hidden="true"></i> Bạn đã thêm
            <span class="cart-popup-name"></span> vào giỏ hàng
        </div>
        <div class="title-quantity-popup">
            <a href="/cart">Giỏ hàng của bạn có <span class="cart-popup-count"></span> sản phẩm</a>
        </div>
        <div class="content-popup-cart clearfix">
            <div class="scroll_cart scroll" style="overflow: auto;">
                <div class="thead-popup" style="width: 800px;">
                    <div style="width: 55%;" class="text-left">Sản phẩm</div>
                    <div style="width: 15%;" class="text-center">Đơn giá</div>
                    <div style="width: 15%;" class="text-center">Số lượng</div>
                    <div style="width: 15%;" class="text-center">Thành tiền</div>
                </div>
                <div class="tbody-popup" style="width: 800px;"></div>
            </div>
            <div class="tfoot-popup">
                <div class="tfoot-popup-1 clearfix">
                    <div class="pull-left popupcon">
                        <a class="btn-continue" title="Tiếp tục mua hàng"><span><span><i class="fa fa-caret-left"
                                        aria-hidden="true"></i> Tiếp tục mua hàng</span></span></a>
                    </div>
                    <div class="pull-right popup-total">
                        Thành tiền: <span class="total-price"></span>
                    </div>
                </div>
                <div class="tfoot-popup-2 clearfix">
                    <a class="button btn-proceed-checkout" title="Thanh toán đơn hàng"
                        href="/ncc/add-donhang-drop?step=2"><span>Giỏ hàng của bạn</span></a>
                </div>
            </div>
        </div>
        <a title="Close" class="quickview-close close-window" href="javascript:;"><i class="ion ion-ios-close"></i></a>
    </div>
</div>
<div class="box_select_product">
    <div class="box_select_product_content">
        <div class="box_content">
            <div class="box_title"><span>Chọn sản phẩm</span><span><i class="fa fa-times-circle"></i></span></div>
            <div class="box_search">
                <input type="text" name="key_deal" placeholder="Nhập từ khóa tìm kiếm"> <button
                    class="search_deal">Tìm</button>
            </div>
            <div class="box_list scroll" page="1" tiep="1" loaded="1"></div>
            <div class="box_bottom">
                <button name="select_main_product" loai="main_product">Tiếp tục</button>
            </div>
        </div>
    </div>
</div>
<div class="box_popup" id="pop_hotro">
    <div class="box_popup_content">
        <div class="box_title"><span></span><span><i class="fa fa-close"></i></span></div>
        <div class="content_box">
            <div class="pop_hotro">
                <div class="noi_dung">
                    Bạn muốn được <b>SÓC ĐỎ</b> hỗ trợ các thông tin: Sản phẩm, hướng dẫn bán hàng, xử lý đơn
                    hàng...<br>
                    Vui lòng chọn khung thời gian để <b>SÓC ĐỎ</b> hỗ trợ bạn một cách tốt nhất.
                </div>
                <div class="list_thoigian">
                    <div class="title_hotro">Chọn khung thời gian muốn được hỗ trợ</div>
                    <div class="li_thoigian">
                        <label>Thời gian nhận hỗ trợ</label>
                        <input type="text" name="thoi_gian" class="thoigian_mask"
                            placeholder="Nhập thời gian nhận hỗ trợ">
                    </div>
                    <div class="li_thoigian">
                        <button id="datlich_hotro">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box_select_nguoinhan">
    <div class="box_select_nguoinhan_content">
        <div class="box_content">
            <div class="box_title"><span>Chọn khách hàng</span><span><i class="fa fa-times-circle"></i></span></div>
            <div class="box_search">
                <input type="text" name="key_member" placeholder="Nhập từ khóa tìm kiếm"> <button
                    class="search_member">Tìm</button>
            </div>
            <div class="box_list scroll" page="1" tiep="1" loaded="1"></div>
        </div>
    </div>
</div>
<div class="box_pop_add"></div>

<!-- <div style="display: none;">{box_taikhoan_kh}</div>
<div class="box_sms_bottom">
    <div class="box_sms_bottom_content"><a href="/ncc/list-chat"><img src="/images/icon-nu.png"><span
                class="total_chat">0</span></a></div>
    <div class="box_huongdan">
        <div class="muiten right"><i class="fa fa-caret-up"></i></div>
        <div class="noidung_huongdan">Chat với bộ phận hỗ trợ</div>
        <div class="button_next"><button step="box_hotro">Tiếp theo</button></div>
    </div>
</div> -->






<input type="hidden" name="thanhvien_chat" value="{thanhvien_chat}">
<audio id="sound_chat">
    <source src="/images/chat.mp3" type="audio/mpeg">
    Không hỗ trợ trình duyệt HTML 5
</audio>
<audio id="sound_global_message">
    <source src="/images/global_message3.mp3" type="audio/mpeg">
    Không hỗ trợ trình duyệt HTML 5
</audio>
<audio id="sound_notification">
    <source src="/images/global_message.mp3" type="audio/mpeg">
    Không hỗ trợ trình duyệt HTML 5
</audio>
<button id="play_chat" onclick="play_chat()" style="display: none;">Play sound</button>
<button id="play_chat_global" onclick="play_global()" style="display: none;">Play sound</button>
<button id="play_notification" onclick="play_notification()" style="display: none;">Play sound</button>
<script>
    var sound_chat = document.getElementById("sound_chat");
    var sound_global_message = document.getElementById("sound_global_message");
    var sound_notification = document.getElementById("sound_notification");
    function play_chat() {
        sound_chat.play();
    }
    function play_global() {
        sound_global_message.play();
    }
    function play_notification() {
        sound_notification.play();
    } 
</script>
<div class="add_cart_fixed">
    <a href="/ncc/add-donhang-drop"><i class="icon icon-cart-add"></i></a>
    <div class="box_huongdan">
        <div class="muiten right"><i class="fa fa-caret-up"></i></div>
        <div class="noidung_huongdan">Truy cập mục tạo đơn hàng</div>
        <div class="button_next"><button step="box_add_cart">Tiếp theo</button></div>
    </div>
</div>
<input type="hidden" name="pop_hotro" value="{pop_hotro}">
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css" />
<link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script src="/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/moment/moment.js"></script>
<script type="text/javascript" src="/js/moment/locale/vi.js"></script>
<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            var slide_donhang = new Swiper('.slide_donhang', {
                // Optional parameters
                direction: "horizontal",
                slidesPerView: 1,
                loop: true,
                observer: true,
                observeParents: true,
                // If we need pagination
                autoplay: {
                    delay: 5000,
                },
                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                // Navigation arrows
                navigation: {
                    nextEl: '.slide_thuonghieu .next',
                    prevEl: '.slide_thuonghieu .prev',
                    disabledClass: 'hide_button',
                    hiddenClass: 'hide_button'
                },
            });
        }, 1000);
        pop_hotro = $('input[name=pop_hotro]').val();
        if (pop_hotro == 1) {
            if (get_cookie('show_huongdan')) {
                setTimeout(function () {
                    $.ajax({
                        url: "/ncc/process.php",
                        type: "post",
                        data: {
                            action: "update_pop_hotro"
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#pop_hotro').fadeIn();
                        }

                    });
                }, 3000)
            }
        }
        $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
        $('input.timepicker').timepicker({ 'timeFormat': 'H:i', 'step': 5 });
        $('.datetimepicker_mask').datetimepicker({
            format: 'H:i d/m/Y',
            locale: 'vi'
            //mask:'16:35 26/07/1988',
        });
        $('.thoigian_mask').datetimepicker({
            format: 'H:i d/m/Y',
            minTime: '08:00',
            maxTime: '23:00',
            locale: 'vi'
            //mask:'16:35 26/07/1988',
        });
        $.datepicker.setDefaults({
            closeText: "Đóng",
            prevText: "&#x3C;Trước",
            nextText: "Tiếp&#x3E;",
            currentText: "Hôm nay",
            monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"
            ],
            monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
            ],
            dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
            dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            weekHeader: "Tu",
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        });
    })
</script>