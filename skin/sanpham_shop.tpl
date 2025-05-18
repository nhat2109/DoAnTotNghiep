{header}
<style>
    body {
        opacity: 0;
        /* Ẩn toàn bộ trang */
        transition: opacity 0.1s ease-in-out;
        /* Hiệu ứng mượt khi hiển thị lại */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.body.style.opacity = "1"; // Hiển thị lại trang sau khi load xong
    });

</script>

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
                            <a href="/san-pham.html">
                                <span> Sản phẩm </span></a>
                            <span class="mr_lr">&nbsp;/&nbsp;</span>
                        </li>
                        <li class="active"><span>{tieu_de}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        .box_shop_info{
            position: relative;
            width: calc(100% - 20px);
            max-width: 1280px;
            margin: auto;
        }
        .shop-info-container {
            background: linear-gradient(135deg, #f8f9ff, #e6f0ff);
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(41, 128, 185, 0.12);
            padding: 25px;
            margin: auto;
            border: 1px solid #d4e6f1;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .shop-info-container:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #f00, #ff6200);
        }
        
        .shop-info-container:hover {
            box-shadow: 0 12px 24px rgba(41, 128, 185, 0.18);
        }
        
        .shop-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }
        
        .shop-avatar {
            width: 80px;
            height: 80px;
            margin-right: 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #db3c34;
            box-shadow: 0 4px 10px rgba(41, 128, 185, 0.3);
            position: relative;
            z-index: 1;
        }
        
        .shop-avatar:after {
            content: '';
            position: absolute;
            top: -6px;
            left: -6px;
            right: -6px;
            bottom: -6px;
            border-radius: 50%;
            border: 2px solid rgba(41, 128, 185, 0.3);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                opacity: 0.7;
            }
            70% {
                transform: scale(1.05);
                opacity: 0.3;
            }
            100% {
                transform: scale(0.95);
                opacity: 0.7;
            }
        }
        
        .shop-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .shop-avatar:hover img {
            transform: scale(1.1);
        }
        
        .shop-details {
            flex: 1;
            text-align: left;
        }
        
        .shop-name {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 12px 0;
            position: relative;
            display: inline-block;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.05);
        }
        
        .shop-name:after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3498db, #2980b9);
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        
        .shop-info-container:hover .shop-name:after {
            width: 100%;
        }
        
        .shop-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 15px;
            color: #555;
        }
        
        .shop-meta div {
            display: flex;
            align-items: center;
            background-color: rgba(41, 128, 185, 0.1);
            padding: 6px 12px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .shop-meta div:hover {
            background-color: rgba(41, 128, 185, 0.2);
            transform: translateY(-2px);
        }
        
        .shop-meta i {
            margin-right: 8px;
            color: #3498db;
            font-size: 16px;
        }
        
        .shop-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }
        
        .shop-btn {
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            min-width: 120px;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            cursor: pointer;
        }
        
        .shop-btn i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .btn-chat {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .btn-chat img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        
        .btn-call {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }
        
        .btn-view-shop {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            color: #3498db;
            border: 1px solid #d4e6f1;
        }
        
        .shop-btn:hover {
            opacity: 0.95;
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(41, 128, 185, 0.15);
        }
        
        .shop-btn:active {
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(41, 128, 185, 0.1);
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .shop-header {
                flex-direction: column;
                text-align: center;
            }
            
            .shop-avatar {
                margin: 0 auto 20px;
                width: 100px;
                height: 100px;
            }
            
            .shop-name:after {
                left: 50%;
                transform: translateX(-50%);
            }
            .shop-details{
                text-align: center;
            }
            .shop-meta {
                justify-content: center;
            }
            
            .shop-actions {
                flex-direction: row;
                flex-wrap: wrap;
            }
            
            .shop-btn {
                flex-basis: calc(50% - 6px);
                padding: 14px 10px;
                font-size: 14px;
            }
            
            .btn-view-shop {
                flex-basis: 100%;
                margin-top: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .shop-info-container {
                padding: 20px 15px;
                margin: 20px 0;
            }
            
            .shop-meta {
                gap: 8px;
            }
            
            .shop-meta div {
                padding: 5px 10px;
                font-size: 13px;
            }
            
            .shop-name {
                font-size: 20px;
            }
            
            .shop-actions {
                gap: 8px;
            }
            
            .shop-btn {
                padding: 12px 8px;
                font-size: 13px;
            }
            
            .shop-btn i, .shop-btn img {
                margin-right: 6px;
            }
        }
    </style>
    <div class="box_shop_info">
        <div class="shop-info-container">
            <div class="shop-header">
                <div class="shop-avatar">
                    <img src="{shop_avatar}" onerror="this.src='/images/shop.svg'" alt="{shop_name}">
                </div>
                <div class="shop-details">
                    <h3 class="shop-name">{shop_name}</h3>
                    <div class="shop-meta">
                        <div><i class="fas fa-calendar-alt"></i> Tham gia: {shop_create}</div>
                        <div><i class="fas fa-box-open"></i> {shop_total_product} sản phẩm</div>
                    </div>
                </div>
            </div>
            <div class="shop-actions">
                <a href="https://zalo.me/{shop_mobile}" class="shop-btn btn-chat">
                    <img src="/skin/css/images/zalo.png" alt="Zalo"> Chat ngay
                </a>
                <a href="tel:{shop_mobile}" class="shop-btn btn-call">
                    <i class="fas fa-phone-alt"></i> Gọi điện
                </a>
            </div>
        </div>
    </div>
    <div class="main_tintuc">
        {box_top_deal_soc}
        <div class="box_filter box_filter_desktop">
            <div class="box_content box_content_desktop">
                <!-- <div class="li_box">
                    <div class="li_box_content"><i class="fa fa-filter"></i> Bộ lọc</div>
                </div> -->
                <div class="li_box">
                    <div>MỨC GIÁ</div>
                    <div class="li_box_content">

                        <!-- <select name="price_filter">
                            <option value="">Giá</option>
                            <option value="">Tất cả</option>
                            {option_price}
                        </select> -->
                        <div class="price-container">
                            {option_price}

                        </div>
                    </div>
                </div>

                <div class="li_box">
                    <div>THƯƠNG HIỆU</div>
                    <div class="li_box_content">
                        <div class="brand-container">
                            {option_brand}
                        </div>
                    </div>
                </div>

                <br>
                <div class="li_box">
                    <div>MÀU SẮC</div>
                    <div class="li_box_content">
                        <!-- <select name="color_filter">
                            <option value="">Màu sắc</option>
                            <option value="">Tất cả</option>
                            {option_color}
                        </select> -->
                        <div class="color-container">
                            {option_color}

                        </div>
                    </div>
                </div>
                <div class="li_box">
                    <div>KÍCH CỠ</div>
                    <div class="li_box_content">
                        <!-- <select name="size_filter">
                            <option value="">Kích thước</option>
                            <option value="">Tất cả</option>
                            {option_size}
                        </select> -->
                        <div class="size-container">
                            {option_size}

                        </div>
                    </div>
                </div>
            </div>
            <button class="toggle-button">Xem thêm bộ lọc</button>
        </div>
        {box_timkiem_nhieu}
        <div class="box_list_sanpham">
            <div class="box_content">

                <div class="box_top">
                    <div class="box_top_container" style="display: flex;">
                        <h1 class="box_top_title">{tieu_de}</h1>
                        <div class="sort-option-container">
                            <div class="sort-option" data-sort="price-descending">Giá giảm dần</div>
                            <div class="sort-option" data-sort="price-ascending">Giá tăng dần</div>
                        </div>
                    </div>

                    <div class="sort">
                        <div class="text">Sắp xếp: </div>
                        <select name="sort">
                            <option value="created-descending">Sản phẩm mới</option>
                            <option value="price-descending">Giá giảm dần</option>
                            <option value="price-ascending">Giá tăng dần</option>
                            <option value="title-ascending">Tên A -> Z</option>
                            <option value="title-descending">Tên Z -> A</option>
                        </select>
                    </div>
                    <div id="open-filters" class="btn open-filters d-lg-none d-block p-0">
                        <i class="fa fa-filter"></i>
                        <span>Lọc</span>
                    </div>
                </div>
                <div class="list_sanpham" id="keo_den_sanpham">{list_sanpham}</div>
                <div class="text-right pageinate-page-blog">
                    <div class="page_redirect">
                        {phantrang}
                    </div>
                </div>
                <input type="hidden" name="cat_id" value="{cat_id}">
            </div>
        </div>
    </div>
    {box_daxem}
    {footer}
    {script_footer}
    <div class="mobile-filters scroll">
        <button class="button-filters"><i class="fa fa-arrow-left mr-3 "></i><b class="d-inline">Tìm theo </b></button>
        <div class="aside-title">
            <h2 class="title-head"><span>Thương hiệu</span></h2>
            <i class="fa fa-chevron-down toggle-icon"></i>

        </div>
        <div class="aside-content">
            <ul class="list_where">
                {list_brand_mobile}
            </ul>
        </div>
        <div class="aside-title">
            <h2 class="title-head title_border"><span>Màu sắc</span></h2>
            <i class="fa fa-chevron-down toggle-icon"></i>
        </div>
        <div class="aside-content">
            <ul class="list_where">
                {list_color_mobile}
            </ul>
        </div>
        <div class="aside-title">
            <h2 class="title-head title_border"><span>Mức Giá</span></h2>
            <i class="fa fa-chevron-down toggle-icon"></i>
        </div>
        <div class="aside-content">
            <ul class="list_where">
                {list_price_mobile}
            </ul>
        </div>
        <div class="aside-title">
            <h2 class="title-head title_border"><span>Kích cỡ</span></h2>
            <i class="fa fa-chevron-down toggle-icon"></i>
        </div>
        <div class="aside-content">
            <ul class="list_where list_size">
                {list_size_mobile}
            </ul>
        </div>
    </div>
    <script>
        if ($(window).width() <= 480) {
            sl = 2;
        } else if ($(window).width() <= 768) {
            sl = 3;
        } else if ($(window).width() <= 1024) {
            sl = 4;
        } else {
            sl = 5;
        }
        var slide_recent = new Swiper('.slide_category', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            slidesPerView: sl,
            observer: true,
            observeParents: true,
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('select[name=sort]').val('{sort}');
        });
        $(document).ready(function () {
            $(".brand-box").click(function () {
                $(".brand-box").removeClass("selected");
                $(this).addClass("selected");
            });
        });

    </script>
</body>

</html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .shop-name {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .subcategory-products {
        display: flex;
        flex-wrap: nowrap;
        gap: 20px;
    }

    .subcategory-products-wrapper {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        width: 100%;
    }

    .subcategory-products-wrapper h4 {
        color: #333;
        font-size: 24px;
        font-weight: bold;
        text-transform: capitalize;
        letter-spacing: 1px;
        position: relative;
        transition: all 0.3s ease;
        border-left: 4px solid #ff0808;
        margin: 0 0 10px 0;
        padding-left: 10px;
    }

    .subcategory-products-wrapper h4:hover {
        color: #007bff;
        text-shadow: 0 4px 10px rgba(0, 123, 255, 0.5);
        transform: translateX(3px) scale(1.01);
        cursor: pointer;

    }

    .subcategory-products::-webkit-scrollbar {
        height: 8px;
    }

    .subcategory-products-wrapper {
        position: relative;
    }

    .subcategory-products {
        overflow-x: auto;
        white-space: nowrap;
    }

    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: #d5d9de;
        color: white;
        border: none;
        padding: 10px 10px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 25px;
        z-index: 1;
        transition: background-color 0.3s ease;
    }

    .scroll-btn:hover {
        background-color: #0056b3;
        /* Màu khi hover */
    }

    .prev-btn {
        left: 10px;
        /* Cách lề trái */
    }

    .next-btn {
        right: 10px;
        /* Cách lề phải */
    }

    /* Container sản phẩm */
    .subcategory-products {
        overflow-x: auto;
        scroll-behavior: smooth;
    }

    /* Thanh cuộn cho trình duyệt WebKit (Chrome, Safari) */
    .subcategory-products::-webkit-scrollbar {
        height: 8px;
        /* Thanh cuộn nhỏ gọn */
    }

    .subcategory-products::-webkit-scrollbar-track {
        background: #f2f2f2;
        /* Màu nền nhạt cho track */
        border-radius: 4px;
    }

    .subcategory-products::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .subcategory-products::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .subcategory-products::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .subcategory-products .li_product {
        flex: 0 0 auto;
        width: 200px;
        /* Chiều rộng cố định cho mỗi sản phẩm */
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        padding: 10px;
        transition: transform 0.3s ease;
    }

    .main_tintuc .box_list_sanpham .box_content .list_sanpham .li_product {
        width: calc(80% / 4);
    }

    .main_tintuc .box_list_sanpham .box_content .list_sanpham .li_product .li_product {
        width: 100%;

    }

    @media (max-width: 575.98px) {
        .subcategory-products .li_product {
            width: 150px;
            /* Giảm chiều rộng sản phẩm */
        }

        .subcategory-products-wrapper h4 {
            font-size: 18px;
            /* Giảm kích thước tiêu đề */
        }

        .subcategory-products {
            gap: 10px;
            /* Giảm khoảng cách giữa các sản phẩm */
        }

        .main_tintuc .box_list_sanpham .box_content .list_sanpham .li_product {
            width: calc(100% / 2);
            /* Hiển thị 2 sản phẩm trên 1 hàng */
        }


        .box_filter_desktop {
            display: none;
            /* Ẩn bộ lọc desktop trên mobile */
        }


    }

    @media (min-width: 576px) and (max-width: 767.98px) {
        .subcategory-products .li_product {
            width: 180px;
            /* Tăng chiều rộng sản phẩm */
        }

        .subcategory-products-wrapper h4 {
            font-size: 20px;
            /* Tăng kích thước tiêu đề */
        }

        .subcategory-products {
            gap: 15px;
            /* Tăng khoảng cách giữa các sản phẩm */
        }

        .main_tintuc .box_list_sanpham .box_content .list_sanpham .li_product {
            width: calc(100% / 2);
            /* Vẫn hiển thị 2 sản phẩm trên 1 hàng */
        }

        .box_filter_desktop {
            display: none;
            /* Ẩn bộ lọc desktop */
        }

        .mobile-filters {
            display: block;
            /* Hiển thị bộ lọc mobile */
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .subcategory-products .li_product {
            width: 220px;
            /* Tăng chiều rộng sản phẩm */
        }

        .subcategory-products-wrapper h4 {
            font-size: 22px;
            /* Tăng kích thước tiêu đề */
        }

        .subcategory-products {
            gap: 20px;
            /* Giữ khoảng cách rộng rãi */
        }

        .main_tintuc .box_list_sanpham .box_content .list_sanpham .li_product {
            width: calc(100% / 3);
            /* Hiển thị 3 sản phẩm trên 1 hàng */
        }

        .box_filter_desktop {
            display: block;
            /* Hiển thị bộ lọc desktop */
        }

        .mobile-filters {
            display: none;
            /* Ẩn bộ lọc mobile */
        }
    }
</style>
<script>
    document.querySelectorAll('.subcategory-products-wrapper').forEach(wrapper => {
        const scrollContainer = wrapper.querySelector('.subcategory-products');
        const prevBtn = wrapper.querySelector('.prev-btn');
        const nextBtn = wrapper.querySelector('.next-btn');

        // Tính khoảng cách cuộn: (chiều rộng sản phẩm + gap) * 3
        const scrollAmount = (200 + 20) * 3; // 660px cho 3 sản phẩm

        // Cuộn sang trái khi bấm nút "Trước"
        prevBtn.addEventListener('click', () => {
            scrollContainer.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth' // Cuộn mượt mà
            });
        });

        // Cuộn sang phải khi bấm nút "Sau"
        nextBtn.addEventListener('click', () => {
            scrollContainer.scrollBy({
                left: scrollAmount,
                behavior: 'smooth' // Cuộn mượt mà
            });
        });
    });
</script>

<style>
    .label_product {
        position: absolute;
        top: -2px;
        right: -1px;
        background: linear-gradient(135deg, #ff7f00, #ff5500) !important;
        color: white !important;
        font-weight: bold !important;
        font-size: 14px !important;
        padding: 5px 10px !important;
        border-radius: 5px !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .label_wrapper {
        display: inline-block;
    }

    .tab_box .tab .li_product .product-content .label_product::after {
        content: none;
        width: 0;
        height: 0;
        left: 0;
        bottom: -4px;
        position: absolute;
        border-color: transparent var(--label-background);
        border-style: solid;
        border-width: 0 20px 5px;
    }

    .main_tintuc .box_list_sanpham .box_content .list_sanpham .li_product .product-content .label_product::after {
        content: none;
        width: 0;
        height: 0;
        left: 0;
        bottom: -4px;
        position: absolute;
        border-color: transparent var(--label-background);
        border-style: solid;
        border-width: 0 20px 5px;
    }

    .tab_box .tab .li_product .product-content .label_product {
        position: absolute;
        top: 7px !important;
        right: 8px !important;
        background: #d41e25;
        padding: 7px 2px;
        font-weight: bold;
        font-size: 12px;
        z-index: 3;
    }

    /*Css cho bộ lọc*/
    @media (min-width: 1024px) {
        /* CSS cho .box_filter và các thành phần bên trong */

        .li_box>div:first-child {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            padding: 10px 0;
            color: #333;
            position: sticky;
            top: -8px;
            /* Giữ tiêu đề ở phía trên của container cha */
            background-color: #fff;
            /* Đảm bảo tiêu đề không bị che bởi nội dung khác */
            z-index: 1;
            /* Đảm bảo tiêu đề hiển thị trên các phần tử khác */
            border-bottom: 1px solid #ddd;
            /* Thêm đường viền dưới để phân biệt */
        }

        .box_filter .li_box {
            flex: 1 1 calc(25% - 10px);
            /* 4 cột trên 1 hàng */
            box-sizing: border-box;
            max-height: 200px;
            /* Giới hạn chiều cao */
            overflow-y: auto;
            /* Thêm thanh cuộn dọc */
            position: relative;
            /* Đảm bảo container cha có position relative */
        }

        .box_filter .li_box_content::-webkit-scrollbar {
            width: 6px;
        }

        .box_filter .li_box_content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .box_filter .li_box_content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .box_filter .li_box_content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .brand-container,
        .color-container,
        .size-container,
        .price-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            overflow: visible;
            max-height: none;
        }

        /* Đảm bảo các container bên trong không bị giới hạn chiều cao */
        .brand-container,
        .color-container,
        .size-container,
        .price-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            overflow: visible;
            max-height: none;
        }

        /* CSS cho các .brand-box, .color-box, .size-box, và .price-box_nhat */
        .brand-box,
        .color-box,
        .size-box,
        .price-box_nhat {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            cursor: pointer;
            text-align: center;
            font-size: 14px;
            transition: 0.3s;
        }

        .brand-box:hover,
        .brand-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .color-box:hover,
        .color-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .size-box:hover,
        .size-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .price-container .price-box_nhat:hover,
        .price-container .price-box_nhat.selected {
            background-color: #007bff !important;
            color: white !important;
            border-color: #007bff !important;
        }

        /* CSS cho các tiêu đề và icon trong .aside-title */
        .aside-title {
            cursor: pointer;
            /* Biến con trỏ thành bàn tay khi di chuột qua */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .aside-title h2 {
            margin: 0;
            font-size: 16px;
        }

        .toggle-icon {
            transition: transform 0.3s ease;
            /* Hiệu ứng xoay icon */
        }



        /* CSS cho các .sort-option */
        .sort-option {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
            transition: all 0.3s ease;
        }

        .sort-option:hover {
            background-color: #f0f0f0;
        }

        .sort-option.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .box_content_desktop {
            width: 80%;
            /* Hoặc max-width: 1200px; */
            margin: 0 auto;
            /* Căn giữa */
            padding: 20px;
            background-color: #ffffff;
            border-bottom: 0.5px #ebebeb solid;
            z-index: 101;
        }

        .box_filter {
            max-height: 500px;
            /* Chiều cao cố định */
            overflow-y: auto;
            /* Cho phép cuộn */

            top: 70px;

            z-index: 100;
        }

        .box_top_title {
            margin: 11px;
        }

        .price-container,
        .brand-container,
        .color-container,
        .size-container {
            max-height: 0px;
            /* Giới hạn chiều cao ban đầu */
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .price-container.expanded,
        .brand-container.expanded,
        .color-container.expanded,
        .size-container.expanded {
            max-height: 400px;
            /* Chiều cao khi mở rộng */
        }

        .toggle-button {
            display: block;
            margin: auto;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;

        }

    }

    /*brand*/
    /*Color*/

    /* CSS cho màn hình mobile (chiều rộng tối đa 768px) */

    /* CSS tối ưu cho mobile */
    @media (max-width: 768px) {
        .box_top_title {
            margin-left: 5px;
            margin-top: 11px;
        }

        .mobile-filters .title-head {
            border-top: 1px solid #eee;
            padding-top: 10px;
            width: 100%;
            text-transform: uppercase;
            font-weight: 400;
            font-size: 16px;
        }

        /* Thiết lập cuộn cho từng danh sách */
        .aside-content {
            max-height: 200px;
            /* Chiều cao tối đa của danh sách */
            overflow-y: auto;
            /* Cho phép cuộn dọc */
            margin-bottom: 10px;
            /* Khoảng cách giữa các danh sách */
            padding: 5px;
            /* Thêm padding để nội dung không dính vào viền */
        }

        /* Thiết lập cuộn cho danh sách thương hiệu */
        .brand-container .aside-content {
            max-height: 150px;
            /* Chiều cao tối đa cho danh sách thương hiệu */
        }

        /* Thiết lập cuộn cho danh sách màu sắc */
        .color-container .aside-content {
            max-height: 120px;
            /* Chiều cao tối đa cho danh sách màu sắc */
        }

        /* Thiết lập cuộn cho danh sách mức giá */
        .price-container .aside-content {
            max-height: 150px;
            /* Chiều cao tối đa cho danh sách mức giá */
        }

        /* Thiết lập cuộn cho danh sách kích cỡ */
        .size-container .aside-content {
            max-height: 150px;
            /* Chiều cao tối đa cho danh sách kích cỡ */
        }

        s .box_filter {
            width: 100%;
            padding: 10px;
            background: #f8f8f8;
            border-radius: 8px;
        }

        .box_content {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .li_box {
            width: calc(50% - 10px);
            /* Chia 2 cột, trừ khoảng cách giữa */
            width: calc(50% - 10px);
            /* Chia 2 cột, trừ khoảng cách giữa */
            background: #fff;
            padding: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .li_box>div:first-child {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .main_tintuc .box_filter .box_content .li_box .li_box_content {
            width: 100%;
            display: flex;
            gap: 10px;
            height: 499%;
            align-items: center;
            padding-left: 10px;
            padding-right: 10px;
        }

        .price-container,
        .brand-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .price-box_nhat,
        .brand-box,
        .color-box,
        .size-box {
            background: #eee;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .price-box_nhat:hover,
        .brand-box:hover,
        .color-box:hover,
        .size-box:hover {
            background: #ddd;
        }

        .price-box_nhat span,
        .brand-box span,
        .color-box span,
        .size-box span {
            font-weight: bold;
        }

        .box_filter .li_box {
            flex: 1 1 calc(50% - 10px);
            /* 4 cột bằng nhau */
            box-sizing: border-box;
        }

        #open-filters {
            height: 30px;
            padding-top: 5px !important;
            padding-left: 5px !important;
            border-radius: 4px;
            /* padding: 4px; */
            background-color: #fff;
            display: block;
            position: relative;
            right: -1px;
            top: 0;
            width: 51px;
            cursor: pointer;
        }

        /* CSS cho tiêu đề và icon */
        .aside-title {
            cursor: pointer;
            /* Biến con trỏ thành bàn tay khi di chuột qua */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .aside-title h2 {
            margin: 0;
            font-size: 16px;
        }

        .toggle-icon {
            transition: transform 0.3s ease;
            /* Hiệu ứng xoay icon */
        }

        /* Khi nội dung được ẩn */
        .aside-content.collapsed {
            display: none;
        }

        /* Xoay icon khi nội dung được ẩn */
        .aside-title.collapsed .toggle-icon {
            transform: rotate(180deg);
        }

        .sort-option {
            /* float: right; */
            font-size: 12px !important;
            cursor: pointer;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
            transition: all 0.3sease;
        }

        .sort-option:hover {
            background-color: #f0f0f0;
        }

        .sort-option.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .box_filter_desktop {
            display: none !important;
        }

        .size-container {
            padding-top: 100px;
        }

        .color-container {
            padding-top: 50px;
        }

        .price-container {
            padding-top: 50px;
        }

        .brand-container {
            padding-top: 100px;
        }

        .brand-box:hover,
        .brand-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .color-box:hover,
        .color-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .size-box:hover,
        .size-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .aside-content .price-box_nhat:hover,
        .aside-content .price-box_nhat.selected {
            background-color: #007bff !important;
            color: white !important;
            border-color: #007bff !important;
        }

        .main_tintuc .box_list_sanpham .box_content .box_top h1 {
            font-size: 15px !important;
            font-weight: 700;
        }

        .box_top_container {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .sort-option-container {
            display: flex;
            float: left;
        }


    }

    @media (max-width: 980px) {
        #open-filters {
            height: 30px;
            padding-top: 5px !important;
            padding-left: 5px !important;
            border-radius: 4px;
            /* padding: 4px; */
            background-color: #fff;
            display: block;
            position: relative;
            right: -1px;
            top: 0;
            width: 51px;
            cursor: pointer;
        }

        .li_box>div:first-child {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            padding: 10px 0;
            color: #333;
            position: sticky;
            top: -8px;
            /* Giữ tiêu đề ở phía trên của container cha */
            background-color: #fff;
            /* Đảm bảo tiêu đề không bị che bởi nội dung khác */
            z-index: 1;
            /* Đảm bảo tiêu đề hiển thị trên các phần tử khác */
            border-bottom: 1px solid #ddd;
            /* Thêm đường viền dưới để phân biệt */
        }

        .box_filter .li_box {
            flex: 1 1 calc(25% - 10px);
            /* 4 cột trên 1 hàng */
            box-sizing: border-box;
            max-height: 200px;
            /* Giới hạn chiều cao */
            overflow-y: auto;
            /* Thêm thanh cuộn dọc */
            position: relative;
            /* Đảm bảo container cha có position relative */
        }

        .box_filter .li_box_content::-webkit-scrollbar {
            width: 6px;
        }

        .box_filter .li_box_content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .box_filter .li_box_content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .box_filter .li_box_content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .brand-container,
        .color-container,
        .size-container,
        .price-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            overflow: visible;
            max-height: none;
        }

        /* Đảm bảo các container bên trong không bị giới hạn chiều cao */
        .brand-container,
        .color-container,
        .size-container,
        .price-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            overflow: visible;
            max-height: none;
        }

        /* CSS cho các .brand-box, .color-box, .size-box, và .price-box_nhat */
        .box_content_desktop .brand-box,
        .color-box,
        .size-box,
        .price-box_nhat {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;

            cursor: pointer;
            text-align: center;
            font-size: 14px;
            transition: 0.3s;
        }

        .brand-box:hover,
        .brand-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .color-box:hover,
        .color-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .size-box:hover,
        .size-box.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .price-container .price-box_nhat:hover,
        .price-container .price-box_nhat.selected {
            background-color: #007bff !important;
            color: white !important;
            border-color: #007bff !important;
        }

        /* CSS cho các tiêu đề và icon trong .aside-title */
        .aside-title {
            cursor: pointer;
            /* Biến con trỏ thành bàn tay khi di chuột qua */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .aside-title h2 {
            margin: 0;
            font-size: 16px;
        }

        .toggle-icon {
            transition: transform 0.3s ease;
            /* Hiệu ứng xoay icon */
        }



        /* CSS cho các .sort-option */
        .sort-option {
            /* float: right; */
            font-size: 12px !important;
            cursor: pointer;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
            transition: all 0.3sease;
        }

        .sort-option:hover {
            background-color: #f0f0f0;
        }

        .sort-option.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .box_content_desktop {
            width: 80%;
            /* Hoặc max-width: 1200px; */
            margin: 0 auto;
            /* Căn giữa */
            padding: 20px;
            background-color: #ffffff;
            border-bottom: 0.5px #ebebeb solid;
            z-index: 101;
        }

        .box_filter {
            max-height: 500px;
            /* Chiều cao cố định */
            overflow-y: auto;
            /* Cho phép cuộn */

            top: 70px;

            z-index: 100;
        }

        .box_top_title {
            margin-top: 11px;
            margin-left: 5px;
        }

        .box_top_container {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .sort-option-container {
            display: flex;
            float: left;
        }

    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Lấy tất cả các tiêu đề có thể thu gọn
        const asideTitles = document.querySelectorAll(".aside-title");

        asideTitles.forEach(title => {
            title.addEventListener("click", function () {
                // Tìm phần tử nội dung tương ứng
                const content = this.nextElementSibling;

                // Toggle lớp 'collapsed' để ẩn/hiện nội dung
                content.classList.toggle("collapsed");

                // Toggle lớp 'collapsed' cho tiêu đề để xoay icon
                this.classList.toggle("collapsed");
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.querySelector('.toggle-button');
        const containers = document.querySelectorAll('.price-container, .brand-container, .color-container, .size-container');

        toggleButton.addEventListener('click', function () {
            containers.forEach(container => {
                if (container.classList.contains('expanded')) {
                    container.classList.remove('expanded');
                    this.textContent = 'Xem thêm bộ  lọc';
                } else {
                    container.classList.add('expanded');
                    this.textContent = 'Thu gọn';
                }
            });
        });
    });

</script>