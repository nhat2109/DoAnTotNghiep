<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
        <div class="box_time">
            <h2>Chọn khoảng thời gian</h2>
            <div class="list_time">
                <div class="li_time">
                    <label>Thời gian bắt đầu</label>
                    <input type="text" class="datepicker" value="{begin}" name="begin" placeholder="Chọn thời gian bắt đầu">
                </div>
                <div class="li_time">
                    <label>Thời gian kết thúc</label>
                    <input type="text" class="datepicker" value="{end}" name="end" placeholder="Chọn thời gian kết thúc">       
                </div>
                <div class="li_time">
                    <button name="button_hoahong">Áp dụng</button>
                </div>
            </div>
        </div>
        <div class="box_result">
            <div class="li_box">
                <h3 class="color_green">Thưởng nâng cấp "Nhà bán chuyên nghiệp"</h3>
                <a href="/ncc/list-thunhap-nhom?loai=nhaban-chuyennghiep&page=1">
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="hoahong_nangcap">{doanhthu_nangcap} đ</div>
                            <div class="text_donhang" id="donhang_nangcap"> với {donhang_nangcap} nhà bán</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_green"></i>
                            </div>
                        </div>                    
                    </div>
                </a>
            </div>
            <div class="li_box">
                <h3 class="color_brown">Thưởng doanh thu nhóm quản lý</h3>
                <a href="/ncc/list-thunhap-nhom?loai=doanhthu-nhom&page=1">
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="hoahong_nhom">{doanhthu_nhom} đ</div>
                            <div class="text_donhang" id="donhang_nhom"> với {donhang_nhom} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_brown"></i>
                            </div>
                        </div>                    
                    </div>
                </a>
            </div>
            <div class="li_box">
                <h3 class="color_violet">Thưởng doanh thu nhóm "Nhà bán chuyên nghiệp"</h3>
                <a href="/ncc/list-thunhap-nhom?loai=thunhap-nhaban&page=1">
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_nhom_gioithieu">{doanhthu_nhom_gioithieu} đ</div>
                            <div class="text_donhang" id="donhang_nhom_gioithieu"> với {donhang_nhom_gioithieu} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_violet"></i>
                            </div>
                        </div>                    
                    </div>
                </a>
            </div>
            <div class="li_box">
                <h3 class="color_red">TỔNG</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_tong">{doanhthu_tong} đ</div>
                        <div class="text_donhang" id="donhang_tong"> với <span class="donhang_tong">{donhang_tong}</span> đơn hàng và <span class="donhang_nangcap">{donhang_nangcap}</span> nhà bán nâng cấp</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar bg_red"></i>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <p style="text-align: center;font-style: italic;">Lưu ý: Số đơn hàng và hoa hồng được tính với những <b>đơn hàng hoàn thành</b></p>
  	</div>
  </div>
</div>
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