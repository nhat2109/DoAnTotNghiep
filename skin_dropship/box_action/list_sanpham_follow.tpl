<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_timkiem" style="float: right;">
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_sanpham_follow" class="button_timkiem">Tìm kiếm</button>
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Sản phẩm theo dõi</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<table class="list_baiviet">
            <tr>
                <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                <th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
                <th style="text-align: center;width: 120px;" class="hide_mobile">Mã sản phẩm</th>
                <th style="text-align: left;">Tên sản phẩm</th>
                <!-- <th style="text-align: center;width: 60px;" class="hide_mobile">Kích cỡ</th> -->
                <th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
                <th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán</th>
                <th style="text-align: center;width: 120px;" class="hide_mobile">Giá bán tối thiểu</th>
                <th style="text-align: center;width: 100px;">Giá nhập</th>
                <th style="text-align: center;width: 100px;" class="hide_mobile">Kho</th>
                <th style="text-align: center;width: 200px;">Hành động</th>
            </tr>
			{list_sanpham}
		</table>
		{phantrang}
  	</div>
  </div>
</div>