<style>
    .form_container { display: flex; gap: 20px; }
    .form_column { flex: 1; }
    .form_group { margin-bottom: 15px; }
    h3 { margin: 20px 0 10px; color: #333; font-size: 16px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
    .tooltip { position: relative; display: inline-block; cursor: pointer; margin-left: 5px; }
    .tooltip .tooltiptext { 
        visibility: hidden; width: 200px; background-color: #555; color: #fff; 
        text-align: center; border-radius: 5px; padding: 5px; position: absolute; 
        z-index: 1; bottom: 125%; left: 50%; margin-left: -100px; opacity: 0; 
        transition: opacity 0.3s; font-size: 12px; 
    }
    .tooltip:hover .tooltiptext { visibility: visible; opacity: 1; }
    .time_grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .time_grid label { margin-bottom: 5px; display: block; }
    .time_grid input { width: 100%; box-sizing: border-box; }
</style>

<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Sửa mã voucher</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="form_container">
                <div class="form_column">
                    <!-- Nhóm 1: Thông tin cơ bản -->
                    <h3>Thông tin cơ bản</h3>
                    <div class="form_group">
                        <label for="ma">Mã voucher <span class="tooltip">ⓘ<span class="tooltiptext">Mã voucher không thể chỉnh sửa</span></span></label>
                        <input type="text" class="form_control" name="ma" id="ma" value="{ma}" readonly disabled>
                    </div>
                    <div class="form_group">
                        <label for="loai">Kiểu khuyến mại</label>
                        <select class="form_control" name="loai">
                            <option value="tru">Trừ theo giá trị (đ)</option>
                            <option value="phantram">Trừ theo phần trăm (%)</option>
                        </select>
                    </div>
                    <div class="form_group">
                        <label for="giam">Khuyến mại</label>
                        <input type="text" class="form_control price_format" name="giam" value="{giam}" placeholder="Nhập giá trị khuyến mại...">
                    </div>

                    <!-- Nhóm 3: Giới hạn sử dụng -->
                    <h3>Giới hạn sử dụng</h3>
                    <div class="form_group" style="display: none;">
                        <label for="allow_combination">Cho phép kết hợp với voucher khác</label>
                        <input type="checkbox" name="allow_combination" value="1" {allow_combination_checked}>
                    </div>
                    <div class="form_group">
                        <label for="max_uses_per_user">Giới hạn lượt sử dụng/tài khoản</label>
                        <input type="text" class="form_control number_format" name="max_uses_per_user" value="{max_uses_per_user}" placeholder="Nhập số lượt...">
                    </div>
                    <div class="form_group">
                        <label for="max_global_uses">Giới hạn tổng lượt sử dụng</label>
                        <input type="text" class="form_control number_format" name="max_global_uses" value="{max_global_uses}" placeholder="Nhập số lượt...">
                    </div>
                </div>
                <div class="form_column">
                    <!-- Nhóm 2: Điều kiện áp dụng -->
                    <h3>Điều kiện áp dụng</h3>
                    <div class="form_group">
                        <label for="apdung">Kiểu áp dụng</label>
                        <select class="form_control" name="apdung">
                            <option value="all">Toàn bộ sản phẩm</option>
                            <option value="sanpham">Sản phẩm được chọn</option>
                        </select>
                    </div>
                    <div class="form_group">
                        <label for="min_price">Giá trị đơn hàng tối thiểu (đ)</label>
                        <input type="text" class="form_control price_format" name="min_price" value="{min_price}" placeholder="Nhập giá trị tối đa...">
                    </div>
                    <div class="form_group">
                        <label for="max_price">Giá trị đơn hàng tối đa (đ)</label>
                        <input type="text" class="form_control price_format" name="max_price" value="{max_price}" placeholder="Nhập giá trị tối đa...">
                    </div>

                    <!-- Nhóm 4: Thời gian áp dụng -->
                    <h3>Thời gian áp dụng</h3>
                    <div class="form_group">
                        <div class="time_grid">
                            <div>
                                <label for="time_start">Giờ áp dụng</label>
                                <input type="text" class="form_control timepicker" name="time_start" value="{time_start}" placeholder="Nhập giờ áp dụng...">
                            </div>
                            <div>
                                <label for="date_start">Ngày áp dụng</label>
                                <input type="text" class="form_control datepicker" name="date_start" value="{date_start}" placeholder="Nhập ngày áp dụng...">
                            </div>
                            <div>
                                <label for="time_expired">Giờ hết hạn</label>
                                <input type="text" class="form_control timepicker" name="time_expired" value="{time_expired}" placeholder="Nhập giờ hết hạn...">
                            </div>
                            <div>
                                <label for="date_expired">Ngày hết hạn</label>
                                <input type="text" class="form_control datepicker" name="date_expired" value="{date_expired}" placeholder="Nhập ngày hết hạn...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần chọn sản phẩm -->
            <div class="box_deal_step" id="box_sanpham" style="margin-bottom: 10px;{display}">
                <div class="content_step">
                    <div class="title_step">Sản phẩm áp dụng</div>
                    <div class="tr_step"><button class="select_product">Chọn sản phẩm</button></div>
                    <div class="tr_step">
                        <div id="list_product_main">{list_sanpham}</div>
                    </div>
                </div>
            </div>

            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_coupon" class="button_all">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/skin_ncc/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Set initial select values
        $('select[name=loai]').val('{loai}');
        $('select[name=apdung]').val('{kieu}');

        // Initialize datepicker and timepicker
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });
        $('input.timepicker').timepicker({
            'timeFormat': 'H:i:s',
            'step': 5
        });
        $.datepicker.setDefaults({
            closeText: "Đóng",
            prevText: "<Trước",
            nextText: "Tiếp>",
            currentText: "Hôm nay",
            monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"],
            monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
            dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
            dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            weekHeader: "Tu",
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        });

        // Number format validation
        $('.number_format').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>