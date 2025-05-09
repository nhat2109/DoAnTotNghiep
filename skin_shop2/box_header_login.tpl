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
                <div class="col-md-5">
                    <div class="search">
                        <div class="header_search search_form">
                            <form class="input-group search-bar search_form" action="/tim-kiem.html" method="get" role="search">
                                <input type="search" name="key" value="" placeholder="Tìm kiếm sản phẩm... " class="input-group-field st-default-search-input search-text" autocomplete="off">
                                <span class="input-group-btn">
                                    <button class="btn icon-fallback-text">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </form>
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
                                        <a class="bg_cart" href="/gio-hang.html" title="Giỏ hàng">
                                            (<span class="count_item count_item_pr"><?php echo count($_SESSION['cart']);?></span>) Sản phẩm
                                            <span class="text-giohang">Giỏ hàng</span>
                                        </a>
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
                    <div class="nav-cate">
                        <ul id="menu2017">
                            {list_category_nav}
                        </ul>
                    </div>
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
    </script>
</header>