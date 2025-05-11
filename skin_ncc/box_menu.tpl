<!-- Container cho countdown timer -->
<div id="custom-countdown-wrapper" style="{display_kh}; position: relative; z-index: 99999;">
	<div id="custom-countdown-container"
		style="background: rgba(0,0,0,0.2); margin: 10px 0; padding: 15px; border-radius: 5px;">
		<h2 style="color: #ffffff; font-size: 16px; margin-bottom: 10px; text-align: center;">Thời gian còn lại:</h2>
		<div id="custom-countdown-timer" data-time="{expire_time}"
			style="background: rgba(0,0,0,0.1); padding: 10px; border-radius: 5px;">
			<div id="custom-countdown-values" style="display: flex; justify-content: center; gap: 10px;">
				<div class="time-section">
					<span class="time-block custom_days">00</span>
					<span class="time-label">Ngày</span>
				</div>
				<div class="time-section">
					<span class="time-block custom_hours">00</span>
					<span class="time-label">Giờ</span>
				</div>
				<div class="time-section">
					<span class="time-block custom_minutes">00</span>
					<span class="time-label">Phút</span>
				</div>
				<div class="time-section">
					<span class="time-block custom_seconds">00</span>
					<span class="time-label">Giây</span>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Box số dư và nút kích hoạt -->
<!-- <div class="box_sodu">
	<div style="margin-bottom: 2px;">
		<button style="margin-bottom: 5px;">
			Số dư: <span>{user_money} đ</span><br><br>
			Khuyến mại: <span>{user_money2} đ</span>
		</button>
	</div>
	<div style="padding: 2px; margin-top: 2px;">
		<span style="{display_kh};" class="open_modal">Kích hoạt tài khoản tại đây</span>
	</div>
</div> -->

<!-- Các menu khác -->
<div class="main_menu_box">
	<div class="title_box">Liên kết</div>
	<div class="list_menu">
		<!-- <div class="li_menu"><a href="/" style="font-weight: bolder !important;"><span class="left"><i
						class="icon icon-link2"></i>SOCDO.VN</span></a></div> -->
		<div class="li_menu"><a style="font-weight: bolder !important;" href="{gianhang}" target="_blank"><span
					class="left"><i class="icon icon-link2"></i>WEBSITE CỦA BẠN</span></a></div>
		<!-- <div class="li_menu">
			<a class="btn-domain" style="font-weight: bolder !important;" href="{domain_giaoviec}" target="_blank"><span
					class="left"><i class="icon icon-link2"></i>QUẢN LÝ CÔNG VIỆC </span></a>
		</div> -->
		<!-- <div class="li_menu"><a href="#" class="lo_trinh_btn" target="_blank"><span class="left">
					<p>LỘ TRÌNH CHO NHÀ BÁN HÀNG</p>
				</span><span class="right">🔑</span></a></div> -->
	</div>
</div>

<!-- Các phần main_menu khác (giữ nguyên nội dung, chỉ rút gọn cách viết) -->
<!-- <div class="main_menu">
	<div class="title" id="menu_title_1">Học viện sóc đỏ</div>
	<div class="list_menu">
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="fa fa-play-circle"></i>Video hướng
					dẫn</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/list-video"><i class="fa fa-angle-double-right"></i>Tất cả
						video</a></div>
				{list_danhmuc_video}
			</div>
		</div>
	</div>
</div> -->

<!-- <div class="main_menu">
	<div class="title" id="menu_title_2">Dịch vụ hỗ trợ bán hàng</div>
	<div class="list_menu">
		<div class="li_menu"><a href="/ncc/list-dichvu#bo-template"><span class="left"><i
						class="fa fa-pie-chart"></i>Thiết kế và Setup Website</span></a></div>
		<div class="li_menu"><a href="/ncc/list-dichvu#seeding-shopee"><span class="left"><i
						class="icofont-ui-user-group"></i>Quản trị và vận hành website</span></a></div>
		<div class="li_menu"><a href="/ncc/list-idol" class="a_main color_green"
				style="color: #f0f0f0 !important;"><span class="left color_livestream"><i class="fa fa-star-o"></i>Book
					lịch LiveStream</span></a></div>
	</div>
</div> -->

<div class="main_menu">
	<div class="title" id="menu_title_3">Quản lý tài chính</div>
	<div class="list_menu">
		<!-- <div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icon icon-credit-card"></i>Quản lý nạp
					tiền</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/add-naptien"><i class="fa fa-plus-circle"></i>Nạp thêm tiền</a>
				</div>
				<div class="li_menu_sub"><a href="/ncc/list-naptien"><i class="icon icon-coin-dollar"></i>Lịch sử nạp
						tiền</a></div>
				<div class="li_menu_sub"><a href="/ncc/list-chitieu"><i class="icon icon-coins"></i>Lịch sử chi tiêu</a>
				</div>
			</div>
		</div> -->
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icon icon-basket"></i>Quản lý đơn
					hàng</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				
				<!-- <div class="li_menu_sub"><a href="/ncc/list-donhang-socdo"><i class="fa fa-angle-double-right"></i>Danh
						sách đơn hàng</a></div>
				<div class="li_menu_sub"><a href="/ncc/list-donhang-ncc"><i class="fa fa-angle-double-right"></i>Danh
						sách đơn hàng sàn TMĐT</a></div> -->
				<div class="li_menu_sub"><a href="/ncc/list-donhang"><i class="fa fa-angle-double-right"></i>Đơn hàng
						website</a></div>
				
			</div>
		</div>
		<div class="li_menu"><a href="/ncc/thongke-chung"><span class="left"><i class="fa fa-pie-chart"></i>Thống kê
					chung</span></a></div>
	</div>
</div>

<div class="main_menu">
	<div class="title" id="menu_title_4">Bán hàng trên Website</div>
	<div class="list_menu">
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="fa fa-cogs"></i>Giao diện</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<!-- <div class="li_menu_sub"><a href="/ncc/list-giaodien"><i class="icon icon-stack"></i>Thay đổi giao
						diện</a></div>
				<div class="li_menu_sub"><a href="/ncc/domain"><i class="fa fa-globe"></i>Đăng ký tên miền</a></div> -->
				<div class="li_menu_sub"><a href="/ncc/list-setting"><i class="icofont-gear-alt"></i>Cài đặt chung</a>
				</div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-bullseye"></i>Kênh
					Marketing</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub">
					<!-- <a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icofont-brand-target"></i>Mua kèm deal sốc</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a> -->
					<!-- <div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/ncc/add-deal"><i class="fa fa-plus-circle"></i>Thêm mua
								kèm deal sốc</a></div>
						<div class="li_menu_sub_sub"><a href="/ncc/list-deal"><i class="icofont-ui-file"></i>Danh sách
								deal sốc</a></div>
					</div> -->
				</div>
				<div class="li_menu_sub"><a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icofont-flash"></i>Flash sale</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/ncc/add-flash-sale"><i class="fa fa-plus-circle"></i>Thêm
								flash sale mới</a></div>
						<div class="li_menu_sub_sub"><a href="/ncc/list-flash-sale"><i class="icofont-ui-file"></i>Danh
								sách flash sale</a></div>
					</div>
				</div>
				<div class="li_menu_sub"><a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icofont-tags"></i>Voucher</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/ncc/add-coupon"><i class="fa fa-plus-circle"></i>Thêm
								voucher mới</a></div>
						<div class="li_menu_sub_sub"><a href="/ncc/list-coupon"><i class="icofont-ui-file"></i>Danh sách
								voucher</a></div>
					</div>
				</div>
				<!-- <div class="li_menu_sub"><a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icon icon-piggy-bank"></i>Tích điểm</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/ncc/edit-tichdiem"><i class="icofont-tools"></i>Cài đặt
								tích điểm</a></div>
						<div class="li_menu_sub_sub"><a href="/ncc/list-tichdiem"><i class="icofont-ui-file"></i>Lịch sử
								tích điểm</a></div>
					</div>
				</div> -->
				<!-- <div class="li_menu_sub"><a href="add-remarketing"><i class="icon icon-target"></i>Remarketing</a></div>
				<div class="li_menu_sub"><a href="/ncc/list-sanpham-trend"><i class="fa fa-question-circle"></i>Gợi ý
						sản phẩm trend</a></div> -->
				<!-- <div class="li_menu_sub"><a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icofont-world"></i>Book lịch livestream</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/ncc/list-idol"><i class="fa fa-plus-circle"></i>Đặt lịch
								livestream</a></div>
						<div class="li_menu_sub_sub"><a href="/ncc/list-dat-live"><i class="icofont-ui-file"></i>Lịch sử
								livestream</a></div>
					</div>
				</div> -->
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i class="icofont-papers"></i>Danh
					mục sản phẩm</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/add-category"><i class="fa fa-plus-circle"></i>Thêm danh mục
						mới</a></div>
				<div class="li_menu_sub"><a href="/ncc/list-category"><i class="icofont-ui-file"></i>Quản lý danh
						mục</a></div>
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i
						class="icon icon-store2"></i>Quản lý sản phẩm</span><span class="right"><i
						class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<!-- <div class="li_menu_sub"><a href="/ncc/add-sanpham"><i class="fa fa-plus-circle"></i>Đăng bán sản phẩm
						socdo.vn</a></div> -->
				<div class="li_menu_sub"><a href="/ncc/add-sanpham-ngoai"><i class="fa fa-plus-circle"></i>Đăng bán sản
						phẩm mới</a></div>
				<!-- <div class="li_menu_sub"><a href="/ncc/add-sanpham-affiliate"><i class="fa fa-plus-circle"></i>Thêm sản
						phẩm affiliate</a></div> -->
				<div class="li_menu_sub"><a href="/ncc/list-sanpham"><i class="icofont-ui-file"></i>Danh sách sản
						phẩm</a></div>
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i
						class="icofont-numbered"></i>Quản lý menu</span><span class="right"><i
						class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/add-menu"><i class="fa fa-plus-circle"></i>Thêm menu mới</a>
				</div>
				<div class="li_menu_sub"><a href="/ncc/list-menu"><i class="icofont-ui-file"></i>Danh sách menu</a>
				</div>
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i
						class="icofont-chart-radar-graph"></i>Thương hiệu sản phẩm</span><span class="right"><i
						class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/add-brand"><i class="fa fa-plus-circle"></i>Thêm thương hiệu
						mới</a></div>
				<div class="li_menu_sub"><a href="/ncc/list-brand"><i class="icofont-ui-file"></i>Danh sách thương
						hiệu</a></div>
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i class="icofont-papers"></i>Danh
					mục bài viết</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/add-theloai"><i class="fa fa-plus-circle"></i>Thêm danh mục
						mới</a></div>
				<div class="li_menu_sub"><a href="/ncc/list-theloai"><i class="icofont-ui-file"></i>Quản lý danh mục</a>
				</div>
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i
						class="icofont-newspaper"></i>Quản lý bài viết</span><span class="right"><i
						class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/add-post"><i class="fa fa-plus-circle"></i>Thêm bài viết mới</a>
				</div>
				<div class="li_menu_sub"><a href="/ncc/list-post"><i class="icofont-ui-file"></i>Danh sách bài viết</a>
				</div>
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i class="fa fa-envelope"></i>Liên
					hệ nhận tin</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/list-lienhe"><i class="icofont-ui-file"></i>Danh sách liên hệ</a>
				</div>
				<div class="li_menu_sub"><a href="/ncc/list-nhantin"><i class="icofont-ui-file"></i>Đăng ký nhận tin</a>
				</div>
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i
						class="icon icon-users"></i>Quản lý thành viên</span><span class="right"><i
						class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/list-thanhvien"><i class="icofont-ui-file"></i>Danh sách thành
						viên</a></div>
			</div>
		</div>
		<div class="li_menu"><a href="javascript:;" class="a_main"><span class="left"><i class="icofont-image"></i>Quản
					lý slide</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/ncc/add-slide"><i class="fa fa-plus-circle"></i>Thêm slide mới</a>
				</div>
				<div class="li_menu_sub"><a href="/ncc/list-slide"><i class="icofont-ui-file"></i>Danh sách slide</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="main_menu_box">
	<div class="title_box">Quản Lý Shop NCC</div>
	<div class="list_menu">
		<div class="li_menu"><a href="/ncc/profile"><span class="left"><i class="icon icon-user"></i>Hồ sơ thông
					tin</span></a></div>
		<div class="li_menu"><a href="/ncc/transport"><span class="left"><i class="icon icon-truck"></i>Cài đặt vận
					chuyển</span></a></div>
		<!-- <div class="li_menu"><a href="/ncc/payment"><span class="left"><i class="fas icon-credit-card"></i>Cài đặt thanh
					toán</span></a></div> -->
		<div class="li_menu"><a href="/ncc/change-password"><span class="left"><i class="icon icon-lock2"></i>Đổi mật
					khẩu</span></a></div>
		<div class="li_menu"><a href="/ncc/logout"><span class="left"><i class="icon icon-switch"></i>Đăng
					xuất</span></a></div>
	</div>
</div>

<!-- CSS -->
<style>
	.time-section {
		display: inline-flex;
		flex-direction: column;
		align-items: center;
	}

	.time-block {
		display: inline-block;
		min-width: 30px;
		padding: 5px 8px;
		background: rgba(255, 255, 255, 0.1);
		border-radius: 3px;
		color: #ffffff;
		font-weight: bold;
		font-size: 16px;
		text-align: center;
	}

	.time-label {
		color: #ffffff;
		font-size: 12px;
		margin-top: 4px;
	}

	#custom-countdown-wrapper,
	#custom-countdown-container,
	#custom-countdown-values {
		position: relative;
		z-index: 99999;
	}

	@keyframes blink4 {
		0% {
			transform: scale(1);
			background-color: red;
			color: white;
		}

		50% {
			transform: scale(1.1);
			background-color: yellow;
			color: black;
		}

		100% {
			transform: scale(1);
			background-color: red;
			color: white;
		}
	}

	.open_modal {
		display: block;
		text-align: center;
		margin: 0 auto;
		padding: 10px 15px;
		border-radius: 5px;
		cursor: pointer;
		width: max-content;
		animation: blink4 1s infinite;
	}

	.box_sodu {
		background: #fff;
		border-radius: 8px;
		padding: 10px;
		margin: 10px 0;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	}

	.box_sodu button {
		width: 100%;
		padding: 15px;
		background: linear-gradient(45deg, #ff0000, #ff4444);
		border: none;
		border-radius: 8px;
		color: white;
		font-size: 14px;
		font-weight: 500;
		text-align: center;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.box_sodu button:hover {
		background: linear-gradient(45deg, #ff4444, #ff0000);
		transform: translateY(-2px);
		box-shadow: 0 4px 8px rgba(255, 0, 0, 0.2);
	}

	.box_sodu button span {
		font-weight: bold;
		font-size: 16px;
		display: inline-block;
		margin-left: 5px;
	}

	.box_sodu .open_modal {
		display: block;
		width: 100%;
		padding: 10px;
		background: #ff0000;
		color: white;
		text-align: center;
		border-radius: 8px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.box_sodu .open_modal:hover {
		background: #cc0000;
		transform: translateY(-2px);
	}

	@media (max-width: 768px) {
		.color_livestream {
			color: #333 !important;
		}
	}

	.main_menu .title {
		position: relative;
		cursor: pointer;
	}

	.main_menu .title::after {
		content: "+";
		border: 3px solid rgb(244, 244, 244);
		display: inline-block;
		padding: 0px 5px;
		position: absolute;
		right: 4px;
		top: 50%;
		color: rgb(255, 255, 255);
		border-radius: 45px;
		transform: translateY(-50%);
	}

	.main_menu .title.active::after {
		content: "-";
		border: 3px solid rgb(244, 244, 244);
		display: inline-block;
		padding: 0px 6.5px;
		position: absolute;
		right: 4px;
		top: 50%;
		color: rgb(255, 255, 255);
		border-radius: 45px;
		transform: translateY(-50%);
	}

	.main_menu .list_menu {
		display: none;
	}

	.page_body .box_left .box_menu_left .box_left_content .main_menu .title {
		border-radius: 45px;
	}

	.main_menu_box {
		background: #fff;
		border: 1px solid #e0e0e0;
		border-radius: 8px;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		overflow: hidden;
		font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
		max-width: 300px;
		margin: 20px auto;
	}

	.main_menu_box .title_box {
		display: flex;
		align-items: center;
		padding: 5px 5px;
		font-size: 12px;
		font-weight: bold;
		background-color: #ff0000;
		color: #fff;
		text-transform: uppercase;
	}

	.main_menu_box .list_menu {
		display: flex;
		flex-direction: column;
	}

	.main_menu_box .li_menu {
		border-bottom: 1px solid #f0f0f0;
		transition: background 0.3s;
	}

	.main_menu_box .li_menu:last-child {
		border-bottom: none;
	}

	.main_menu_box .li_menu a {
		display: flex;
		align-items: center;
		padding: 5px 5px;
		color: #333;
		text-decoration: none;
		transition: background 0.3s, color 0.3s;
	}

	.main_menu_box .li_menu a:hover {
		background: #f7f7f7;
	}

	.main_menu_box .li_menu a .left {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.main_menu_box .li_menu a .left i {
		font-size: 14px;
		color: #ff0000;
	}

	.main_menu_box .li_menu a .left p {
		margin: 0;
		font-size: 12px;
		font-weight: 600;
		color: inherit;
	}

	.main_menu_box .li_menu a .right {
		margin-left: auto;
		font-size: 14px;
		color: #666;
	}

	.main_menu_box .li_menu a.lo_trinh_btn {
		color: #d32f2f;
	}

	.main_menu_box .li_menu a.lo_trinh_btn .left {
		color: #d32f2f;
	}
</style>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript -->
<script>
	// Khai báo một lần duy nhất ở scope cao nhất
	window.hasInitialized = window.hasInitialized || false;

	$(document).ready(function () {
		// Kiểm tra xem đã khởi tạo chưa
		if (window.hasInitialized) {
			return;
		}
		window.hasInitialized = true;


		// Khởi tạo các biến
		const $button = $(".open_modal");
		const $boxKichHoat = $(".box_kichhoat");
		const $countdownTimer = $('#custom-countdown-timer');
		const dataTime = $countdownTimer.attr('data-time');
		const endTime = parseInt(dataTime, 10) * 1000;
		let countdownInterval;
		// Kiểm tra nút open_modal
		if ($button.length > 0) {
			console.log("Nút .open_modal đã tìm thấy, bắt đầu hiệu ứng...");

			// Hiệu ứng nhấp nháy cho nút
			setTimeout(() => {
				$button.css("animation", "none");
				console.log("Hiệu ứng nhấp nháy đã dừng.");
			}, 30000);

			// Sự kiện click để hiển thị popup
			$button.on('click', function (e) {
				e.preventDefault();
				e.stopPropagation();

				// Kiểm tra thời gian còn lại
				const now = new Date().getTime();
				const timeLeft = endTime - now;

				console.log("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.");
				// console.log('data-time:', dataTime);
				// console.log('endTime:', endTime);
				// console.log('timeLeft:', timeLeft);

				if (isNaN(endTime)) {
					alert('Lỗi: Giá trị data-time không hợp lệ. Vui lòng kiểm tra backend.');
					return;
				}

				if (timeLeft > 0) {
					// Hiển thị popup
					window.showKichHoatPopup();
				} else {
					alert('Đã hết thời gian kích hoạt tài khoản!');
				}
			});
		} else {
			console.error("Không tìm thấy phần tử .open_modal!");
		}

		// Countdown timer và xử lý khi hết thời gian
		function showExpiredModal() {
			$boxKichHoat.fadeIn(300).css({
				'display': 'flex',
				'background-color': 'rgba(0, 0, 0, 0.8)',
				'z-index': '9999'
			});
			$('.close_modal').hide();
			$('.box_kichhoat').css({ 'pointer-events': 'all' });
			$('.box_kichhoat_content').css({
				'pointer-events': 'auto',
				'position': 'relative',
				'z-index': '10000'
			});
			$('.box_kichhoat_content').find('*:not(#sudung_sodu, .box_xuly, .box_xuly *)').css({
				'pointer-events': 'none',
				'opacity': '1'
			});
			$('#sudung_sodu').css({
				'pointer-events': 'auto',
				'opacity': '1',
				'background': '#ff0000',
				'transform': 'scale(1.05)',
				'box-shadow': '0 0 10px rgba(255, 0, 0, 0.5)',
				'transition': 'all 0.3s ease'
			});
			if (!$('.warning-message').length) {
				$('.box_thongbao').prepend(`
                <div class="warning-message" style="background: #fff3cd; color: #856404; padding: 15px; margin-bottom: 15px; border-radius: 4px; text-align: center;">
                    <strong>⚠️ Đã hết thời gian dùng thử!</strong><br>
                    Vui lòng kích hoạt để tiếp tục sử dụng.
                </div>
            `);
			}
			$boxKichHoat.off('click').on('click', function (e) {
				if ($(e.target).is($boxKichHoat)) {
					return false;
				}
			});
		}

		function updateCountdown() {
			let now = new Date().getTime();
			let timeLeft = endTime - now;

			if (timeLeft <= 0) {
				$countdownTimer.text("Hết thời gian!");
				showExpiredModal();
				if (countdownInterval) {
					clearInterval(countdownInterval);
				}
				return;
			}

			let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
			let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
			let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

			$('.custom_days').text(days.toString().padStart(2, '0'));
			$('.custom_hours').text(hours.toString().padStart(2, '0'));
			$('.custom_minutes').text(minutes.toString().padStart(2, '0'));
			$('.custom_seconds').text(seconds.toString().padStart(2, '0'));
		}

		// Kiểm tra thời gian khi tải trang
		let now = new Date().getTime();
		if (isNaN(endTime)) {
			console.error('Lỗi: Giá trị data-time không hợp lệ. Vui lòng kiểm tra backend.');
		} else if (endTime && now >= endTime) {
			showExpiredModal();
		} else {
			updateCountdown();
			countdownInterval = setInterval(updateCountdown, 1000);
		}

		// Ẩn hiện menu
		let stored = localStorage.getItem('open_menus');
		if (!stored) {
			let openMenus = [];
			$('.main_menu .title').each(function () {
				let id = $(this).attr('id');
				if (id) {
					$(this).addClass('active');
					$(this).next('.list_menu').show();
					openMenus.push(id);
				}
			});
			localStorage.setItem('open_menus', JSON.stringify(openMenus));
		} else {
			let openMenus = JSON.parse(stored);
			$('.main_menu .title').each(function () {
				let id = $(this).attr('id');
				if (openMenus.indexOf(id) !== -1) {
					$(this).addClass('active');
					$(this).next('.list_menu').show();
				}
			});
		}

		$('.main_menu .title').on('click', function (e) {
			e.preventDefault();
			let $this = $(this);
			$this.toggleClass('active');
			$this.next('.list_menu').slideToggle(300);

			let titleId = $this.attr('id');
			if (!titleId) return;

			let openMenus = JSON.parse(localStorage.getItem('open_menus')) || [];
			if ($this.hasClass('active')) {
				if (!openMenus.includes(titleId)) openMenus.push(titleId);
			} else {
				openMenus = openMenus.filter(id => id !== titleId);
			}
			localStorage.setItem('open_menus', JSON.stringify(openMenus));
		});

		// Scroll tới mục có hash
		if (window.location.hash) {
			const targetElement = document.querySelector(window.location.hash);
			if (targetElement) {
				targetElement.scrollIntoView({ behavior: 'smooth' });
				const tbodyElement = targetElement.querySelector('tbody');
				if (tbodyElement) {
					tbodyElement.style.border = '5px solid red';
				}
			}
		}
	});
</script>