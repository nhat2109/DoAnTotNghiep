{header}
<body class="body_scroll">
	{box_header}
    {banner_baohanh}
    <div class="box_baohanh">
        <div class="box_baohanh_content">
            <div class="title">Kích hoạt bảo hành</div>
            <div class="mota">
                Xin chào <b>Quý khách hàng</b><br>
                <b>Công ty cổ phần Sóc Đỏ</b> xin cảm ơn quý khách hàng đã tin tưởng và đặt mua sản phẩm trên hệ thống Sóc Đỏ
            </div>
            <div class="note_kh">Để đảm bảo quyền lợi, quý khách hàng vui lòng điền thông tin bên dưới để kích hoạt bảo hành điện tử.</div>
            <div class="form_baohanh">
                <div class="li_input">
                    <label>Họ và tên</label>
                    <input type="text" name="ho_ten" placeholder="Họ và tên (VD: Nguyễn Khắc Hiếu)">
                </div>
                <div class="li_input">
                    <label>Điện thoại</label>
                    <input type="text" name="dien_thoai" placeholder="Nhập số điện thoại bảo hành">
                </div>
                <div class="li_input">
                    <label>Tên sản phẩm/Mã vận đơn</label>
                    <input type="text" name="san_pham" placeholder="Nhập tên sản phẩm bảo hành">
                </div>
                <div class="li_input">
                    <label>File đơn hàng/Hình ảnh đăng ký xe máy/Ảnh bảo hiểm cũ</label>
                    <div class="list_file_bh" id="drop-zone">
                        <button class="button_file_bh"><i class="icon icon-image5"></i> Click để thêm file đơn hàng hoặc kéo thả vào đây</button>
                    </div>
                </div>
                <div class="list_button">
                    <input type="file" id="file-input" name="file_bh" style="display: none;">
                    <button name="save_baohanh">Kích hoạt bảo hành</button>
                </div>
            </div>
            <div class="text_s">
                Nếu quý khách cần hỗ trợ hoặc giải đáp các thắc mắc, vui lòng liên hệ <b>Hotline/Zalo: 0943.051.818</b><br>
                hoặc gửi email về hòm thư <b>socdogroup@gmail.com</b>
            </div>
        </div>
    </div>
    <script src="/carousel/owl.carousel.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            if($(window).width()<768){
                sl=1;
                sl_nb=3;
            }else{
                sl=2;
                sl_nb=10;
            }
            var slide_danhmuc_noibat = new Swiper('#slide_danhmuc_noibat', {
                // Optional parameters
                direction: 'horizontal',
                slidesPerView: sl_nb,
                slidesPerColumn: 2,
                slidesPerColumnFill: 'column',
                spaceBetween: 0,
                loop: false,
                observer: true,
                observeParents: true,
                autoplay: {
                    delay: 3000,
                }
            });
            $('.box_danhmuc_noibat').show();
            var slide_brand_top = new Swiper('.slide_brand_top', {
                // Optional parameters
                direction: 'horizontal',
                slidesPerView: sl,
                spaceBetween: 10,
                loop: true,
                observer: true,
                observeParents: true,
                // If we need pagination
                autoplay: {
                    delay: 5000,
                  },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.slide_brand_top .next',
                    prevEl: '.slide_brand_top .prev',
                },
            })
            $('.list_top_brand').show();
            var owl_trend=$('#slide_trend');
            owl_trend.owlCarousel({
                loop:true,
                margin:10,
                nav:true,
                autoplay:false,
                autoplayTimeout:3000,
                autoplayHoverPause:true,
                responsive:{
                    0:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
            })
            $('.next_trend').click(function() {
                owl_trend.trigger('next.owl.carousel');
            });
            $('.prev_trend').click(function() {
                owl_trend.trigger('prev.owl.carousel');
            });
        });
    </script>  
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
    if ($(window).width() < 480) {
       var sl=2;
       $('.box_top_index img').attr('src',$('.box_top_index img').attr('src-mobile'));
    }
    else {
       var sl=3;
    }
    var slide_product = new Swiper('.slide_product', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: sl,
        loop: true,
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
    <script>
    var tomorrow = new Date(); 
    var newdate = new Date();
    newdate.setDate(tomorrow.getDate() + 1);
    next_day = (newdate.getMonth()+1) + ' ' + newdate.getDate() + ', ' + newdate.getFullYear();
    var countDownDate = new Date(next_day+" 23:59:59").getTime();
    var x = setInterval(function() {
      var now = new Date().getTime();
      var distance = countDownDate - now;
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      if(hours<10){
        hours='0'+hours;
      }
      if(minutes<10){
        minutes='0'+minutes;
      }
      if(seconds<10){
        seconds='0'+seconds;
      }
      document.getElementById("ega-badge-ctd").innerHTML = '<div><div class="ega-badge-ctd__item ega-badge-ctd__h">'+hours+'</div><span>Giờ</span></div><div class="ega-badge-ctd__colon"> : </div><div><div class="ega-badge-ctd__item  ega-badge-ctd__m">'+minutes+'</div><span>Phút</span></div><div class="ega-badge-ctd__colon"> : </div><div><div class="ega-badge-ctd__item ega-badge-ctd__s">'+seconds+'</div><span>Giây</span></div>';
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("ega-badge-ctd").innerHTML = '<div><div class="ega-badge-ctd__item ega-badge-ctd__h">00</div><span>Giờ</span></div><div class="ega-badge-ctd__colon"> : </div><div><div class="ega-badge-ctd__item  ega-badge-ctd__m">00</div><span>Phút</span></div><div class="ega-badge-ctd__colon"> : </div><div><div class="ega-badge-ctd__item ega-badge-ctd__s">00</div><span>Giây</span></div>';
      }
    }, 1000);
    </script>
</body>
</html>