<style>
    @media (min-width: 1200px) {
        .col-xl-3_lienquan {
            flex: 0 0 20%;
            /* Chiếm 20% chiều rộng */
            max-width: 20%;
            /* Đảm bảo hiển thị tối đa 5 cột */
        }

    }
</style>
<style>
    .menu-item-count .subcategory-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .menu-item-count .subcategory-list li {
        margin: 5px 0;
        padding: 0;
    }

    .menu-item-count .subcategory-list a {
        text-decoration: none;
        color: #333;
    }

    .menu-item-count .subcategory-list a:hover {
        color: #007bff;
    }

    .hidden {
        display: none;
    }

    .dropdown-search {
        position: absolute;
        top: 50px;
        /* Khoảng cách dưới icon */
        left: 0;
        width: 100%;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        z-index: 1000;
        padding: 15px;
    }

    .dropdown-search input {
        width: calc(100% - 30px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #output_search {
        position: absolute;
        top: 100%;
        left: 22%;
        background: #fff;
        width: 60%;
        z-index: 1000;
        list-style: none;
        padding: 0;
        margin: 0;
    }



    /* Định dạng danh sách kết quả tìm kiếm */
    #output_search {
        list-style: none;
        padding: 0;
        margin: 0;
        background-color: #fff;
        border: 1px solid #ddd;
        max-height: 400px;
        overflow-y: auto;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        position: absolute;

        z-index: 1000;
        border-radius: 8px;
    }

    /* Định dạng mỗi sản phẩm */
    #output_search .list-group {
        display: flex;
        align-items: center;
        padding: 12px;
        transition: background-color 0.3s ease-in-out;
        border-bottom: 1px solid #f1f1f1;
    }

    /* Hover hiệu ứng */
    #output_search .list-group:hover {
        background-color: #f8f9fa;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Ảnh sản phẩm */
    #output_search .image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-left: 15px;
        border-radius: 6px;
    }

    /* Tên sản phẩm */
    #output_search .name_product a {
        font-size: 12px;
        color: #333;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    #output_search .name_product a:hover {
        color: #5053f5;
    }

    /* Giá sản phẩm */
    #output_search .price_product_new {
        color: #f11d1d;
        font-size: 12px;
        font-weight: bold;
        margin-right: 10px;
    }

    #output_search .price_product_old {
        color: #d21765;
        font-size: 12px;
        text-decoration: line-through;
    }

    .product-info {
        margin-left: 35px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #output_search .list-group {
            flex-direction: column;
            align-items: flex-start;
        }

        #output_search .image img {
            width: 50px;
            height: 50px;
        }
    }
</style>
<header class="ega-header ega-pos--relative">
    <div class="header-wrap container">
        <!-- Chưa để làm gì -->
        <div class="toggle-nav btn menu-bar mr-4 ml-0 p-0 d-lg-none d-flex text-white">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <!-- logo -->
        <div id="logo">
            <a href="/" class="logo-wrapper">
                <img class="img-fluid" src="{logo}" alt="logo" width="134" height="45" />
            </a>
        </div>
        <!-- navigation-wrapper  -->
        <div class="navigation--horizontal d-lg-flex align-items-center d-none">
            <div class=" navigation-horizontal-wrapper">
                <!-- Header_menu_center -->

                <nav>
                    <ul class="navigation navigation-horizontal list-group list-group-flush scroll">
                        <li class="menu-item list-group-item">
                            <a href="/" class="menu-item__link" title="Sản phẩm">
                                <span>Danh mục Sản phẩm</span>

                                <i class="float-right" data-toggle-submenu>
                                    <svg class="icon">
                                        <use xlink:href="#icon-arrow" />
                                    </svg>
                                </i>
                            </a>

                            <div class="submenu scroll mega-menu">
                                <div class="toggle-submenu d-lg-none d-xl-none">
                                    <i class="mr-3">
                                        <svg class="icon" style="transform: rotate(180deg)">
                                            <use xlink:href="#icon-arrow" />
                                        </svg>
                                    </i>
                                    <span> Danh mục sản phẩm </span>

                                </div>
                                <ul class="submenu__list container">

                                    {list_category_nav}

                                </ul>
                            </div>
                        </li>

                        {menu_mobile}
                    </ul>
                </nav>
            </div>
            <!-- icon -->
            <div class="navigation-arrows">
                <i class="fas fa-chevron-left prev disabled"></i>
                <i class="fas fa-chevron-right next"></i>
            </div>

        </div>


        <!-- header_right -->
        <div class="header-right ega-d--flex">
            <div id="desktop-lang"></div>

            <div class="icon-action header-right__icons" style="--header-grid-template: repeat(3, 1fr)">
                <span class="header-icon icon-action__search icon-action__search--desktop toggle_form_search_1">
                    <img src="/uploads/minh-hoa/icon-search.png" alt="icon-search" />
                </span>
                <div id="searchDropdown" class="dropdown-search hidden ">
                    <!-- logo -->
                    <div id="logo ">
                        <a href="/" class="logo-wrapper ">
                            <img class="img-fluid logo-wrapper_mobile" src="{logo}" alt="logo" width="134" height="45">
                        </a>
                    </div>
                    <!-- timkiem -->
                    <div class="timkiem_mobile">
                        <form method="GET" action="/tim-kiem.html"
                            class="input-group search-bar custom-input-group  search-bar search_form" role="search">
                            <input type="search" name="key" id="key"
                                class="input-group-field auto-search form-control input-group-field st-default-search-input search-text"
                                required="" data-placeholder="Tìm theo tên sản phẩm...; Tìm theo thương hiệu...;">
                            <span class="input-group-btn btn-action input-group-btn">
                                <button type="submit" aria-label="search"
                                    class="btn text-white icon-fallback-text h-100 icon-fallback-text">
                                    <svg class="icon">
                                        <use xlink:href="#icon-search" />
                                    </svg></button>
                            </span>
                        </form>
                        <ul id="output_search"></ul>
                        <div class="search-dropdow">
                            <ul class="list-inline search__list pl-0 d-flex list-unstyled mb-0 flex-wrap">
                                {list_category_sub}
                            </ul>
                        </div>
                    </div>
                    <!-- thontintaikhoan -->
                    <div>
                        <div class="header-right ega-d--flex">
                            <div class="icon-action header-right__icons"
                                style='--header-grid-template: repeat(3, 1fr);'>
                                <div id="icon-account"
                                    class="ega-color--inherit header-icon icon-account d-none d-md-block d-lg-block">
                                    <svg class="icon">
                                        <use xlink:href="#icon-user" />
                                    </svg>
                                    <div class="account-action">
                                        <a href="/tai-khoan.html">Thông tin</a>
                                        <a href="/don-hang.html">Đơn hàng của bạn</a>
                                        <a href="/doi-mat-khau.html">Đổi mật khẩu</a>
                                        <a href="/dang-xuat.html">Đăng xuất</a>
                                    </div>
                                </div>
                                <div class="mini-cart text-xs-center logo-wrapper_mobile">
                                    <a class="header-icon cart-count ega-color--inherit " href="/gio-hang.html"
                                        title="Giỏ hàng">
                                        <img class="logo-wrapper_mobile" src="/uploads/minh-hoa/icon-cart.png"
                                            alt="icon-cart" />
                                        <span class="count_item count_item_pr logo-wrapper_mobile">
                                            <?php echo count((array)$_SESSION['cart']);?>
                                        </span>
                                    </a>
                                    <div class="top-cart-content card">
                                        <ul id="cart-sidebar" class="mini-products-list count_li list-unstyled">
                                            <ul class="list-item-cart">
                                                {list_cart}
                                            </ul>
                                            <div class="pd">
                                                <!-- <div class="top-subtotal">
                                                    Tổng tiền tạm tính:
                                                    <span class="price price_big">{tongtien}₫</span>
                                                </div> -->
                                            </div>
                                            <div class="pd right_ct">
                                                <a type="button" onclick="window.location.href='/checkout.html?step=1'"
                                                    class="btn btn-white btn-proceed-checkout-mobile"><span>Tiến hành
                                                        thanh toán</span></a>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- <form action="/tim-kiem.html" method="GET" class="input-group search-bar custom-input-group  search-bar search_form" role="search">
                        <input type="search" id="key" name="key" value="" autocomplete="off"
                        class="input-group-field auto-search form-control input-group-field st-default-search-input search-text" required=""
                        data-placeholder="Tìm theo tên sản phẩm...; Tìm theo thương hiệu...;">
                        <input type="hidden" name="type" value="product">
                        <span class="input-group-btn btn-action input-group-btn">
                            <button type="submit"  aria-label="search" class="btn text-white icon-fallback-text h-100 icon-fallback-text">
                            <svg class="icon">
                                <use xlink:href="#icon-search" />
                            </svg></button>
                        </span> 
                    </form> -->
                </div>
                <div id="icon-account" class="ega-color--inherit header-icon icon-account d-none d-lg-block">
                    <img src="/uploads/minh-hoa/icon-account.png" alt="icon-account" />
                    <div class="account-action">

                        <a href="/tai-khoan.html">Thông tin</a>
                        <a href="/don-hang.html">Đơn hàng của bạn</a>
                        <a href="/doi-mat-khau.html">Đổi mật khẩu</a>
                        <a href="/dang-xuat.html">Đăng xuất</a>

                    </div>
                </div>
                <div class="mini-cart text-xs-center">
                    <a class="header-icon cart-count ega-color--inherit" href="/gio-hang.html" title="Giỏ hàng">
                        <img src="/uploads/minh-hoa/icon-cart.png" alt="icon-cart" />
                        <span class="count_item count_item_pr">
                            <?php echo count((array)$_SESSION['cart']);?>
                        </span>
                    </a>
                    <div class="top-cart-content card">
                        <ul id="cart-sidebar" class="mini-products-list count_li list-unstyled">
                            <ul class="list-item-cart">
                                {list_cart}
                            </ul>
                            <div class="pd">
                                <!-- <div class="top-subtotal">
                                    Tổng tiền tạm tính:
                                    <span class="price price_big">{tongtien}₫</span>
                                </div> -->
                            </div>
                            <div class="pd right_ct">
                                <a type="button" onclick="window.location.href='/checkout.html?step=1'"
                                    class="btn btn-white btn-proceed-checkout-mobile"><span>Tiến hành thanh
                                        toán</span></a>
                            </div>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <style>
        .ega-header .header-wrap .header-right__icons #icon-account .account-action {
            width: 150px !important;
        }
    </style>
    <style>
        .dropdown.offset {
            top: 50px;
        }

        .dropdown {

            position: sticky;
            top: 0;
            background: #fff;
            border: 1px solid #ddd;
            width: 100%;
            z-index: 1000;
        }

        .dropdown.hidden {
            display: none;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .dropdown-item h4 {
            margin: 0;
            font-size: 14px;
        }

        .dropdown-item p {
            margin: 0;
            font-size: 12px;
            color: #888;
        }

        .hidden {
            display: none;
        }

        #searchDropdown {

            margin-top: -20px;
            justify-content: space-between;
            display: flex;


            top: 0;

            left: 50%;
            transform: translateX(-50%);
            width: 102%;
            height: 200px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            z-index: 1000;
            transition: top 0.3s ease-in-out;
        }

        #searchDropdown.show {
            top: -30%;
            padding: 80px;
        }

        #searchDropdown input {

            width: calc(100% - 20%);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</header>
<!-- Tìm kiếm nâng cao -->
<script type="text/x-custom-template" data-template="stickyHeader">
    <header class="ega-header header header_sticky">
        <div class="container">
            <div class="header-wrap">

                <div id="logo">
                    <a href="/" class="logo-wrapper ">
                        <img class="img-fluid"
                             src="{logo}"
                             alt="logo"
                             width="134"
                             height="45"
                             >
                    </a>



                </div>

                <div class="ega-form-search">
                    <form action="/search" method="get" class="input-group search-bar custom-input-group " role="search">
        <input type="text" name="query" value="" autocomplete="off"
               class="input-group-field auto-search form-control " required=""
               data-placeholder="Tìm theo tên sản phẩm...; Tìm theo thương hiệu...;">
        <input type="hidden" name="type" value="product">
        <span class="input-group-btn btn-action">
            <button type="submit"  aria-label="search" class="btn text-white icon-fallback-text h-100">
                <svg class="icon">
        <use xlink:href="#icon-search" />
    </svg>		</button>
        </span>

    </form>



                                    <div class="search-dropdow">
                        <ul class="search__list pl-0 d-flex list-unstyled mb-0 flex-wrap">
                                                    <li class="mr-2 mt-2" >
                                <a id="filter-search-mau-sofa-moi" href="/search?q=tags:(M%E1%BA%ABu+Sofa+m%E1%BB%9Bi)&type=product">Mẫu Sofa mới</a>
                            </li>
                            <li class="mr-2 mt-2" >
                                <a id="filter-search-noi-that-phong-khach" href="/search?q=tags:(+N%E1%BB%99i+th%E1%BA%A5t+ph%C3%B2ng+kh%C3%A1ch)&type=product"> Nội thất phòng khách</a>
                            </li>
                            <li class="mr-2 mt-2" >
                                <a id="filter-search-den-trang-tri" href="/search?q=tags:(+%C4%90%C3%A8n+trang+tr%C3%AD)&type=product"> Đèn trang trí</a>
                            </li>
                        </ul>
                    </div>
                                                </div>

                <div class="header-right ega-d--flex">
                    <div class="icon-action header-right__icons" style='--header-grid-template: repeat(3, 1fr);'>

                        <div id="icon-account" class="ega-color--inherit header-icon icon-account d-none d-md-block d-lg-block">
                            <svg class="icon">
        <use xlink:href="#icon-user" />
    </svg>						<div class="account-action">

                       
            <a href="/tai-khoan.html">Thông tin</a>
            <a href="/don-hang.html">Đơn hàng của bạn</a>
            <a href="/doi-mat-khau.html">Đổi mật khẩu</a>
            <a href="/dang-xuat.html">Đăng xuất</a>

                                                        </div>
                        </div>
                        <div class="mini-cart text-xs-center">
                            <a class="header-icon cart-count ega-color--inherit" href="/cart"  title="Giỏ hàng">
                                 <img src="/uploads/minh-hoa/icon-cart.png" alt="icon-cart"/>
                                <span class="count_item count_item_pr">0</span>
                            </a>
                            <div class="top-cart-content card ">
                                <ul id="cart-sidebar" class="mini-products-list count_li list-unstyled">
                                    <li class="list-item">
                                        <ul></ul>
                                    </li>
                                    <li class="action">

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ega-header-layer"></div>
        </div>
    </header>
  </script>

<style>
    /* CSS cho li với class menu-item */
    .menu-item.list-group-item.active {
        background-color: #f8f9fa !important;
        /* Màu nền */
        color: #333 !important;
        /* Màu chữ */
        padding: 10px 15px !important;
        /* Padding */
        border-radius: 5px !important;
        /* Bo góc */
    }

    /* CSS cho a bên trong li */
    .menu-item.list-group-item.active .menu-item__link {
        font-weight: bold !important;
        /* Đậm chữ */
        color: black !important;
        /* Màu chữ của link */
        text-decoration: none !important;
        /* Loại bỏ gạch chân */
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* CSS cho icon trong a */
    .menu-item.list-group-item.active .menu-item__link i.float-right {
        transform: rotate(180deg) !important;
        /* Đảo chiều icon */
    }

    /* CSS cho submenu */
    .menu-item.list-group-item.active .submenu {
        display: none !important;
        /* Ẩn submenu mặc định */
    }

    .menu-item.list-group-item.active:hover .submenu {
        display: block !important;
        /* Hiển thị submenu khi hover */
    }

    /* CSS cho danh sách các mục trong submenu */
    .submenu__list.container .menu-item-count h3 a {
        font-size: 14px !important;
        /* Chỉnh cỡ chữ */
        color: black !important;
        /* Màu chữ của link */
        text-decoration: none !important;
        /* Loại bỏ gạch chân */
    }

    /* Thêm một số CSS khác nếu cần */
    .submenu__list.container .menu-item-count h3 a:hover {
        color: #ec720e !important;
        /* Màu khi hover */
    }
</style>


<script>
    function toggleBanner(isHidden) {
        const dropdown = document.querySelector('.dropdown');
        const banner = document.getElementById('.top-banner');

        if (isHidden) {
            // Ẩn banner và thêm offset cho dropdown
            banner.style.display = 'none';
            dropdown.classList.add('offset');
        } else {
            // Hiển thị banner và xóa offset
            banner.style.display = 'block';
            dropdown.classList.remove('offset');
        }
    }
    // timkiem js
    document.addEventListener("DOMContentLoaded", function () {
        const searchIcon = document.querySelector(".toggle_form_search_1");
        const searchDropdown = document.getElementById("searchDropdown");
        const overlay = document.createElement("div");

        // Tạo lớp phủ màn hình đen
        overlay.id = "overlay";
        overlay.style.position = "fixed";
        overlay.style.top = "0";
        overlay.style.left = "0";
        overlay.style.width = "100%";
        overlay.style.height = "100%";
        overlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
        overlay.style.zIndex = "999";
        overlay.style.display = "none";
        document.body.appendChild(overlay);

        // Hiển thị dropdown và overlay
        searchIcon.addEventListener("click", function () {
            searchDropdown.classList.add("show");
            searchDropdown.classList.remove("hidden");
            overlay.style.display = "block";
        });

        // Đóng dropdown khi nhấn vào overlay
        overlay.addEventListener("click", function () {
            searchDropdown.classList.remove("show");
            searchDropdown.classList.add("hidden");
            overlay.style.display = "none";
        });

        // Đóng dropdown bằng cách nhấn phím Esc
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                searchDropdown.classList.remove("show");
                searchDropdown.classList.add("hidden");
                overlay.style.display = "none";
            }
        });
    });

    // timkiem js
    $(document).ready(function () {
        //console.log("abc");
        $("#key").keyup(function () {

            var key = $("#key").val();
            //console.log(key);
            if (key !== "") {
                $.ajax({
                    url: "/process.php",
                    method: "POST",
                    data: {
                        action: 'filter_search',
                        key: key, // Truyền giá trị nhập vào
                    },
                    success: function (data) {
                        $("#output_search").html(data);
                    }
                });
            } else {
                $("#output_search").html("");
            }
            console.log("Search Name:", key);

        });
    });
    // shop_cart
    $('.cart-count').on('mouseenter', function () {
        console.log("abc");
        $.ajax({
            url: '/process.php',
            type: 'POST',
            data: {
                action: 'show_cart',
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(".list-item-cart").html(info.list_cart);
            }
        });
    });

    /*
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const dropdown = document.getElementById('dropdown');
        
            // Hiển thị dropdown khi focus vào input
            searchInput.addEventListener('focus', () => {
                dropdown.classList.remove('hidden');
            });
        
            // Ẩn dropdown khi click ra ngoài input và dropdown
            document.addEventListener('click', (event) => {
                // Kiểm tra nếu không click vào input hoặc dropdown
                if (!searchInput.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        
            // Đảm bảo dropdown không bị ẩn khi nhấn vào chính nó
            dropdown.addEventListener('click', (event) => {
                event.stopPropagation();
            });
        });
        
        */
</script>
<style>
    .menu-item-count .subcategory-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .menu-item-count .subcategory-list li {
        margin: 5px 0;
        padding: 0;
    }

    .menu-item-count .subcategory-list a {
        text-decoration: none;
        color: #333;
    }

    .menu-item-count .subcategory-list a:hover {
        color: #007bff;
    }

    .hidden {
        display: none;
    }

    .dropdown-search {
        position: absolute;
        top: 50px;
        /* Khoảng cách dưới icon */
        left: 0;
        width: 100%;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        z-index: 1000;
        padding: 15px;
    }

    .dropdown-search input {
        width: calc(100% - 30px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #output_search {
        position: absolute;
        top: 100%;
        left: 22%;
        background: #fff;
        width: 60%;
        z-index: 1000;
        list-style: none;
        padding: 0;
        margin: 0;
    }



    /* Định dạng danh sách kết quả tìm kiếm */
    #output_search {
        list-style: none;
        padding: 0;
        margin: 0;
        background-color: #fff;
        border: 1px solid #ddd;
        max-height: 400px;
        overflow-y: auto;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        position: absolute;

        z-index: 1000;
        border-radius: 8px;
    }

    /* Định dạng mỗi sản phẩm */
    #output_search .list-group {
        display: flex;
        align-items: center;
        padding: 12px;
        transition: background-color 0.3s ease-in-out;
        border-bottom: 1px solid #f1f1f1;
    }

    /* Hover hiệu ứng */
    #output_search .list-group:hover {
        background-color: #f8f9fa;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Ảnh sản phẩm */
    #output_search .image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-left: 15px;
        border-radius: 6px;
    }

    /* Tên sản phẩm */
    #output_search .name_product a {
        font-size: 12px;
        color: #333;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    #output_search .name_product a:hover {
        color: #5053f5;
    }

    /* Giá sản phẩm */
    #output_search .price_product_new {
        color: #f11d1d;
        font-size: 12px;
        font-weight: bold;
        margin-right: 10px;
    }

    #output_search .price_product_old {
        color: #d21765;
        font-size: 12px;
        text-decoration: line-through;
    }

    .product-info {
        margin-left: 35px;
    }

   /* Responsive */
   @media (max-width: 768px) {
    #output_search .image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-left: -10px;
        border-radius: 6px;
    }
    #output_search {
        position: absolute;
        top: 100%;
        left: 6%;
        background: #fff;
        width: 88%;
        z-index: 1000;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    #output_search .list-group {
        flex-direction: column;
        align-items: flex-start;
    }

    #output_search .image img {
        width: 50px;
        height: 50px;
    }

    .logo-wrapper_mobile {
        display: none;
    }

    .search-dropdow {
        display: none;
    }
    /* Desktop lớn (> 1200px) */
@media (min-width: 1200px) { 
    #output_search .list-group .row{
        width: 100%;
    }
 }

/* Desktop nhỏ và tablet ngang (992px - 1199px) */
@media (max-width: 1199px) { 
    #output_search .list-group .row{
        width: 100%;
    }
 }
}
</style>


<script type="text/x-custom-template" data-template="menuMobile">
	<div id="mobile-menu" class="scroll">
		<div class='media d-flex user-menu'>

			<i class="fas fa-user-circle mr-3 align-self-center"></i>
			<div class="media-body d-md-flex flex-column ">
				<a rel="nofollow" href="/tai-khoan.html" class="d-block" title="Tài khoản" >
					Tài khoản
				</a>
				<small>
					<a href="/dang-xuat.html" title="Đăng xuất" class="font-weight: light">
						Đăng xuất
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".footer-click ul li span").forEach(span => {
            span.removeAttribute("style");
        });
    });
</script>

<style type="text/css">
    body{
        background: {bg_backgroud} !important;
    } 
    .top-banner{
        background: {bg_topbar} !important;
    }
    .ega-header, .ega-pos--relative {
        background: {bg_header} !important;
    }
    .header .top-cart-contain, .header .hotline_dathang{
        background: {bg_hotline} !important;
    }
    .header nav{
        background: {bg_menu} !important;
    }
    .header nav .mainmenu{
        background: {bg_title_menu} !important;
    }
    .navigation .list-group-item>a{
        color: {bg_title_menu} !important;
    }
    .submenu__list.container .menu-item-count h3 a
    {
        color: {bg_title_menu} !important;
    }
    header.header nav .mainmenu .nav-cate ul {
        width: 100%;
        min-height: 364px;
        background: #fff;
        overflow: visible;
        border: 1px solid {bg_title_menu} !important;
        border-top: none;
    }
    header.header nav .mainmenu .nav-cate ul li:hover {
        background-color: {bg_title_menu} !important;
    }
    header nav .nav-item>a:hover{
        background-color: {bg_title_menu} !important;
    }
    header nav .nav-item:hover{
        background-color: {bg_title_menu} !important;
    }
    .section_product.color_group_2 .group-top-product .section_product_title{
        background: {bg_title_box} !important;
    }
    .box_category_slide .container .box_category .box_category_title{
        background: {bg_title_box} !important;
    }
    .box_tintuc_index .box_title{
        border-bottom: 2px solid {bg_title_box} !important;
    }
    .box_tintuc_index .box_title h2{
        background: {bg_title_box} !important;
    }
    .section_product.color_group_2 .group-top-product .section_product_title:after{
        border-left-color: {bg_title_box} !important;
    }
    @media (max-width: 991px){
        .section_product .group-top-product .menu-button-edit {
            color: {bg_title_box} !important;
        }
    }
    .backtop{
        background: {bg_button_top} !important;
    }
    .footer .tt-footer-default{
        background: {bg_subcribe} !important;
    }
    #mobile-menu{
        background: {bg_top_menu_mobile} !important;
    }
    .coupon_item .coupon_icon, .coupon_item.coupon--new-style .coupon_body {
        background: {bg_ma_giamgia} !important;
    }
    .item_product_main .label_product  {
        background: {bg_label_sale} !important;
    }
    .box_coupon .box_title h2{
        background: {bg_title_box} !important;
    }
    .box_coupon .box_title h2:after{
        border-left-color: {bg_title_box} !important;
    }
    .box_flash_sale .box_title h2{
        background: {bg_title_box} !important;
    }
    .box_flash_sale .box_title h2:after{
        border-left-color: {bg_title_box} !important;
    }
    .box_index .box_title h2{
        background: {bg_title_box} !important;
    }
    .box_index .box_title {
        border-bottom: 2px solid {bg_title_box} !important;
    }
    .box_index .box_title span button{
        background: {bg_title_box} !important;
    }
    .box_index .img_category .box_title_laptop{
        background: {bg_title_box} !important;
    }
    .box_index .list_sanpham .text_more a{
        background: {bg_title_box} !important;
    }
    .box_index .list_sanpham .li_sanpham .info .button-link button{
        background: {bg_title_box} !important;
    }
    .box_index .list_sanpham .button_next{
        background: {bg_title_box} !important;
    }
    .box_index .list_sanpham .button_prev{
        background: {bg_title_box} !important;
    }
    footer .mid-footer, footer .footer-click ul {
        background: {bg_top_footer} !important;
    }
    .footer .site-footer ul{
        background: {bg_top_footer} !important;
    }
    footer .list-menu a{
        color: {color_text_top_footer} !important;
    }
    footer .list-menu li{
        color: {color_text_top_footer} !important;
    }
    .footer-click ul li p, .footer-click ul li span, .footer-click .list-menu li a, .footer-click .mailchimp-title {
        color: {color_text_top_footer} !important;
    }
    .col-lg-3 register{
        color: blue !important;
    }
    footer .newsletter-form  .custom-input-group .input-group-btn{
        background: {bg_nhantin} !important;
    }
    .custom-input-group .input-group-btn{
        background: {bg_timkiem} !important;
    }
    .mid-footer .footer-block .footer-title{
        color: {color_text_title_top_footer} !important;
    }
</style>
