<div class="box_right">
	<div class="box_right_content">
		<div class="box_profile" style="width: 100%;padding: 10px;">
		  <div class="page_title">
			  <h1 class="undefined">Danh sách màu sản phẩm</h1>
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
				  <th style="text-align: left;">Tên màu</th>
				  <th style="text-align: left;">Mã màu</th>
				  <th style="text-align: center;" class="hide_mobile">Thứ tự</th>
				  <th style="text-align: center;width: 100px;">Hành động</th>
			  </tr>
			  {list_color}
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
			  if($(this).attr('id')=='menu_color'){
				  vitri=total_height - 90;
			  }
		  });
		  $('.box_menu_left').animate({scrollTop: vitri}, 1000);
	  });
  </script>