<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
      <div class="list_thuonghieu add_sanpham">
        <div class="swiper-container slide_thuonghieu">
            <div class="swiper-wrapper">
                {list_banner_qc}
            </div>
        </div>
      </div>
  		<div class="box_timkiem" style="float: right;">
          <div class="sanpham_trend"><a href="/dropship/list-sanpham-trend">Click : Sản phẩm Trend để bán</a></div>
          <select name="chon_kho" id="chon_kho">
            <option value="kho">Kho Hà Nội</option>
            <option value="kho_hcm">Kho Tp.HCM</option>
          </select>
        	<select name="thuong_hieu" id="timkiem_thuonghieu_add">
        		<option value="">Thương hiệu</option>
        		{option_thuonghieu}
        	</select>
  			<input type="text" name="key" placeholder="Nhập từ khóa tìm kiếm">
  			<button name="timkiem_sanpham" class="button_timkiem" kieu="laptop">Tìm kiếm</button>
  		</div>
      <div class="info_thuonghieu">
          <div class="cover_thuonghieu">
              <img src="">
          </div>
          <div class="noidung_thuonghieu"></div>
          <div class="menu_thuonghieu"><span><i class="fa fa-times-circle-o"></i> Đóng lại</span></div>
      </div>
		<div class="page_title">
		    <h1 class="undefined">Thêm sản phẩm mới</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tên sản phẩm</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Tồn kho</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">Giá nhập</th>
				<th style="text-align: center;width: 160px;" class="hide_mobile">Giá bán tối thiểu</th>
				<th style="text-align: center;width: 180px;">Hành động</th>
			</tr>
			{list_sanpham}
		</table>
		<div class="load_sanpham"><button page="1">Tải thêm</button></div>
  	</div>
  </div>
</div>
<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            $('.list_thuonghieu').show();
            var slide_thuonghieu = new Swiper('.slide_thuonghieu', {
                // Optional parameters
                direction: 'horizontal',
                slidesPerView: 5,
                loop: true,
                observer: true,
                observeParents: true,
                // If we need pagination
                autoplay: {
                    delay: 3000,
                  },
                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                // Navigation arrows
                navigation: {
                    nextEl: '.slide_thuonghieu .next',
                    prevEl: '.slide_thuonghieu .prev',
                    disabledClass: 'hide_button',
                    hiddenClass: 'hide_button'
                },
            });
        },1000);
    });
</script>