<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_timkiem">
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_thanhvien_drop" class="button_timkiem">Tìm kiếm</button>
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Danh sách tài khoản tạm khóa</h1>
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
				<th style="text-align: left;width: 200px">Họ tên</th>
				<th style="text-align: left;" class="hide_mobile">Tài khoản</th>
				<th style="text-align: center;" class="hide_mobile">Điện thoại</th>
				<th style="text-align: center;" class="hide_mobile">TK chính</th>
				<th style="text-align: center;" class="hide_mobile">TK Khuyến mại</th>
				<th style="text-align: center;width: 350px;">Tình trạng</th>
			</tr>
			{list_thanhvien}
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
            if($(this).attr('id')=='menu_thanhvien'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>