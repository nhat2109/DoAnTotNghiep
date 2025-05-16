<style>
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
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Thêm voucher mới</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <!-- Nhóm 1: Thông tin cơ bản -->
                <h3>Thông tin cơ bản</h3>
                <div class="form_group">
                    <label for="">Nhập mã <span class="tooltip">ⓘ<span class="tooltiptext">Mã voucher, tối đa 5 ký tự, không dấu</span></span></label>
                    <input type="text" class="form_control" name="ma" value="" placeholder="Viết liền, không dấu, tối đa 5 ký tự..." maxlength="5" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')">
                </div>
                <div class="form_group">
                    <label for="">Kiểu khuyến mại</label>
                    <select class="form_control" name="loai">
                        <option value="tru">Trừ theo giá trị (đ)</option>
                        <option value="phantram">Trừ theo phần trăm (%)</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Khuyến mại</label>
                    <input type="text" class="form_control price_format" name="giam" value="" placeholder="Nhập giá trị khuyến mại...">
                </div>

                <!-- Nhóm 2: Điều kiện áp dụng -->
                <h3>Điều kiện áp dụng</h3>
                <div class="form_group">
                    <label for="">Kiểu áp dụng</label>
                    <select class="form_control" name="apdung">
                        <option value="all">Toàn bộ sản phẩm</option>
                        <option value="sanpham">Sản phẩm được chọn</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Giá trị đơn hàng tối thiểu (đ)</label>
                    <input type="text" class="form_control price_format" name="min_price" value="" placeholder="Nhập giá trị tối thiểu...">
                </div>
                <div class="form_group">
                    <label for="">Giá trị đơn hàng tối đa (đ)</label>
                    <input type="text" class="form_control price_format" name="max_price" value="" placeholder="Nhập giá trị tối đa...">
                </div>

                <!-- Nhóm 3: Giới hạn sử dụng -->
                <h3>Giới hạn sử dụng</h3>
                <div class="form_group" style="display: none;">
                    <label for="">Cho phép kết hợp với voucher khác</label>
                    <input type="checkbox" name="allow_combination" value="1">
                </div>
                <div class="form_group">
                    <label for="max_uses_per_user" for="">Giới hạn lượt sử dụng/tài khoản</label>
                    <input type="text" class="form_control number_format" name="max_uses_per_user" value="" placeholder="Nhập số lượt...">
                </div>
                <div class="form_group">
                    <label for="">Giới hạn tổng lượt sử dụng</label>
                    <input type="text" class="form_control number_format" name="max_global_uses" value="" placeholder="Nhập số lượt...">
                </div>

                <!-- Nhóm 4: Thời gian áp dụng -->
                <h3>Thời gian áp dụng</h3>
                <div class="form_group">
                    <div class="col_50">
                        <label for="">Giờ áp dụng</label>
                        <input type="text" class="form_control timepicker" name="time_start" value="" placeholder="Nhập giờ áp dụng...">
                    </div>
                    <div class="col_50">
                        <label for="">Ngày áp dụng</label>
                        <input type="text" class="form_control datepicker" name="date_start" value="" placeholder="Nhập ngày áp dụng...">
                    </div>
                    <div class="col_50">
                        <label for="">Giờ hết hạn</label>
                        <input type="text" class="form_control timepicker" name="time_expired" value="" placeholder="Nhập giờ hết hạn...">
                    </div>
                    <div class="col_50">
                        <label for="">Ngày hết hạn</label>
                        <input type="text" class="form_control datepicker" name="date_expired" value="" placeholder="Nhập ngày hết hạn...">
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>

            <!-- Phần chọn sản phẩm -->
            <div class="box_deal_step" id="box_sanpham" style="margin-bottom: 10px; display: none;">
                <div class="content_step">
                    <div class="title_step">Sản phẩm áp dụng</div>
                    <div class="tr_step"><button class="select_product">Chọn sản phẩm</button></div>
                    <div class="tr_step">
                        <div id="list_product_main"></div>
                    </div>
                </div>
            </div>

            <div style="clear: both;"></div>
            <div class="form_group">
                <button name="add_coupon" class="button_all">Thêm coupon</button>
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
        function generateCouponCode() {
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let random = '';
            for (let i = 0; i < 3; i++) {
                random += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return `${random}${day}`;
        }

        $('input[name=ma]').val(generateCouponCode());
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
    });
    document.getElementById('ma').addEventListener('input', function(e) {
        let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        e.target.value = value.slice(0, 5);
    });
    $('.number_format').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
   
</script>

