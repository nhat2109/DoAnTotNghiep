<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_timkiem">
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Danh sách hoa hồng nhóm</h1>
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
				<th style="text-align: center;width: 150px">Mã đơn</th>
				<th style="text-align: center;width: 150px">Ngày</th>
				<th style="text-align: center;width: 150px">Loại đơn</th>
				<th style="text-align: center;">Tài khoản</th>
				<th style="text-align: center;">Tạm tính</th>
				<th style="text-align: center;">Hoa hồng</th>
				<th style="text-align: center;">Loại hoa hồng</th>
				<th style="text-align: center;">Tình trạng</th>
				<th style="text-align: center;">Ngày thanh toán</th>
				<th style="text-align: center;width: 150px;">Hành động</th>
			</tr>
			{list_hoahong}
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