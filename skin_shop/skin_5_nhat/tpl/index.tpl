
{header}
<body>
<style>
    .category-nav h3 a {
  display: inline-block;
  max-width: 200px;  /* hoặc bất kỳ kích thước phù hợp nào */
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
    /* General styles for the container bannerfirst nhatthem214 */
        /* Container để giữ hiệu ứng */
        .banner-item {
          position: relative;
          overflow: hidden;
        }
        
        /* Ảnh cơ bản */
        .banner-item img {
          display: block;
          width: 100%;
          height: auto;
          transition: transform 0.5s ease;
        }
        
        /* Hiệu ứng lấp lánh */
        .banner-item::before {
          content: '';
          position: absolute;
          top: -50%;
          left: -50%;
          width: 200%;
          height: 200%;
          background: linear-gradient(120deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.8) 50%, rgba(255,255,255,0.2) 100%);
          transform: rotate(30deg) translate(-100%, 0);
          opacity: 0;
          pointer-events: none;
          transition: opacity 0.5s, transform 1s;
        }
        
        /* Dấu cộng 
        .banner-item::after {
          content: '+';
          font-size: 100px;
          color: rgba(255,255,255,0.5);
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%) scale(1.5);
          transition: transform 0.5s ease;
          pointer-events: none;
        }
        */
        /* Khi hover vào banner */
        .banner-item:hover::before {
          opacity: 1;
          transform: rotate(30deg) translate(100%, 0);
        }
        
        /* Hover vào: dấu cộng thu nhỏ lại */
        .banner-item:hover::after {
          transform: translate(-50%, -50%) scale(0.8);
        }
        
    /*///////////////////////////////////////////////////////*/
.swiper{
    max-width: 1150px !important;
    margin: auto !important;
}


@media (min-width: 769px) {
    .container-sub .swiper-slide {
        width: 50% !important; 
    }

    .container-sub .banner_slider .swiper-button-prev,
    .container-sub .banner_slider .swiper-button-next {
        display: none; 
    }

    .container-sub .banner_slider .swiper-pagination {
        display: none; 
    }

    .container-sub .banner_slider {
        overflow: visible; 
    }
}


@media (max-width: 768px) {
    .container-sub .banner_slider {
        height: auto;
    }

    .container-sub .swiper-slide {
        width: 100% !important; /* Ensure 1 slide takes full width */
    }
    .slick-dotted.slick-slider
    {
        margin-bottom: 10px !important;
    }

    .container-sub .swiper-slide img {
        height: auto;
        width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: contain !important;
        border-radius: 8px;
    }
    .container-sub
    {
        padding-top: 10px !important;
    }
    .swiper-button-prev,
    .swiper-button-next {
        width: 30px !important; /* Smaller buttons on mobile */
        height: 30px !important;
        font-size: 16px;
    }

    .swiper-button-prev::after,
    .swiper-button-next::after {

        font-size: 16px !important; /* Smaller arrow icons */
    }
}
    /*Banner styles for the banner slider nhatthem214/*/
   /* Scoped container for the layout */

.container-sub {
    display: flex;
    max-width: 1200px;
    margin: 0 auto;
    padding-top: 20px;
    gap: 20px;
}

/* Navigation Categories (Left Sidebar) */
.container-sub .category-nav {
    width: 250px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 15px;
}

.container-sub #menu2017 {
    list-style: none;
    padding: 0;
    margin: 0;
}

.container-sub #menu2017 li {
    border: 1px solid #3333;
    border-radius: 7px;
    margin: 5px;
    padding: 5px;
}


.container-sub #menu2017 li h3 {
    margin: 0;
    font-size: 16px;
    font-weight: normal;
}
/*/
.container-sub #menu2017 li h3 a {
    color: #333;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
}
    */

.container-sub #menu2017 li h3 a:hover {
    color: #007bff;
}

/* Add a small icon before each menu item (similar to Image 1) */
.container-sub #menu2017 li h3 a::before {
    content: ''; /* Remove the URL from content */
    display: inline-block;
    background-image: url('/skin_shop/skin_5_nhat/tpl/css/images/default_menu_icon.png'); /* Use background-image instead */
    background-size: contain; /* Ensure the image fits within the defined dimensions */
    background-repeat: no-repeat;
    background-position: center;
    width: 20px; /* Desired width */
    height: 20px; /* Desired height */
    margin-right: 8px; /* Space between icon and text */
    vertical-align: middle; /* Align with text */
}

/* Slider Section */
.container-sub .awe-section-1 {
    flex: 1;
    position: relative;
}

.container-sub .home-slider {
    width: 100%;
    border-radius: 8px;
    overflow: hidden;
}

.container-sub .swiper-wrapper {
    display: flex;
}

.container-sub .swiper-slide {
    width: 100% !important;
}

.container-sub .swiper-slide img {
    width: 100%;
    height: 400px; /* Adjust height as needed */
    object-fit: cover;
    border-radius: 8px;
}

/* Navigation Arrows */

.container-sub .swiper-button-prev,
.container-sub .swiper-button-next {
    background-color: rgba(255, 255, 255, 0.8);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007bff;
    font-size: 20px;
    cursor: pointer;
}

.container-sub .swiper-button-prev::after,
.container-sub .swiper-button-next::after {
    font-size: 20px;
    color: #007bff;
}

.container-sub .swiper-button-prev {
    left: 10px;
}

.container-sub .swiper-button-next {
    right: 10px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container-sub {
        flex-direction: column;
    }

    .container-sub .category-nav {
        width: 100%;
        display: none;
    }

    .container-sub .home-slider {
        height: auto; /* Let the height adjust dynamically */
    }

}
      
	:root {
		--mainColor: #37bee3;
		--hoverColor: #0282a5;
		--textColor: #1b2830;
		--priceColor: #ff4440;
		--gradient1: #0282a5;
		--gradient2: #37bee3;
	}
</style>

	{box_header}
    <h1 class="hidden">{site_name}</h1>
    <div class="container">
        <div class="container-sub">
            <div class="category-nav">
                <ul id="menu2017">
                    {list_category_nav}
                </ul>
            </div>
            <section class="awe-section-1" >
                <div class="home-slider swiper-container slide_home">
                    
                    <div class="swiper-wrapper">
                        {list_slide}
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <!-- Thêm mới -->
    {service_high_lights}
    {box_coupon}
    <!-- Thêm mới -->
    {banner_firts}
    {box_flash_sale}
    <!-- Thêm mới -->
    {banner_two}
    {list_box_index}
    <!-- Thêm mới -->
    <section class="testimonial-section">
        <div class="testimonial-header">
            <h2>Đánh giá từ khách hàng</h2>
            <p>Những phản hồi chân thực từ khách hàng đã trải nghiệm dịch vụ của chúng tôi</p>
            {list_user_feedbacks}
        </div>
      
    </section>
    <div class="box_tintuc_index">
    	<div class="container">
    		<div class="box_title">
    			<h2><a href="/tin-tuc.html">Tin tức mới</a></h2>
    			<span><a href="/tin-tuc.html">Xem thêm <i class="fa fa-angle-double-right"></i></a></span>
    		</div>
    		<div class="box_list">
    			<div class="tintuc_left">{list_tintuc_left}</div>
    			<div class="tintuc_right scroll">{list_tintuc_right}</div>
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
                $this.fadeTo('slow', .5);
                $this.html('Đã hết hạn');
                finished = true;
                        break;
                }
            }
            $('.box_flash_sale .count_down').each(function(){
                con=$(this).attr('time')*1000;
                $(this).countdown(con + currentDate.valueOf(), call_flash);
            });
        });
      </script>
    <script>
    //9-4
    var swiper = new Swiper(".testimonialSwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    });
    </script>
    <script>
    
        var slide_recent = new Swiper('.slide_home', {
            // Optional parameters
            direction: 'horizontal',
            slidesPerView: 1,
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
                nextEl: '#gallery_01 .owl-next',
                prevEl: '#gallery_01 .owl-prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        });
        
/*
        if ($(window).width() < 480) {
           var sl=2;
        }else if ($(window).width() < 640) {
           var sl=3;
        }else if ($(window).width() < 768) {
           var sl=3;
        }else if ($(window).width() < 1024) {
            var sl=4;
        }else {
           var sl=5;
        }
        
        var slide_product = new Swiper('.slide_product', {
            // Optional parameters
            direction: 'horizontal',
            slidesPerView: sl,
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
                nextEl: '.box_index .button_next',
                prevEl: '.box_index .button_prev',
                disabledClass: 'hide_button',
                hiddenClass: 'hide_button'
            },
        });
*/


//slide_bannerfirst nhatthem214
        var slide_recent = new Swiper('.banner_slider', {
            direction: 'horizontal',
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            observer: true,
            observeParents: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
                disabledClass: 'swiper-button-disabled',
                hiddenClass: 'swiper-button-hidden'
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                0: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            function setSlidesPerView() {
                if ($(window).width() < 480) {
                    return 2;
                } else if ($(window).width() < 640) {
                    return 3;
                } else if ($(window).width() < 768) {
                    return 3;
                } else if ($(window).width() < 1024) {
                    return 4;
                } else {
                    return 5;
                }
            }
        
            var slide_product = new Swiper('.slide_product', {
                direction: 'horizontal',
                slidesPerView: setSlidesPerView(),
                loop: true,
                observer: true,
                observeParents: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 3000,
                },
                navigation: {
                    nextEl: '.box_index .button_next',
                    prevEl: '.box_index .button_prev',
                    disabledClass: 'hide_button',
                    hiddenClass: 'hide_button'
                },
            });
        
            // Update slidesPerView on window resize
            window.addEventListener('resize', function () {
                slide_product.params.slidesPerView = setSlidesPerView();
                slide_product.update();
            });
        });
    </script>
    
</body>

</html>

