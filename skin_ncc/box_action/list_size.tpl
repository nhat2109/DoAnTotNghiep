<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
		<div class="page_title">
		    <h1 class="undefined">Danh sách kích cỡ</h1>
		    <div class="line"></div>
		    <div style="margin-top: 10px;float: inline-end;">
				<label><input type="checkbox" id="selectAll"> Chọn tất cả</label>
				<button id="deleteSelected" class="button_timkiem" style="margin-left: 10px; background-color: red;">Xóa đã chọn</button>
			</div>
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
				<th style="text-align: center;">Tên kích cỡ</th>
				<th style="text-align: center;" class="hide_mobile">Thứ tự</th>
				<th style="text-align: center;width: 100px;">Hành động</th>
				<th style="text-align: center;width: 50px;">Chọn</th>
			</thead>
			{list_size}
		</table>
		{phantrang}	
  	</div>
  </div>
</div>