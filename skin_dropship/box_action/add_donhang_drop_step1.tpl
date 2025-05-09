<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" style="width: 100%; padding: 10px;">
            <div class="box_timkiem sticky-filter">
                <div class="box_huongdan">
                    <div class="muiten xuong"><i class="fa fa-caret-up"></i></div>
                    <div class="noidung_huongdan">Lọc sản phẩm theo tiêu chí của bạn</div>
                    <div class="button_next"><button step="box_timkiem">Tiếp theo</button></div>
                </div>
                <div class="sanpham_trend"><a href="/dropship/list-sanpham-trend">Click : Sản phẩm HOT</a></div>
                <select name="category" id="timkiem_category">
                    <option value="">Danh mục</option>
                    <option value="">Tất cả</option>
                    {option_category}
                </select>
                <select name="thuong_hieu" id="timkiem_thuonghieu">
                    <option value="">Thương hiệu</option>
                    <option value="">Tất cả</option>
                    {option_thuonghieu}
                </select>
                <select name="sort" id="sort_product">
                    <option value="">Sắp xếp</option>
                    <option value="kho-desc">Tồn kho giảm dần</option>
                    <option value="kho-asc">Tồn kho tăng dần</option>
                    <option value="drop-desc">Giá drop giảm dần</option>
                    <option value="drop-asc">Giá drop tăng dần</option>
                    <option value="price-desc">Giá bán giảm dần</option>
                    <option value="price-asc">Giá bán tăng dần</option>
                    <option value="name-asc">Tên A - Z</option>
                    <option value="name-desc">Tên Z - A</option>
                    <option value="time-desc">Sản phẩm mới - cũ</option>
                    <option value="time-asc">Sản phẩm cũ - mới</option>
                </select>
                <div style="clear: both;"></div>
            </div>
            <h1 class="title_name">Danh sách sản phẩm</h1>
            <div style="clear: both;"></div>
            <table class="list_baiviet">
                <tr class="sticky-header">
                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                    <th style="text-align: center;width: 80px;" class="hide_mobile">Minh họa</th>
                    <th style="text-align: center;width: 120px;" class="hide_mobile">Mã sản phẩm</th>
                    <th style="text-align: left;">Tên sản phẩm</th>
                    <th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
                    <th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán</th>
                    <!-- <th style="text-align: center;width: 120px;" class="hide_mobile">Giá bán tối thiểu</th> -->
                    <th style="text-align: center;width: 150px;">Giá nhập</th>
                    <th style="text-align: center;width: 80px;">Kho</th>
                    <th style="text-align: center;width: 200px;">Hành động</th>
                </tr>
                {list_sanpham}
            </table>
            {phantrang}
        </div>
    </div>
</div>
<div style="margin:auto;">
    <div class="fixed-action-btn">
        <div class="arrow-box">
            <div class="arrow-toggle" id="toggle-button">
                <i style="font-weight: bold;" class="fa fa-caret-up"></i> <span style="font-weight: bold;">Thương hiệu nổi bật</span>
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

<style>
    /* Ensure the parent container allows sticky positioning */
    .box_right {
        position: relative;
        width: 100%;
    }

    .box_right_content {
        width: 100%;
    }

    .box_profile {
        position: relative;
        width: 100%;
        padding: 10px;
    }

    /* Sticky filter section */
    .sticky-filter {
        position: sticky;
        top: 0;
        z-index: 20; /* Higher than table header to stay on top */
        background-color: #fff; /* Ensure background isn’t transparent */
        padding: 10px;
        border-bottom: 1px solid #dee2e6; /* Visual separator */
    }

    /* Sticky table header */
    .list_baiviet {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .sticky-header {
        position: sticky;
        top: 70px; /* Adjusted based on the height of .sticky-filter */
        z-index: 10; /* Below filter section */
        background: #0056d2; /* Blue background as seen in the image */
        color: #fff; /* White text for contrast */
    }

    .list_baiviet th {
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        padding: 12px 15px;
    }

    .list_baiviet td {
        border-bottom: 1px solid #dee2e6;
        padding: 12px 15px;
    }

    .list_baiviet tr:hover {
        background-color: #e9ecef;
        transition: background-color 0.2s ease;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sticky-header {
            top: 90px; /* Adjust for filter section height on mobile */
        }

        .hide_mobile {
            display: none; /* Keep existing mobile hiding logic */
        }
    }

    /* Ensure Swiper and other elements don’t interfere */
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
        padding: 12px;
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

    #slide_box .li_thuonghieu {
        width: 130px;
        height: 160px;
        margin: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 12px;
        background: linear-gradient(145deg, #f3f3f3, #ffffff);
        box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    #slide_box .li_thuonghieu:hover {
        transform: translateY(-3px);
        box-shadow: 6px 6px 20px rgba(0, 0, 0, 0.15);
    }

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

    /* Tablet */
    @media (max-width: 1024px) {
        #slide_box .li_thuonghieu {
            width: 100px;
            height: 130px;
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
            height: 170px;
        }

        #slide_box .li_thuonghieu {
            width: 80px;
            height: 100px;
        }

        .fixed-action-btn {
            width: 150px;
            right: 20%;
        }
    }

    /* Ensure images fit properly */
    #slide_box .li_thuonghieu img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Shadow effect for sticky header
        const stickyHeader = document.querySelector('.sticky-header');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 0) {
                stickyHeader.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            } else {
                stickyHeader.style.boxShadow = 'none';
            }
        });

        // Toggle slide box
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

<!-- Slide thương hiệu nổi bật -->
<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var queryParams = new URLSearchParams(window.location.search);
        var sort = queryParams.get("sort");
        var key = queryParams.get("key");
        if (sort == null) {
            $('#sort_product').val('time-desc');
        } else {
            $('#sort_product').val(sort);
        }
        if (key != null) {
            $('input[name=key]').val(key);
        }
        setTimeout(function () {
            $('.list_thuonghieu').show();
            var slide_thuonghieu = new Swiper('.slide_thuonghieu', {
                direction: 'horizontal',
                slidesPerView: 5,
                loop: true,
                observer: true,
                observeParents: true,
                autoplay: {
                    delay: 3000,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
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