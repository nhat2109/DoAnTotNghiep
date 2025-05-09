{box_danhhieu}
<!-- Sử dụng một container div thay cho button nếu không cần chức năng nút -->
<div id="custom-countdown-wrapper" style="{display_kh}; position: relative; z-index: 99999;">
	<div id="custom-countdown-container"
		style="background: rgba(0,0,0,0.2); margin: 10px 0; padding: 15px; border-radius: 5px;">
		<h2 style="color: #ffffff; font-size: 16px; margin-bottom: 10px; text-align: center;">Thời gian còn lại:</h2>
		<div id="custom-countdown-timer" data-time="{expire_time}"
			style="background: rgba(0,0,0,0.1); padding: 10px; border-radius: 5px;">
			<div id="custom-countdown-values" style="display: flex; justify-content: center; gap: 10px;">
				<div class="time-section">
					<span class="time-block custom_days" class="">00</span>
					<span class="time-label">Ngày</span>
				</div>
				<div class="time-section">
					<span class="time-block custom_hours" class="">00</span>
					<span class="time-label">Giờ</span>
				</div>
				<div class="time-section">
					<span class="time-block custom_minutes" class="">00</span>
					<span class="time-label">Phút</span>
				</div>
				<div class="time-section">
					<span class="time-block custom_seconds" class="">00</span>
					<span class="time-label">Giây</span>
				</div>
			</div>
		</div>
	</div>
</div>

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

	#custom-countdown-wrapper {
		position: relative;
		z-index: 99999;
	}

	#custom-countdown-container {
		position: relative;
	}

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
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(document).ready(function () {
		// Lấy phần tử nút bằng jQuery
		let $button = $(".open_modal");

		// Kiểm tra nếu nút tồn tại
		if ($button.length > 0) {
			console.log("Nút đã tìm thấy, bắt đầu hiệu ứng...");

			// Chạy hiệu ứng trong 10 giây
			setTimeout(() => {
				$button.css("animation", "none"); // Tắt hiệu ứng
				console.log("Hiệu ứng đã dừng.");
			}, 30000); // 10 giây
		} else {
			console.error("Không tìm thấy phần tử .open_modal!");
		}
	});
</script>
<script>
	$(document).ready(function () {
		let $button = $(".open_modal");
		const $boxKichHoat = $(".box_kichhoat");

		if ($button.length > 0) {
			console.log("Nút đã tìm thấy, bắt đầu hiệu ứng...");

			// Xử lý click event
			$button.on('click', function (e) {
				e.preventDefault();

				// Kiểm tra thời gian còn lại
				const $countdownTimer = $('#custom-countdown-timer');
				const endTime = parseInt($countdownTimer.attr('data-time'), 10) * 1000;
				const now = new Date().getTime();
				const timeLeft = endTime - now;

				if (timeLeft > 0) {
					// Hiển thị box kích hoạt khi vẫn còn thời gian
					$boxKichHoat.css({
						'display': 'flex',
						'background-color': 'rgba(0, 0, 0, 0.5)',
						'z-index': '9999'
					});

					// Dừng countdown nếu muốn
					if (countdownInterval) {
						clearInterval(countdownInterval);
					}
				} else {
					// Hết thời gian thì báo
					alert('Đã hết thời gian kích hoạt tài khoản!');
					showExpiredModal();
				}
			});

			// Hiệu ứng nhấp nháy
			setTimeout(() => {
				$button.css("animation", "none");
				console.log("Hiệu ứng đã dừng.");
			}, 30000);
		} else {
			console.error("Không tìm thấy phần tử .open_modal!");
		}

		// Thêm xử lý đóng modal
		$('.close_modal').on('click', function () {
			$boxKichHoat.hide();
		});
	});
</script>
<div class="box_danhhieu"></div>

<div class="box_sodu">
	<div style="margin-bottom: 2px;">
		<button style="margin-bottom: 5px;">
			Số dư: <span>{user_money} đ</span><br><br>
			Khuyến mại: <span>{user_money2} đ</span>
		</button>
	</div>
	<div style="padding: 2px; margin-top: 2px;">
		<span style="{display_kh};" class="open_modal">Kích hoạt tài khoản tại đây</span>
	</div>
</div>
<style>
	.box_sodu {
		background: #fff;
		border-radius: 8px;
		padding: 10px;
		/* padding-bottom: 0px; */
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
</style>
<div class="main_menu_box">
	<div class="title_box">Liên kết</div>
	<div class="list_menu">
		<div class="li_menu">
			<a href="/" style="font-weight: bolder !important;"><span class="left"><i
						class="icon icon-link2"></i>SOCDO.VN</span></a>
		</div>
		<div class="li_menu">
			<a style="font-weight: bolder !important;" href="{gianhang}" target="_blank"><span class="left"><i
						class="icon icon-link2"></i>WEBSITE CỦA
					BẠN</span></a>
		</div>
		<div class="li_menu">
			<a href="#" class="lo_trinh_btn" target="_blank">
				<span class="left">
					<p>LỘ TRÌNH CHO NHÀ BÁN HÀNG</p>
				</span>
				<span class="right">🔑</span>
			</a>
		</div>
	</div>
</div>


<div class="main_menu">
	<div class="title" id="menu_title_1">Học viện sóc đỏ</div>
	<div class="list_menu">
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="fa fa-play-circle"></i>Video hướng
					dẫn</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/list-video"><i class="fa fa-angle-double-right"></i>Tất cả
						video</a></div>
				{list_danhmuc_video}
			</div>
		</div>
	</div>
</div>
<div class="main_menu">
	<div class="title" id="menu_title_2">Dịch vụ hỗ trợ bán hàng</div>
	<div class="list_menu">
		<div class="li_menu"><a href="/dropship/list-dichvu#bo-template">
				<span class="left"><i class="fa fa-pie-chart"></i> Cung cấp bộ Template</a></span></div>
		<div class="li_menu"><a href="/dropship/list-dichvu#setup-gian-hang">
				<span class="left"><i class="icofont-search-job"></i>Setup gian hàng shopee</span></a></div>
		<div class="li_menu"><a href="/dropship/list-dichvu#coppy-san-pham">
				<span class="left"><i class="fa fa-rss"></i>Coppy gian hàng shopee</span><span class="right"></span></a>
		</div>
		<div class="li_menu"><a href="/dropship/list-dichvu#seeding-shopee">
				<span class="left"><i class="icofont-ui-user-group"></i>Seeding Shoope</span></a>
		</div>
		<div class="li_menu">
			<a href="/dropship/list-idol" class="a_main color_green" style="color: #f0f0f0 !important;"><span
					class="left color_livestream"><i class="fa fa-star-o"></i>Book lịch LiveStream</span><span
					class="right"></span></a>
		</div>
	</div>

</div>

<div class="main_menu">
	<div class="title" id="menu_title_3">Quản lý tài chính</i></div>
	<div class="list_menu">
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icon icon-credit-card"></i>Quản lý nạp
					tiền</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-naptien"><i class="fa fa-plus-circle"></i>Nạp thêm
						tiền</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-naptien"><i class="icon icon-coin-dollar"></i>Lịch sử
						nạp tiền</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-chitieu"><i class="icon icon-coins"></i>Lịch sử chi
						tiêu</a></div>
			</div>
		</div>


		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icon icon-basket"></i>Quản lý đơn
					hàng</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-donhang-drop"><i
							class="fa fa-angle-double-right"></i>Thêm đơn hàng mới</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-donhang-socdo"><i
							class="fa fa-angle-double-right"></i>Danh sách đơn hàng</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-donhang-dropship"><i
							class="fa fa-angle-double-right"></i>Danh sách đơn hàng sàn TMĐT</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-donhang"><i class="fa fa-angle-double-right"></i>Đơn
						hàng website</a></div>
				<div class="li_menu_sub">
					<a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="fa fa-angle-double-right"></i>Affilate</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/dropship/list-link-affiliate"><i
									class="fa fa-angle-right"></i>Link Affiliate</a></div>
						<div class="li_menu_sub_sub"><a href="/dropship/list-donhang-affiliate"><i
									class="fa fa-angle-right"></i>Đơn hàng Affiliate</a></div>
					</div>
				</div>
			</div>
		</div>


		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icon icon-wallet"></i>Quản lý rút hoa
					hồng</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-ruttien"><i class="fa fa-plus-circle"></i>Yêu cầu rút
						hoa hồng</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-ruttien"><i class="icon icon-coins"></i>Lịch sử rút hoa
						hồng</a></div>
			</div>
		</div>


		<div class="li_menu"><a href="/dropship/thongke-chung"><span class="left"><i class="fa fa-pie-chart"></i>Thống
					kê chung</a></span></div>
		<div class="li_menu"><a href="/dropship/list-tuyendung-nhom"><span class="left"><i
						class="icofont-search-job"></i>Link giới thiệu</span></a></div>
		<!-- <div class="li_menu"><a href="/dropship/list-sanpham-follow"><span class="left"><i class="fa fa-rss"></i>yêu
					thích</span><span class="right"><i class="fa fa-bell"><span
							class="total_quantam">0</span></i></span></a></div> -->
		<div class="li_menu">
			<a href="/dropship/list-thanhvien-nhom"><span class="left"><i class="icofont-ui-user-group"></i>Thống kê
					thành viên đăng ký</span></a>
		</div>
		<div class="li_menu">
			<a href="/dropship/thongke-doanhthu-nhom"><span class="left"><i class="icofont-money-bag"></i>Thống kê doanh
					thu nhóm</span></a>
		</div>
		<div class="li_menu">
			<a href="/dropship/thongke-donhang-nhom"><span class="left"><i class="icon icon-cart5"></i>Thống kê đơn hàng
					nhóm</span></a>
		</div>
		<div class="li_menu">
			<a href="/dropship/thongke-hoahong-nhom"><span class="left"><i class="icon icon-cash3"></i>Thống kê thu
					nhập</span></a>
		</div>
		<div class="li_menu">
			<a href="/dropship/list-donhang-nhom"><span class="left"><i class="fa fa-file-text"></i>
				Danh sách đơn hàng
					nhóm</span></a>
		</div>

	</div>
</div>
<div class="main_menu">

	<div class="list_menu">

	</div>
</div>
<!-- <div class="main_menu">
	<div class="title">Báo cáo nhóm</div>
	<div class="list_menu">
		
	</div>
</div> -->
<div class="main_menu">
	<div class="title" id="menu_title_4">Bán hàng trên Website</div>
	<div class="list_menu">
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="fa fa-cogs"></i>Giao diện & Tên
					miền</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/list-giaodien"><i class="icon icon-stack"></i>Thay đổi giao
						diện</a></div>
				<div class="li_menu_sub"><a href="/dropship/domain"><i class="fa fa-globe"></i>Đăng ký tên miền</a>
				</div>
				<div class="li_menu_sub"><a href="/dropship/list-setting"><i class="icofont-gear-alt"></i>Cài đặt
						chung</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-bullseye"></i>Kênh
					Marketing</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub">
					<a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icofont-brand-target"></i>Mua kèm deal sốc</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/dropship/add-deal"><i class="fa fa-plus-circle"></i>Thêm
								mua kèm deal sốc</a></div>
						<div class="li_menu_sub_sub"><a href="/dropship/list-deal"><i class="icofont-ui-file"></i>Danh
								sách deal sốc</a></div>
					</div>
				</div>
				<div class="li_menu_sub">
					<a href="javascript:;" class="space-between a_sub"><span class="left"><i class="icofont-flash"
								style="font-size: 20px;"></i>Flash sale</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/dropship/add-flash-sale"><i
									class="fa fa-plus-circle"></i>Thêm flash sale mới</a></div>
						<div class="li_menu_sub_sub"><a href="/dropship/list-flash-sale"><i
									class="icofont-ui-file"></i>Danh sách flash sale</a></div>
					</div>
				</div>
				<div class="li_menu_sub">
					<a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icofont-tags"></i>Voucher</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/dropship/add-coupon"><i
									class="fa fa-plus-circle"></i>Thêm voucher mới</a></div>
						<div class="li_menu_sub_sub"><a href="/dropship/list-coupon"><i class="icofont-ui-file"></i>Danh
								sách voucher</a></div>
					</div>
				</div>
				<div class="li_menu_sub">
					<a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icon icon-piggy-bank"></i>Tích điểm</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/dropship/edit-tichdiem"><i class="icofont-tools"></i>Cài
								đặt tích điểm</a></div>
						<div class="li_menu_sub_sub"><a href="/dropship/list-tichdiem"><i
									class="icofont-ui-file"></i>Lịch sử tích điểm</a></div>
					</div>
				</div>
				<div class="li_menu_sub">
					<a href="add-remarketing"><i class="icon icon-target"></i>Remarketing</a>
				</div>
				<div class="li_menu_sub">
					<a href="/dropship/list-sanpham-trend"><i class="fa fa-question-circle"></i>Gợi ý sản phẩm trend</a>
				</div>
				<div class="li_menu_sub">
					<a href="javascript:;" class="space-between a_sub"><span class="left"><i
								class="icofont-world"></i>Book lịch livestream</span><span class="right"><i
								class="fa fa-plus-square-o"></i></span></a>
					<div class="list_menu_sub_sub">
						<div class="li_menu_sub_sub"><a href="/dropship/list-idol"><i class="fa fa-plus-circle"></i>Đặt
								lịch livestream</a></div>
						<div class="li_menu_sub_sub"><a href="/dropship/list-dat-live"><i
									class="icofont-ui-file"></i>Lịch sử livestream</a></div>
					</div>
				</div>
			</div>
		</div>



		<!-- <div class="main_menu">
			<div class="title">Thông báo</div>
			<div class="list_menu">
				<div class="li_menu">
					<a href="/dropship/list-thongbao"><span class="left"><i class="icon icon-bell2"></i>Thông báo
							mới</span><span class="right"><i class="fa fa-bell"><span
									class="total_thongbao">0</span></i></span></a>
				</div>
				<div class="li_menu">
					<a href="/dropship/list-sanpham-tuan"><span class="left"><i class="fa fa-clock-o"></i>Chương trình
							tuần</span><span class="right"><i class="fa fa-bell"><span
									class="total_ct_tuan">0</span></i></span></a>
				</div>
				<div class="li_menu"><a href="/dropship/list-sanpham-hethang"><span class="left"><i
								class="icofont-ui-file"></i>Sản phẩm sắp hết hàng</span><span class="right"><i
								class="fa fa-bell"><span class="total_hethang">0</span></i></span></a></div>
				<div class="li_menu"><a href="/dropship/list-sanpham-hethang-catma"><span class="left"><i
								class="icofont-ui-file"></i>Sản phẩm hết hàng cắt mã</span><span class="right"><i
								class="fa fa-bell"><span class="total_catma">0</span></i></span></a></div>
			</div>
		</div> -->




		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-papers"></i>Danh mục sản
					phẩm</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-category"><i class="fa fa-plus-circle"></i>Thêm danh mục
						mới</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-category"><i class="icofont-ui-file"></i>Quản lý danh
						mục</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icon icon-store2"></i>Quản lý sản
					phẩm</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-sanpham"><i class="fa fa-plus-circle"></i>Đăng bán sản
						phẩm
						socdo.vn</a></div>
				<div class="li_menu_sub"><a href="/dropship/add-sanpham-ngoai"><i class="fa fa-plus-circle"></i>Đăng bán
						sản phẩm của bạn</a></div>
				<div class="li_menu_sub"><a href="/dropship/add-sanpham-affiliate"><i class="fa fa-plus-circle"></i>Thêm
						sản phẩm affiliate</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-sanpham"><i class="icofont-ui-file"></i>Danh sách sản
						phẩm</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-numbered"></i>Quản lý
					menu</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-menu"><i class="fa fa-plus-circle"></i>Thêm menu mới</a>
				</div>
				<div class="li_menu_sub"><a href="/dropship/list-menu"><i class="icofont-ui-file"></i>Danh sách menu</a>
				</div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-chart-radar-graph"></i>Thương
					hiệu sản phẩm</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-brand"><i class="fa fa-plus-circle"></i>Thêm thương hiệu
						mới</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-brand"><i class="icofont-ui-file"></i>Danh sách thương
						hiệu</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-resize"></i>Kích cỡ sản
					phẩm</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-size"><i class="fa fa-plus-circle"></i>Thêm kích cỡ
						mới</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-size"><i class="icofont-ui-file"></i>Danh sách kích
						cỡ</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-resize"></i>Màu sắc sản
					phẩm</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-color"><i class="fa fa-plus-circle"></i>Thêm màu sắc
						mới</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-color"><i class="icofont-ui-file"></i>Danh sách màu sắc</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-papers"></i>Danh mục bài
					viết</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-theloai"><i class="fa fa-plus-circle"></i>Thêm danh mục
						mới</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-theloai"><i class="icofont-ui-file"></i>Quản lý danh
						mục</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-newspaper"></i>Quản lý bài
					viết</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-post"><i class="fa fa-plus-circle"></i>Thêm bài viết
						mới</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-post"><i class="icofont-ui-file"></i>Danh sách bài
						viết</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="fa fa-envelope"></i>Liên hệ nhận
					tin</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/list-lienhe"><i class="icofont-ui-file"></i>Danh sách liên
						hệ</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-nhantin"><i class="icofont-ui-file"></i>Đăng ký nhận
						tin</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icon icon-users"></i>Quản lý thành
					viên</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/list-thanhvien"><i class="icofont-ui-file"></i>Danh sách
						thành viên</a></div>
			</div>
		</div>
		<div class="li_menu">
			<a href="javascript:;" class="a_main"><span class="left"><i class="icofont-image"></i>Quản lý
					slide</span><span class="right"><i class="fa fa-plus-square-o"></i></span></a>
			<div class="list_menu_sub">
				<div class="li_menu_sub"><a href="/dropship/add-slide"><i class="fa fa-plus-circle"></i>Thêm slide
						mới</a></div>
				<div class="li_menu_sub"><a href="/dropship/list-slide"><i class="icofont-ui-file"></i>Danh sách
						slide</a></div>
			</div>
		</div>
	</div>
</div>
<!-- <div class="main_menu">
	<div class="title">Thống kê website</div>
	<div class="list_menu">
		
		
	</div>
</div> -->
<div class="main_menu_box">
	<div class="title_box">Thông tin cá nhân</div>
	<div class="list_menu">
		<!-- Nội dung các mục con -->
		<div class="li_menu">
			<a href="/dropship/profile"><span class="left"><i class="icon icon-user"></i>Hồ sơ</span></a>
		</div>
		<div class="li_menu">
			<a href="/dropship/change-password"><span class="left"><i class="icon icon-lock2"></i>Đổi mật
					khẩu</span></a>
		</div>
		<div class="li_menu">
			<a href="/dropship/logout"><span class="left"><i class="icon icon-switch"></i>Đăng xuất</span></a>
		</div>
	</div>
</div>
<div class="list_social">
	<div class="social_box"
		style="margin-left: 15px padding: 3px 5px; border-radius: 20px;">
		<i style="color: #ffffff;" class="fa fa-facebook"></i>
		<span> <a href="https://www.facebook.com/groups/nguonhangsocdo" style="color: aliceblue;"
				target="_blank">Group</a></span>
	</div>
	<div class="social_box"
		style="padding: 3px 5px; border-radius: 20px;">
		<i style="color: rgb(255, 255, 255);" class="fa fa-facebook"></i>
		<span> <a href="https://www.facebook.com/SocDoPage" style="color: aliceblue;" target="_blank">Fanpage</a></span>
	</div>
</div>
<style>
	.list_social {
		display: flex;
		justify-content: space-between;
		gap: 10px;
	}
	.list_social .social_box {
		width: 50%;
		display: flex;
		justify-content: center;
		align-items: center;
		background-color: #ff0000;
		color: #ffffff;
		border-radius: 20px;
		padding: 3px 5px;
	}

	@media (max-width: 768px) {
		.color_livestream {
			color: #333 !important;
		}
	}

	/* Định dạng cho tiêu đề */
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

	/* Khi active hiển thị dấu -, cập nhật icon của title */
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

	/* Ẩn các mục con mặc định */
	.main_menu .list_menu {
		display: none;
	}

	/* Thêm nếu cần: định dạng riêng cho title bên trong container nhất định */
	.page_body .box_left .box_menu_left .box_left_content .main_menu .title {
		border-radius: 45px;
	}
</style>

<!-- css của liên kết + thông tin cá nhân  -->
<style>
	/* Container chính */
	.main_menu_box {
		background: #fff;
		border: 1px solid #e0e0e0;
		border-radius: 8px;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		overflow: hidden;
		font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
		max-width: 300px;
		/* điều chỉnh theo nhu cầu */
		margin: 20px auto;
	}

	/* Tiêu đề của box */
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

	/* Danh sách menu */
	.main_menu_box .list_menu {
		display: flex;
		flex-direction: column;
	}

	/* Mỗi mục menu */
	.main_menu_box .li_menu {
		border-bottom: 1px solid #f0f0f0;
		transition: background 0.3s;
	}

	.main_menu_box .li_menu:last-child {
		border-bottom: none;
	}

	/* Link trong menu */
	.main_menu_box .li_menu a {
		display: flex;
		align-items: center;
		padding: 5px 5px;
		color: #333;
		text-decoration: none;
		transition: background 0.3s, color 0.3s;
	}

	/* Hiệu ứng hover cho menu item */
	.main_menu_box .li_menu a:hover {
		background: #f7f7f7;
	}

	/* Phần bên trái của link (icon + text) */
	.main_menu_box .li_menu a .left {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	/* Icon bên trái */
	.main_menu_box .li_menu a .left i {
		font-size: 14px;
		/* Bạn có thể tùy chỉnh màu sắc theo ý muốn */
		color: #ff0000;
	}

	/* Text tiêu đề menu */
	.main_menu_box .li_menu a .left p {
		margin: 0;
		font-size: 12px;
		font-weight: 600;
		color: inherit;
	}

	/* Nếu có phần bên phải (ví dụ: key icon) */
	.main_menu_box .li_menu a .right {
		margin-left: auto;
		font-size: 14px;
		color: #666;
	}

	/* Ví dụ style riêng cho link có class lo_trinh_btn */
	.main_menu_box .li_menu a.lo_trinh_btn {
		color: #d32f2f;
	}

	.main_menu_box .li_menu a.lo_trinh_btn .left {
		color: #d32f2f;
	}
</style>

<!-- js của  ẩn hiện menu -->
<script>
	$(document).ready(function () {
		// Nếu chưa có giá trị lưu trong localStorage => mặc định mở tất cả menu
		var stored = localStorage.getItem('open_menus');
		if (!stored) {
			var openMenus = [];
			$('.main_menu .title').each(function () {
				var id = $(this).attr('id');
				if (id) {
					$(this).addClass('active');               // Thêm active cho tiêu đề
					$(this).next('.list_menu').show();          // Hiển thị danh sách
					openMenus.push(id);
				}
			});
			localStorage.setItem('open_menus', JSON.stringify(openMenus));
		} else {
			var openMenus = JSON.parse(stored);
			// Duyệt qua mỗi tiêu đề: nếu id có trong mảng lưu, mở menu tương ứng
			$('.main_menu .title').each(function () {
				var id = $(this).attr('id');
				if (openMenus.indexOf(id) !== -1) {
					$(this).addClass('active');
					$(this).next('.list_menu').show();
				}
			});
		}

		// Bind sự kiện click để toggle menu
		$('.main_menu .title').off('click').on('click', function (e) {
			e.preventDefault();
			var $this = $(this);
			$this.toggleClass('active');
			$this.next('.list_menu').slideToggle(300);

			var titleId = $this.attr('id');
			if (!titleId) {
				console.warn("Menu title không có id:", $this);
				return; // Yêu cầu mỗi menu phải có id để lưu trạng thái
			}

			var openMenus = JSON.parse(localStorage.getItem('open_menus')) || [];
			if ($this.hasClass('active')) {
				// Nếu menu mở, thêm id nếu chưa có
				if ($.inArray(titleId, openMenus) === -1) {
					openMenus.push(titleId);
				}
			} else {
				// Nếu menu đóng, loại bỏ id khỏi mảng
				openMenus = openMenus.filter(function (id) {
					return id !== titleId;
				});
			}
			localStorage.setItem('open_menus', JSON.stringify(openMenus));
		});
	});

	document.addEventListener('DOMContentLoaded', function () {
		if (window.location.hash) {
			const targetElement = document.querySelector(window.location.hash);
			if (targetElement) {
				targetElement.scrollIntoView({ behavior: 'smooth' });

				// Thêm viền đỏ cho thẻ <tbody> bên trong phần tử mục tiêu
				const tbodyElement = targetElement.querySelector('tbody');
				if (tbodyElement) {
					tbodyElement.style.border = '5px solid red';
				}
			}
		}
	});

</script>
<script>
	$(document).ready(function () {
		const modal = $('.box_kichhoat');
		const modalContent = $('.box_kichhoat_content');
		const closeModal = $('.close_modal');
		const $countdownTimer = $('#custom-countdown-timer');
		const endTime = parseInt($countdownTimer.attr('data-time'), 10) * 1000;
		let countdownInterval;

		function showExpiredModal() {
			// Hiển thị modal với backdrop
			modal.fadeIn(300).css({
				'display': 'flex',
				'background-color': 'rgba(0, 0, 0, 0.8)', // Làm tối nền
				'z-index': '9999' // Đảm bảo hiển thị trên cùng
			});

			// Ẩn nút đóng
			closeModal.hide();


			// Vô hiệu hóa tất cả tương tác nền
			$('.box_kichhoat').css({
				'pointer-events': 'all'
			});

			// Cho phép tương tác với content modal
			modalContent.css({
				'pointer-events': 'auto',
				'position': 'relative',
				'z-index': '10000'
			});

			// Vô hiệu hóa tất cả trừ nút kích hoạt và box_xuly
			modalContent.find('*:not(#sudung_sodu, .box_xuly, .box_xuly *)').css({
				'pointer-events': 'none',
				'opacity': '1'
			});

			// Làm nổi bật nút kích hoạt
			$('#sudung_sodu').css({
				'pointer-events': 'auto',
				'opacity': '1',
				'background': '#ff0000',
				'transform': 'scale(1.05)',
				'box-shadow': '0 0 10px rgba(255, 0, 0, 0.5)',
				'transition': 'all 0.3s ease'
			});

			// Thêm thông báo hết hạn
			if (!$('.warning-message').length) {
				$('.box_thongbao').prepend(`
            <div class="warning-message" style="background: #fff3cd; color: #856404; padding: 15px; margin-bottom: 15px; border-radius: 4px; text-align: center;">
                <strong>⚠️ Đã hết thời gian dùng thử!</strong><br>
                Vui lòng kích hoạt để tiếp tục sử dụng.
            </div>
        `);
			}

			// Thêm handler để chặn click outside
			modal.off('click').on('click', function (e) {
				if ($(e.target).is(modal)) {
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

		// Xử lý các sự kiện click
		closeModal.on('click', function (e) {
			e.preventDefault();
			let now = new Date().getTime();
			if (endTime - now > 0) {
				modal.fadeOut(300);
			}
		});

		// Kiểm tra khi tải trang
		let now = new Date().getTime();
		if (endTime && now >= endTime) {
			showExpiredModal();
		} else {
			// Khởi tạo countdown
			updateCountdown();
			countdownInterval = setInterval(updateCountdown, 1000);
		}
	});
</script>