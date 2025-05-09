<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_timkiem" style="float: right;">
          <select name="chon_kho" id="chon_kho">
            <option value="kho">Kho Hà Nội</option>
            <option value="kho_hcm">Kho Tp.HCM</option>
          </select>
        	<select name="thuong_hieu" id="timkiem_thuonghieu_tuan">
        		<option value="">Thương hiệu</option>
        		{option_thuonghieu}
        	</select>
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_sanpham_tuan" class="button_timkiem">Tìm kiếm</button>
  		</div>
		<div class="page_title">
		    <h1 class="undefined">Chương trình tuần</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tên sản phẩm</th>
        <th style="text-align: left;width: 160px;">Thời gian</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Tồn kho</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá nhập</th>
        <th style="text-align: center;width: 160px;" class="hide_mobile">Giá chương trình tuần</th>
			</tr>
			{list_sanpham}
		</table>
		<div class="load_sanpham_tuan"><button page="1">Tải thêm</button></div>
  	</div>
  </div>
</div>
<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<script type="text/javascript" charset="utf-8">
    $(function() {
      var currentDate = new Date(),
          finished = false,
          availiableExamples = {
            set5ngay: 15 * 24 * 60 * 60 * 1000,
            set5phut  : 5 * 60 * 1000,
            set1phut  : 1 * 10 * 1000
          };         
        function call_flash(event) {
          $this = $(this);
            switch(event.type) {
                case "seconds":
                case "minutes":
                case "hours":
                case "days":
                case "weeks":
                case "daysLeft":
                  $this.find('.'+event.type).html(event.value);
                  if(finished) {
                    $this.fadeTo(0, 1);
                    finished = false;
                  }
                    break;
                case "finished":
            status=$this.attr('status');
            if(status==0){
              $this.find('.text_time').html('Kết thúc sau:');
              con=$this.attr('thoigian')*1000;
              $this.countdown(con + currentDate.valueOf(), call_flash);
              $this.attr('status',1);
            }else{
              $this.fadeTo('slow', .5);
              $this.html('Đã kết thúc');
              finished = true;              
            }
            break;
            }
        }
        $('.count_down').each(function(){
            con=$(this).attr('time')*1000;
            $(this).countdown(con + currentDate.valueOf(), call_flash);
        });
    });
  </script>