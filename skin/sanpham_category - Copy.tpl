{header}

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
    <div class="main_tintuc">
        <div class="container">
            <div class="row">
                <div class="box_left">
                    <div class="aside-title">
                        <h2 class="title-head"><span>Thương hiệu</span></h2>
                    </div>
                    <div class="aside-content">
                        <ul class="list_where">
                            {list_brand}
                        </ul>
                    </div>
                    <div class="aside-title">
                        <h2 class="title-head title_border"><span>Màu sắc</span></h2>
                    </div>
                    <div class="aside-content">
                        <ul class="list_where">
                            {list_color}
                        </ul>
                    </div>
                    <div class="aside-title">
                        <h2 class="title-head title_border"><span>Mức Giá</span></h2>
                    </div>
                    <div class="aside-content">
                        <ul class="list_where">
                            {list_price}
                        </ul>
                    </div>
                    <div class="aside-title">
                        <h2 class="title-head title_border"><span>Kích cỡ</span></h2>
                    </div>
                    <div class="aside-content">
                        <ul class="list_where list_size">
                            {list_size}
                        </ul>
                    </div>
                </div>
                <div class="box_right">
                    <h1 class="title_page">{tieu_de}</h1>
                    <div id="sort-by">
                        <label class="left"><span class="">Sắp xếp: </span></label>
                        <ul class="content_ul">
                            <li id="title-ascending"><a class="link" href="javascript:;">Tên A → Z</a></li>
                            <li id="title-descending"><a class="link" href="javascript:;">Tên Z → A</a></li>
                            <li id="price-ascending"><a class="link" href="javascript:;">Giá tăng dần</a></li>
                            <li id="price-descending"><a class="link" href="javascript:;">Giá giảm dần</a></li>
                            <li id="created-descending" class="active"><a class="link" href="javascript:;">Hàng mới </a></li>
                        </ul>
                        <div id="open-filters">
                            <i class="fa fa-filter"></i>
                            <span>Lọc</span>
                        </div>
                    </div>
                    <div class="list_tintuc">
                        <div class="tab">
                            {list_sanpham}
                        </div>
                    </div>
                    <div class="text-right pageinate-page-blog">
                        <div class="page_redirect">
                            {phantrang}
                        </div>
                    </div>
                    <input type="hidden" name="cat_id" value="{cat_id}">
                </div>
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
        </div>
        <div class="aside-content">
            <ul class="list_where">
                {list_brand_mobile}
            </ul>
        </div>
        <div class="aside-title">
            <h2 class="title-head title_border"><span>Màu sắc</span></h2>
        </div>
        <div class="aside-content">
            <ul class="list_where">
                {list_color_mobile}
            </ul>
        </div>
        <div class="aside-title">
            <h2 class="title-head title_border"><span>Mức Giá</span></h2>
        </div>
        <div class="aside-content">
            <ul class="list_where">
                {list_price_mobile}
            </ul>
        </div>
        <div class="aside-title">
            <h2 class="title-head title_border"><span>Kích cỡ</span></h2>
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
    $(document).ready(function() {
        $('.content_ul li').removeClass('active');
        $('.content_ul li#{sort}').addClass('active');
    });
    </script>
</body>

</html>