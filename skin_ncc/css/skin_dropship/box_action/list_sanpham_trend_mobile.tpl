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
  			<button name="timkiem_sanpham_trend" class="button_timkiem" kieu="mobile">Tìm kiếm</button>
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Danh sách sản phẩm Trend</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<div class="list_sanpham">
    {list_sanpham}  
    </div>
		<div class="load_sanpham_trend"><button page="1">Tải thêm</button></div>
  	</div>
  </div>
</div>