<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
		<div class="page_title">
		    <h1 class="undefined">Lịch sử chi tiêu</h1>
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
				<th style="text-align: left;">Thời gian</th>
				<th style="text-align: left;">Thành viên</th>
				<th style="text-align: left;">Điện thoại</th>
				<th style="text-align: left;">Số tiền</th>
				<th style="text-align: left;width: 120px;">Số dư trước</th>
				<th style="text-align: left;width: 120px;">Số dư sau</th>
				<th style="text-align: left;">Nội dung chi tiêu</th>
			</tr>
			{list_chitieu}
		</table>
		{phantrang}
		<p style="font-style: italic;">Lưu ý: Số dư trước là tổng số tiền của tài khoản chính và tài khoản khuyến mại trước giao dịch.<br>Số dư sau là tổng số tiền của tài khoản chính và tài khoản khuyến mại sau giao dịch.</p>
  	</div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_naptien'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>