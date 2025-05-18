{header}
<style>
    /* Container bố trí 2 cột ngang */
    .content-horizontal {
        display: flex;
        gap: 20px;
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
    }

    /* Cột bên trái */
    .left-column {
        flex: 1;
    }

    /* Cột bên phải: xếp chồng các box */
    .right-column {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 11px;
    }

    /* Style chung cho card */
    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 30px 1px;
        text-align: center;
    }

    /* Style riêng cho box giỏ hàng */
    .box_shopcart p {
        font-size: 16px;
        color: #666;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .box_shopcart img {
        max-width: 100%;
        height: auto;
        margin-bottom: 30px;
    }

    .box_shopcart .btn {
        display: inline-block;
        padding: 12px 30px;
        background-color: #f60;
        color: #fff;
        text-decoration: none;
        font-size: 16px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .box_shopcart .btn:hover {
        background-color: #e05500;
    }

    .box_daxem p,
    .box_deal p {
        font-size: 16px;
        color: #666;
    }

    /* Responsive: chuyển thành cột dọc trên thiết bị nhỏ */
    @media (max-width: 768px) {
        .content-horizontal {
            flex-direction: column;
        }
    }

    /* CSS chỉ áp dụng cho box_daxem trong giao diện giỏ hàng trống */
    /* Giả sử container đã có class: .box_daxem.card */
    .box_daxem.card {
        padding: 10px;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-sizing: border-box;
        width: 100%;
        height: 100%;
    }

    /* Tiêu đề của box đã xem */
    .box_daxem.card .title_box {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid #e0e0e0;
    }

    .box_daxem.card .title_box h4 {
        font-size: 18px;
        color: #333;
        margin: 0;
        text-align: left;
    }

    /* Swiper container bên trong box_daxem */
    .box_daxem.card .swiper-container.slide_category {
        margin-top: 10px;
        /* Giả sử tiêu đề chiếm khoảng 40-50px, trừ ra phần còn lại cho slide */
        height: calc(100% - 50px);
        overflow: hidden;
        box-sizing: border-box;
    }

    /* Wrapper và slide bên trong */
    .box_daxem.card .swiper-wrapper {
        display: flex;
        align-items: center;
    }

    .box_daxem.card .swiper-slide {
        flex: 0 0 auto;
        margin: 0 5px;
    }

    /* Các sản phẩm trong slider */
    .box_daxem.card .li_product {
        width: 120px;
        /* Điều chỉnh lại kích thước phù hợp với khung nhỏ */
        text-align: center;
        box-sizing: border-box;
    }

    .box_daxem.card .li_product .product-thumbnail {
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .box_daxem.card .li_product img.minh_hoa {
        width: 100%;
        height: auto;
        display: block;
    }

    /* Responsive: giảm kích thước sản phẩm nếu cần */
    @media (max-width: 768px) {
        .box_daxem.card .li_product {
            width: 100px;
        }
    }

    .tab_box .tab .li_product .product-content {
        font-size: 10px;
    }

    .tab_box .tab .li_product .product-content .compare-price {
        font-size: 8.5px;
    }

    .box_daxem.card .title_box {
        margin-bottom: -16px;
        padding-bottom: 5px;
        height: 25px;

    }

    .box_daxem.card .title_box h4 {
        font-size: 14px;
    }

    .home_box {
        width: 107%;
        margin-bottom: -30px;
    }

    .tab_box .tab .list_product_category .swiper-container .swiper-wrapper {
        width:122%;
        height: 104%;
    }

    .tab_box .tab .list_product_category .li_product {
        min-height: 1px;
        padding-right: 0px;
        padding-left: 1px;
        height: 195px;
        width: 103%;
    }

    .box_daxem.card .swiper-container.slide_category {
        margin-top: 20px;
    }

    .tab_box .tab .li_product .product-content .product-name {
        font-size: 12px;
        margin: 0px 0 -1px;
    }

    .tab_box .tab .li_product .product-content .product-info {
        padding: 1px;
    }

    .tab_box .tab .li_product .product-content .label_product .label_wrapper {
        width: 12px;
    }

    .tab_box .tab .li_product .product-content .label_product {
        position: absolute;
        top: 9px;
        right: 0px;
        background: #d41e25;
        padding: 11px 4px;
        font-weight: bold;
        font-size: 7px;
        z-index: 3;
    }

    .tab_box .tab .li_product .product-content .product-thumbnail .minh_hoa {
        position: absolute;
        top: 58%;
        left: 50%;
        transform: translate(-50%, -50%) scale(1);
        object-fit: cover;
        width: 100%;
        height: 100%;
        box-shadow: 0 4px 8px rgb(0 0 0 / 10%);
    }

    .tab_box .tab .list_product_category {
        width: 116%;
        position: relative;
        min-height: 1px;
        padding-right: 55px;
        padding-left: 0px;
        flex: 0 0 100%;
        margin-top: -10px;
    }

    .deal-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 10px;
        margin-bottom: 8px;
        border-bottom: 1px solid #e0e0e0;
    }
</style>
<style>
    /* Container chính của flash sale */
    /* Giới hạn kích thước của box_deal */
    .box_deal.card {
        height: 300px;
        max-width: 560px;
        overflow: hidden;
        padding: 10px;
        box-sizing: border-box;
        margin-top: 5px;
    }

    /* Tiêu đề của box */
    .deal-header {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
        text-align: left;
    }

    /* Container chính của ưu đãi */
    .deal-container {
        height: calc(100% - 30px);
        /* trừ đi phần tiêu đề */
        overflow: hidden;
        box-sizing: border-box;
    }

    .deal-products {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 5px;
        box-sizing: border-box;
        scroll-behavior: smooth;
    }

    /* Tùy chỉnh thanh cuộn */
    .deal-products::-webkit-scrollbar {
        height: 3px;
        /* Chiều cao của thanh cuộn ngang */
    }

    .deal-products::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Màu nền của track (đường ray) */
        border-radius: 10px;
        /* Bo góc track */
    }

    .deal-products::-webkit-scrollbar-thumb {
        background: #ff0909;
        /* Màu của thanh cuộn */
        border-radius: 10px;
        /* Bo góc thanh cuộn */
    }



    .deal-product-item {
        background: #f9f9f9;
        border-radius: 6px;
        padding: 1px;
        /* tăng chút padding cho nội dung */
        text-align: center;
        box-sizing: border-box;
        min-width: calc((560px - 3*10px) / 4);
        /* 4 sản phẩm: 560px container, gap 10px giữa các sản phẩm */
        transition: transform 0.3s ease;
    }

    .deal-product-item:hover {
        transform: translateY(-2px);
    }

    /* Ảnh sản phẩm */
    .deal-product-thumbnail img {
        width: 80%;
        height: auto;
        border-radius: 4px;
        margin-bottom: 4px;
    }

    /* Tên sản phẩm */
    .product-name {
        font-size: 12px;
        margin-bottom: 2px;
        color: #333;
        text-decoration: none;
        display: block;
    }

    /* Giá sản phẩm */
    .price-box {
        font-size: 10px;
        font-weight: bold;
        color: #f60;
    }

    .compare-price {
        font-size: 10px;
        color: #999;
        text-decoration: line-through;
        margin-left: 3px;
    }

    .discount {
        font-size: 10px;
        color: #d41e25;
        margin-left: 3px;
    }
</style>
<style>
    /* Giao diện chung cho mobile khi viewport <= 600px 
   (áp dụng cho hầu hết các thiết bị mobile từ 5.5″ đến 6.7″) */
    @media only screen and (max-width: 600px) {

        .compare-price {
            display: none;
        }

        .price-box .price {
            font-size: 10px;
        }

        .tab_box .tab .li_product .product-content .product-thumbnail .minh_hoa {
            top: 71%;
            left: 50%;
        }

        .tab_box .tab .li_product .product-content .price-contact,
        .tab_box .tab .li_product .product-content .price {
            margin: 4px 0 0px 19px;
        }

        .deal-right-inline {
            display: flex;
            flex-wrap: nowrap;
            /* Buộc không wrap */
            align-items: center;
            gap: 8px;
        }

    

        .tab_box .tab .list_product_category .li_product {
            height: 184px;
        }

        .deal-right-text {
            font-size: 16px;
            /* Giảm margin hoặc kích thước nếu cần để vừa với không gian mobile */
        }

        /* Nếu cần, bạn có thể điều chỉnh lại kích thước deal-countdown */
        #ega-badge-ctd {
            font-size: 14px;
            padding: 2px 4px;
        }

        .box_daxem {
            height: 40%;
            max-width: 560px;
        }

        .tab_box .tab .list_product_category {

            width: 156%;
            position: relative;
            min-height: 1px;
            padding-right: 75px;
            padding-left: 0px;
            flex: 0 0 100%;
            margin-top: -10px;
        }
    }

    /* Nếu bạn muốn điều chỉnh riêng cho dải viewport từ 601px đến 768px (một số máy tablet hoặc điện thoại lớn hơn) */
    @media only screen and (min-width: 601px) and (max-width: 768px) {
        .compare-price {
            display: none;
        }

        .price-box .price {
            font-size: 10px;
        }

        .tab_box .tab .li_product .product-content .product-thumbnail .minh_hoa {
            top: 71%;
            left: 50%;
        }

        .box_daxem {
            height: 40%;
            max-width: 560px;
        }

        .tab_box .tab .list_product_category {

            width: 156%;
            position: relative;
            min-height: 1px;
            padding-right: 75px;
            padding-left: 0px;
            flex: 0 0 100%;
            margin-top: -10px;
        }


        .tab_box .tab .li_product .product-content .price-contact,
        .tab_box .tab .li_product .product-content .price {
            margin: 4px 0 0px 19px;
        }

        .deal-right-inline {
            display: flex;
            flex-wrap: nowrap;
            /* Buộc không wrap */
            align-items: center;
            gap: 8px;
        }

        .tab_box .tab .list_product_category .li_product {
            height: 190px;
        }

        .deal-right-text {
            font-size: 16px;
            /* Giảm margin hoặc kích thước nếu cần để vừa với không gian mobile */
        }

        /* Nếu cần, bạn có thể điều chỉnh lại kích thước deal-countdown */
        #ega-badge-ctd {
            font-size: 14px;
            padding: 2px 4px;
        }
    }

    .deal-left {
        font-size: 16px;
        font-weight: bold;
        margin: 0;
        text-align: left;
    }

    .deal-right-inline {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .deal-right-text {
        font-size: 16px;
        font-weight: bold;
        margin: 0;
        color: #333;
    }

    .deal-countdown {
        display: flex;
        align-items: center;
        background-color: #ff4d4d;
        /* nền đỏ */
        border: 1px solid #fff;
        /* border trắng */
        border-radius: 4px;
        padding: 2px 6px;
    }

    .deal-countdown .deal-time {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 4px;
    }

    .box_shopcart {
        width: 100%;
        background: #fff;
        margin-top: 1px !important;
    }
</style>

<body>
    {box_header}
    <div class="bread-crumb mb-3">
        <span class="crumb-border"></span>
        <div class="container">
            <div class="row">
                <div class="col-12 a-left">
                    <ul class="breadcrumb m-0 px-0" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                            <a href="/" target="_self" itemprop="item"><span itemprop="name"
                                    style="margin-left: 10px;">Trang chủ</span></a>
                            <meta itemprop="position" content="1">
                            <span class="mr_lr">&nbsp;/&nbsp;</span>
                        </li>
                        <li class="active"><span>{title}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="content-horizontal">
        <!-- Cột bên trái: Giỏ hàng -->
        <div class="left-column">
            <div class="box_shopcart card">
                <p style="font-size: 16px;">Hiện tại giỏ hàng của bạn chưa có sản phẩm nào.</p>
                <img src="/images/cart-emty.png" alt="giỏ hàng trống">
                <h2><a href="/#slide_danhmuc_noibat" class="btn">Tiếp tục mua sắm</a></h2>
            </div>
        </div>

        <!-- Cột bên phải: Box đã xem và Box deal -->
        <div class="right-column">
            <div class="box_daxem card" style="height: 48%;max-width: 560px;">
                <p style="font-weight: bold; border-bottom: 1px solid #e0e0e0;">Sản phẩm đã xem</p>
                <!-- Nội dung box sản phẩm đã xem -->
                {box_daxem}
            </div>
            <div class="box_deal card" style="height: 47%; max-width: 560px;">
                <div class="deal-header-flex">
                    <p class="deal-left">Chương trình ưu đãi</p>
                    <div class="deal-right-inline">
                        <span class="deal-right-text">Ưu đãi còn</span>
                        <div class="deal-countdown" id="ega-badge-ctd">
                            <div class="deal-time">
                                <span class="time-item">06</span>
                            </div>
                            <span class="colon">:</span>
                            <div class="deal-time">
                                <span class="time-item">18</span>
                            </div>
                            <span class="colon">:</span>
                            <div class="deal-time">
                                <span class="time-item">56</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="deal-container">
                    <div class="deal-products">
                        {list_sanpham_deal}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {footer}
    {script_footer}
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var sliderContainer = document.querySelector('.slide_category');
        if (sliderContainer) {
            var slides = sliderContainer.querySelectorAll('.swiper-slide');
            if (slides.length > 1) {
                // Khởi tạo Swiper nếu có nhiều hơn 1 slide
                var slide_recent = new Swiper('.slide_category', {
                    direction: 'horizontal',
                    slidesPerView: 5,
                    loop: false,
                    observer: true,
                    observeParents: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    autoplay: { delay: 3000 },
                    navigation: {
                        nextEl: '.slide_category .next',
                        prevEl: '.slide_category .prev',
                        disabledClass: 'hide_button',
                        hiddenClass: 'hide_button'
                    }
                });
            } else {
                // Nếu chỉ có 1 slide, bạn có thể ẩn các nút điều hướng
                var navNext = sliderContainer.querySelector('.next');
                var navPrev = sliderContainer.querySelector('.prev');
                if (navNext) navNext.style.display = 'none';
                if (navPrev) navPrev.style.display = 'none';
            }
        }
    });
</script>
<script>
    var tomorrow = new Date();
    var newdate = new Date();
    newdate.setDate(tomorrow.getDate() + 1);
    next_day = (newdate.getMonth() + 1) + ' ' + newdate.getDate() + ', ' + newdate.getFullYear();
    var countDownDate = new Date(next_day + " 23:59:59").getTime();
    var x = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        if (hours < 10) {
            hours = '0' + hours;
        }
        if (minutes < 10) {
            minutes = '0' + minutes;
        }
        if (seconds < 10) {
            seconds = '0' + seconds;
        }
        document.getElementById("ega-badge-ctd").innerHTML =
            '<div><div class="ega-badge-ctd__item ega-badge-ctd__h">' + hours + '</div></div>' +
            '<div class="ega-badge-ctd__colon">:</div>' +
            '<div><div class="ega-badge-ctd__item ega-badge-ctd__m">' + minutes + '</div></div>' +
            '<div class="ega-badge-ctd__colon">:</div>' +
            '<div><div class="ega-badge-ctd__item ega-badge-ctd__s">' + seconds + '</div></div>';
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("ega-badge-ctd").innerHTML =
                '<div><div class="ega-badge-ctd__item ega-badge-ctd__h">' + hours + '</div></div>' +
                '<div class="ega-badge-ctd__colon">:</div>' +
                '<div><div class="ega-badge-ctd__item ega-badge-ctd__m">' + minutes + '</div></div>' +
                '<div class="ega-badge-ctd__colon">:</div>' +
                '<div><div class="ega-badge-ctd__item ega-badge-ctd__s">' + seconds + '</div></div>';
        }
    }, 1000);
    var countdownCSS = `
    /* CSS cho bộ đếm */
    .ega-badge-ctd__item {
      font-size: 14px;
      font-weight: bold;
      color: #fff;
      display: inline-block;
      margin: 0 2px;
    }
    .ega-badge-ctd__colon {
      font-size: 14px;
      font-weight: bold;
      color: #fff;
      margin: 0 2px;
    }
    /* Nếu bạn muốn thêm background, padding, border... */
    #ega-badge-ctd {
      background-color: #ff4d4d;
      padding: 2px 6px;
      border: 1px solid #fff;
      border-radius: 4px;
      display: inline-flex;
      align-items: center;
    }
  `;

    // Tạo thẻ <style> và thêm CSS vào đó
    var styleEl = document.createElement('style');
    styleEl.type = 'text/css';
    styleEl.innerHTML = countdownCSS;
    document.head.appendChild(styleEl);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Chọn tất cả các phần tử có class product-name
        const productNames = document.querySelectorAll('.product-name');
        productNames.forEach(el => {
            let words = el.textContent.trim().split(/\s+/);
            if (words.length > 3) {
                el.textContent = words.slice(0, 3).join(' ') + '...';
            }
        });
    });

</script>