<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
        <div class="box_timkiem">
            <input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
            <button name="timkiem_thanhvien_nhom" nhom="{id}" class="button_timkiem">Tìm kiếm</button>
        </div>
		<div class="page_title">
		    <h1 class="undefined">Danh sách thành viên "{tieu_de}"</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<style type="text/css">
			.list_baiviet i{
				margin-right: 5px;
			}
		</style>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
				<th style="text-align: left;">Tài khoản</th>
				<th style="text-align: left;">Điện thoại</th>
				<th style="text-align: left;">Họ và tên</th>
				<th style="text-align: center;">Vai trò</th>
				<th style="text-align: center;">Tổng đơn hàng</th>
				<th style="text-align: center;">Tổng doanh số</th>
				<th style="text-align: center;width: 150px;">Hành động</th>
			</tr>
			{list_thanhvien}
		</table>
		{phantrang}
		<p style="text-align: center;font-style: italic;">Lưu ý: Số đơn hàng và doanh số không tính những <b>đơn hàng hủy</b> và <b>đơn hàng hoàn</b></p>
  	</div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_nhom'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>