<div class="box_show_update_content" style="width: 650px;">
    <div class="content">
        <div class="box_title">Cập nhật địa chỉ <span><i class="fa fa-close"></i></span></div>
        <div class="form_update">
            <div class="li_input">
                <label>Họ và tên</label>
                <input type="text" name="ho_ten" value="{ho_ten}" placeholder="Họ và tên">
            </div>
            <div class="li_group_input col_2">
                <div class="li_input">
                    <label>Điện thoại</label>
                    <input type="text" name="dien_thoai" value="{dien_thoai}" placeholder="Điện thoại">
                </div>
                <div class="li_input">
                    <label>Email</label>
                    <input type="text" name="email" value="{email}" placeholder="Địa chỉ email">
                </div>
            </div>
            <div class="li_group_input col_3">
                <div class="li_input">
                    <label>Tỉnh/TP</label>
                    <select name="tinh" class="load_huyen">
                        <option value="">Chọn tỉnh</option>
                        {option_tinh}
                    </select>
                </div>
                <div class="li_input">
                    <label>Quận/Huyện</label>
                    <select name="huyen" class="load_xa">
                        <option value="">Chọn huyện</option>
                        {option_huyen}
                    </select>
                </div>
                <div class="li_input">
                    <label>Xã/Phường</label>
                    <select name="xa">
                        <option value="">Chọn xã</option>
                        {option_xa}
                    </select>
                </div>
            </div>
            <div class="li_input">
                <label>Địa chỉ</label>
                <input type="text" name="dia_chi" value="{dia_chi}" placeholder="Địa chỉ">
            </div>
            <div class="li_input">
                <label>Đặt làm mặc định</label>
                <select name="active">
                    <option value="0">Không</option>
                    <option value="1">Có</option>
                </select>
            </div>
            <div class="li_input">
                <input type="hidden" name="id" value="{id}">
                <button type="button" class="button_login" name="update_diachi">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        $('.box_show_update_content select[name=active]').val('{active}');
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