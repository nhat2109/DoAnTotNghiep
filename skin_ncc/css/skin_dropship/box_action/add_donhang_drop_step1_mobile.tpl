<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%;padding: 5px;">
            <!-- <div class="title_thuonghieu"><span>Nhà cung cấp nổi bật</span></div>
            <div class="list_thuonghieu add_donhang_drop add_donhang_drop_mobile">
                <div class="swiper-container slide_thuonghieu">
                    <div class="swiper-wrapper">
                        {list_banner_qc}
                    </div>
                </div>
            </div> -->
            <div class="box_timkiem">
                <div class="box_huongdan">
                    <div class="muiten xuong"><i class="fa fa-caret-up"></i></div>
                    <div class="noidung_huongdan">Lọc sản phẩm theo tiêu chí của bạn</div>
                    <div class="button_next"><button step="box_timkiem">Tiếp theo</button></div>
                </div>
                <div class="sanpham_trend"><a href="/dropship/list-sanpham-trend">Click : Sản phẩm Trend để bán</a>
                </div>
                <select name="chon_kho" id="chon_kho">
                    <option value="kho">Kho Hà Nội</option>
                    <option value="kho_hcm">Kho Tp.HCM</option>
                </select>
                <select name="category" id="timkiem_category">
                    <option value="">Danh mục</option>
                    <option value="">Tất cả</option>
                    {option_category}
                </select>
                <select name="thuong_hieu" id="timkiem_thuonghieu">
                    <option value="">Thương hiệu</option>
                    {option_thuonghieu}
                </select>
                <select name="sort" id="sort_product">
                    <option value="">Sắp xếp</option>
                    <option value="kho-desc">Tồn kho giảm dần</option>
                    <option value="kho-asc">Tồn kho tăng dần</option>
                    <option value="drop-desc">Giá nhập giảm dần</option>
                    <option value="drop-asc">Giá nhập tăng dần</option>
                    <option value="price-desc">Giá bán giảm dần</option>
                    <option value="price-asc">Giá bán tăng dần</option>
                    <option value="name-asc">Tên A - Z</option>
                    <option value="name-desc">Tên Z - A</option>
                    <option value="time-desc">Sản phẩm mới - cũ</option>
                    <option value="time-asc">Sản phẩm cũ - mới</option>
                </select>
                <input type="text" name="key" style="width: 125px;" placeholder="Nhập từ khóa tìm kiếm">
                <button name="timkiem_sanpham_drop" class="button_timkiem" kieu="mobile"><i
                        class="fa fa-search"></i></button>
                <div class="box_shopcart"><a href="/dropship/add-donhang-drop?step=2"><i class="icon icon-basket"></i>
                        (<span>{total_cart}</span>)</a></div>
                <div style="clear: both;"></div>
            </div>
            <div style="clear: both;"></div>
            <div style="margin-top: 10px;margin-bottom: 10px;">
                <!--                 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7667437466339231"
                     crossorigin="anonymous"></script> -->
                <!-- hiển thị -->
                <!--                 <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7667437466339231"
                     data-ad-slot="2193067812"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script> -->
            </div>
            <div class="info_thuonghieu">
                <div class="cover_thuonghieu">
                    <img src="">
                </div>
                <div class="noidung_thuonghieu"></div>
                <div class="menu_thuonghieu"><span><i class="fa fa-times-circle-o"></i> Đóng lại</span></div>
            </div>
            <div class="page_title">
                <div class="list_mxh">
                    <div class="text">Tham gia:</div>
                    <a href="https://www.facebook.com/groups/nguonhangsocdo" target="_blank">Group facebook</a>
                    <a href="https://www.facebook.com/SocDoPage" target="_blank">Fanpage facebook</a>
                </div>
                <h1 class="undefined">Danh sách sản phẩm</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="list_sanpham">
                {list_sanpham}
            </div>
            {phantrang}
        </div>
    </div>
</div>

<div style="margin:auto;">
    <div class="fixed-action-btn">
        <div class="arrow-box">
            <div class="arrow-toggle" id="toggle-button">
                <i style="font-weight: bold;" class="fa fa-caret-up"></i> <span style="font-weight: bold;">Thương hiệu
                    nổi bật</span>
            </div>
        </div>
    </div>
    <div id="slide_box" class="hidden-slide-box">
        <div class="list_thuonghieu add_donhang_drop add_donhang_drop_laptop">
            <div class="swiper-container slide_thuonghieu">
                <div class="swiper-wrapper">
                    {list_banner_qc}
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Slide thương hiệu nổi bật  -->


<style>
    /* Box chứa banner */
    #slide_box .li_thuonghieu {
        width: 130px;
        /* Tăng kích thước để nổi bật hơn */
        height: 160px;
        /* Điều chỉnh chiều cao phù hợp */
        margin: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 12px;
        background: linear-gradient(145deg, #f3f3f3, #ffffff);
        /* Hiệu ứng gradient nhẹ */
        box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.1);
        /* Bóng đổ nhẹ tạo chiều sâu */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    #slide_box .li_thuonghieu:hover {
        transform: translateY(-3px);
        /* Hiệu ứng nổi khi hover */
        box-shadow: 6px 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Ảnh banner */
    #slide_box .li_thuonghieu img {
        height: 90%;
        width: auto;
        object-fit: contain;
        display: block;
        border-radius: 8px;
    }

    .swiper-container {
        margin-left: auto;
        margin-right: auto;
        position: relative;
        overflow: hidden;
        list-style: none;
        padding: 10px;
        z-index: 1;
    }

    .fixed-action-btn {
        position: fixed;
        width: 240px;
        bottom: 2px;
        right: 40%;
        z-index: 999;
        margin: auto;
    }

    .fixed-action-btn .arrow-box {
        height: 35px;
        width: 75%;
        background-color: #ffe6e6;
        border: 2px solid #ff9999;
        /* Viền nổi bật hơn */
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 12px;
        font-weight: bold;
        color: #ff4d4d;
    }

    .fixed-action-btn .arrow-toggle {
        display: flex;
        align-items: center;
        color: #ff0000;
        cursor: pointer;
        padding: 3px;
    }

    .fixed-action-btn .arrow-toggle i {
        margin-right: 5px;
    }

    #slide_box {
        position: fixed;
        bottom: -500px;
        left: 0;
        width: 100%;
        height: 210px;
        background-color: #fff;
        z-index: 998;
        overflow: hidden;
        border: 2px solid rgb(201, 199, 199);
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        transition: bottom 0.5s ease-in-out;
    }

    #slide_box.visible {
        bottom: 0;
    }

    .slide-content {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #slide_box .li_thuonghieu {
        width: 120px;
        height: 150px;
        margin: 2px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #slide_box .li_thuonghieu img {
        height: 100%;
        width: auto;
        object-fit: contain;
        display: block;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }



    /* Tablet */
    @media (max-width: 1024px) {
        #slide_box .li_thuonghieu {
            width: 100px;
            height: 130px;
            border-radius: 0px;
        }

        #slide_box .li_thuonghieu img {
            height: 100%;
            width: auto;
        }

        .fixed-action-btn {
            width: 200px;
            right: 30%;
        }
    }

    /* Mobile */
    @media (max-width: 768px) {
        #slide_box {
            border-radius: 0px;
            height: 250px;
        }

        #slide_box .li_thuonghieu {
            width: 250px;
            /* Đặt chiều rộng cố định là 250px */
            height: 180px;
            /* Tăng chiều cao để ảnh được hiển thị lớn hơn */
            margin: 4px;
            display: flex;
            justify-content: center;
            align-items: center;

        }



        /*      
        #slide_box .li_thuonghieu {
            width: 348px !important;
          
            height: 190px;
          //xin 
            margin: 4px;
        } */
        #slide_box .li_thuonghieu {
            max-width: 380px;
            width: 98% !important;
            margin: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        /* Đảm bảo ảnh bên trong hiển thị đủ và không bị vỡ */
        #slide_box .li_thuonghieu img {
            width: 80%;
            height: 100%;
            object-fit: cover;
            /* Giúp ảnh cắt xén hợp lý, không bị vỡ */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: block;
        }

        /* Điều chỉnh fixed-action-btn cho phù hợp với mobile */
        .fixed-action-btn {
            width: 223px;
            right: 16%;
        }


    }
</style>


<!-- Slide thương hiệu nổi bật  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('toggle-button').addEventListener('click', function () {
            const slideBox = document.getElementById('slide_box');
            slideBox.classList.toggle('visible');
            const icon = this.querySelector('i');
            if (slideBox.classList.contains('visible')) {
                icon.classList.remove('fa-caret-up');
                icon.classList.add('fa-caret-down');
            } else {
                icon.classList.remove('fa-caret-down');
                icon.classList.add('fa-caret-up');
            }
        });
    });

</script>



<script src="/swiper/swiper.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var queryParams = new URLSearchParams(window.location.search);
        sort = queryParams.get("sort");
        key = queryParams.get("key");
        if (sort == null) {
            $('#sort_product').val('time-desc');
        } else {
            $('#sort_product').val(sort);
        }
        if (key == null) {

        } else {
            $('input[name=key]').val(key);
        }
        setTimeout(function () {
            $('.list_thuonghieu').show();
            var slide_thuonghieu = new Swiper('.slide_thuonghieu', {
                // Optional parameters
                direction: 'horizontal',
                slidesPerView: 1, // Hiển thị 1 slide mỗi lần
                loop: true, // Lặp lại các slide
                observer: true,
                observeParents: true,
                speed: 2000, // Tốc độ chuyển động (ms)
                autoplay: {
                    delay: 0, // Không dừng giữa các slide
                    disableOnInteraction: false, // Tiếp tục chạy khi người dùng tương tác
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
        }, 1000);
    });
</script>

<!-- <script type="text/javascript">
    $(document).ready(function () {
        var queryParams = new URLSearchParams(window.location.search);
        sort = queryParams.get("sort");
        key = queryParams.get("key");
        if (sort == null) {
            $('#sort_product').val('time-desc');
        } else {
            $('#sort_product').val(sort);
        }
        if (key == null) {

        } else {
            $('input[name=key]').val(key);
        }
        setTimeout(function () {
            $('.list_thuonghieu').show();
            var slide_thuonghieu = new Swiper('.slide_thuonghieu', {
                // Optional parameters
                direction: 'horizontal',
                slidesPerView: 1,
                loop: true,
                observer: true,
                observeParents: true,
                // If we need pagination
                autoplay: {
                    delay: 2000,
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
        }, 1000);
    });
</script> -->