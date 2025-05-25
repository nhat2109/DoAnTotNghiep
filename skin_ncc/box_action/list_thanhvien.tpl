<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_timkiem">
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_thanhvien" class="button_timkiem">Tìm kiếm</button>
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Danh sách thành viên</h1>
		    <div style="clear: both;"></div>
		    <div class="line"></div>
		    <hr>
		</div>
		<style type="text/css">
			.list_baiviet i{
				font-size: 35px;
			}
		</style>
		<table class="list_baiviet">
			<thead>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: left;">ID</th>
				<th style="text-align: left;">Họ tên</th>
				<th style="text-align: center;" class="hide_mobile">Email</th>
				<th style="text-align: center;" class="hide_mobile">Tình trạng</th>
				<th style="text-align: center;" class="hide_mobile">Đăng ký</th>
				<th style="text-align: center;width: 140px;">Hành động</th>
			</thead>
			{list_thanhvien}
		</table>
		{phantrang}
  	</div>
  </div>
</div>