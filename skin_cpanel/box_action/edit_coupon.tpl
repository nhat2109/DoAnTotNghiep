<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Sửa mã coupon</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Nhập mã</label>
                    <input type="text" class="form_control" name="ma" value="{ma}" placeholder="Viết liền không dấu...">
                </div>
                <div class="form_group">
                    <label for="">Kiểu khuyến mại</label>
                    <select class="form_control" name="loai">
                        <option value="tru">Trừ theo giá trị (đ)</option>
                        <option value="phantram">Trừ theo phầm Trăm (%)</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Khuyến mại</label>
                    <input type="text" class="form_control price_format" name="giam" value="{giam}" placeholder="Nhập giá trị khuyến mại...">
                </div>
                <div class="form_group">
                    <label for="">Điều kiện</label>
                    <input type="text" class="form_control price_format" name="dieu_kien" value="{dieu_kien}" placeholder="Nhập giá trị đơn hàng áp dụng...">
                </div>
                <div class="form_group">
                    <label for="">Kiểu áp dụng</label>
                    <select class="form_control" name="apdung">
                        <option value="all">Toàn bộ sản phẩm</option>
                        <option value="sanpham">Sản phẩm được chọn</option>
                    </select>
                </div>
                <div style="clear: both;"></div>
                <div class="form_group">
                    <div class="col_50">
                        <label for="">Giờ áp dụng</label>
                        <input type="text" class="form_control timepicker" name="time_start" value="{time_start}" placeholder="Nhập giờ áp dụng...">
                    </div>
                    <div class="col_50">
                        <label for="">Ngày áp dụng</label>
                        <input type="text" class="form_control datepicker" name="date_start" value="{date_start}" placeholder="Nhập ngày áp dụng...">
                    </div>
                    <div class="col_50">
                        <label for="">Giờ hết hạn</label>
                        <input type="text" class="form_control timepicker" name="time_expired" value="{time_expired}" placeholder="Nhập giờ hết hạn...">
                    </div>
                    <div class="col_50">
                        <label for="">Ngày hết hạn</label>
                        <input type="text" class="form_control datepicker" name="date_expired" value="{date_expired}" placeholder="Nhập ngày hết hạn...">
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
            <div class="box_deal_step" id="box_sanpham" style="margin-bottom: 10px;{display}">
                <div class="content_step">
                    <div class="title_step">Sản phẩm</div>
                    <div class="tr_step"><button class="select_product">Chọn sản phẩm</button></div>
                    <div class="tr_step">
                        <div id="list_product_main">{list_sanpham}</div>
                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_coupon" class="button_all"> Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name=loai]').val('{loai}');
        $('select[name=apdung]').val('{kieu}');
        $(".datepicker" ).datepicker({dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $('input.timepicker').timepicker({'timeFormat': 'H:i:s','step': 5});
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
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_marketing'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>