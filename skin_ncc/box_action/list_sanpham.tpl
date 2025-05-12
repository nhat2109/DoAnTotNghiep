<div class="box_right">
	<div class="box_right_content">
		<div class="box_profile" style="width: 100%;padding: 10px;">
			<div class="box_timkiem" style="float: right;">
				<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
				<button name="timkiem_sanpham_shop" class="button_timkiem">Tìm kiếm</button>
			</div>
			<div class="page_title">
				<h1 class="undefined">Danh sách sản phẩm</h1>
				<div class="line"></div>
				<hr>
			</div>
			<div style="margin-bottom: 10px; margin-left: 10px;">
				<button type="button" id="approve-selected" class="btn btn-primary" style="background-color: red;">Xóa
					sản phẩm</button>
				<span id="selected-count">Đã chọn: 0</span>
			</div>
			<table class="list_baiviet">
				<tr style="z-index: 999;">
					<th style="text-align: center;"><input type="checkbox" id="select-all"></th>
					<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
					<th style="text-align: center;width: 120px;" class="hide_mobile">Mã</th>
					<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
					<th style="text-align: left;">Tên sản phẩm</th>
					<!-- <th style="text-align: center;width: 100px;" class="hide_mobile">Giá Nhập</th> -->
					<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán lẻ</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">Giá Drop</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">Giá CTV</th>
					<th style="text-align: center;width: 110px;" class="hide_mobile">Giá Sóc Đỏ</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">Kho</th>
					<th style="text-align: center;width: 100px;" class="hide_mobile">View</th>
					<th style="text-align: center;width: 160px;">Hành động</th>
				</tr>
				{list_sanpham}
			</table>
			{phantrang}
		</div>
	</div>
</div>
<div class="box_confirm" style="display: none;">
	<div class="box_confirm_content">
		<div class="title" style="color: #d9534f; font-weight: bold; text-align: center;">
			Xác nhận đăng sản phẩm
		</div>
		<div style="text-align: center; margin: 20px 0;">
			Bạn có chắc chắn muốn đăng sản phẩm này lên Sóc Đỏ?
		</div>
		<div style="text-align: center;">
			<button id="confirm_yes"
				style="background: #ff0000; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-right: 10px;">
				Thực hiện
			</button>
			<button id="confirm_no"
				style="background: #0066cc; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
				Hủy
			</button>
		</div>
	</div>
</div>

<div class="success-notification">
	<span class="notification-text"></span>
</div>

<script>
	function postToSocDo(id) {
		// Hiện box confirm
		$('.box_confirm').show();

		// Xử lý nút Thực hiện
		$('#confirm_yes').off('click').on('click', function () {
			$('.box_confirm').hide();

			$.ajax({
				url: '/ncc/process.php',
				type: 'post',
				data: {
					action: 'post_to_socdo',
					id: id
				},
				dataType: 'json',
				success: function (response) {
					if (response.ok == 1) {
						showSuccessNotification('Đăng sản phẩm lên Sóc Đỏ thành công!', 1000, function () {
							window.location.reload();
						});
					} else {
						showSuccessNotification('Lỗi: ' + response.thongbao, 3000);
					}
				},
				error: function () {
					showSuccessNotification('Đã có lỗi xảy ra, vui lòng thử lại!', 3000);
				}
			});
		});

		// Xử lý nút Hủy
		$('#confirm_no').off('click').on('click', function () {
			$('.box_confirm').hide();
		});
	}

	// Thêm hàm hiển thị notification
	function showSuccessNotification(message, duration, callback) {
		const notification = $('.success-notification');
		notification.removeClass('success error'); // Remove existing classes

		// Add appropriate class based on message content
		if (message.toLowerCase().includes('lỗi') || message.toLowerCase().includes('thất bại')) {
			notification.addClass('error');
		} else {
			notification.addClass('success');
		}

		notification.find('.notification-text').text(message);
		notification.addClass('show');

		setTimeout(function () {
			notification.removeClass('show');
			if (callback) {
				setTimeout(callback, 300);
			}
		}, duration);
	}
</script>

<!-- huyphuc24/04/2025 -->
<script>
	$(document).ready(function () {
		// 1. Xử lý checkbox "Chọn tất cả"
		$("#select-all").on("change", function () {
			var isChecked = $(this).is(":checked");
			$(".select-item").prop("checked", isChecked);
			updateSelectedCount(); // Cập nhật số bản ghi đã chọn
		});

		// 2. Xử lý khi checkbox của từng hàng thay đổi
		$(document).on("change", ".select-item", function () {
			updateSelectedCount(); // Cập nhật số bản ghi đã chọn
		});

		// 3. Hàm cập nhật số bản ghi đã chọn
		function updateSelectedCount() {
			var selectedCount = $(".select-item:checked").length;
			$("#selected-count").text("Đã chọn: " + selectedCount);
		}

		// 4. Xử lý nút "Duyệt"
		$("#approve-selected").on("click", function () {
			// Lấy tất cả các checkbox đã được chọn
			var selectedItems = $(".select-item:checked");
			if (selectedItems.length === 0) {
				alert("Vui lòng chọn ít nhất một thương hiệu để duyệt!");
				return;
			}

			// Thu thập tất cả các ID của các bản ghi đã chọn
			var selectedIds = [];
			selectedItems.each(function () {
				var id = $(this).data("id");
				if (id) {
					selectedIds.push(id);
				}
			});

			// Gọi hàm confirm_phedhuyetnhieu_thuong_hieu với mảng ids
			confirm_xoanhieu_sanpham('del', 'xoanhieu_sanpham', 'Xác nhận xóa ' + selectedIds.length + ' sản phẩm', selectedIds);
		});

		// Cập nhật số bản ghi đã chọn lần đầu khi trang tải
		updateSelectedCount();
	});
</script>