<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_timkiem">
        	<select name="chon_kho" id="chon_kho">
        		<option value="kho">Kho Hà Nội</option>
        		<option value="kho_hcm">Kho Tp.HCM</option>
        	</select>
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_sanpham" class="button_timkiem">Tìm kiếm</button>
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Sản phẩm sắp hết hàng</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: left;width: 150px;" class="hide_mobile">Mã Sản Phẩm</th>
				<th style="text-align: center;width: 80px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tên sản phẩm</th>
				<th style="text-align: center;width: 50px;" class="hide_mobile">Kho</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá drop</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá CTV</th>
				<th style="text-align: center;width: 140px;" class="hide_mobile">Giá bán tối thiểu</th>
				<th style="text-align: center;width: 80px;" class="hide_mobile">View</th>
				<th style="text-align: center;width: 160px;">Hành động</th>
			</tr>
			{list_sanpham}
		</table>
		{phantrang}
  	</div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_sanpham'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>