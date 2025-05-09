<div class="box_right">
	<div class="box_right_content">
		<div class="box_profile" style="width: 100%;padding: 10px;">
			<div class="page_title">
				<h1 class="undefined">Danh sách cần duyệt</h1>
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
					<th style="text-align: left;">Tên thương hiệu</th>
					<th style="text-align: left;">Tên nhà cung cấp</th>
					<th style="text-align: left;">SĐT</th>
					<th style="text-align: center;" class="hide_mobile">Thứ tự</th>
					<th style="text-align: center;width: 100px;">Hành động</th>
				</tr>
				{list_brand_browse_ncc}
			</table>
			{phantrang_browse_ncc}
			<hr>
			<div class="page_title">
				<h1 class="undefined">Danh sách thương hiệu</h1>
				<div class="line"></div>
				   <hr>
		   </div>
		   <table class="list_baiviet">
				<tr>
					<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
					<th style="text-align: left;">Tên thương hiệu</th>
					<th style="text-align: left;"  class="hide_mobile">Ảnh thương hiệu</th>
					<th style="text-align: left;"  class="hide_mobile">link đi kèm ảnh</th>
					<th style="text-align: center;" class="hide_mobile">Thứ tự</th>
					<th style="text-align: center;"  class="hide_mobile">Hiển thị trang chủ</th>
					<th style="text-align: center;width: 100px;">Hành động</th>
				</tr>
				{list_brand}
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
			  if($(this).attr('id')=='menu_brand'){
				  vitri=total_height - 90;
			  }
		  });
		  $('.box_menu_left').animate({scrollTop: vitri}, 1000);
	  });
  </script>