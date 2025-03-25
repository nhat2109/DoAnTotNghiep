<!DOCTYPE html>

<html lang="vi">
<!-- Header -->
{header}
<!-- style mau -->
<style>
  .disabled-link {
      pointer-events: none; /* Vô hiệu hóa tất cả sự kiện chuột */
      cursor: default; /* Đổi con trỏ chuột thành mặc định */
      text-decoration: none; /* Loại bỏ gạch chân */
      color: inherit; /* Giữ màu như phần tử cha */
  }
</style>
<style>
  
  .heading-bar__title .ega-dot {
    position: relative;
    width: 10px;
    height: 10px;
    background-color: #f00;
    border-radius: 100%;
    margin: 0 20px 0px;
    display: inline-block;
    background-color: #ff4949;
    top: 13px;
    float: right;
}

  .btn-slide--new .ss_img picture img {
    width: 50% !important;
    /* Kích thước khung vuông */
    height: 50% !important;
    /* Kích thước khung vuông */
    border-radius: 50% !important;
    /* Làm tròn ảnh */
    object-fit: cover !important;
    /* Cắt ảnh để vừa khung */
    object-position: center !important;
  }
  

  .ss_item.style2 {
    z-index: 11;
    border-radius: 10px;

    width: 203.6px;
  }

  .list-group .list-group-item .mega-menu {
    height: 200%;
  }

  .swatch-div {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .swatch {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
  }

  .swatch .header {
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
  }

  .select-swap {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .n-sd {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
  }

  .n-sd input[type="radio"] {
    display: none;
  }

  .n-sd label {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: all 0.3s;
  }

  .n-sd label:hover {
    border-color: #000;
    background-color: #f5f5f5;
  }

  .n-sd label img {
    width: 20px;
    height: 20px;
  }

  .n-sd input[type="radio"]:checked+label {
    border-color: #007bff;
    background-color: #e9f5ff;
  }

  .n-sd input[type="radio"]:checked+label .img-check img {

    display: none;
  }

  .n-sd input[type="radio"]:checked+label .crossed-out {
    display: none;
  }

  .crossed-out {
    opacity: 0.6;
    filter: grayscale(100%);
  }

  .img-check {
    display: none;
  }

  .swatch-element {
    position: relative;
    /**margin: 8px 10px 0px 0px; **/
  }

  .swatch-element:not(.color) {
    overflow: hidden;
  }

  .swatch-element-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }

  .swatch-div {
    margin-bottom: 30px;
  }

  .swatch-element.color {
    /**margin: 8px 15px 0px 0px;**/
  }

  .swatch-element.color .xanh-den {
    background-color: #2e314e;
  }

  .swatch-element.color .xanh-den.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_1.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .den {
    background-color: #111112;
  }

  .swatch-element.color .den.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_2.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .kem {
    background-color: #f8f6f1;
  }

  .swatch-element.color .kem.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_3.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .hong {
    background-color: #f5cac8;
  }

  .swatch-element.color .hong.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_4.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .nau-nhat {
    background-color: #a77862;
  }

  .swatch-element.color .nau-nhat.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_5.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .nau-dam {
    background-color: #4e2c29;
  }

  .swatch-element.color .nau-dam.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_6.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .xanh-la {
    background-color: #93c062;
  }

  .swatch-element.color .xanh-la.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_7.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .cam {
    background-color: #f8632e;
  }

  .swatch-element.color .cam.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_8.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .do {
    background-color: #ec042f;
  }

  .swatch-element.color .do.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_9.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color .trang {
    background-color: #f1f0f1;
  }

  .swatch-element.color .trang.image-type {
    background: url(//bizweb.dktcdn.net/100/491/756/themes/956460/assets/color_10.png?1727322848954) no-repeat center center;
    background-size: cover;
  }

  .swatch-element.color+.tooltip {
    z-index: -1;
    white-space: nowrap;
  }

  .swatch-element.color:hover+.tooltip {
    opacity: 1;
    z-index: 100;
    top: -30px;
    min-width: 30px;
    background: #000;
    color: #fff;
    padding: 4px 6px;
    font-size: 10px;
    border-radius: 4px;
  }

  .swatch-element.color:hover+.tooltip:after {
    content: "";
    position: absolute;
    left: 16px;
    bottom: -3px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 3px 2.5px 0 2.5px;
    border-color: #000 transparent transparent transparent;
  }

  .swatch-element.color:hover label {
    box-shadow: 0 0 0 1px #000, inset 0 0 0 4px #fff;
    transform: scale(1.1);
  }

  .swatch-element label {
    padding: 10px;
    font-size: 14px;
    border-radius: 6px;
    height: 30px !important;
    min-width: auto !important;
    white-space: nowrap;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .swatch-element input {
    width: 100%;
    height: 100%;
    opacity: 0;
    position: absolute;
    z-index: 3;
    top: 0;
    left: 0;
    cursor: pointer;
  }

  .swatch .swatch-element:not(.color) input:checked+label {
    border-color: var(--primary-color) !important;
    color: var(--primary-color);
    position: relative;
  }

  .swatch .swatch-element:not(.color) input:checked+label:after {
    content: "";
    background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfkCw8RJSHXzNuNAAAAfElEQVQoz7WRsQ2CYBQGLwRCaLRkDwqdwcLCSZjCmj2AgtoJXMbEUquzEAz+8Je89r675sGG59ka0ig+0ZFbJDGbgRwoAXemi/hb1QZw793ebB739cPgTdV2qvzZAFY+VL+VwB4nB59j5RLYhBVXcTBZw7NJDAN49LrFyz67GnkMHStx0wAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0xMS0xNVQxNzozNzozMyswMDowMGfDTJEAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMTEtMTVUMTc6Mzc6MzMrMDA6MDAWnvQtAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAABJRU5ErkJggg==");
    background-repeat: no-repeat;
    background-size: contain;
    position: absolute;
    top: 0px;
    right: 0;
    width: 6px;
    height: 6px;
  }

  .swatch .swatch-element:not(.color) input:checked+label:before {
    content: "";
    padding: 4px;
    font-size: 10px;
    line-height: 1;
    position: absolute;
    top: -15px;
    right: -13px;
    background: var(--primary-color);
    width: 26px;
    height: 24px;
    transform: rotate(45deg);
    border-radius: 100%;
  }

  .swatch .color label {
    width: 33px;
    min-width: unset !important;
    height: 33px !important;
    line-height: 33px !important;
    border-radius: 6px !important;
    border: 1px solid #eee;
  }

  .swatch .color label:before {
    content: none;
  }

  .swatch {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }

  .swatch .header {
    font-weight: bold;
    color: #333;
    flex: 0 0 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .swatch .color label {
    position: relative;
    z-index: 2;
    border-radius: 100% !important;
    transition: box-shadow 0.25s ease, transform 0.25s ease;
    border: none;
  }

  .swatch .color span {
    content: "";
    position: absolute;
    width: calc(100% + 1px);
    height: calc(100% + 1px);
    border-radius: 100%;
    background: #fff;
    top: 50%;
    left: 50%;
    z-index: 0;
    transform: translate(-50%, -50%);
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
  }

  .swatch .color input:checked+label {
    box-shadow: 0 0 0 1px #000, inset 0 0 0 4px #fff;
  }

  .swatch .color input:checked~span {
    opacity: 1;
    border: 1px solid #ccc;
  }

  .quick-view-product .swatch {
    padding: var(--block-spacing) 0;
  }

  .item_product_main .swatch-element.color {
    margin-right: 5px;
    margin-top: 5px;
  }

  .item_product_main .swatch .color label {
    width: 26px;
    height: 26px !important;
    line-height: 26px !important;
    padding: 0;
  }

  .swatch-color .swatch-element.color:hover+.tooltip {
    opacity: 1;
    z-index: 100;
    min-width: 30px;
    background: #000;
    color: #fff;
    padding: 4px 12px;
    border-radius: 4px;
    top: auto;
    bottom: calc(100% + 12px);
    left: calc(50%);
    transform: translateX(-50%);
    font-size: 12px;
  }

  .swatch-color .swatch-element.color:hover+.tooltip:after {
    border-style: solid;
    border-width: 3px 2.5px 0 2.5px;
    border-color: #000 transparent transparent transparent;
    background: #333333;
    content: "";
    height: 8px;
    position: absolute;
    transform: rotate(45deg);
    width: 8px;
    left: calc(50% - 4px);
    bottom: -4px;
  }

  span.swatch-value {
    font-weight: normal;
    font-size: 14px;
  }
</style>
<!-- js coupon -->

<body id="template-index">
  <div class="opacity_menu"></div>
  <!-- <link rel="preload" as="style" type="text/css" href="/skin_shop/skin_7_nhat/tpl/css/header.css" /> -->
  <!-- <link rel="stylesheet" href="/skin_shop/skin_7_nhat/tpl/css/header.css" /> -->
  {box_banner}
  <style>
    /* Mobile: Hiển thị 2 phần tử trên 1 dòng */
    @media (max-width: 768px) {
      .heading-bar__title .ega-dot {
        position: relative;
        width: 10px;
        height: 10px;
        background-color: #f00;
        border-radius: 100%;
        margin: 0 20px 0px;
        display: inline-block;
        background-color: #ff4949;
        top: -17px;
        left: 20px;
        float: right;
    }
      .js-slider {
        display: flex;
        flex-wrap: wrap;
        /* Cho phép các phần tử bọc dòng */
        justify-content: space-between;
        /* Căn giữa các phần tử trong dòng */
      }

      .js-slider .col-6 {
        width: 48%;
        /* Mỗi phần tử chiếm 48% chiều rộng */
        margin-bottom: 15px;
        /* Thêm khoảng cách giữa các phần tử */
      }

      .col-xl-3_lienquan {
        -ms-flex: 0 0 100%;
        flex: 0 0 50%;
        max-width: 50%;
      }

      .ss_item.style2 .ss_img img {
        --image-scale: 1.2 !important;
        position: absolute;
        top: var(--img-top, 50%);
        left: var(--img-left, 50%);
        transform: translate(-50%, -50%) scale(var(--image-scale));
        object-fit: contain;
        max-width: 145%;
        max-height: 103%;
        min-width: 1px;
        min-height: 1px;
      }
    }

    .ss_item.style2 .ss_img img {
      --image-scale: 1.6;
      position: absolute;
      top: var(--img-top, 50%);
      left: var(--img-left, 50%);
      transform: translate(-50%, -50%) scale(var(--image-scale));
      object-fit: contain;
      max-width: 145%;
      max-height: 103%;
      min-width: 1px;
      min-height: 1px;
    }

    .section_ss_collection .ss_img picture {
      width: 150px;
      /* Đặt kích thước ảnh */
      height: 150px;
      /* Kích thước phải bằng nhau */
      border-radius: 50%;
      /* Làm tròn ảnh */
      object-fit: cover;
      /* Cắt ảnh để phù hợp với khung tròn */
    }
  </style>

  <!-- Box_header -->
  {box_header}
  <!-- Box_slide -->
  <!-- Slide   -->
  <section class="section awe-section-1 section-section_slider">
    <div class="section_slider clearfix">
      <div class="">
        <div class="home-slider btn-slide--new">{list_slide}</div>
      </div>
    </div>
  </section>
  <!-- Box_category -->
  <section class="section awe-section-2 section-section_season_coll">
    <section class="section_ss_collection section">
      <div class="container border-0">
        <h2 class="heading-bar__title">DANH MỤC SẢN PHẨM</h2>
        <div class="ss_body">
          <div class="row mx-0 hrz-scroll text-center flex-nowrap js-slider justify-content-around btn-slide--new">
            {list_box_index}

          </div>
        </div>
      </div>
    </section>
  </section>
<style>
  .scroll_s-container {
    width: 100%;
    overflow: hidden;
}

.scroll_s {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  gap: 10px;
  scrollbar-width: none;
  -ms-overflow-style: none;
  padding-left: 160px; /* Thêm khoảng trống 100px đầu */
  margin: 0;
}


/* Ẩn thanh cuộn trên Chrome, Safari */
.scroll_s::-webkit-scrollbar {
    display: none;
}

.coupon-item-wrap {
    flex: 0 0 auto;
    min-width: 250px; /* Kích thước tối thiểu */
    min-height: 220px;
    padding: 0;
    margin: 0;
    box-sizing: border-box; /* Đảm bảo padding và border không làm tăng kích thước */
    position: relative; /* Đảm bảo không bị ảnh hưởng bởi các thuộc tính position khác */
}

</style>
  <!-- Box_coupons -->
  {box_coupons}
  <!-- Box_flashsales -->
  <section class="section_flashsale flashsale">
    <!-- <link rel="preload" as="style" type="text/css" href="//bizweb.dktcdn.net/100/491/756/themes/956460/assets/flashsale.css?1727322848954" /> -->

    <!-- <link rel="stylesheet" href="//bizweb.dktcdn.net/100/491/756/themes/956460/assets/flashsale.css?1727322848954" /> -->

    <noscript>
      <!-- <link href="//bizweb.dktcdn.net/100/491/756/themes/956460/assets/flashsale.css?1727322848954" rel="stylesheet" type="text/css" media="all" /> -->
    </noscript>

    {box_flash_sale}

    {list_chungnhan}

    <section class="section_product_top section">

      <div class="container card border-0">
        <div class="slideshow-banner-wrap">
          <div class="module-product">
            {list_box_index_1}
          </div>
        </div>
      </div>

    </section>


  </section>

  <!-- Box_brand -->
  <!-- {box_brand} -->
  <!-- Box_lookbook -->
  {box_lookbook}
  <!-- Box_lookbook_2 -->
  <!-- {box_lookbook_2} -->
  <!-- Box_producttops -->
  <!-- {box_producttops} -->
  <!-- Box_imagetext -->
  {box_imagetext}
  <!-- Box_moudleproduct -->
  <!-- {box_moudleproduct} -->
  <!-- Box_tikok_slide -->
  <!-- {box_tikok_slide} -->
  <!-- Box_insta -->
  <!-- {box_insta} -->

  <!-- Box_video -->
  <!-- {box_video} -->
  <!-- Box_Feedback -->
  <!-- {box_Feedback} -->

  <!-- Box_blog -->
  <section class="section awe-section-15 section-section_blog">
    <div class="section_blog">
      <div class="container">
        <div class="title_module_main d-flex justify-content-between px-0">
          <h2 class="heading-bar__title" style="color: #000000">
            <a class="link" href="/tin-tuc.html" title="GÓC CẢM HỨNG">GÓC CẢM HỨNG</a>
          </h2>
          <a href="/tin-tuc.html" title="Xem tất cả" class="btn">
            Xem tất cả
          </a>
        </div>
        <div class="section__blogs">
          <div class="row blog-list blog-list-custom blog-size-9 section-news">
            <!-- <div class="list_tintuc_index"> -->
            {list_tintuc}
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Box_policies -->
  {box_policies}

  <script>
    var egaLookBook = {
      slider: function () {
        $(
          ".section_lookbook:not(.lookbook--oneproduct) .lookbooks-container"
        ).slick({
          autoplay: false,
          autoplaySpeed: 6000,
          dots: false,
          arrows: true,
          infinite: false,
          speed: 300,
          slidesToShow: 5,
          slidesToScroll: 5,
          centerMode: false,
          responsive: [
            {
              breakpoint: 1199,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
              },
            },
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
              },
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              },
            },
          ],
        });
      },
      popover: function () {
        $('.popover-dot[data-toggle="popover"]').popover({
          html: true,
          animation: true,
          placement: function (popover, trigger) {
            var placement = jQuery(trigger).attr("data-placement");
            var dataClass = jQuery(trigger).attr("data-class");
            jQuery(trigger).addClass("is-active");
            jQuery(popover).addClass(dataClass);
            return placement;
          },
          content: function () {
            var elementId = $(this).attr("data-popover-content");
            return $(elementId).html();
          },
        });
        setTimeout(function () {
          $(".lookbooks-1 .popover-dot:eq(0)").click();
        }, 3000);
        jQuery("body").on(
          "click",
          '.popover-dot[data-toggle="popover"]',
          function (e) {
            $('.popover-dot[data-toggle="popover"]').each(function () {
              if (
                !$(this).is(e.target) &&
                $(this).has(e.target).length === 0 &&
                $(".popover").has(e.target).length === 0
              ) {
                $(this).popover("hide");
              }
            });
          }
        );
        $("body").on("hidden.bs.popover", function (e) {
          $(e.target).data("bs.popover").inState = {
            click: false,
            hover: false,
            focus: false,
          };
        });
      },
      getLookBook: function (element) {
        try {
          var idList = [
            32001438, 32031667, 32001432, 36579028, 32001426, 32001454,
            36595070, 36579028, 36579018,
          ];
          if (idList && idList.length && Array.isArray(idList)) {
            let filter = `(${idList.join(" OR ")})`;
            $.ajax({
              
              success: function (data) {
                if (data && data.length) {
                  let wrapper = $(element);
                  wrapper.html(data);
                } else {
                  $(element).remove();
                }
              },
            });
          } else {
            $(element).remove();
          }
        } catch (e) {
          console.log(e);
          $(element).remove();
        }
      },
    };
  </script>
  <!-- Section_footer -->
  {footer}
  <!-- Banner model khi bắt đầu trang -->
  
  <!-- chưa biết để làm gì -->
  <script type="text/x-custom-template" data-template="navigation">

      <nav>
      <ul  class="navigation navigation-horizontal list-group list-group-flush scroll">



      			<li class="menu-item list-group-item">
      		<a href="/collections/all"

      		   class="menu-item__link" title="Sản phẩm">
      									<span>
      			Sản phẩm</span>

      			<i class='float-right' data-toggle-submenu>


      <svg class="icon" >
      	<use xlink:href="#icon-arrow" />
      </svg>			</i>


      			</a>





      										<div class="submenu scroll  mega-menu ">
      			<div class='toggle-submenu d-lg-none d-xl-none'>
      				<i class='mr-3'>


      <svg class="icon" style="transform: rotate(180deg)"
      >
      	<use xlink:href="#icon-arrow" />
      </svg>				</i>
      				<span>Sản phẩm </span>
      			</div>
      			<ul class="submenu__list container">



      			<li class="submenu__col">
      				<span class="submenu__item submenu__item--main">
      					<a

      					   class="link" href="/san-pham-moi" title="Nội thất">Nội thất</a>
      				</span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Sofa phòng khách">Sofa phòng khách</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Bàn ăn">Bàn ăn</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Ghế ăn">Ghế ăn</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Tủ và giá đỡ">Tủ và giá đỡ</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Nội thất sân vưởn">Nội thất sân vưởn</a>
      				 </span>

      			</li>




      			<li class="submenu__col">
      				<span class="submenu__item submenu__item--main">
      					<a

      					   class="link" href="/den-trang-tri" title="Đèn trí">Đèn trang trí</a>
      				</span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Đèn ngoài trời">Đèn ngoài trời</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Đèn tường">Đèn tường</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Đèn bàn">Đèn bàn</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Đèn trần">Đèn trần</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Phụ kiện chống sét">Phụ kiện chống sét</a>
      				 </span>

      			</li>




      			<li class="submenu__col">
      				<span class="submenu__item submenu__item--main">
      					<a

      					   class="link" href="/tu-giay-tu-trang-tri" title="Vật dụng trong nhà">Vật dụng trong nhà</a>
      				</span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Gương">Gương</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Móc và giá treo áo">Móc và giá treo áo</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Phụ kiện nhà bếp">Phụ kiện nhà bếp</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Chân nến và đèn lồng">Chân nến và đèn lồng</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="Bình hoa">Bình hoa</a>
      				 </span>

      			</li>




      			<li class="submenu__col">
      				<span class="submenu__item submenu__item--main">
      					<a

      					   class="link" href="/ban-ghe-an" title="Bộ sưu tập">Bộ sưu tập</a>
      				</span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="MỚI! Nâng cao nỗi nhớ">MỚI! Nâng cao nỗi nhớ</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="BST Nỗi nhớ">BST Nỗi nhớ</a>
      				 </span>

      				 <span class="submenu__item submenu__item">
      					 <a

      						class="link" href="/" title="BST Bước ngoặc">BST Bước ngoặc</a>
      				 </span>

      			</li>


      		</ul>
      		</div>
      			</li>



      			<li class="menu-item list-group-item">
      		<a href="/collections/all"

      		   class="menu-item__link" title="Phòng">
      									<span>
      			Phòng</span>

      			<i class='float-right' data-toggle-submenu>


      <svg class="icon" >
      	<use xlink:href="#icon-arrow" />
      </svg>			</i>


      			</a>




      							<div class="submenu scroll  default ">
      			<div class='toggle-submenu d-lg-none d-xl-none'>
      				<i class='mr-3'>


      <svg class="icon" style="transform: rotate(180deg)"
      >
      	<use xlink:href="#icon-arrow" />
      </svg>				</i>
      				<span>Phòng </span>
      			</div>
      			<ul class="submenu__list container">



      			<li class="submenu__item submenu__item--main ">
      					<a class="link"


      					   href="/phong-khach" title="Phòng khách">Phòng khách</a>
      				</li>




      			<li class="submenu__item submenu__item--main ">
      					<a class="link"


      					   href="/giuong-ngu-hien-dai" title="Phòng ngủ">Phòng ngủ</a>
      				</li>




      			<li class="submenu__item submenu__item--main ">
      					<a class="link"


      					   href="/nha-bep" title="Phòng bếp">Phòng bếp</a>
      				</li>


      		</ul>
      		</div>
      			</li>



      			<li class="menu-item list-group-item">
      		<a href="/flashsale"

      		   class="menu-item__link" title="Khuyến mãi">
      									<span>
      			Khuyến mãi</span>
      			</a>

      					</li>



      			<li class="menu-item list-group-item">
      		<a href="/tin-tuc"

      		   class="menu-item__link" title="Góc cảm hứng">
      									<span>
      			Góc cảm hứng</span>
      			</a>

      					</li>



      			<li class="menu-item list-group-item">
      		<a href="https://wiki.egany.com/s/ega-furniture-sapo"
      		    target="_blank"
      		   class="menu-item__link" title="Hướng dẫn thiết lập">
      									<span>
      			Hướng dẫn thiết lập</span>
      			</a>

      					</li>

      </ul>
      	</nav>
    </script>
  <!-- menu-mobile -->
  <script type="text/x-custom-template" data-template="menuMobile">
      <div id="mobile-menu" class="scroll">
      	<div class='media d-flex user-menu'>

      		<i class="fas fa-user-circle mr-3 align-self-center"></i>
      		<div class="media-body d-md-flex flex-column ">
      			<a rel="nofollow" href="/tai-khoan.html" class="d-block" title="Tài khoản" >
      				Tài khoản
      			</a>
      			<small>
      				<a href="/dang-nhap.html" title="Đăng nhập" class="font-weight: light">
      					Đăng nhập
      				</a> </small>

      		</div>
      	</div>

      	<div class="mobile-menu-body scroll">
      		<nav>
     				<ul  class="navigation navigation-horizontal list-group list-group-flush scroll">
      					{menu_mobile}

      </ul>
      	</nav>

      	</div>

      	<div class="mobile-menu-footer border-top w-100 d-flex align-items-center text-center">
      		<div class="hotline  w-50   p-2 ">
      			<a  href="tel:{hotline}" title="{hotline}">
      				Gọi điện <i class="fas fa-phone ml-3"></i>
      			</a>
      		</div>
      				<div class="messenger border-left p-2 w-50 border-left">

      			<a  href="https://m.me/" title="https://m.me/">
      				Nhắn tin
      				<i class="fab fa-facebook-messenger ml-3"></i>
      			</a>
      		</div>

      	</div>
      </div>
      <div class='menu-overlay'>

      </div>
    </script>
  <!-- svg none -->
  <svg style="display: none">
    <defs>
      <symbol class="icon" id="icon-cart" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M15.594 16.39a.703.703 0 0 1-.703.704h-.704v.703a.703.703 0 0 1-1.406 0v-.703h-.703a.703.703 0 0 1 0-1.407h.703v-.703a.703.703 0 1 1 1.406 0v.704h.704c.388 0 .703.314.703.703Zm0-10.968v6.75a.703.703 0 0 1-1.406 0V6.125H12.78v2.11a.703.703 0 1 1-1.406 0v-2.11h-6.75v2.11a.703.703 0 1 1-1.406 0v-2.11H1.813v10.969h7.453a.703.703 0 1 1 0 1.406H1.109a.703.703 0 0 1-.703-.703V5.422c0-.388.315-.703.703-.703h2.143A4.788 4.788 0 0 1 8 .5a4.788 4.788 0 0 1 4.748 4.219h2.143c.388 0 .703.315.703.703Zm-4.266-.703A3.38 3.38 0 0 0 8 1.906 3.38 3.38 0 0 0 4.672 4.72h6.656Z"
          fill="currentColor" />
      </symbol>
    </defs>
  </svg>
  <svg style="display: none">
    <defs>
      <symbol id="icon-minus" class="icon icon-minus" viewBox="0 0 16 2" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M15.375 0H0.625C0.279813 0 0 0.279813 0 0.625C0 0.970187 0.279813 1.25 0.625 1.25H15.375C15.7202 1.25 16 0.970187 16 0.625C16 0.279813 15.7202 0 15.375 0Z"
          fill="#8C9196" />
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-plus" class="icon icon-plus" viewBox="0 0 93.562 93.562" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path xmlns="http://www.w3.org/2000/svg"
          d="M87.952,41.17l-36.386,0.11V5.61c0-3.108-2.502-5.61-5.61-5.61c-3.107,0-5.61,2.502-5.61,5.61l0.11,35.561H5.61   c-3.108,0-5.61,2.502-5.61,5.61c0,3.107,2.502,5.609,5.61,5.609h34.791v35.562c0,3.106,2.502,5.61,5.61,5.61   c3.108,0,5.61-2.504,5.61-5.61V52.391h36.331c3.108,0,5.61-2.504,5.61-5.61C93.562,43.672,91.032,41.17,87.952,41.17z"
          fill="currentColor" />
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol class="icon icon-arrow" id="icon-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.8 490.8"
        fill="none" aria-hidden="true" focusable="false" role="presentation">
        <path
          d="M135.685 3.128c-4.237-4.093-10.99-3.975-15.083.262-3.992 4.134-3.992 10.687 0 14.82l227.115 227.136-227.136 227.115c-4.237 4.093-4.354 10.845-.262 15.083 4.093 4.237 10.845 4.354 15.083.262.089-.086.176-.173.262-.262l234.667-234.667c4.164-4.165 4.164-10.917 0-15.083L135.685 3.128z"
          fill="currentColor" />
        <path
          d="M128.133 490.68a10.667 10.667 0 01-7.552-18.219l227.136-227.115L120.581 18.232c-4.171-4.171-4.171-10.933 0-15.104 4.171-4.171 10.933-4.171 15.104 0l234.667 234.667c4.164 4.165 4.164 10.917 0 15.083L135.685 487.544a10.663 10.663 0 01-7.552 3.136z" />
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-search" class="icon icon-search" xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 192.904 192.904">
        <path
          d="M190.707 180.101l-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 005.303 2.197 7.498 7.498 0 005.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z" />
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-play" viewBox="0 0 18 18" fill="currentColor">
        <path
          d="M15.562 8.1L3.87.225c-.818-.562-1.87 0-1.87.9v15.75c0 .9 1.052 1.462 1.87.9L15.563 9.9c.584-.45.584-1.35 0-1.8z"
          fill="currentColor"></path>
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-user" fill="currentColor" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 448 512">
        <path
          d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z">
        </path>
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-star" viewBox="0 0 26 28">
        <path
          d="M26 10.109c0 0.281-0.203 0.547-0.406 0.75l-5.672 5.531 1.344 7.812c0.016 0.109 0.016 0.203 0.016 0.313 0 0.406-0.187 0.781-0.641 0.781-0.219 0-0.438-0.078-0.625-0.187l-7.016-3.687-7.016 3.687c-0.203 0.109-0.406 0.187-0.625 0.187-0.453 0-0.656-0.375-0.656-0.781 0-0.109 0.016-0.203 0.031-0.313l1.344-7.812-5.688-5.531c-0.187-0.203-0.391-0.469-0.391-0.75 0-0.469 0.484-0.656 0.875-0.719l7.844-1.141 3.516-7.109c0.141-0.297 0.406-0.641 0.766-0.641s0.625 0.344 0.766 0.641l3.516 7.109 7.844 1.141c0.375 0.063 0.875 0.25 0.875 0.719z">
        </path>
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-star-half" viewBox="0 0 26 28">
        <path
          d="M18.531 14.953l4.016-3.906-6.594-0.969-0.469-0.938-2.484-5.031v15.047l0.922 0.484 4.969 2.625-0.938-5.547-0.187-1.031zM25.594 10.859l-5.672 5.531 1.344 7.812c0.109 0.688-0.141 1.094-0.625 1.094-0.172 0-0.391-0.063-0.625-0.187l-7.016-3.687-7.016 3.687c-0.234 0.125-0.453 0.187-0.625 0.187-0.484 0-0.734-0.406-0.625-1.094l1.344-7.812-5.688-5.531c-0.672-0.672-0.453-1.328 0.484-1.469l7.844-1.141 3.516-7.109c0.203-0.422 0.484-0.641 0.766-0.641v0c0.281 0 0.547 0.219 0.766 0.641l3.516 7.109 7.844 1.141c0.938 0.141 1.156 0.797 0.469 1.469z">
        </path>
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-instagram" viewBox="0 0 448 512">
        <path fill="currentColor"
          d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
        </path>
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-share" xmlns="http://www.w3.org/2000/svg" width="14" height="16" fill="none" viewBox="0 0 14 16">
        <path fill="#000"
          d="M11 10c.8333 0 1.5417.2917 2.125.875.5833.5833.875 1.2917.875 2.125 0 .8333-.2917 1.5417-.875 2.125-.5833.5833-1.2917.875-2.125.875-.8333 0-1.54167-.2917-2.125-.875C8.29167 14.5417 8 13.8333 8 13c0-.3125.04167-.6146.125-.9062l-3.0625-1.9063C4.47917 10.7292 3.79167 11 3 11c-.83333 0-1.54167-.2917-2.125-.875C.291667 9.54167 0 8.83333 0 8c0-.83333.291667-1.54167.875-2.125C1.45833 5.29167 2.16667 5 3 5c.79167 0 1.47917.27083 2.0625.8125L8.125 3.90625C8.04167 3.61458 8 3.3125 8 3c0-.83333.29167-1.54167.875-2.125C9.45833.291667 10.1667 0 11 0c.8333 0 1.5417.291667 2.125.875C13.7083 1.45833 14 2.16667 14 3c0 .83333-.2917 1.54167-.875 2.125C12.5417 5.70833 11.8333 6 11 6c-.7917 0-1.47917-.27083-2.0625-.8125L5.875 7.09375c.1875.60417.1875 1.20833 0 1.8125l3.0625 1.90625C9.52083 10.2708 10.2083 10 11 10zm1.0625-8.0625C11.7708 1.64583 11.4167 1.5 11 1.5c-.4167 0-.7708.14583-1.0625.4375C9.64583 2.22917 9.5 2.58333 9.5 3s.14583.77083.4375 1.0625c.2917.29167.6458.4375 1.0625.4375.4167 0 .7708-.14583 1.0625-.4375.2917-.29167.4375-.64583.4375-1.0625s-.1458-.77083-.4375-1.0625zm-10.125 7.125C2.22917 9.35417 2.58333 9.5 3 9.5s.77083-.14583 1.0625-.4375S4.5 8.41667 4.5 8s-.14583-.77083-.4375-1.0625S3.41667 6.5 3 6.5s-.77083.14583-1.0625.4375S1.5 7.58333 1.5 8s.14583.77083.4375 1.0625zm8 5c.2917.2917.6458.4375 1.0625.4375.4167 0 .7708-.1458 1.0625-.4375.2917-.2917.4375-.6458.4375-1.0625 0-.4167-.1458-.7708-.4375-1.0625-.2917-.2917-.6458-.4375-1.0625-.4375-.4167 0-.7708.1458-1.0625.4375C9.64583 12.2292 9.5 12.5833 9.5 13c0 .4167.14583.7708.4375 1.0625z">
        </path>
      </symbol>
    </defs>
  </svg>

  <svg style="display: none">
    <defs>
      <symbol id="icon-compare" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
        <path fill="currentColor"
          d="M164 384h-44V48a16 16 0 0 0-16-16H88a16 16 0 0 0-16 16v336H28a12 12 0 0 0-8.73 20.24l68 72a12 12 0 0 0 17.44 0l68-72A12 12 0 0 0 164 384zm200.72-276.24l-68-72a12 12 0 0 0-17.44 0l-68 72A12 12 0 0 0 220 128h44v336a16 16 0 0 0 16 16h16a16 16 0 0 0 16-16V128h44a12 12 0 0 0 8.72-20.24z"
          class=""></path>
      </symbol>
    </defs>
  </svg>
  <svg style="display: none">
    <defs>
      <symbol xmlns="http://www.w3.org/2000/svg" id="icon-calendar" viewBox="0 0 25.881 25.88">
        <path id="Exclusão_32" data-name="Exclusão 32"
          d="M6150.835-12351.079h-17.79a4.047,4.047,0,0,1-4.043-4.042v-15.771a4.048,4.048,0,0,1,4.044-4.043h1.264v-1.012a1.014,1.014,0,0,1,1.011-1.012,1.014,1.014,0,0,1,1.012,1.011v1.013h4.547v-1.012a1.013,1.013,0,0,1,1.011-1.012,1.014,1.014,0,0,1,1.012,1.011v1.013h4.6v-1.012a1.012,1.012,0,0,1,1.011-1.011,1.013,1.013,0,0,1,1.012,1.011v1.012h1.315a4.048,4.048,0,0,1,4.044,4.042v15.773A4.05,4.05,0,0,1,6150.835-12351.079Zm-2.107-7.4a.974.974,0,0,0-.973.975.973.973,0,0,0,.973.969.971.971,0,0,0,.969-.97.972.972,0,0,0-.275-.707.969.969,0,0,0-.7-.293Zm-4.379,0a.973.973,0,0,0-.97.974.968.968,0,0,0,.283.687.97.97,0,0,0,.687.285.973.973,0,0,0,.973-.973.971.971,0,0,0-.276-.707.972.972,0,0,0-.7-.293Zm-4.76,0a.974.974,0,0,0-.973.975.973.973,0,0,0,.973.97.973.973,0,0,0,.97-.972.973.973,0,0,0-.274-.705.967.967,0,0,0-.7-.294Zm-4.38,0a.975.975,0,0,0-.973.975.973.973,0,0,0,.973.97.973.973,0,0,0,.974-.971.971.971,0,0,0-.275-.705.967.967,0,0,0-.7-.295Zm13.52-4.374a.972.972,0,0,0-.974.968.974.974,0,0,0,.973.974.972.972,0,0,0,.97-.973.962.962,0,0,0-.263-.727.971.971,0,0,0-.711-.3Zm-4.379,0a.97.97,0,0,0-.97.967.972.972,0,0,0,.97.976.976.976,0,0,0,.972-.975.969.969,0,0,0-.265-.726.971.971,0,0,0-.711-.3Zm-4.76,0a.972.972,0,0,0-.973.968.975.975,0,0,0,.973.974.973.973,0,0,0,.97-.974.969.969,0,0,0-.263-.725.969.969,0,0,0-.708-.306Zm-4.38,0a.972.972,0,0,0-.973.968.975.975,0,0,0,.973.974.971.971,0,0,0,.973-.973.969.969,0,0,0-.263-.726.97.97,0,0,0-.708-.306Zm13.519-4.381a.974.974,0,0,0-.973.973.974.974,0,0,0,.973.975.973.973,0,0,0,.969-.975.971.971,0,0,0-.28-.7.977.977,0,0,0-.695-.289Zm-4.379,0a.972.972,0,0,0-.969.973.971.971,0,0,0,.969.974.972.972,0,0,0,.973-.974.971.971,0,0,0-.281-.7.976.976,0,0,0-.7-.288Zm-4.76,0a.974.974,0,0,0-.973.973.975.975,0,0,0,.973.975.974.974,0,0,0,.971-.975.972.972,0,0,0-.279-.7.972.972,0,0,0-.693-.29Zm-4.379,0a.973.973,0,0,0-.973.973.974.974,0,0,0,.973.975.974.974,0,0,0,.973-.975.971.971,0,0,0-.28-.7.974.974,0,0,0-.693-.29Z"
          transform="translate(-6129.002 12376.958)" fill="currentColor" />
      </symbol>
    </defs>
  </svg>
  <svg style="display: none">
    <defs>
      <symbol xmlns="http://www.w3.org/2000/svg" id="icon-clock" viewBox="0 0 28.145 28.163">
        <path id="União_49" data-name="União 49"
          d="M.4,10.781C1.864,4.681,6.792.6,13.385.021a13.276,13.276,0,0,1,3.692.308,15.16,15.16,0,0,1-.346,1.885,6.058,6.058,0,0,1-.682-.091,11.8,11.8,0,0,0-8.537,1.8,12.137,12.137,0,0,0,2.17,21.469,12.674,12.674,0,0,0,8.151.22,12.314,12.314,0,0,0,7.538-7.061c.1-.247.2-.4.24-.393s.453.165.909.347l.834.33-.11.287c-.063.158-.17.421-.236.595a14.559,14.559,0,0,1-4.145,5.371c-.165.132-.311.252-.327.271A15.556,15.556,0,0,1,18.8,27.353a14.471,14.471,0,0,1-4.74.81A14.076,14.076,0,0,1,.4,10.781ZM7.339,21.3a10.008,10.008,0,0,1,5.523-17c7.88-1.28,13.973,7.071,10.462,14.338a9.93,9.93,0,0,1-9.006,5.538A9.771,9.771,0,0,1,7.339,21.3ZM14.046,8.479c-.507.236-.5.158-.5,3.431v2.909l.685.748c1.019,1.114,3.893,3.928,4.066,3.979a.841.841,0,0,0,.992-1c-.04-.1-.973-1.093-2.079-2.2l-2-2.015-.024-2.677c-.02-2.9-.02-2.881-.4-3.126a.711.711,0,0,0-.4-.135.8.8,0,0,0-.34.086Zm12.037,7.6a2.655,2.655,0,0,1,.039-.543c.036-.287.063-.964.063-1.5,0-.747.02-.989.075-.992s.417-.039.838-.078.823-.084.89-.087c.24-.017.2,3.349-.039,3.5h-.018a18.522,18.522,0,0,1-1.848-.3Zm-.575-6.049c0-.013-.066-.165-.133-.346a13.968,13.968,0,0,0-.929-1.9c-.186-.311-.256-.481-.217-.521s.39-.278.787-.55.736-.494.74-.5a16.158,16.158,0,0,1,1.479,2.831l.123.333-.158.064c-.338.131-1.646.582-1.691.582ZM21.856,4.787a14.121,14.121,0,0,0-1.72-1.2l-.547-.323.351-.656c.189-.362.39-.744.444-.851.123-.235.079-.245.646.082,1.385.8,2.437,1.626,2.287,1.811-.248.315-1.161,1.331-1.193,1.331a1.381,1.381,0,0,1-.268-.194Z"
          transform="translate(-0.006 0)" fill="currentColor" />
      </symbol>
    </defs>
  </svg>
  <div id="popup-cart" class="popcart">
    <div id="popup-cart-desktop" class="clearfix">
      <div class="title-popup-cart"></div>
      <div class="wrap_popup">
        <div class="title-quantity-popup">
          <span class="cart_status" onclick="window.location.href='/cart';">
            Giỏ hàng của bạn có <span class="cart-popup-count"></span> sản
            phẩm
          </span>
        </div>
        <div class="content-popup-cart">
          <!-- <div class="thead-popup">
					<div style="width: 53%;" class="text-left">Sản phẩm</div>
					<div style="width: 15%;" class="text-center">Đơn giá</div>
					<div style="width: 15%;" class="text-center">Số lượng</div>
					<div style="width: 17%;" class="text-center">Thành tiền</div>
				</div> -->
          <div class="tbody-popup scrollbar-dynamic"></div>
          <div class="tfoot-popup">
            <div class="tfoot-popup-1 clearfix">
              <div class="popup-ship"></div>
              <span class="total-p popup-total">Tổng tiền thanh toán: <span class="total-price"></span></span>
            </div>
            <div class="tfoot-popup-2 clearfix">
              <a class="button btn-continue close-pop" title="Tiếp tục mua hàng" href="javascript:;"
                onclick="$('#popup-cart').modal('hide');"><span><span>Tiếp tục mua hàng</span></span></a>
              <a class="button checkout_ btn-proceed-checkout" title="Thực hiện thanh toán" href="/checkout"><span>Thực
                  hiện thanh toán</span></a>
            </div>
          </div>
        </div>
        <a title="Close" class="close-modal quickview-close close-pop" href="javascript:;"
          onclick="$('#popup-cart').modal('hide');"><i class="fa fa-close"></i></a>
      </div>
    </div>
  </div>

  <!-- Add to cart -->
  <div id="popupCartModal" class="modal fade" role="dialog"></div>

  <!-- <link rel="stylesheet" href="//bizweb.dktcdn.net/100/491/756/themes/956460/assets/sales-pop.css?1727322848954"
    media="print" onload="this.media='all'" /> -->

  <!-- footer_script -->
  {script_footer}

  <script type="text/javascript" charset="utf-8">
    $(function () {
      var currentDate = new Date(),
        finished = false,
        availiableExamples = {
          set5ngay: 15 * 24 * 60 * 60 * 1000,
          set5phut: 5 * 60 * 1000,
          set1phut: 1 * 10 * 1000
        };
      function call_flash(event) {
        $this = $(this);
        switch (event.type) {
          case "seconds":
          case "minutes":
          case "hours":
          case "days":
          case "weeks":
          case "daysLeft":
            $this.find('.' + event.type).html(event.value);
            if (finished) {
              $this.fadeTo(0, 1);
              finished = false;
            }
            break;
          case "finished":
            $this.fadeTo('slow', .5);
            $this.html('Đã hết hạn');
            finished = true;
            break;
        }
      }
      $('.box_flash_sale .count_down').each(function () {
        con = $(this).attr('time') * 1000;
        $(this).countdown(con + currentDate.valueOf(), call_flash);
      });
    });
  </script>
</body>

</html>