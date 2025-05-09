<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_timkiem" style="float: right;">
          <select name="chon_kho" id="chon_kho">
            <option value="kho">Kho Hà Nội</option>
            <option value="kho_hcm">Kho Tp.HCM</option>
          </select>
        	<select name="thuong_hieu" id="timkiem_thuonghieu_trend">
        		<option value="">Thương hiệu</option>
        		{option_thuonghieu}
        	</select>
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_sanpham_trend" class="button_timkiem" kieu="laptop">Tìm kiếm</button>
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Danh sách sản phẩm Trend</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tên sản phẩm</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Tồn kho</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá nhập</th>
				<th style="text-align: center;width: 160px;" class="hide_mobile">Giá bán tối thiểu</th>
        <th style="text-align: center;width: 160px;" class="hide_mobile">Giá bán gợi ý</th>
				<th style="text-align: center;width: 180px;">Hành động</th>
			</tr>
			{list_sanpham}
		</table>
		<div class="load_sanpham_trend"><button page="1">Tải thêm</button></div>
  	</div>
  </div>
</div>