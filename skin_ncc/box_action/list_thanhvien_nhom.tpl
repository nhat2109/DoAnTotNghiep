<!-- Thêm thư viện Chart.js -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<div class="page_body">
	<div class="box_right box_right_mobile">
		<div class="container">
			<div class="header">
				<div class="tab active" data-target="box_tien_nhom">Doanh Thu</div>
				<div class="tab" data-target="box_donhang_xuly">Đơn Hàng Xử Lý</div>
				<div class="tab" data-target="box_theongay_thang">
					Đơn Hàng Theo Ngày/Tháng
				</div>
			</div>
			<!-- Box Doanh Thu -->
			<!-- <div class="box_content box_tien_nhom active">
				<div class="box_right_content">
					<div class="box_profile" style="width: 100%;padding: 10px;">
						<div class="box_time">
							<h2>Chọn khoảng thời gian</h2>
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
											<div class="text_donhang" id="donhang_nangcap"> với {donhang_nangcap} nhà
												bán</div>
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
											<div class="text_donhang" id="donhang_nhom"> với {donhang_nhom} đơn hàng
											</div>
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
											<div class="text_doanhthu" id="doanhthu_nhom_gioithieu">
												{doanhthu_nhom_gioithieu} đ</div>
											<div class="text_donhang" id="donhang_nhom_gioithieu"> với
												{donhang_nhom_gioithieu} đơn hàng</div>
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
										<div class="text_donhang" id="donhang_tong"> với <span
												class="donhang_tong">{donhang_tong}</span> đơn hàng và <span
												class="donhang_nangcap">{donhang_nangcap}</span> nhà bán nâng cấp</div>
									</div>
									<div class="li_box_right">
										<div class="li_box_right_content">
											<i class="fa fa-dollar bg_red"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<p style="text-align: center;font-style: italic;">Lưu ý: Số đơn hàng và hoa hồng được tính với
							những <b>đơn hàng hoàn thành</b></p>
					</div>
				</div>
			</div>
			 -->

			<div class="box_content box_tien_nhom active">
				<div class="box_right_content">
					<div class="box_profile" style="width: 100%; padding: 10px">
						<div class="box_time">
							<h2>Chọn khoảng thời gian</h2>
							<div class="list_time">
								<div class="li_time">
									<label>Thời gian bắt đầu</label>
									<input type="text" class="datepicker" value="{begin}" name="begin"
										placeholder="Chọn thời gian bắt đầu" />
								</div>
								<div class="li_time">
									<label>Thời gian kết thúc</label>
									<input type="text" class="datepicker" value="{end}" name="end"
										placeholder="Chọn thời gian kết thúc" />
								</div>
								<div class="li_time">
									<button name="button_hoahong">Áp dụng</button>
								</div>
							</div>
						</div>
						<div class="box_result">
							<div class="li_box">
								<h3 class="color_green">Biểu đồ doanh thu</h3>
								<canvas id="doanhthuChart" width="400" height="200"></canvas>
							</div>

							<div class="li_box">
								<h3 class="color_brown">Biểu đồ đơn hàng</h3>
								<canvas id="donhangChart" width="400" height="200"></canvas>
							</div>
							<div class="li_box" style="
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    max-width: 380px;
    margin: auto;
">
    <h3 class="color_red" style="
        color: #e74c3c;
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
    ">TỔNG</h3>

    <!-- Căn giữa số tiền -->
    <div class="text_doanhthu" id="doanhthu_tong" style="
        font-size: 32px;
        font-weight: bold;
        color: #2c3e50;
        background: #f8f9fa;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 10px;
        display: inline-block;
    ">
        {doanhthu_tong} đ
    </div>

    <div class="text_donhang" id="donhang_tong" style="
        font-size: 16px;
        color: #7f8c8d;
        margin-top: 6px;
        line-height: 1.4;
    ">
        với <span class="donhang_tong" style="
            font-weight: bold;
            color: #3498db;
        ">{donhang_tong}</span> đơn hàng và
        <span class="donhang_nangcap" style="
            font-weight: bold;
            color: #2ecc71;
        ">{donhang_nangcap}</span> nhà bán nâng cấp
    </div>

    <p style="
        text-align: center;
        font-style: italic;
        font-size: 14px;
        color: #7f8c8d;
        margin-top: 12px;
    ">Lưu ý: Số đơn hàng và hoa hồng được tính với những
        <b>đơn hàng hoàn thành</b>
    </p>
</div>


						</div>
					</div>
				</div>
			</div>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
			<link rel="stylesheet" href="/skin/css/jquery.timepicker.css" />
			<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
			<script src="/js/jquery.timepicker.js"></script>
			<script type="text/javascript">
				$(document).ready(function () {
					$(".datepicker").datepicker({
						dateFormat: "dd/mm/yy",
						changeMonth: true,
						changeYear: true,
					});
					$("input.timepicker").timepicker({ timeFormat: "H:i:s", step: 5 });
					$.datepicker.setDefaults({
						closeText: "Đóng",
						prevText: "&#x3C;Trước",
						nextText: "Tiếp&#x3E;",
						currentText: "Hôm nay",
						monthNames: [
							"Tháng Một",
							"Tháng Hai",
							"Tháng Ba",
							"Tháng Tư",
							"Tháng Năm",
							"Tháng Sáu",
							"Tháng Bảy",
							"Tháng Tám",
							"Tháng Chín",
							"Tháng Mười",
							"Tháng Mười Một",
							"Tháng Mười Hai",
						],
						monthNamesShort: [
							"Tháng 1",
							"Tháng 2",
							"Tháng 3",
							"Tháng 4",
							"Tháng 5",
							"Tháng 6",
							"Tháng 7",
							"Tháng 8",
							"Tháng 9",
							"Tháng 10",
							"Tháng 11",
							"Tháng 12",
						],
						dayNames: [
							"Chủ Nhật",
							"Thứ Hai",
							"Thứ Ba",
							"Thứ Tư",
							"Thứ Năm",
							"Thứ Sáu",
							"Thứ Bảy",
						],
						dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
						dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
						weekHeader: "Tu",
						firstDay: 0,
						isRTL: false,
						showMonthAfterYear: false,
						yearSuffix: "",
					});
				});
			</script>

			<!-- Box Đơn Hàng Xử Lý -->
			<div class="box_content box_donhang_xuly">
				<div class="box_right_content">
					<div class="box_profile" style="width: 100%; padding: 10px">
						<div class="box_time">
							<h2>Chọn khoảng thời gian</h2>
							<div class="list_time">
								<div class="li_time">
									<label>Thời gian bắt đầu</label>
									<input type="text" class="datepicker" value="{begin}" name="begin"
										placeholder="Chọn thời gian bắt đầu" />
								</div>
								<div class="li_time">
									<label>Thời gian kết thúc</label>
									<input type="text" class="datepicker" value="{end}" name="end"
										placeholder="Chọn thời gian kết thúc" />
								</div>
								<div class="li_time">
									<button name="button_doanhthu">Áp dụng</button>
								</div>
							</div>
						</div>
						<div class="box_result">
							<div class="li_box">
								<h3 class="color_green">Đơn hàng hoàn thành</h3>
								<a href="/ncc/list-donhang-nhom?loai=drop&status=dagiao&page=1">
									<div class="li_box_content">
										<div class="li_box_left">
											<div class="text_doanhthu" id="doanhthu_hoanthanh">
												{doanhthu_hoanthanh} đ
											</div>
											<div class="text_donhang" id="donhang_hoanthanh">
												với <b>{donhang_hoanthanh} đơn hàng</b>
											</div>
										</div>
										<div class="li_box_right">
											<div class="li_box_right_content">
												<i class="fa fa-dollar bg_green"></i>
											</div>
										</div>
										<div class="li_box_bottom">
											<div class="text_donhang" id="donhang_hoanthanh_san">
												<i class="fa fa-dot-circle-o"></i> Đơn sàn TMĐT:
												<b>{doanhthu_hoanthanh_san} đ</b> với
												<span>{donhang_hoanthanh_san}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_hoanthanh_socdo">
												<i class="fa fa-dot-circle-o"></i> Đơn SOCDO.VN:
												<b>{doanhthu_hoanthanh_socdo} đ</b> với
												<span>{donhang_hoanthanh_socdo}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_hoanthanh_aff">
												<i class="fa fa-dot-circle-o"></i> Đơn Affiliate:
												<b>{doanhthu_hoanthanh_aff} đ</b> với
												<span>{donhang_hoanthanh_aff}</span> đơn hàng
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="li_box">
								<h3 class="color_brown">Đơn hàng chờ xử lý</h3>
								<a href="/ncc/list-donhang-nhom?loai=drop&status=wait&page=1">
									<div class="li_box_content">
										<div class="li_box_left">
											<div class="text_doanhthu" id="doanhthu_cho">
												{doanhthu_cho} đ
											</div>
											<div class="text_donhang" id="donhang_cho">
												với <b>{donhang_cho} đơn hàng</b>
											</div>
										</div>
										<div class="li_box_right">
											<div class="li_box_right_content">
												<i class="fa fa-dollar bg_brown"></i>
											</div>
										</div>
										<div class="li_box_bottom">
											<div class="text_donhang" id="donhang_cho_san">
												<i class="fa fa-dot-circle-o"></i> Đơn sàn TMĐT:
												<b>{doanhthu_cho_san} đ</b> với
												<span>{donhang_cho_san}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_cho_socdo">
												<i class="fa fa-dot-circle-o"></i> Đơn SOCDO.VN:
												<b>{doanhthu_cho_socdo} đ</b> với
												<span>{donhang_cho_socdo}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_cho_aff">
												<i class="fa fa-dot-circle-o"></i> Đơn Affiliate:
												<b>{doanhthu_cho_aff} đ</b> với
												<span>{donhang_cho_aff}</span> đơn hàng
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="li_box">
								<h3 class="color_violet">Đơn hàng đã tiếp nhận</h3>
								<a href="/ncc/list-donhang-nhom?loai=drop&status=tiepnhan&page=1">
									<div class="li_box_content">
										<div class="li_box_left">
											<div class="text_doanhthu" id="doanhthu_tiepnhan">
												{doanhthu_tiepnhan} đ
											</div>
											<div class="text_donhang" id="donhang_tiepnhan">
												với <b>{donhang_tiepnhan} đơn hàng</b>
											</div>
										</div>
										<div class="li_box_right">
											<div class="li_box_right_content">
												<i class="fa fa-dollar bg_violet"></i>
											</div>
										</div>
										<div class="li_box_bottom">
											<div class="text_donhang" id="donhang_tiepnhan_san">
												<i class="fa fa-dot-circle-o"></i> Đơn sàn TMĐT:
												<b>{doanhthu_tiepnhan_san} đ</b> với
												<span>{donhang_tiepnhan_san}</span>
												đơn hàng
											</div>
											<div class="text_donhang" id="donhang_tiepnhan_socdo">
												<i class="fa fa-dot-circle-o"></i> Đơn SOCDO.VN:
												<b>{doanhthu_tiepnhan_socdo} đ</b> với
												<span>{donhang_tiepnhan_socdo}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_tiepnhan_aff">
												<i class="fa fa-dot-circle-o"></i> Đơn Affiliate:
												<b>{doanhthu_tiepnhan_aff} đ</b> với
												<span>{donhang_tiepnhan_aff}</span>
												đơn hàng
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="li_box">
								<h3 class="color_orange">Đơn hàng đang giao</h3>
								<a href="/ncc/list-donhang-nhom?loai=drop&status=vanchuyen&page=1">
									<div class="li_box_content">
										<div class="li_box_left">
											<div class="text_doanhthu" id="doanhthu_giao">
												{doanhthu_giao} đ
											</div>
											<div class="text_donhang" id="donhang_giao">
												với <b>{donhang_giao} đơn hàng</b>
											</div>
										</div>
										<div class="li_box_right">
											<div class="li_box_right_content">
												<i class="fa fa-dollar"></i>
											</div>
										</div>
										<div class="li_box_bottom">
											<div class="text_donhang" id="donhang_giao_san">
												<i class="fa fa-dot-circle-o"></i> Đơn sàn TMĐT:
												<b>{doanhthu_giao_san} đ</b> với
												<span>{donhang_giao_san}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_giao_socdo">
												<i class="fa fa-dot-circle-o"></i> Đơn SOCDO.VN:
												<b>{doanhthu_giao_socdo} đ</b> với
												<span>{donhang_giao_socdo}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_giao_aff">
												<i class="fa fa-dot-circle-o"></i> Đơn Affiliate:
												<b>{doanhthu_giao_aff} đ</b> với
												<span>{donhang_giao_aff}</span> đơn hàng
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="li_box">
								<h3 class="color_red">Đơn hàng hủy</h3>
								<a href="/ncc/list-donhang-nhom?loai=drop&status=huy&page=1">
									<div class="li_box_content">
										<div class="li_box_left">
											<div class="text_doanhthu" id="doanhthu_huy">
												{doanhthu_huy} đ
											</div>
											<div class="text_donhang" id="donhang_huy">
												với <b>{donhang_huy} đơn hàng</b>
											</div>
										</div>
										<div class="li_box_right">
											<div class="li_box_right_content">
												<i class="fa fa-dollar bg_red"></i>
											</div>
										</div>
										<div class="li_box_bottom">
											<div class="text_donhang" id="donhang_huy_san">
												<i class="fa fa-dot-circle-o"></i> Đơn sàn TMĐT:
												<b>{doanhthu_huy_san} đ</b> với
												<span>{donhang_huy_san}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_huy_socdo">
												<i class="fa fa-dot-circle-o"></i> Đơn SOCDO.VN:
												<b>{doanhthu_huy_socdo} đ</b> với
												<span>{donhang_huy_socdo}</span> đơn hàng
											</div>
											<div class="text_donhang" id="donhang_huy_aff">
												<i class="fa fa-dot-circle-o"></i> Đơn Affiliate:
												<b>{doanhthu_huy_aff} đ</b> với
												<span>{donhang_huy_aff}</span> đơn hàng
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="li_box">
								<h3 class="color_blue">Đơn hàng hoàn trả</h3>
								<a href="/ncc/list-donhang-nhom?loai=drop&status=hoan&page=1">
									<div class="li_box_content">
										<div class="li_box_left">
											<div class="text_doanhthu" id="doanhthu_hoan">
												{doanhthu_hoan} đ
											</div>
											<div class="text_donhang" id="donhang_hoan">
												với <b>{donhang_hoan} đơn hàng</b>
											</div>
										</div>
										<div class="li_box_right">
											<div class="li_box_right_content">
												<i class="fa fa-dollar bg_blue"></i>
											</div>
										</div>
										<div class="li_box_bottom">
											<div class="text_donhang" id="donhang_hoan_san">
												<i class="fa fa-dot-circle-o"></i> Đơn sàn TMĐT:
												<b>{doanhthu_hoan_san} đ</b> với {donhang_hoan_san} đơn
												hàng
											</div>
											<div class="text_donhang" id="donhang_hoan_socdo">
												<i class="fa fa-dot-circle-o"></i> Đơn SOCDO.VN:
												<b>{doanhthu_hoan_socdo} đ</b> với {donhang_hoan_socdo}
												đơn hàng
											</div>
											<div class="text_donhang" id="donhang_hoan_aff">
												<i class="fa fa-dot-circle-o"></i> Đơn Affiliate:
												<b>{doanhthu_hoan_aff} đ</b> với {donhang_hoan_aff} đơn
												hàng
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
			<link rel="stylesheet" href="/skin/css/jquery.timepicker.css" />
			<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
			<script src="/js/jquery.timepicker.js"></script>
			<script type="text/javascript">
				$(document).ready(function () {
					$(".datepicker").datepicker({
						dateFormat: "dd/mm/yy",
						changeMonth: true,
						changeYear: true,
					});
					$("input.timepicker").timepicker({ timeFormat: "H:i:s", step: 5 });
					$.datepicker.setDefaults({
						closeText: "Đóng",
						prevText: "&#x3C;Trước",
						nextText: "Tiếp&#x3E;",
						currentText: "Hôm nay",
						monthNames: [
							"Tháng Một",
							"Tháng Hai",
							"Tháng Ba",
							"Tháng Tư",
							"Tháng Năm",
							"Tháng Sáu",
							"Tháng Bảy",
							"Tháng Tám",
							"Tháng Chín",
							"Tháng Mười",
							"Tháng Mười Một",
							"Tháng Mười Hai",
						],
						monthNamesShort: [
							"Tháng 1",
							"Tháng 2",
							"Tháng 3",
							"Tháng 4",
							"Tháng 5",
							"Tháng 6",
							"Tháng 7",
							"Tháng 8",
							"Tháng 9",
							"Tháng 10",
							"Tháng 11",
							"Tháng 12",
						],
						dayNames: [
							"Chủ Nhật",
							"Thứ Hai",
							"Thứ Ba",
							"Thứ Tư",
							"Thứ Năm",
							"Thứ Sáu",
							"Thứ Bảy",
						],
						dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
						dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
						weekHeader: "Tu",
						firstDay: 0,
						isRTL: false,
						showMonthAfterYear: false,
						yearSuffix: "",
					});
				});
			</script>

			<div class="box_theongay_thang box_content" style="height: 1400px; width:100% !important;">
				<div class="box_right_content">
					<div class="box_profile" style="width: 100%;padding: 10px;">
						<h1>Đơn hàng của <span class="color_green">{tieu_de}</span> năm {nam}</h1>
					  <div class="chart">
						  <!-- Chart wrapper -->
						  <figure class="highcharts-figure">
							<div id="container_chart_nam"></div>
							<p class="highcharts-description"></p>
						  </figure>
					  </div>
					  <h1>Đơn hàng của <span class="color_green">{tieu_de}</span> tháng {thang}/{nam}</h1>
					  <div class="chart">
						  <figure class="highcharts-figure">
							<div id="container_chart_thang"></div>
							<p class="highcharts-description"></p>
						  </figure>
					  </div>
					  <h1>Đơn hàng của <span class="color_green">{tieu_de}</span> tuần thứ {tuan}({ngay_dau_tuan} - {ngay_cuoi_tuan})</h1>
					  <div class="chart">
						  <figure class="highcharts-figure">
							<div id="container_chart_tuan"></div>
							<p class="highcharts-description"></p>
						  </figure>
					  </div>
					</div>
				</div>
			  </div>
			  <style type="text/css">
			  #container_chart {
				  height: 400px; 
			  }
			  .highcharts-figure, .highcharts-data-table table {
				  min-width: 310px; 
				  max-width: 100%;
				  margin: 1em auto;
			  }
			  
			  .highcharts-data-table table {
				  font-family: Verdana, sans-serif;
				  border-collapse: collapse;
				  border: 1px solid #EBEBEB;
				  margin: 10px auto;
				  text-align: center;
				  width: 100%;
				  max-width: calc(100% - 20px);
			  }
			  .highcharts-data-table caption {
				  padding: 1em 0;
				  font-size: 1.2em;
				  color: #555;
			  }
			  .highcharts-data-table th {
				  font-weight: 600;
				  padding: 0.5em;
			  }
			  .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
				  padding: 0.5em;
			  }
			  .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
				  background: #f8f8f8;
			  }
			  .highcharts-data-table tr:hover {
				  background: #f1f7ff;
			  }
			  </style>
			  <script src="/js/highcharts.js"></script>
			  <script src="/js/exporting.js"></script>
			  <script src="/js/export-data.js"></script>
			  <script src="/js/accessibility.js"></script>
			  <script type="text/javascript">
			  Highcharts.chart('container_chart_nam', {
				  chart: {
					  type: 'bar'
				  },
				  title: {
					  text: ''
				  },
				  subtitle: {
					  text: ''
				  },
				  xAxis: {
					  categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
					  tickmarkPlacement: 'on',
					  title: {
						  enabled: false
					  }
				  },
				  yAxis: {
					  title: {
						  text: 'Đơn hàng',
						  enabled: false
					  },
					  labels: {
						  formatter: function () {
							  return this.value/1;
						  }
					  }
				  },
				  tooltip: {
					  split: true,
					  valueSuffix: ' đơn hàng'
				  },
				  plotOptions: {
					  area: {
						  stacking: 'normal',
						  lineColor: '#666666',
						  lineWidth: 1,
						  marker: {
							  lineWidth: 1,
							  lineColor: '#666666'
						  }
					  }
				  },
				  series: [{
					  name: 'Số đơn hàng',
					  data: [{data_nam}]
				  }]
			  });
			  Highcharts.chart('container_chart_thang', {
				  chart: {
					  type: 'column'
				  },
				  title: {
					  text: ''
				  },
				  subtitle: {
					  text: ''
				  },
				  xAxis: {
					  categories: [{list_ngay}],
					  tickmarkPlacement: 'on',
					  title: {
						  enabled: false
					  }
				  },
				  yAxis: {
					  title: {
						  text: 'Thống kê đơn hàng'
					  },
					  labels: {
						  formatter: function () {
							  return this.value/1;
						  }
					  }
				  },
				  tooltip: {
					  split: true,
					  valueSuffix: ' đơn hàng'
				  },
				  plotOptions: {
					  area: {
						  stacking: 'normal',
						  lineColor: '#666666',
						  lineWidth: 1,
						  marker: {
							  lineWidth: 1,
							  lineColor: '#666666'
						  }
					  }
				  },
				  series: [{
					  name: 'Số đơn hàng',
					  data: [{data_thang}]
				  }]
			  });
			  Highcharts.chart('container_chart_tuan', {
				  chart: {
					  type: 'column'
				  },
				  title: {
					  text: ''
				  },
				  subtitle: {
					  text: ''
				  },
				  xAxis: {
					  categories: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'],
					  tickmarkPlacement: 'on',
					  title: {
						  enabled: false
					  }
				  },
				  yAxis: {
					  title: {
						  text: 'Thống kê đơn hàng'
					  },
					  labels: {
						  formatter: function () {
							  return this.value/1;
						  }
					  }
				  },
				  tooltip: {
					  split: true,
					  valueSuffix: ' đơn hàng'
				  },
				  plotOptions: {
					  area: {
						  stacking: 'normal',
						  lineColor: '#666666',
						  lineWidth: 1,
						  marker: {
							  lineWidth: 1,
							  lineColor: '#666666'
						  }
					  }
				  },
				  series: [{
					  name: 'Số đơn hàng',
					  data: [{data_tuan}]
				  }]
			  });
			  </script>
		</div>
	</div>
</div>

<style>
	/* Style cho container chứa các tab và box */
	.page_body .box_right {
		position: relative;
		width: calc(100% - 250px);
		min-height: calc(100vh - 50px);
		top: 50px;
		bottom: 0px;
		right: 0;
		left: 0;
		background: #fff;
		margin-left: 250px;
	}

	.container {
		width: 100%;
		margin: 0 auto;
	}

	.header {
		display: flex;
		justify-content: space-around;
		background: rgb(73, 110, 230);
		cursor: pointer;
		/* Bo góc nhẹ cho header */
	}

	.header div {
		color: white;
		font-weight: bold;
		padding: 10px 20px;
		transition: background 0.3s, border-radius 0.3s;
		border-radius: 6px;
		/* Bo tròn góc nhẹ */
	}

	.header div:hover,
	.header div.active {
		background: #0056b3;
		border-radius: 10px;
		/* Khi hover, bo tròn nhiều hơn */
	}

	.box_content {
		display: none;
		padding: 20px;
		border: 1px solid #ddd;
		margin-top: 10px;
		background: #f9f9f9;
		border-radius: 8px;
		/* Bo góc nhẹ cho box content */
	}

	.box_content.active {
		display: block;
	}

	/* Style cho container chứa ô tìm kiếm và nút */
	.box_timkiem_thanhviennhom {
		margin-top: 10px;
		display: flex;
		align-items: center;
		gap: 10px;
		/* Khoảng cách giữa input và button */
		float: right;
		/* Đảm bảo phần tử nằm bên phải */
	}

	/* Style cho ô input */
	.box_timkiem_thanhviennhom input[type="text"] {
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 8px;
		/* Bo tròn các góc */
		font-size: 14px;
		outline: none;
		/* Loại bỏ viền khi focus */
		transition: border-color 0.3s, box-shadow 0.3s;
	}

	.box_timkiem_thanhviennhom input[type="text"]:focus {
		border-color: #007bff;
		/* Đổi màu viền khi focus */
		box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
		/* Hiệu ứng shadow khi focus */
	}

	/* Style cho nút tìm kiếm */
	.button_timkiem {
		pointer-events: auto !important;
		position: relative;
		z-index: 20;
		padding: 10px 20px;
		background-color: #007bff;
		color: white;
		border: none;
		border-radius: 8px;
		/* Bo tròn các góc */
		cursor: pointer;
		font-size: 14px;
		transition: background-color 0.3s, transform 0.2s;
	}

	.button_timkiem:hover {
		background-color: #0056b3;
		/* Đổi màu nền khi hover */
		transform: scale(1.05);
		/* Hiệu ứng phóng to nhẹ khi hover */
	}

	.button_timkiem:active {
		transform: scale(0.95);
		/* Hiệu ứng nhỏ lại khi nhấn */
	}

	.box_timkiem_thanhviennhom {
		pointer-events: auto;
	}

	.box_timkiem_thanhviennhom input[name="key"] {
		position: relative;
		z-index: 10;
	}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		// Lấy tất cả các tab và box
		const tabs = document.querySelectorAll(".tab");
		const boxes = document.querySelectorAll(".box_content");

		// Thêm sự kiện click cho mỗi tab
		tabs.forEach((tab) => {
			tab.addEventListener("click", function () {
				// Xóa active khỏi tất cả các tab và box
				tabs.forEach((t) => t.classList.remove("active"));
				boxes.forEach((box) => box.classList.remove("active"));

				// Kích hoạt tab được click
				tab.classList.add("active");
				// Hiển thị box tương ứng
				document
					.querySelector("." + tab.dataset.target)
					.classList.add("active");
			});
		});
	});
</script>

<div class="box_right box_right_thanhvien_mobile">
	
	<div class="box_right_content">
		<div class="box_profile" style="width: 100%; padding: 10px">
			<div class="page_title">
				<h1 class="undefined">Danh sách thành viên nhóm</h1>
				<!-- <div class="line"></div>
				<hr /> -->
				<div style="float: right" class="box_timkiem_thanhviennhom">
					<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm" />
					<button name="timkiem_thanhviennhom" nhom="{id}" class="button_timkiem">
						Tìm kiếm
					</button>
				</div>
			</div>
			<style type="text/css">
				.list_baiviet i {
					margin-right: 5px;
				}
			</style>
			<table class="list_baiviet">
				<tr>
					<th style="text-align: center; width: 50px" class="hide_mobile">
						ID
					</th>
					<th style="text-align: left">Họ và tên</th>
					<th style="text-align: left">Điện thoại</th>
					<th style="text-align: center">Vai trò</th>
					<th style="text-align: center">Tổng đơn hàng</th>
					<th style="text-align: center">Tổng doanh số</th>
					<th style="text-align: center; width: 150px">Hành động</th>
					<th style="text-align: center; width: 150px">Tình trạng</th>
				</tr>
				{list_thanhvien}
			</table>
			{phantrang}
			<p style="text-align: center; font-style: italic">
				Lưu ý: Số đơn hàng và doanh số không tính những <b>đơn hàng hủy</b> và
				<b>đơn hàng hoàn</b>
			</p>
		</div>
	</div>
</div>
<style>
    canvas {
        border: 1px solid #007BFF;
        border-radius: 8px;
    }

    #doanhthuChart {
		max-height: 400px; /* Điều chỉnh theo kích thước của biểu đồ tròn */
	}
	.drop_status input[type="radio"] {
        pointer-events: none; /* Không cho click */
        opacity: 0.6; /* Làm mờ một chút để hiển thị chỉ xem */
    }
</style>
<script>
    $(document).ready(function () {
        var doanhthuChart = null;
        var donhangChart = null;

        // Đăng ký plugin ChartDataLabels để hiển thị phần trăm
        Chart.register(ChartDataLabels);

        // Hàm xử lý lọc dữ liệu
        function applyFilter() {
            let time_begin = $("input[name=begin]").val();
            let time_end = $("input[name=end]").val();

            if (time_begin.length < 10) {
                $("input[name=begin]").focus();
            } else if (time_end.length < 10) {
                $("input[name=end]").focus();
            } else {
                $(".load_overlay").show();
                $(".load_process").fadeIn();

                var form_data = new FormData();
                form_data.append("action", "load_hoahong");
                form_data.append("time_begin", time_begin);
                form_data.append("time_end", time_end);

                $.ajax({
                    url: "/ncc/process.php",
                    type: "post",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (response) {
                        var info = JSON.parse(response);

                        setTimeout(function () {
                            $(".load_note").html(info.thongbao);
                        }, 1000);

						
                        setTimeout(function () {
                            $(".load_process").hide();
                            $(".load_note").html("Hệ thống đang xử lý");
                            $(".load_overlay").hide();
							// Chỉ xử lý nếu có dữ liệu
                            if (info.ok == 1) {
                                // Cập nhật dữ liệu lên giao diện
                                $("#hoahong_nangcap").html(info.doanhthu_nangcap);
                                $("#donhang_nangcap").html(info.donhang_nangcap);
                                $("#hoahong_nhom").html(info.doanhthu_nhom);
                                $("#donhang_nhom").html(info.donhang_nhom);
                                $("#doanhthu_nhom_gioithieu").html(info.doanhthu_nhom_gioithieu);
                                $("#donhang_nhom_gioithieu").html(info.donhang_nhom_gioithieu);
                                $("#doanhthu_tong").html(info.doanhthu_tong);
                                $("#donhang_tong").html(info.donhang_tong);

                                // Xử lý dữ liệu để vẽ biểu đồ
                                var doanhthuData = {
									labels: ['Doanh thu nâng cấp', 'Doanh thu nhóm', 'Doanh thu nhóm giới thiệu'],
									datasets: [
										{
											label: 'Doanh thu nâng cấp',
											data: [parseFloat(info.doanhthu_nangcap.replace(/[^0-9.-]+/g, "")), 0, 0],
											backgroundColor: '#4CAF50'
										},
										{
											label: 'Doanh thu nhóm',
											data: [0, parseFloat(info.doanhthu_nhom.replace(/[^0-9.-]+/g, "")), 0],
											backgroundColor: '#FFA500'
										},
										{
											label: 'Doanh thu nhóm giới thiệu',
											data: [0, 0, parseFloat(info.doanhthu_nhom_gioithieu.replace(/[^0-9.-]+/g, ""))],
											backgroundColor: '#9C27B0'
										}
									]
								};
		

                                var donhangData = {
                                    labels: ["Đơn hàng nâng cấp", "Đơn hàng nhóm", "Đơn hàng nhóm giới thiệu"],
                                    datasets: [
                                        {
                                            label: "Số lượng đơn hàng",
                                            data: [
                                                parseInt(info.donhang_nangcap.replace(/[^0-9.-]+/g, "")),
                                                parseInt(info.donhang_nhom.replace(/[^0-9.-]+/g, "")),
                                                parseInt(info.donhang_nhom_gioithieu.replace(/[^0-9.-]+/g, ""))
                                            ],
                                            backgroundColor: ["#4CAF50", "#FFA500", "#9C27B0"],
                                            borderColor: ["#388E3C", "#F57C00", "#7B1FA2"],
                                            borderWidth: 1,
											radius: "70%"
                                        }
                                    ]
                                };

                                // Hủy biểu đồ cũ nếu tồn tại
                                if (doanhthuChart) doanhthuChart.destroy();
                                if (donhangChart) donhangChart.destroy();

                                // Vẽ biểu đồ cột cho doanh thu
                                var ctx1 = document.getElementById("doanhthuChart").getContext("2d");
                                doanhthuChart = new Chart(ctx1, {
                                    type: "bar",
                                    data: doanhthuData,
                                    options: {
                                        responsive: true,
										maintainAspectRatio: false, // Cho phép biểu đồ điều chỉnh chiều cao linh hoạt
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: "bottom",
                                                labels: {
                                                    color: "#000",
                                                    font: {
                                                        size: 12,
                                                        weight: "bold"
                                                    }
                                                }
                                            },
                                            title: {
                                                display: true,
                                                text: "Biểu đồ doanh thu",
                                                font: {
                                                    size: 20,
                                                    weight: "bold"
                                                }
												,color: "#333" // Màu xám đậm giúp hiển thị tốt hơn
                                            },
                                            datalabels: {
                                                anchor: "top",
                                                align: "end",
                                                formatter: (value, ctx) => {
                                                    let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                                    let percentage = ((value / sum) * 100).toFixed(2) + "%";
                                                   return percentage > 0 ? percentage + "%" : ""; // Không hiển thị nếu bằng 0
                                                },
                                                color: "#000",
                                                font: {
                                                    size: 14,
                                                    weight: "bold"
                                                }
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                grid: {
                                                    color: "#e0e0e0"
                                                }
                                            },
                                            x: {
                                                grid: {
                                                    color: "#e0e0e0"
                                                }
                                            }
                                        }
                                    }
                                });

                                // Vẽ biểu đồ tròn cho đơn hàng
                                var ctx2 = document.getElementById("donhangChart").getContext("2d");
                                donhangChart = new Chart(ctx2, {
                                    type: "pie",
                                    data: donhangData,
                                    options: {
                                        responsive: true,
										maintainAspectRatio: false, // Cho phép biểu đồ điều chỉnh chiều cao linh hoạt
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: "bottom",
                                                labels: {
                                                    color: "#000",
                                                    font: {
                                                        size: 12,
                                                        weight: "bold"
                                                    }
                                                }
                                            },
                                            title: {
                                                display: true,
                                                text: "Phân bổ đơn hàng",
                                                font: {
                                                    size: 20,
                                                    weight: "bold"
                                                }
												,color: "#000" // Đổi sang màu đen để rõ hơn
                                            },
                                            datalabels: {
                                                formatter: (value, ctx) => {
                                                    let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                                    let percentage = ((value / sum) * 100).toFixed(2);
                                                    return percentage > 0 ? percentage + "%" : "";
                                                },
                                                color: "#fff",
                                                font: {
                                                    size: 14,
                                                    weight: "bold"
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        }, 2000);
                    }
                });
            }
        }

        // Định dạng ngày mặc định
        let today = new Date();
        let year = today.getFullYear();

        // Định dạng ngày thành dd/mm/yyyy
        function formatDate(date) {
            let dd = String(date.getDate()).padStart(2, "0");
            let mm = String(date.getMonth() + 1).padStart(2, "0");
            let yyyy = date.getFullYear();
            return `${dd}/${mm}/${yyyy}`;
        }

        // Đặt giá trị mặc định cho input date
        $("input[name=begin]").val(formatDate(new Date(year, 0, 1))); // Ngày đầu năm
        $("input[name=end]").val(formatDate(today)); // Ngày hiện tại

        // Gọi applyFilter() ngay khi vào trang để hiển thị biểu đồ mặc định
        $(document).ready(function () {
            applyFilter();
        });

        // Lắng nghe sự kiện khi người dùng thay đổi ngày và nhấn áp dụng
        $("button[name=button_hoahong]").on("click", function () {
            applyFilter();
        });
    });
</script>
<!-- 01/10/2023 -->



<style>
	.li_box {
		width: 100%;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}

	.li_box canvas {
		width: 100% !important;
		height: 300px !important;
		/* Đảm bảo cả hai biểu đồ có chiều cao giống nhau */
		border: 1px solid #007BFF;
		border-radius: 8px;
	}
	@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

	body {
		font-family: 'Roboto', sans-serif;
	}
	h3 {
		all: unset !important; /* Reset tất cả thuộc tính về mặc định */
		
		font-size: 1.17em !important;
		margin-block-start: 1em !important; 
		
		margin-inline-start: 0px !important;
		margin-inline-end: 0px !important;
		font-weight: bold !important;
		unicode-bidi: isolate !important;
	}
	.page_body .box_right {
	
		min-height: calc(105vh - 30px) !important;
	
	}
		/* Mobile */
@media (max-width: 768px) {
    .box_right {
        width: 100%;
        margin-left: 0;
        padding: 10px;
    }

    .box_right_content {
        padding: 10px;
    }

    .qr_container {
        flex-direction: column;
        text-align: center;
    }

    .qr_code img {
        width: 150px;
        height: 150px;
    }

    .filter_section {
		
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .filter_section label {
        margin-bottom: 5px;
    }

    .box_timkiem_thanhviennhom {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .box_timkiem_thanhviennhom input {
        width: 100%;
    }

    .button_timkiem {
        width: 100%;
    }

    table.list_baiviet {
        width: 100%;
        font-size: 14px;
    }

    table.list_baiviet th,
    table.list_baiviet td {
        padding: 5px;
    }

    table.list_baiviet .hide_mobile {
        display: none;
    }
	.page_body .box_right
	{
		width: 100%;
		margin-left: 0;
	}
	.box_right_mobile{
		margin-top: 220px !important;
	}
	.page_body .box_right .box_right_content_mobile
	{
		top: 180px !important;
	}
	.box_right_thanhvien_mobile{
		margin-top: 750px !important;
	}
	.page_body .box_right .box_right_content .box_profile .box_result .li_box {
		background: #ffff;
		position: relative;
		width: calc(100% / 3 - 7px);
		border: 1px solid #ffffff;
		border-radius: 7px;
		padding: 20px;
		display: inline-block;
		box-shadow: 0 4px 8px rgb(0 0 0 / 10%);
		margin-bottom: 20px;
		float: left;
	}
}

</style>