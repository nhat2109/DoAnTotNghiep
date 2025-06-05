<input type="hidden" name="shop" value="{shop}">
<!-- <button class="button_top" id="go_button">TOP</button> -->
<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<script src="/swiper/swiper.min.js?t=<?php echo time();?>"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript" src="/js/lazyload.min.js"></script>
<script src="/skin_shop/skin_5_nhat/tpl/js/process.js?t=<?php echo time();?>"></script>
<div class="load_overlay" style="display: none;"></div>
<div class="load_process" style="display: none;">
    <div class="load_content">
        <img src="/images/load.gif" alt="loading" width="70">
        <div class="load_note">Hệ thống đang xử lý</div>
    </div>
</div>
<div class="box_pop" id="box_pop_confirm">
    <div class="box_pop_content">
        <div class="pop_content">
            <div class="li_input" style="font-style: italic;text-align: center;">
                <span style="font-style: italic;text-align: center;font-size: 20px;color: red;font-weight: 700;"
                    id="title_confirm"></span>
            </div>
        </div>
        <div class="li_input" style="font-style: italic;text-align: center;">
            <span style="font-style: italic;font-family: Arial">Bạn có chắc chắn thực hiện hàng động này!</span>
        </div>
        <div class="pop_button">
            <div class="text_center">
                <button id="button_thuchien" action="" post_id="">Thực hiện</button>
                <button class="button_cancel bg_blue">Hủy</button>
            </div>
        </div>
    </div>
</div>
<div class="c-menu--slide-left">
    {header_menu_mobile}
    <div class="la-scroll-fix-infor-user scroll">
        <!--CATEGORY-->
        <div class="la-nav-menu-items">
            <div class="la-title-nav-items title_menu_mobile">MENU</div>
            <ul class="la-nav-list-items">
                {menu_mobile}
            </ul>
            <div class="la-title-nav-items title_menu_mobile">DANH MỤC SẢN PHẨM</div>
            <ul class="la-nav-list-items">
                {category_mobile}
            </ul>
        </div>
    </div>
</div>
<div class="actionToolbar_mobile visible-xs ">
    <ul class="actionToolbar_listing">
        <li>
            <a href="javascript:" rel="nofollow"  aria-label="Sản phẩm" id="trigger-mobile" >
                <i class="fa fa-th-list"></i>
            </a>
        </li>
        <li>
            <a href="tel:{hotline_number}" rel="nofollow" aria-label="phone">
                <i class="fas fa-phone ml-3"></i>
            </a>
        </li>
        <li>
            <a href="{link_facebook}" target="_blank" rel="nofollow noreferrer" aria-label="Nhắn tin">
                <i class="fab fa-facebook-messenger ml-3"></i>
            </a>
        </li>
        <li>
            <a href="/lien-he.html" aria-label="Liên hệ">
                <i class="fa fa-envelope"></i>
            </a>
        </li>
    </ul>
</div>

<!-- Thêm vào cuối shopcart.tpl, trước {footer} -->
<div id="quick-view-popup" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-quick-view">×</span>
        <div id="quick-view-content"></div>
    </div>
</div>

<style> 
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        overflow-y: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #fff;
        padding: 20px;
        position: relative;
        width: 90%;
        max-width: 910px;
        /* Thu hẹp chiều ngang */
    }

    .close-quick-view {
        position: absolute;
        top: -17px;
        right: 1px;
        font-size: 30px;
        cursor: pointer;
        color: #333;
    }

    .close-quick-view:hover {
        color: #e74c3c;
    }

    .box_flash_sale .list_flash_sale .li_flash_sale .li_flash_sale_content .li_flash_sale_info .price {
        width: 104% !important;
    }
</style>

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


<script>
    $(document).ready(function () {
       $("body").on("click", ".quick-view", function () {
        var sp_id = $(this).data("id");
        var link = $(this).data("link");

        $.ajax({
            url: "/process.php",
            type: "POST",
            data: {
                action: "quick_view",
                sp_id: sp_id,
                link: link,
            },
            success: function (response) {
                $("#quick-view-content").html(response);
                $("#quick-view-popup").css("display", "flex");

                // Xử lý ảnh con
                const mainImage = document.querySelector(".main-image");
                const thumbnails = document.querySelectorAll(".thumbnail-list img");
                const thumbnailWrapper = document.querySelector(".thumbnail-wrapper");
                const thumbnailList = document.querySelector(".thumbnail-list");
                const prevBtn = document.querySelector(".prev-btn");
                const nextBtn = document.querySelector(".next-btn");
                let currentIndex = 0;

                // Hiển thị ảnh lớn khi click ảnh con
                thumbnails.forEach((thumb, index) => {
                    thumb.addEventListener("click", function () {
                        mainImage.src = this.src;
                        thumbnails.forEach(t => t.classList.remove("active"));
                        this.classList.add("active");
                        currentIndex = index;
                    });
                });

                // Xử lý nút Previous và Next
                const thumbWidth = 62; // Chiều rộng mỗi thumbnail (60px + 2px margin)
                const visibleThumbs = 3; // Số thumbnail hiển thị cùng lúc
                const maxScroll = Math.max(0, thumbnails.length - visibleThumbs);

                prevBtn.addEventListener("click", function () {
                    if (currentIndex > 0) {
                        currentIndex -= visibleThumbs;
                        if (currentIndex < 0) currentIndex = 0;
                        thumbnailList.style.transform = `translateX(-${currentIndex * thumbWidth}px)`;
                        thumbnails.forEach(t => t.classList.remove("active"));
                        thumbnails[currentIndex].classList.add("active");
                        mainImage.src = thumbnails[currentIndex].src;
                    }
                    updateButtonVisibility();
                });

                nextBtn.addEventListener("click", function () {
                    if (currentIndex < maxScroll) {
                        currentIndex += visibleThumbs;
                        if (currentIndex > maxScroll) currentIndex = maxScroll;
                        thumbnailList.style.transform = `translateX(-${currentIndex * thumbWidth}px)`;
                        thumbnails.forEach(t => t.classList.remove("active"));
                        thumbnails[currentIndex].classList.add("active");
                        mainImage.src = thumbnails[currentIndex].src;
                    }
                    updateButtonVisibility();
                });

                function updateButtonVisibility() {
                    prevBtn.style.display = currentIndex === 0 ? "none" : "block";
                    nextBtn.style.display = currentIndex >= maxScroll ? "none" : "block";
                }

                if (thumbnails.length <= visibleThumbs) {
                    prevBtn.style.display = "none";
                    nextBtn.style.display = "none";
                } else {
                    updateButtonVisibility();
                }

                // Logic xử lý biến thể
                function updateStockAndPrice() {
                    const selectedColor = document.querySelector(".variant-color:checked");
                    const selectedSize = document.querySelector(".variant-size:checked");
                    if (selectedColor && selectedSize) {
                        const selectedVariant = window.variants.find(
                            v => v.color === selectedColor.value && v.size === selectedSize.value
                        );
                        if (selectedVariant) {
                            const kho = parseInt(selectedVariant.kho) || 0;
                            const gia = parseInt(selectedVariant.gia_moi) || 0;
                            const giaCu = parseInt(selectedVariant.gia_cu) || 0;
                            const stockStatus = kho > 0 ? "Còn hàng" : "Hết hàng";
                            const buttonText = kho > 0 ? "Thêm vào giỏ hàng" : "Hết hàng";
                            const formattedPrice = new Intl.NumberFormat('vi-VN').format(gia) + ' đ';
                            const formattedOldPrice = giaCu > 0 ? new Intl.NumberFormat('vi-VN').format(giaCu) + '₫' : '';

                            document.getElementById("stock-status").innerText = stockStatus;
                            document.getElementById("price").innerText = formattedPrice;
                            document.getElementById("old-price").innerText = formattedOldPrice;
                            document.getElementById("buy-button").innerText = buttonText;
                            document.getElementById("buy-button").classList.toggle("disabled", kho <= 0);
                            document.getElementById("buy-button").setAttribute("data-variant-id", selectedVariant.variant_id);
                        }
                    }
                }

                document.querySelectorAll(".variant-color").forEach((input) => {
                    input.addEventListener("change", function () {
                        const selectedColor = this.value;
                        const sizeSwap = document.getElementById("size-swap");
                        let sizeHtml = "";
                        let firstSize = true;
                        window.variants.forEach((variant) => {
                            if (variant.color === selectedColor) {
                                const checked = firstSize ? "checked" : "";
                                sizeHtml += `
                                    <div class="n-sd swatch-element">
                                        <input class="variant-size" id="size-${variant.size}" type="radio" name="size" value="${variant.size}" ${checked} data-kho="${variant.kho}" data-gia="${variant.gia_moi}" data-gia-cu="${variant.gia_cu}" data-ten-size="${variant.ten_size}" data-variant-id="${variant.variant_id}" />
                                        <label for="size-${variant.size}">${variant.ten_size}</label>
                                    </div>`;
                                firstSize = false;
                            }
                        });
                        sizeSwap.innerHTML = sizeHtml;
                        updateStockAndPrice();
                        addSizeEventListeners();
                    });

                    const label = input.nextElementSibling;
                    if (label) {
                        const colorCode = input.getAttribute("data-ma-mau");
                        label.style.backgroundColor = colorCode;
                        label.innerHTML = "";
                    }
                });

                function addSizeEventListeners() {
                    document.querySelectorAll(".variant-size").forEach((input) => {
                        input.addEventListener("change", updateStockAndPrice);
                    });
                }
                addSizeEventListeners();

                // Khởi tạo giá và trạng thái ban đầu
                updateStockAndPrice();

                // Xử lý thêm vào giỏ hàng
                $("body").off("click", "#quick-view-content #buy-button").on("click", "#quick-view-content #buy-button", function() {
                    if ($(this).hasClass("disabled")) return;

                    const selectedColor = document.querySelector(".variant-color:checked")?.value;
                    const selectedSize = document.querySelector(".variant-size:checked")?.value;
                    if (!selectedColor || !selectedSize) {
                        alert("Vui lòng chọn màu và kích thước.");
                        return;
                    }

                    const selectedVariant = window.variants.find(
                        (v) => v.color === selectedColor && v.size === selectedSize
                    );
                    if (!selectedVariant) {
                        alert("Biến thể không hợp lệ.");
                        return;
                    }

                    const cartData = {
                        action: "add_to_cart",
                        sp_id: $(this).attr("sp_id"),
                        loai: $(this).attr("loai"),
                        mau: selectedColor,
                        size: selectedSize,
                        variant_id: selectedVariant.variant_id,
                        ten_color: selectedVariant.ten_color,
                        ten_size: selectedVariant.ten_size,
                        gia_moi: selectedVariant.gia_moi,
                        kho: selectedVariant.kho,
                        quantity: $("#quantity_quick_view").val(),
                    };

                    $.ajax({
                        url: "/process.php",
                        type: "POST",
                        data: cartData,
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $("#popup-cart").css("display", "block");
                            $("#popup-cart .tbody-popup").html(info.list);
                            $("#popup-cart .tfoot-popup .total-price").html(info.total_price);
                            $("#popup-cart .cart-popup-name").html(info.name);
                            $("#popup-cart .cart-popup-count").html(info.total_cart);
                            $(".content_cart_header .count_item").html(info.total);
                            $("#quick-view-popup").css("display", "none");
                        },
                        error: function() {
                            alert("Lỗi khi thêm vào giỏ hàng.");
                        }
                    });
                });

                // Xử lý nút tăng giảm số lượng
                $("body").on("click", ".btn-plus", function() {
                    var input = $(this).siblings("#quantity_quick_view");
                    var currentVal = parseInt(input.val()) || 0;
                    var selectedSize = document.querySelector(".variant-size:checked");
                    var maxKho = selectedSize ? parseInt(selectedSize.getAttribute("data-kho")) : 0;
                    if (currentVal < maxKho) {
                        input.val(currentVal + 1);
                    }
                });

                $("body").on("click", ".btn-minus", function() {
                    var input = $(this).siblings("#quantity_quick_view");
                    var currentVal = parseInt(input.val()) || 0;
                    if (currentVal > 1) {
                        input.val(currentVal - 1);
                    }
                });
            },
            error: function() {
                alert("Lỗi khi tải quick view.");
            }
        });
    });
    });

</script>





<div class="box_note">
    <div class="note_title">Thông báo <i class="fa fa-close"></i></div>
    <div class="note_content"></div>
</div>
<div class="box_popup">
    <div class="box_popup_content">
        <div class="box_title"><span></span><span><i class="fa fa-close"></i></span></div>
        <div class="content_box"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(window).scroll(function () {
            if ($(window).width() < 768) {
            }
            else {
                if ($(this).scrollTop() > 100) {
                    $('#go_button').fadeIn();
                } else {
                    $('#go_button').fadeOut();
                }
            }
        });
        $('#go_button').on('click', function () {
            var top_download = $('body').offset().top;
            $('html,body').stop().animate({ scrollTop: top_download - 150 }, 500, 'swing', function () { });
        });
        if ($('.note_top').length > 0) {
            setTimeout(function () {
                $.ajax({
                    url: '/process.php',
                    type: 'post',
                    data: {
                        action: 'load_note',
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        $('.note_top .num').show();
                        $('.note_top .num').html(info.total);
                    }
                });
            }, 1200);
        }
        $(".close-quick-view").on("click", function () {
            $("#quick-view-popup").css("display", "none");
          });
    });
</script>
<script type="text/javascript">
    $(function () {
        $('img').lazyload({
            effect: "fadeIn"
        });
    });
</script>
<!-- <div id="fb-root"></div> -->
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId=641938006744130&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
{script_chat}
<div id="popup-cart" class="modal fade in" role="dialog" style="display: none;z-index: 99999;">
    <div id="popup-cart-desktop" class="clearfix">
        <div class="title-popup-cart">
            <i class="ion ion-md-notifications-outline" aria-hidden="true"></i> Bạn đã thêm <span
                class="cart-popup-name"></span> vào giỏ hàng
        </div>
        <div class="title-quantity-popup">
            <a href="/gio-hang.html">Giỏ hàng của bạn có <span class="cart-popup-count">{total_cart}</span> sản phẩm</a>
        </div>
        <div class="content-popup-cart clearfix">
            <div style="overflow-x: auto;" class="scroll">
                <div style="width: 800px">
                    <div class="thead-popup">
                        <div style="width: 55%;" class="text-left">Sản phẩm</div>
                        <div style="width: 15%;" class="text-center">Đơn giá</div>
                        <div style="width: 15%;" class="text-center">Số lượng</div>
                        <div style="width: 15%;" class="text-center">Thành tiền</div>
                    </div>
                    <div class="tbody-popup"></div>
                </div>
            </div>
            <div class="tfoot-popup">
                <div class="tfoot-popup-1 clearfix">
                    <div class="pull-left popupcon">
                        <a class="btn-continue" title="Tiếp tục mua hàng"><span><span><i class="fa fa-caret-left"
                                        aria-hidden="true"></i> Tiếp tục mua hàng</span></span></a>
                    </div>

                    <div class="pull-right popup-total">
                        <p>Thành tiền: <span class="total-price">8,570,000₫</span></p>
                    </div>

                </div>
                <div class="tfoot-popup-2 clearfix">
                    <a class="button btn-proceed-checkout" title="Thanh toán đơn hàng"
                        href="/checkout.html?step=1"><span>Thanh toán đơn hàng</span></a>
                </div>
            </div>
        </div>
        <a title="Close" class="quickview-close close-window" href="javascript:;"><i class="ion ion-ios-close"></i></a>
    </div>
</div>
<a href="https://chat.zalo.me/?phone={hotline_number}" id="linkzalo" target="_blank" rel="noopener noreferrer">
    <div id="fcta-zalo-tracking" class="fcta-zalo-mess">
        <span id="fcta-zalo-tracking">Chat hỗ trợ</span>
    </div>
    <div class="fcta-zalo-vi-tri-nut">
        <div id="fcta-zalo-tracking" class="fcta-zalo-nen-nut">
            <div id="fcta-zalo-tracking" class="fcta-zalo-ben-trong-nut"> <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 460.1 436.6">
                    <path fill="currentColor" class="st0"
                        d="M82.6 380.9c-1.8-.8-3.1-1.7-1-3.5 1.3-1 2.7-1.9 4.1-2.8 13.1-8.5 25.4-17.8 33.5-31.5 6.8-11.4 5.7-18.1-2.8-26.5C69 269.2 48.2 212.5 58.6 145.5 64.5 107.7 81.8 75 107 46.6c15.2-17.2 33.3-31.1 53.1-42.7 1.2-.7 2.9-.9 3.1-2.7-.4-1-1.1-.7-1.7-.7-33.7 0-67.4-.7-101 .2C28.3 1.7.5 26.6.6 62.3c.2 104.3 0 208.6 0 313 0 32.4 24.7 59.5 57 60.7 27.3 1.1 54.6.2 82 .1 2 .1 4 .2 6 .2H290c36 0 72 .2 108 0 33.4 0 60.5-27 60.5-60.3v-.6-58.5c0-1.4.5-2.9-.4-4.4-1.8.1-2.5 1.6-3.5 2.6-19.4 19.5-42.3 35.2-67.4 46.3-61.5 27.1-124.1 29-187.6 7.2-5.5-2-11.5-2.2-17.2-.8-8.4 2.1-16.7 4.6-25 7.1-24.4 7.6-49.3 11-74.8 6zm72.5-168.5c1.7-2.2 2.6-3.5 3.6-4.8 13.1-16.6 26.2-33.2 39.3-49.9 3.8-4.8 7.6-9.7 10-15.5 2.8-6.6-.2-12.8-7-15.2-3-.9-6.2-1.3-9.4-1.1-17.8-.1-35.7-.1-53.5 0-2.5 0-5 .3-7.4.9-5.6 1.4-9 7.1-7.6 12.8 1 3.8 4 6.8 7.8 7.7 2.4.6 4.9.9 7.4.8 10.8.1 21.7 0 32.5.1 1.2 0 2.7-.8 3.6 1-.9 1.2-1.8 2.4-2.7 3.5-15.5 19.6-30.9 39.3-46.4 58.9-3.8 4.9-5.8 10.3-3 16.3s8.5 7.1 14.3 7.5c4.6.3 9.3.1 14 .1 16.2 0 32.3.1 48.5-.1 8.6-.1 13.2-5.3 12.3-13.3-.7-6.3-5-9.6-13-9.7-14.1-.1-28.2 0-43.3 0zm116-52.6c-12.5-10.9-26.3-11.6-39.8-3.6-16.4 9.6-22.4 25.3-20.4 43.5 1.9 17 9.3 30.9 27.1 36.6 11.1 3.6 21.4 2.3 30.5-5.1 2.4-1.9 3.1-1.5 4.8.6 3.3 4.2 9 5.8 14 3.9 5-1.5 8.3-6.1 8.3-11.3.1-20 .2-40 0-60-.1-8-7.6-13.1-15.4-11.5-4.3.9-6.7 3.8-9.1 6.9zm69.3 37.1c-.4 25 20.3 43.9 46.3 41.3 23.9-2.4 39.4-20.3 38.6-45.6-.8-25-19.4-42.1-44.9-41.3-23.9.7-40.8 19.9-40 45.6zm-8.8-19.9c0-15.7.1-31.3 0-47 0-8-5.1-13-12.7-12.9-7.4.1-12.3 5.1-12.4 12.8-.1 4.7 0 9.3 0 14v79.5c0 6.2 3.8 11.6 8.8 12.9 6.9 1.9 14-2.2 15.8-9.1.3-1.2.5-2.4.4-3.7.2-15.5.1-31 .1-46.5z">
                    </path>
                </svg></div>
            <div id="fcta-zalo-tracking" class="fcta-zalo-text">Chat ngay</div>
        </div>
    </div>
</a>
<!--    /* Chat Icon AI Styles */ -->
<!-- Chat Icon AI -->
<!-- Chat Icon AI -->
<div id="ai-chat-trigger" class="ai-chat-icon-wrapper">
    <div class="ai-chat-tooltip">
        <span>Chat AI</span>
    </div>
    <div class="ai-chat-icon">
        <div class="ai-chat-icon-inner">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
            </svg>
        </div>
        <span class="ai-chat-icon-text">Hỏi AI</span>
    </div>
</div>

<!-- Chat Window AI -->
<div id="ai-chat-window" class="ai-chat-modal" style="display: none;">
    <div class="ai-chat-header">
        <h3>Trò chuyện với AI</h3>
        <span class="ai-chat-close">&times;</span>
    </div>
    <div class="ai-chat-messages" id="ai-chat-messages">
        <div class="message ai-message">
            <strong>AI:</strong> Xin chào! Tôi là Grok 3, AI của xAI. Bạn muốn tìm kiếm sản phẩm nào? Ví dụ: hỏi về giá, danh mục, hoặc mô tả sản phẩm.
        </div>
    </div>
    <div class="ai-chat-input">
        <input type="text" id="ai-chat-input" placeholder="Nhập câu hỏi của bạn..." />
        <button id="ai-chat-send">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
            </svg>
        </button>
    </div>
</div>
<style>
    /* Product Card in Chat */
.ai-product-card {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin: 10px 0;
    padding: 10px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.ai-product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.ai-product-info {
    flex-grow: 1;
    font-size: 14px;
    line-height: 1.5;
}

.ai-product-info a {
    color: #4CAF50;
    text-decoration: none;
}

.ai-product-info a:hover {
    text-decoration: underline;
}

.ai-product-info strong {
    color: #333;
}

/* Flash Sale Icon */


.flash-quantity {
    font-weight: bold;
}
 /* Chat Icon AI Styles */
.ai-chat-icon-wrapper {
    position: fixed;
    bottom: 70px;
    right: 20px;
    z-index: 999;
    cursor: pointer;
}

.ai-chat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.ai-chat-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
}

.ai-chat-icon::before,
.ai-chat-icon::after {
    content: "";
    position: absolute;
    border: 2px solid rgba(76, 175, 80, 0.5);
    border-radius: 50%;
    left: -10px;
    right: -10px;
    top: -10px;
    bottom: -10px;
    opacity: 0;
    animation: zoom 2s infinite;
}

.ai-chat-icon::after {
    animation-delay: 0.5s;
}

.ai-chat-icon-inner {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60%;
    height: 60%;
}

.ai-chat-icon-inner svg {
    width: 100%;
    height: 100%;
    fill: #fff;
}

.ai-chat-icon-text {
    position: absolute;
    top: -30px;
    background: #4CAF50;
    color: #fff;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.ai-chat-icon:hover .ai-chat-icon-text {
    opacity: 1;
    transform: translateY(0);
}

.ai-chat-tooltip {
    position: absolute;
    bottom: 70px;
    right: 0;
    background: #fff;
    padding: 8px 15px;
    border-radius: 15px 15px 0 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    color: #4CAF50;
    font-weight: 600;
    font-size: 14px;
    font-family: 'Roboto', sans-serif;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.ai-chat-icon-wrapper:hover .ai-chat-tooltip {
    opacity: 1;
    transform: translateY(0);
}

/* Chat Window Styles */
.ai-chat-modal {
    position: fixed;
    bottom: 140px;
    right: 20px;
    width: 350px;
    height: 450px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    animation: slideIn 0.3s ease-out;
    overflow: hidden;
}

@keyframes slideIn {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.ai-chat-header {
    background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
    color: #fff;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 15px 15px 0 0;
}

.ai-chat-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.ai-chat-close {
    font-size: 24px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.ai-chat-close:hover {
    color: #FFCDD2;
}

.ai-chat-messages {
    flex-grow: 1;
    overflow-y: auto;
    padding: 15px;
    background: #f5f5f5;
}

.ai-chat-messages::-webkit-scrollbar {
    width: 6px;
}

.ai-chat-messages::-webkit-scrollbar-thumb {
    background: #4CAF50;
    border-radius: 10px;
}

.ai-chat-messages::-webkit-scrollbar-track {
    background: #e0e0e0;
}

.message {
    margin-bottom: 15px;
    line-height: 1.5;
    font-size: 14px;
}

.message strong {
    color: #333;
}

.user-message {
    float: right;
    text-align: right;
    color: #fff;
    background: #4CAF50;
    padding: 8px 12px;
    border-radius: 15px 15px 0 15px;
    display: inline-block;
    max-width: 80%;
}

.ai-message {
    float: left;
    text-align: left;
    color: #333;
    background: #fff;
    padding: 8px 12px;
    border-radius: 15px 15px 15px 0;
    display: inline-block;
    max-width: 80%;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.ai-chat-input {
    display: flex;
    padding: 10px 15px;
    background: #fff;
    border-top: 1px solid #e0e0e0;
}

#ai-chat-input {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 20px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s ease;
}

#ai-chat-input:focus {
    border-color: #4CAF50;
}

#ai-chat-send {
    background: #4CAF50;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 10px;
    cursor: pointer;
    transition: background 0.3s ease;
}

#ai-chat-send:hover {
    background: #2E7D32;
}

#ai-chat-send svg {
    width: 20px;
    height: 20px;
    fill: #fff;
}
    @keyframes zoom {
        0% {
            transform: scale(.5);
            opacity: 0
        }

        50% {
            opacity: 1
        }

        to {
            opacity: 0;
            transform: scale(1)
        }
    }

    @keyframes lucidgenzalo {
        0% to {
            transform: rotate(-25deg)
        }

        50% {
            transform: rotate(25deg)
        }
    }

    .jscroll-to-top {
        bottom: 100px
    }

    .fcta-zalo-ben-trong-nut svg path {
        fill: #fff
    }

    .fcta-zalo-vi-tri-nut {
        position: fixed;
        bottom: 50px;
        left: 20px;
        z-index: 999
    }

    .fcta-zalo-nen-nut,
    div.fcta-zalo-mess {
        box-shadow: 0 1px 6px rgba(0, 0, 0, .06), 0 2px 32px rgba(0, 0, 0, .16)
    }

    .fcta-zalo-nen-nut {
        width: 50px;
        height: 50px;
        text-align: center;
        color: #fff;
        background: #0068ff;
        border-radius: 50%;
        position: relative
    }

    .fcta-zalo-nen-nut::after,
    .fcta-zalo-nen-nut::before {
        content: "";
        position: absolute;
        border: 1px solid #0068ff;
        background: #0068ff80;
        z-index: -1;
        left: -20px;
        right: -20px;
        top: -20px;
        bottom: -20px;
        border-radius: 50%;
        animation: zoom 1.9s linear infinite
    }

    .fcta-zalo-nen-nut::after {
        animation-delay: .4s
    }

    .fcta-zalo-ben-trong-nut,
    .fcta-zalo-ben-trong-nut i {
        transition: all 1s
    }

    .fcta-zalo-ben-trong-nut {
        position: absolute;
        text-align: center;
        width: 60%;
        height: 60%;
        left: 10px;
        bottom: 25px;
        line-height: 70px;
        font-size: 25px;
        opacity: 1
    }

    .fcta-zalo-ben-trong-nut i {
        animation: lucidgenzalo 1s linear infinite
    }

    .fcta-zalo-nen-nut:hover .fcta-zalo-ben-trong-nut,
    .fcta-zalo-text {
        opacity: 0
    }

    .fcta-zalo-nen-nut:hover i {
        transform: scale(.5);
        transition: all .5s ease-in
    }

    .fcta-zalo-text a {
        text-decoration: none;
        color: #fff
    }

    .fcta-zalo-text {
        position: absolute;
        top: 6px;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 700;
        transform: scaleX(-1);
        transition: all .5s;
        line-height: 1.5
    }

    .fcta-zalo-nen-nut:hover .fcta-zalo-text {
        transform: scaleX(1);
        opacity: 1
    }

    div.fcta-zalo-mess {
        position: fixed;
        bottom: 55px;
        left: 58px;
        z-index: 99;
        background: #fff;
        padding: 7px 25px 7px 15px;
        color: #0068ff;
        border-radius: 0px 50px 50px 0px;
        font-weight: 700;
        font-size: 15px
    }

    .fcta-zalo-mess span {
        color: #0068ff !important
    }

    span#fcta-zalo-tracking {
        font-family: Roboto;
        line-height: 1.5
    }

    .fcta-zalo-text {
        font-family: Roboto
    }
</style>
<style>
    .layered-content {
        max-width: 400px;
        margin: 20px;
    }
    .check-box-list {
        list-style: none;
        padding: 0;
        max-height: 200px; /* Adjust as needed */
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    .check-box-list.expanded {
        max-height: none;
    }
    .check-box-list li {
        margin: 5px 0;
    }
    .check-box-list li.hidden { /* Add this rule */
        display: none;
    }
    .view-more-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
        display: block;
        width: 100%;
        text-align: center;
    }
    .view-more-btn:hover {
        background-color: #0056b3;
    }
</style>

<script>
$(document).ready(function() {
        const $list = $('.check-box-list');
        const $viewMoreBtn = $('.view-more-btn');
        const $hiddenItems = $('.check-box-list li.hidden');
        let isExpanded = false;

        // Check if there are hidden items to show/hide the button
        if ($hiddenItems.length === 0) {
            $viewMoreBtn.hide();
        }

        $viewMoreBtn.on('click', function() {
            if (!isExpanded) {
                $list.addClass('expanded');
                $hiddenItems.removeClass('hidden');
                $viewMoreBtn.text('Rút gọn');
                isExpanded = true;
            } else {
                $list.removeClass('expanded');
                $hiddenItems.addClass('hidden');
                $viewMoreBtn.text('View More');
                isExpanded = false;
            }
        });
    });
</script>
<script>
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) { document.getElementById("linkzalo").href = "https://zalo.me/{hotline_number}"; }
</script>

<script>
$(document).ready(function () {
    // Xử lý click vào icon AI để mở cửa sổ chat
    $("#ai-chat-trigger").on("click", function (e) {
        e.preventDefault(); // Ngăn chặn hành vi mặc định
        $("#ai-chat-window").css("display", "flex");
    });

    // Xử lý đóng cửa sổ chat
    $(".ai-chat-close").on("click", function () {
        $("#ai-chat-window").css("display", "none");
    });

    // Xử lý gửi tin nhắn đến AI
    $("#ai-chat-send").on("click", function () {
        const message = $("#ai-chat-input").val().trim();
        if (message) {
            // Thêm tin nhắn của người dùng vào giao diện
            $("#ai-chat-messages").append(`
                <div class="message user-message"><strong>Bạn:</strong> ${message}</div>
            `);
            $("#ai-chat-input").val(""); // Xóa input
            $("#ai-chat-messages").scrollTop($("#ai-chat-messages")[0].scrollHeight); // Cuộn xuống cuối

            // Gửi yêu cầu AJAX đến server
            $.ajax({
                url: "/process.php",
                type: "POST",
                data: {
                    action: "ai_chat",
                    message: message
                },
                success: function (response) {
                    try {
                        const info = JSON.parse(response);
                        if (info.ok === 1) {
                            // Thêm phản hồi từ AI vào giao diện
                            $("#ai-chat-messages").append(`
                                <div class="message ai-message"><strong>AI:</strong> ${info.reply}</div>
                            `);
                            $("#ai-chat-messages").scrollTop($("#ai-chat-messages")[0].scrollHeight);
                        } else {
                            $("#ai-chat-messages").append(`
                                <div class="message ai-message"><strong>AI:</strong> Lỗi: ${info.message}</div>
                            `);
                        }
                    } catch (e) {
                        console.error("Lỗi phân tích JSON:", e);
                        $("#ai-chat-messages").append(`
                            <div class="message ai-message"><strong>AI:</strong> Lỗi xử lý dữ liệu.</div>
                        `);
                    }
                },
                error: function () {
                    $("#ai-chat-messages").append(`
                        <div class="message ai-message"><strong>AI:</strong> Lỗi kết nối đến server.</div>
                    `);
                }
            });
        }
    });

    // Bắt sự kiện Enter để gửi tin nhắn
    $("#ai-chat-input").on("keypress", function (e) {
        if (e.which === 13) {
            $("#ai-chat-send").click();
        }
    });
});
</script>