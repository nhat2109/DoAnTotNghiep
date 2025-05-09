

<div class="box_right">
	<div class="box_right_content">
	  <div class="box_profile" style="width: 100%;padding: 10px;">
		<div class="box_timkiem">
		  <select name="thuong_hieu" id="timkiem_ncc">
				<option value="">Nhà cung cấp</option>
				{option_ncc}
		  </select>
		  <select name="thuong_hieu" id="timkiem_status">
				<option value="">Trạng thái</option>
				<option value="0">Chờ duyệt</option>
				<option value="1">Đã duyệt</option>
			</select>
		  <input type="text" name="search" placeholder="Nhập từ khóa tìm kiếm" class="search_sanpham_ncc">
		</div>
		<div style="clear: both;"></div>
		<div class="page_title">
		  <h1 class="undefined">Danh sách sản phẩm NCC</h1>
		  <div class="line"></div>
		  <hr>
		</div>
		<table class="list_baiviet">
		  <tr>
			<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
			<th style="text-align: left;width: 150px;" class="hide_mobile">Mã Sản Phẩm</th>
			<th style="text-align: center;width: 80px;" class="hide_mobile">Minh họa</th>
			<th style="text-align: left;">Tên sản phẩm</th>
			<th style="text-align: center;width: 80px;" class="hide_mobile">Nhà cung cấp</th>  <!--//3-4-->
			<th style="text-align: center;width: 50px;" class="hide_mobile">Kho</th>
			<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
			<th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán Sóc Đỏ</th>
			<th style="text-align: center;width: 100px;" class="hide_mobile">Giá drop</th>
			<th style="text-align: center;width: 100px;" class="hide_mobile">Giá CTV</th>
			<th style="text-align: center;width: 140px;" class="hide_mobile">Giá bán tối thiểu</th>
			<th style="text-align: center;width: 160px;">Hành động</th>
		  </tr>
		  {list_sanpham_ncc}
		</table>
		{phantrang}
	  </div>
	</div>
  </div>
  <script type="text/javascript">
	$(document).ready(function(){
	  total_height = 0;
	  $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
		total_height += $(this).outerHeight();
		if($(this).attr('id') == 'menu_sanpham'){
		  vitri = total_height - 90;
		}
	  });
	  $('.box_menu_left').animate({scrollTop: vitri}, 1000);
  
	  // Xử lý lọc theo trạng thái
	  $('#status_filter').on('change', function(){
		var status = $(this).val();
		var url = '/admincp/list-sanpham';
		if (status !== '') {
		  url += '?status=' + status;
		}
		window.location.href = url;
	  });
  
	  // Đặt giá trị mặc định cho select dựa trên query string
	  var urlParams = new URLSearchParams(window.location.search);
	  var statusParam = urlParams.get('status');
	  if (statusParam) {
		$('#status_filter').val(statusParam);
	  }
	});

	function approveProduct(id) {
		if (confirm('Bạn có chắc chắn muốn duyệt sản phẩm này?')) {
		  $.ajax({
			url: '/admincp/process.php',
			type: 'post',
			data: {
			  action: 'approve_product',
			  id: id
			},
			dataType: 'json',
			success: function(response) {
			  if (response.ok == 1) {
				alert('Duyệt sản phẩm thành công!');
				window.location.reload(); // Tải lại trang để cập nhật danh sách
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
		background-color: #ff9800; /* Màu cam cho "Chờ duyệt" */
	  }
	  
	  .status-1 {
		background-color: #4caf50; /* Màu xanh cho "Đã duyệt" */
	  }
	  
	  .bg_blue {
		display: inline-block;
		padding: 5px 10px;
		margin-left: 5px;
		background-color: #2196f3; /* Màu xanh dương cho nút "Duyệt" */
		color: #fff;
		border-radius: 3px;
		text-decoration: none;
		font-size: 12px;
	  }
	  
	  .bg_blue:hover {
		background-color: #1976d2; /* Màu xanh đậm hơn khi hover */
	  }
  </style>