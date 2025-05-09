<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_action_top">
  			<a href="/dropship/add-bom"><i class="fa fa-plus-circle"></i> Thêm mới</a>
  		</div>
  		<div class="box_timkiem">
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_bom" class="button_timkiem">Tìm kiếm</button>
  		</div>
  		<div style="clear: both;"></div>
		<div class="page_title">
		    <h1 class="undefined">Danh sách bom hàng</h1>
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
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: left;width: 150px">Người thêm</th>
				<th style="text-align: left; width: 150px;">Họ và tên</th>
				<th style="text-align: center;" class="hide_mobile">Điện thoại</th>
				<th style="text-align: left;" class="hide_mobile">Địa chỉ</th>
				<th style="text-align: left;width: 250px;">Tình trạng bom</th>
				<th style="text-align: center;">Hành động</th>
			</tr>
			{list_bom}
		</table>
		{phantrang}
  	</div>
  </div>
</div>