<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Yêu cầu rút hoa hồng</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Số dư hiện tại: <span class="color_red">{user_money} đ</span></label>
                </div>
                <div class="form_group">
                    <label for="">Số hoa hồng</label>
                    <input type="text" class="form_control price_format" name="so_tien" value="" placeholder="Nhập số hoa hồng cần rút...">
                </div>
                <div class="form_group">
                    <label for="">Chủ tài khoản</label>
                    <input type="text" class="form_control" name="chu_khoan" value="" placeholder="Nhập tên chủ tài khoản ngân hàng...">
                </div>
                <div class="form_group">
                    <label for="">Số tài khoản</label>
                    <input type="text" class="form_control" name="so_taikhoan" value="" placeholder="Nhập số tài khoản ngân hàng...">
                </div>
                <div class="form_group">
                    <label for="">Ngân hàng</label>
                    <input type="text" class="form_control" name="ngan_hang" value="" placeholder="Nhập tên ngân hàng...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_ruttien" class="button_all"> Gửi yêu cầu</button>
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