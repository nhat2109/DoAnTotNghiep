<style>
.cart-item {
    padding: 15px;
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s ease;
    list-style-type: none;
}

.cart-item:hover {
    list-style-type: none;
    background-color: #f8f9fa;
}

.cart-item-inner {
    display: flex;
    gap: 15px;
}

.cart-item-image {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.cart-item-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.cart-item-header {
    position: relative;
}

.remove-item-cart {
    position: absolute;
    top: -24px;
    right: -15px;
    color: #666;
    font-size: 16px;
    padding: 5px;
    cursor: pointer;
    transition: color 0.2s ease;
}

.remove-item-cart:hover {
    color: #dc3545;
}

.cart-item-title {
    margin: 0 0 10px;
    font-size: 14px;
    line-height: 1.4;
}

.cart-item-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.2s ease;
}

.cart-item-title a:hover {
    color: #007bff;
}

.cart-item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.cart-item-price {
    font-weight: 600;
    color: #dc3545;
    font-size: 15px;
}

.cart-item-quantity {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #666;
    font-size: 13px;
}

.quantity-label {
    color: #666;
}

.quantity-value {
    font-weight: 500;
    color: #333;
}

@media (max-width: 576px) {
    .cart-item-inner {
        gap: 10px;
    }
    
    .cart-item-image {
        width: 60px;
        height: 60px;
    }
    
    .cart-item-title {
        font-size: 13px;
    }
    
    .cart-item-price {
        font-size: 14px;
    }
    
    .cart-item-quantity {
        font-size: 12px;
    }
}
</style>
<style>
.cart-dropdown {
    z-index: 999 !important;
    position: absolute;
    top: 100%;
    right: 0;
    width: 320px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 15px;
    font-family: Arial, sans-serif;
    display: none; /* Ensure initially hidden */
}

.cart-dropdown-inner {
    max-height: 400px;
    overflow-y: auto; /* Giữ khả năng cuộn dọc */
    scrollbar-width: none; /* Ẩn thanh cuộn trên Firefox */
    -ms-overflow-style: none; /* Ẩn thanh cuộn trên IE/Edge */
}

.cart-dropdown-inner::-webkit-scrollbar {
    display: none; /* Ẩn thanh cuộn trên Chrome, Safari */
}

.cart-dropdown .cart-header-info {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.cart-dropdown .cart-header-info .icon_hotline {
    color: #007bff;
}

.cart-dropdown .cart-header-info .content_hotline a {
    font-size: 16px;
    font-weight: bold;
    color: #007bff;
    text-decoration: none;
}

.cart-dropdown .cart-header-info .content_hotline span {
    font-size: 12px;
    color: #666;
}

.cart-dropdown .cart-title {
    font-size: 16px;
    font-weight: bold;
    color: #dc3545;
    margin-bottom: 15px;
}

.cart-dropdown .cart-footer {
    border-top: 1px solid #eee;
    padding-top: 15px;
    margin-top: 15px;
}

.cart-dropdown .cart-total {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 15px;
}

.cart-dropdown .cart-total span:first-child {
    color: #333;
}

.cart-dropdown .cart-total .total-price {
    color: #333;
}

.cart-dropdown .cart-buttons {
    display: flex;
    gap: 10px;
    justify-content: space-between;
}

.cart-dropdown .btn-view-cart,
.btn-checkout {
    flex: 1;
    padding: 10px;
    text-align: center;
    border-radius: 4px;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    transition: background 0.2s ease;
}

.cart-dropdown .btn-view-cart {
    background: #f8f9fa;
    color: #333;
    border: 1px solid #ddd;
}

.cart-dropdown .btn-view-cart:hover {
    background: #e9ecef;
}

.cart-dropdown .btn-checkout {
    background: #007bff;
    color: #fff;
    border: none;
}

.cart-dropdown .btn-checkout:hover {
    background: #0056b3;
}

.cart-dropdown .empty-cart {
    text-align: center;
    color: #666;
    padding: 20px;
    font-size: 14px;
}
</style>

<header class="header">
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-4">
                    <ul class="top-left-info">
                        <li><a target="_blank" href="{link_facebook}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="{link_twitter}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="{link_instagram}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="{link_youtube}"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        <li class="li_note"><a href="/thongbao.html"><i class="fa fa-bell" aria-hidden="true"></i><span class="count_note">0</span></a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-8 hidden-xs">
                    <ul class="top-right-info">
                        <li class="li-account">
                            <a href="/tai-khoan.html" class="a-account"><i class="fa fa-user" aria-hidden="true"></i> Tài khoản</a>
                            <ul>
                                <li><a href="/tai-khoan.html">Thông tin</a></li>
                                <li><a href="/don-hang.html">Đơn hàng của bạn</a></li>
                                <li><a href="/doi-mat-khau.html">Đổi mật khẩu</a></li>
                                <li><a href="/dang-xuat.html">Đăng xuất</a></li>
                            </ul>
                        </li>
                        <li style="padding-right: 16px;">
                            <a href="/thongbao.html"><i class="fa fa-bell" aria-hidden="true"></i> Thông báo <span class="count_note">0</span></a>
                        </li>
                        <li>
                            <a href="/lien-he.html"><i class="fa fa-map-marker" aria-hidden="true"></i> Liên hệ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="header-main">
            <div class="row row_header">
                <div class="col-md-3 col-100-h">
                    <button type="button" class="navbar-toggle collapsed visible-sm visible-xs" id="trigger-mobile">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="logo">
                        <a href="/" class="logo-wrapper ">
                            <img src="{logo}" alt="logo" style="height: 88px;">
                        </a>
                    </div>
                    <div class="mobile-cart visible-sm visible-xs">
                        <a href="/gio-hang.html" title="Giỏ hàng">
                            <i class="fa fa-shopping-bag"></i>
                            <div class="cart-right">
                                <span class="count_item_pr">0</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-5" style="position:relative; top:20px">
                    <div class="search">
                        <div class="header_search search_form">
                            <form class="input-group search-bar search_form" action="/tim-kiem.html" method="get" role="search">
                                <input type="search" name="key" value="" placeholder="Tìm kiếm sản phẩm..." class="input-group-field st-default-search-input search-text" autocomplete="off" id="search-input">
                                <button type="button" id="voiceSearchBtn"><i class="fa fa-microphone"></i></button>
                                <span class="input-group-btn">
                                    <button class="btn icon-fallback-text">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </form>
                            <div class="search-dropdown" style="display:none;">
                                <div class="search-result">
                                    <button type="button" class="close-search-btn" style="position: absolute; top: 4px; right: 10px; width: 25px; height: 25px; background: #ff4747; border: none; border-radius: 50%; font-size: 18px; line-height: 1; color: #fff; cursor: pointer; padding: 0px 0 3px 0; display: flex; align-items: center; justify-content: center; z-index: 1001; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: all 0.2s ease;" onmouseover="this.style.background='#ff3333'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='#ff4747'; this.style.transform='scale(1)'">×</button>
                                    <div class="featured-products">
                                        <h3>Sản phẩm nổi bật</h3>
                                        <div class="featured-list"></div>
                                    </div>
                                    <div class="search-products">
                                        <h3>Kết quả tìm kiếm</h3>
                                        <div class="search-list"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 hidden-sm hidden-xs">
                    <div class="header-right clearfix">
                        <div class="top-cart-contain f-right">
                            <div class="mini-cart text-xs-center">
                                <div class="heading-cart cart_header">
                                    <div class="icon_hotline">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                    </div>
                                    <div class="content_cart_header">
                                        <a class="bg_cart cart-count" href="/gio-hang.html" title="Giỏ hàng">
                                            (<span class="count_item count_item_pr"><?php echo count((array)$_SESSION['cart']);?></span>) Sản phẩm
                                            <span class="text-giohang">Giỏ hàng</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-dropdown">
                            <div class="cart-dropdown-inner">
                                <div class="cart-items list-item-cart">
                                    <!-- Cart items will be loaded dynamically here -->
                                </div>
                                <div class="cart-footer">
                                    <div class="cart-total">
                                        <span>Tổng tiền:</span>
                                        <span class="total-price">0 đ</span>
                                    </div>
                                    <div class="cart-buttons">
                                        <a href="/gio-hang.html" class="btn-view-cart">Xem giỏ hàng</a>
                                        <a href="/checkout.html?step=1" class="btn-checkout">Thanh toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hotline_dathang f-right hidden-sm draw">
                            <div class="icon_hotline">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="content_hotline">
                                <a href="tel:{hotline_number}">{hotline}</a>
                                <span>{text_hotline}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="hidden-sm hidden-xs">
        <div class="container">
            <div class="col-md-3 no-padding">
                <div class="mainmenu ">
                    <span><i class="ion ion-ios-keypad"></i> Danh mục sản phẩm</span>
                    <!-- <div class="nav-cate">
                        <ul id="menu2017">
                            {list_category_nav}
                        </ul>
                    </div> -->
                </div>
            </div>
            <div class="col-md-9 no-padding">
                <ul id="nav" class="nav">
                    {menu_top}
                </ul>
            </div>
        </div>
    </nav>
    <script>
    if ($(window).width() > 1100) {


        var menu_limit = "8";
        if (isNaN(menu_limit)) {
            menu_limit = 10;
        } else {
            menu_limit = 7;
        }
    } else {


        var menu_limit = "7";
        if (isNaN(menu_limit)) {
            menu_limit = 8;
        } else {
            menu_limit = 6;
        }
    }
    var sidebar_length = $('.menu-item-count').length;
    if (sidebar_length > (menu_limit + 1)) {
        $('.nav-cate:not(.site-nav-mobile) > ul').each(function() {
            $('.menu-item-count', this).eq(menu_limit).nextAll().hide().addClass('toggleable');
            $(this).append('<li class="more"><h3><a><label>Xem thêm ... </label></a></h3></li>');
        });
        $('.nav-cate > ul').on('click', '.more', function() {
            if ($(this).hasClass('less')) {
                $(this).html('<h3><a><label>Xem thêm ...</label></a></h3>').removeClass('less');
            } else {
                $(this).html('<h3><a><label>Thu gọn ... </label></a></h3>').addClass('less');;
            }
            $(this).siblings('li.toggleable').slideToggle({
                complete: function() {
                    var divHeight = $('#menu2017').height() + 1;
                    $('.subcate.gd-menu').css('min-height', divHeight + 'px');
                    $('.subcate2').css('min-height', divHeight + 'px');
                }
            });
        });
        $('.mainmenu-other').hover(function() {
            var divHeight = $('#menu2017').height() + 1;
            $('.subcate.gd-menu').css('min-height', divHeight + 'px');
            $('.subcate2').css('min-height', divHeight + 'px');
        });
    }



    document.addEventListener("DOMContentLoaded", function () {
		const voiceBtn = document.getElementById("voiceSearchBtn");
		const searchInput = document.getElementById("search-input");
		let isListening = false;

		if ('webkitSpeechRecognition' in window) {
			const recognition = new webkitSpeechRecognition();
			recognition.continuous = false;
			recognition.interimResults = false;
			recognition.lang = "vi-VN";

			voiceBtn.addEventListener("click", function () {
				if (!isListening) {
					try {
						recognition.start();
						isListening = true;
						voiceBtn.classList.add('listening');
						voiceBtn.innerHTML = '<i class="fa fa-microphone"></i>';
					} catch (e) {
						console.error("Error starting recognition:", e);
					}
				} else {
					recognition.stop();
					isListening = false;
					voiceBtn.classList.remove('listening');
					voiceBtn.innerHTML = '<i class="fa fa-microphone"></i>';
				}
			});

			recognition.onresult = function (event) {
				const transcript = event.results[0][0].transcript;
				searchInput.value = transcript;
				
				// Trigger input event to show search suggestions
				const inputEvent = new Event('input', {
					bubbles: true,
					cancelable: true,
				});
				searchInput.dispatchEvent(inputEvent);
			};

			recognition.onend = function() {
				isListening = false;
				voiceBtn.classList.remove('listening');
				voiceBtn.innerHTML = '<i class="fa fa-microphone"></i>';
			};

			recognition.onerror = function (event) {
				console.error("Lỗi nhận diện giọng nói:", event.error);
				isListening = false;
				voiceBtn.classList.remove('listening');
				voiceBtn.innerHTML = '<i class="fa fa-microphone"></i>';
				
				switch(event.error) {
					case 'no-speech':
						//alert('Không phát hiện giọng nói. Vui lòng thử lại.');
						break;
					case 'audio-capture':
						//alert('Không thể truy cập microphone. Vui lòng kiểm tra quyền truy cập.');
						break;
					case 'not-allowed':
						//alert('Quyền truy cập microphone bị từ chối. Vui lòng cấp quyền và thử lại.');
						break;
					default:
						//alert('Có lỗi xảy ra khi nhận diện giọng nói. Vui lòng thử lại.');
				}
			};
		} else {
			voiceBtn.style.display = 'none';
			console.log("Trình duyệt không hỗ trợ nhận diện giọng nói");
		}
	});


    $(document).ready(function () {
    let cartTimeout;

    // Handle cart hover
    $('.cart_header').on('mouseenter', function () {
        clearTimeout(cartTimeout);
        loadCartItems();
    });

    $('.mini-cart').on('mouseleave', function () {
        cartTimeout = setTimeout(function () {
            $('.cart-dropdown').fadeOut(200);
        }, 300);
    });

    $('.cart-dropdown').on('mouseenter', function () {
        clearTimeout(cartTimeout);
    });

    $('.cart-dropdown').on('mouseleave', function () {
        cartTimeout = setTimeout(function () {
            $('.cart-dropdown').fadeOut(200);
        }, 300);
    });

    // Function to load cart items
    function loadCartItems() {
        $.ajax({
            url: '/process.php',
            type: 'POST',
            data: {
                action: 'show_cart'
            },
            success: function (response) {
                try {
                    var info = JSON.parse(response);
                    if (info.ok === 1) {
                        $(".list-item-cart").html(info.list_cart);
                        $(".total-price").text(info.tongtien);
                        $(".count_item_pr").text(info.total_cart);
                        $(".cart-dropdown").fadeIn(200);
                    } else {
                        $(".list-item-cart").html('<div class="empty-cart">' + info.thongbao + '</div>');
                        $(".total-price").text('0 đ');
                        $(".count_item_pr").text('0');
                        $(".cart-dropdown").fadeIn(200);
                    }
                } catch (e) {
                    console.error('Error parsing cart data:', e);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading cart:', error);
            }
        });
    }

    // Handle remove item from cart
    $(document).on('click', '.remove-item-cart', function (e) {
        e.preventDefault();
        const productId = $(this).data('id');

        $.ajax({
            url: '/process.php',
            type: 'POST',
            data: {
                action: 'remove_cart',
                id: productId
            },
            success: function (response) {
                try {
                    var info = JSON.parse(response);
                    if (info.ok === 1) {
                        loadCartItems(); // Reload cart items
                        $(".count_item_pr").text(info.total_cart); // Update cart count
                    }
                } catch (e) {
                    console.error('Error parsing remove cart response:', e);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error removing item:', error);
            }
        });
    });
});
    </script>
</header>