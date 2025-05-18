<div class="box_show_update_content" style="width: 385px;">
    <div class="content">
        <div class="box_title">Cập nhật thông tin <span><i class="fa fa-close"></i></span></div>
        <div class="form_update">
            <div class="li_input">
                <label>Họ và tên</label>
                <input type="text" name="name" value="{name}" placeholder="Họ và tên">
            </div>
            <div class="li_input">
                <label>Email</label>
                <input type="text" name="email" value="{email}" placeholder="Email tài khoản">
            </div>
            <div class="li_input">
                <label>Giới tính</label>
                <select name="gioi_tinh">
                    <option value="">Chọn giới tính</option>
                    <option value="nam">Nam</option>
                    <option value="nu">Nữ</option>
                    <option value="khac">Khác</option>
                </select>
            </div>
            <div class="li_input">
                <label>Ngày sinh</label>
                <input type="text" class="datepicker" name="ngay_sinh" value="{ngay_sinh}" placeholder="Ngày sinh">
            </div>
            <div class="li_input">
                <button type="button" class="button_login" name="update_profile">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        $('.box_show_update_content select[name=gioi_tinh]').val('{gioi_tinh}');
        $(".datepicker" ).datepicker({dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true,yearRange: "-50:+0"});
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
    });
</script>