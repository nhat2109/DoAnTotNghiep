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
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tên sản phẩm</th>
				<!-- <th style="text-align: center;width: 100px;" class="hide_mobile">Giá Nhập</th> -->
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán lẻ</th>
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
<style>
	.status {
		display: inline-block;
		padding: 5px 10px;
		margin-left: 5px;
		border-radius: 3px;
		font-size: 12px;
		color: #fff;
	}
	
	.status-0 {
		background-color: #ff9800; /* Màu cam cho "Đang chờ duyệt" */
	}
	
	.status-1 {
		background-color: #4caf50; /* Màu xanh cho "Đã duyệt" */
	}
	
	.post-socdo {
		display: inline-block;
		text-decoration: none;
		font-size: 12px;
	}
	
	.post-socdo:hover {
		color: #1976d2; /* Màu xanh đậm hơn khi hover */
	}
</style>

<script>
	function postToSocDo(id) {
		if (confirm('Bạn có chắc chắn muốn đăng sản phẩm này lên Sóc Đỏ?')) {
			$.ajax({
				url: '/ncc/process.php',
				type: 'post',
				data: {
					action: 'post_to_socdo',
					id: id
				},
				dataType: 'json',
				success: function(response) {
					if (response.ok == 1) {
						alert('Đăng sản phẩm lên Sóc Đỏ thành công!');
						window.location.reload(); // Tải lại trang để cập nhật trạng thái
					} else {
						alert('Lỗi: ' + response.thongbao);
					}
				},
				error: function() {
					alert('Đã có lỗi xảy ra, vui lòng thử lại!');
				}
			});
		}
	}
	</script>