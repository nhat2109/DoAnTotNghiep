<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_timkiem">
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_thanhvien_drop" class="button_timkiem">Tìm kiếm</button>
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Danh sách đăng ký drop</h1>
		    <div style="clear: both;"></div>
		    <div class="line"></div>
		    <hr>
		</div>
		<div class="filter_section_drop">
                
			<label for="start_date_drop">Từ ngày:</label>
			<input type="date" id="start_date_drop" name="start_date_drop">
			
			<label for="end_date_drop">Đến ngày:</label>
			<input type="date" id="end_date_drop" name="end_date_drop">
			
			<button id="filter_button_drop" class="button_filter_drop">Lọc</button>
			
		</div>
		<style type="text/css">
		.list_baiviet i {
			font-size: 35px;
		}
		.filter_section_drop {
			margin: 15px 0;
		   text-align: center; 
		}
		.filter_section_drop label {
			margin-right: 5px;
		}
		</style>
		<style type="text/css">
			.list_baiviet i{
				font-size: 35px;
			}
			.list_baiviet tr td a {
				color: #495057 !important;
			}
			.list_baiviet tr {
				background: #ffffff;
				color: #495057 !important;
			}
		</style>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;" class="hide_mobile">Ngày</th>
				<th style="text-align: left;" class="hide_mobile">Người quản lý</th>
				<th style="text-align: left;width: 200px">Họ tên</th>
				<th style="text-align: left;" class="hide_mobile">Tài khoản</th>
				<th style="text-align: left;" class="hide_mobile">Chuyên nghiệp</th>
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