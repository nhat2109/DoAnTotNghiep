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
				  <th style="text-align: center;width: 120px;" class="hide_mobile">Mã</th>
				  <th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				  <th style="text-align: left;">Tên sản phẩm</th>
				  <th style="text-align: center;width: 100px;" class="hide_mobile">Giá Nhập</th>
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