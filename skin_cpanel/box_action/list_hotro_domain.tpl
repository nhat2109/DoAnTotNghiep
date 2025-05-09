<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
		<div class="page_title">
		    <h1 class="undefined">Danh sách yêu cầu hỗ trợ tên miền</h1>
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
				<th style="text-align: left;">Thành viên</th>
				<th style="text-align: left;">Điện thoại</th>
				<th style="text-align: left;">Phí hỗ trợ</th>
				<th style="text-align: left;">Trạng thái</th>
				<th style="text-align: left;">Thời gian</th>
				<th style="text-align: center;width: 100px;">Hành động</th>
			</tr>
			{list_hotro_domain}
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
            if($(this).attr('id')=='menu_mua_domain'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>