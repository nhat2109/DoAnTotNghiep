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
	                    <li class="active"><span>Đăng nhập</span></li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="home_box" style="margin-top: 20px;">
		<div class="container">
			<div class="title_box">
				<h2><a href="/dang-nhap.html" class="link">Đăng nhập tài khoản</a></h2>
			</div>
			<div class="tab_box">
				<div class="tab" style="padding-bottom: 10px;">
					<div class="box_login" style="width: 450px;">
						<div class="li_input">
							<label for="">Số điện thoại <span>*</span></label>
							<input type="text" name="email" placeholder="Nhập số điện thoại">
						</div>
						<div class="li_input">
							<label for="">Mật khẩu <span>*</span></label>
							<input type="password" name="password" placeholder="Nhập mật khẩu đăng nhập">
						</div>
						<div class="li_input">
							<button type="button" class="button_login" name="login">Đăng nhập</button>
						</div>
						<div class="li_input">
							<div class="text-center">
								<a href="/dang-ky.html">Đăng ký</a> | <a href="/quen-mat-khau.html">Quên mật khẩu?</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{footer}
	{script_footer}
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
	<script type="text/javascript" charset="utf-8">
	    $(function() {
	      var currentDate = new Date(),
	          finished = false,
	          availiableExamples = {
	            set5ngay: 15 * 24 * 60 * 60 * 1000,
	            set2gio: 2 * 60 * 60 * 1000,
	            set5phut  : 5 * 60 * 1000,
	            set1phut  : 1 * 60 * 1000
	          };
	      
	      function callback(event) {
	          $this = $(this);
	            switch(event.type) {
	                case "seconds":
	                case "minutes":
	                case "hours":
	                case "days":
	                case "weeks":
	                case "daysLeft":
	                  $this.find('#'+event.type).html(event.value);
	                  if(finished) {
	                    $this.fadeTo(0, 1);
	                    finished = false;
	                  }
	                    break;
	                case "finished":
	            $this.fadeTo('slow', .5);
	            finished = true;
	                    break;
	            }
	      }
	      
	        $('div#clock').countdown(availiableExamples.set2gio + currentDate.valueOf(), callback);
	    });
	</script>
</body>
</html>