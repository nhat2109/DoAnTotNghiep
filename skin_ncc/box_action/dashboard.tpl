<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 10px;">
            <div class="box_list_donhang">
                <div class="box_list_left">
                    <div class="title">Đơn hàng trên Sóc Đỏ</div>
                    <div class="list_donhang scroll">
                        {list_donhang}
                    </div>
                </div>
                <div class="box_list_right">
                    <div class="title">Đơn hàng trên shop</div>
                    <div class="list_donhang scroll">
                        {list_donhang_cuaban}
                    </div>
                </div>
            </div>
            <div class="box_time">
                <h2>Thống kê đơn hàng của bạn</h2>
                <div class="list_time">
                    <div class="li_time">
                        <label>Thời gian bắt đầu</label>
                        <input type="text" class="datepicker" value="{begin}" name="begin"
                            placeholder="Chọn thời gian bắt đầu">
                    </div>
                    <div class="li_time">
                        <label>Thời gian kết thúc</label>
                        <input type="text" class="datepicker" value="{end}" name="end"
                            placeholder="Chọn thời gian kết thúc">
                    </div>
                    <div class="li_time">
                        <button name="button_doanhthu_cuaban">Áp dụng</button>
                    </div>
                </div>
            </div>
            <div class="box_result">
                <div class="title_thongke"><i class="icon icon-file-stats2"></i> THỐNG KÊ ĐƠN HÀNG SÓC ĐỎ</div>
                <div class="li_box">
                    <h3 class="color_green">Đơn hàng hoàn thành</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_hoanthanh_socdo">{doanhthu_hoanthanh_socdo} đ</div>
                            <div class="text_donhang" id="donhang_hoanthanh_socdo"> với {donhang_hoanthanh_socdo} đơn
                                hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_green"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_brown">Đơn hàng chờ xử lý</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_cho_socdo">{doanhthu_cho_socdo} đ</div>
                            <div class="text_donhang" id="donhang_cho_socdo"> với {donhang_cho_socdo} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_brown"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_violet">Đơn hàng đã tiếp nhận</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_tiepnhan_socdo">{doanhthu_tiepnhan_socdo} đ</div>
                            <div class="text_donhang" id="donhang_tiepnhan_socdo"> với {donhang_tiepnhan_socdo} đơn hàng
                            </div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_violet"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_orange">Đơn hàng đang giao</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_giao_socdo">{doanhthu_giao_socdo} đ</div>
                            <div class="text_donhang" id="donhang_giao_socdo"> với {donhang_giao_socdo} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_red">Đơn hàng hủy</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_huy_socdo">{doanhthu_huy_socdo} đ</div>
                            <div class="text_donhang" id="donhang_huy_socdo"> với {donhang_huy_socdo} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_red"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_blue">Đơn hàng hoàn trả</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_hoan_socdo">{doanhthu_hoan_socdo} đ</div>
                            <div class="text_donhang" id="donhang_hoan_socdo">với {donhang_hoan_socdo} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_blue"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title_thongke"><i class="icon icon-file-stats2"></i> THỐNG KÊ ĐƠN HÀNG SÀN</div>
                <div class="li_box">
                    <h3 class="color_green">Đơn hàng hoàn thành</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_hoanthanh">{doanhthu_hoanthanh} đ</div>
                            <div class="text_donhang" id="donhang_hoanthanh"> với {donhang_hoanthanh} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_green"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_brown">Đơn hàng chờ xử lý</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_cho">{doanhthu_cho} đ</div>
                            <div class="text_donhang" id="donhang_cho"> với {donhang_cho} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_brown"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_violet">Đơn hàng đã tiếp nhận</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_tiepnhan">{doanhthu_tiepnhan} đ</div>
                            <div class="text_donhang" id="donhang_tiepnhan"> với {donhang_tiepnhan} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_violet"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_orange">Đơn hàng đang giao</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_giao">{doanhthu_giao} đ</div>
                            <div class="text_donhang" id="donhang_giao"> với {donhang_giao} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_red">Đơn hàng hủy</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_huy">{doanhthu_huy} đ</div>
                            <div class="text_donhang" id="donhang_huy"> với {donhang_huy} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_red"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <h3 class="color_blue">Đơn hàng hoàn trả</h3>
                    <div class="li_box_content">
                        <div class="li_box_left">
                            <div class="text_doanhthu" id="doanhthu_hoan">{doanhthu_hoan} đ</div>
                            <div class="text_donhang" id="donhang_hoan">với {donhang_hoan} đơn hàng</div>
                        </div>
                        <div class="li_box_right">
                            <div class="li_box_right_content">
                                <i class="fa fa-dollar bg_blue"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="/js/process_ncc.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Đảm bảo chỉ bind event một lần
        $('body').off('click', '#sudung_sodu').on('click', '#sudung_sodu', function() {
            console.log("Click sudung_sodu detected"); // Debug log
            
            // Hiển thị modal xác nhận
            $('.box_confirm').css({
                'display': 'flex',
                'z-index': '10000',
                'position': 'fixed',
                'top': '0',
                'left': '0', 
                'width': '100%',
                'height': '100%',
                'background-color': 'rgba(0, 0, 0, 0.5)',
                'justify-content': 'center',
                'align-items': 'center'
            });
    
            // Xử lý nút xác nhận
            $('#confirm_yes').off('click').on('click', function() {
                $('.box_confirm').hide();
                $('.box_xuly').html('<i class="fa fa-refresh fa-spin"></i> Hệ thống đang xử lý...');
    
                // Call API
                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    data: {
                        action: 'sudung_sodu'
                    },
                    success: function(response) {
                        console.log("API Response:", response); // Debug log
                        
                        try {
                            const info = JSON.parse(response);
                            setTimeout(function() {
                                switch(info.ok) {
                                    case 1:
                                        $('.box_xuly').html(info.thongbao);
                                        setTimeout(() => location.reload(), 2000);
                                        break;
                                    case 0:
                                        $('.box_xuly').html(info.step2);
                                        break; 
                                    default:
                                        $('.box_xuly').html('Có lỗi không xác định');
                                }
                            }, 1000);
                        } catch(e) {
                            console.error("Parse error:", e); // Debug log
                            $('.box_xuly').html('Lỗi xử lý dữ liệu');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Ajax error:", error); // Debug log
                        $('.box_xuly').html('Lỗi kết nối máy chủ');
                    }
                });
            });
    
            // Xử lý nút hủy
            $('#confirm_no').off('click').on('click', function() {
                $('.box_confirm').fadeOut(300);
            });
        });
    });
    </script> -->