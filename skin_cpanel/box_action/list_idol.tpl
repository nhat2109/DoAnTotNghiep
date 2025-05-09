<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
		<div class="page_title">
		    <h1 class="undefined">Danh sách idol</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Ảnh đại diện</th>
				<th style="text-align: left;width: 150">Họ và tên</th>
				<th style="text-align: center;" class="hide_mobile">Năm sinh</th>
				<th style="text-align: center;" class="hide_mobile">Chiều cao</th>
				<th style="text-align: center;" class="hide_mobile">Cân nặng</th>
				<th style="text-align: center;" class="hide_mobile">Khung giờ</th>
				<th style="text-align: center;" class="hide_mobile">Ngân sách</th>
				<th style="text-align: center;" class="hide_mobile">Trạng thái</th>
				<th style="text-align: center;width: 160px;">Hành động</th>
			</tr>
			{list_idol}
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
            if($(this).attr('id')=='menu_livestream'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>