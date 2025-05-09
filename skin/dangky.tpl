{header}
<body>
	{box_header}
	<div class="bread-crumb mb-3">
	    <span class="crumb-border"></span>
	    <div class="container">
	        <div class="row">
	            <div class="col-12 a-left">
	                <ul class="breadcrumb m-0 px-0" itemscope="" itemtype="http://schema.org/BreadcrumbList">
	                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
	                        <a href="/" target="_self" itemprop="item"><span itemprop="name">Trang chủ</span></a>
	                        <meta itemprop="position" content="1">
	                        <span class="mr_lr">&nbsp;/&nbsp;</span>
	                    </li>
	                    <li>
	                        <a href="/tai-khoan.html" target="_self">
	                            <span> Tài khoản </span></a>
	                        <span class="mr_lr">&nbsp;/&nbsp;</span>
	                    </li>
	                    <li class="active"><span>Đăng ký</span></li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="home_box" style="margin-top: 20px;">
		<div class="container">
			<div class="title_box">
				<h2><a href="/dang-ky.html" class="link">Đăng ký tài khoản</a></h2>
			</div>
			<div class="tab_box">
				<div class="tab" style="padding-bottom: 10px;">
					<div class="box_login" style="width: 450px;padding: 10px;">
						<div class="li_input">
							<label for="">Họ và tên <span>*</span></label>
							<input type="text" name="ho_ten" placeholder="Nhập họ và tên của bạn">
						</div>
						<div class="li_input">
							<label for="">Điện thoại <span>*</span></label>
							<input type="text" name="dien_thoai" placeholder="Nhập số điện thoại của bạn">
						</div>
						<div class="li_input">
							<label for="">Mật khẩu <span>*</span></label>
							<input type="password" name="password" placeholder="Nhập mật khẩu đăng nhập">
						</div>
						<div class="li_input">
							<label for="">Nhập lại mật khẩu <span>*</span></label>
							<input type="password" name="re_password" placeholder="Nhập lại mật khẩu đăng nhập">
						</div>
<!-- 						<div class="li_input">
							<label for="">Mã xác nhận <span>*</span></label>
							<div class="list_col">
								<div class="col left" style="width: 55%;">
									<input type="text" name="ma_xacnhan" placeholder="Nhập mã xác nhận">
								</div>
								<div class="col right" style="width: 45%;">
									<button id="get_opt" class="timer_countdown" time="60" style="width: 160px;">Lấy mã xác nhận</button>
								</div>
							</div>
						</div> -->
						<div class="li_input">
							<button type="button" class="button_login" name="dangky">Đăng ký</button>
						</div>
						<div class="li_input">
							<div class="text-center">
								<a href="/dang-nhap.html">Đăng nhập</a> | <a href="/quen-mat-khau.html">Quên mật khẩu?</a>
							</div>
						</div>
<!--                         <div class="li_input">
                            <div class="text"><b>Lưu ý:</b><br> + Mã xác nhận sẽ được gửi tới số điện thoại đăng ký tài khoản.<br>+ Sau khi yêu cầu lấy mã xác nhận vui lòng đợi ít phút để nhận mã.<br> 
                                <span class="blink">+ Liên hệ bộ phận hỗ trợ qua hotline hoặc zalo <b>0943 051 818</b>.</span></div>
                        </div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	{footer}
	{script_footer}
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
                    /*$this.fadeTo('slow', .5);*/
                    $this.html('Lấy mã xác nhận');
                finished = true;
                        break;
                }
            }
            $('.timer_countdown').each(function(){
            	con=$(this).attr('time')*1000;
                $(this).countdown(con + currentDate.valueOf(), call_flash);
            });
        });
      </script>
    <script>
    var slide_recent = new Swiper('.slide_category', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 5,
        loop: true,
        observer: true,
        observeParents: true,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
          },
        // Navigation arrows
        navigation: {
            nextEl: '.slide_category .next',
            prevEl: '.slide_category .prev',
            disabledClass: 'hide_button',
            hiddenClass: 'hide_button'
        },
    })
    var slide_product = new Swiper('.slide_product', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 3,
        loop: false,
        observer: true,
        observeParents: true,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        // Navigation arrows
        navigation: {
            nextEl: '.slide_product .next',
            prevEl: '.slide_product .prev',
            disabledClass: 'hide_button',
            hiddenClass: 'hide_button'
        },
    })
    var slide_banner = new Swiper('.slide_top', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 1,
        loop: true,
        observer: true,
        observeParents: true,
        // If we need pagination
        autoplay: {
            delay: 3000,
          },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        // Navigation arrows
        navigation: {
            nextEl: '.box_slide .next',
            prevEl: '.box_slide .prev',
        },
    })
    </script>
</body>
</html>