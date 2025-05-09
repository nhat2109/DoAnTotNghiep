<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
		<div class="page_title">
		    <h1 class="undefined">Danh sách bảo hành</h1>
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
				<th style="text-align: center;width: 80px;">Thời gian</th>
				<th style="text-align: center;width: 150px;">Họ và tên</th>
				<th style="text-align: center;width: 100px;">Điện thoại</th>
				<th style="text-align: center;width: 80px;">Mã coupon</th>
				<th style="text-align: center;width: 120px;">Thời hạn coupon</th>
				<th style="text-align: center;width: 150px;">Trạng thái</th>
				<th style="text-align: center;width: 120px;">Đơn hàng</th>
				<th style="text-align: left;">Ghi chú</th>
			</tr>
			{list_baohanh}
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
            if($(this).attr('id')=='menu_ruttien'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>