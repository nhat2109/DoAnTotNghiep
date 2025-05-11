{header}
<body>
    {box_header}
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="/" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">{cat_tieude}</strong>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="hidden">
        <aside class="aside-item collection-category margin-bottom-10">
            <div class="aside-title">
                <h3 class="title-head margin-top-0"><span>Danh mục</span></h3>
            </div>
            <div class="aside-content">
                <nav class="nav-category navbar-toggleable-md">
                    <ul class="nav navbar-pills">
                    	{list_category_left}
                    </ul>
                </nav>
            </div>
        </aside>
    </div>
    <div class="container margin-top-20">
        <div class="row">
            <div class="col-md-12">
                <div class="collections_des_and_menu">
                    <div class="collections_des_and_menu_list margin-bottom-20">
                        <div class="title clearfix margin-bottom-20" id="loc_danhmuc">
                            {cat_tieude}
                        </div>
                        <ul class="list-inline">
                        	{list_category_sub}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container margin-bottom-20" id="collection-body">
        <div class="row">
            <aside class="sidebar left left-content col-md-3 col-sm-12 col-xs-12">
                <div class="hidden-xs hidden-sm">
                    <aside class="aside-item collection-category margin-bottom-10">
                        <div class="aside-title">
                            <h3 class="title-head margin-top-0"><span>Danh mục</span></h3>
                        </div>
                        <div class="aside-content">
                            <nav class="nav-category navbar-toggleable-md">
                                <ul class="nav navbar-pills">
                                	{list_category_left}
                                </ul>
                            </nav>
                        </div>
                    </aside>
                </div>
                <div class="box_sidebar">
                    <div class="block left-module">
                        <div class=" filter_xs">
                            <div class="layered">
                                <p class="title_block" id="loc_thuonghieu">
                                    Bộ lọc
                                </p>
                                <div class="block_content">
                                    <!-- ./filter brand -->
                                    <div class="group-filter" aria-expanded="true">
                                        <div class="layered_subtitle dropdown-filter"><span>Thương hiệu</span></div>
                                        <div class="layered-content bl-filter filter-brand">
                                            <ul class="check-box-list">
                                            	{list_thuonghieu}
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- ./filter price -->
                                    <div class="group-filter" aria-expanded="true">
                                        <div class="layered_subtitle dropdown-filter"><span>Giá sản phẩm</span></div>
                                        <div class="layered-content bl-filter filter-price">
                                            <ul class="check-box-list">
                                            	{list_price}
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- ./filter color -->
                                    <!-- <div class="group-filter" aria-expanded="true">
                                        <div class="layered_subtitle dropdown-filter"><span>Màu sắc</span></div>
                                        <div class="layered-content filter-color s-filter">
                                            <ul class="check-box-list">
                                            	{list_color}
                                            </ul>
                                        </div>
                                    </div> -->
                                    <!-- ./filter size -->
                                    <div class="group-filter" aria-expanded="true">
                                        <div class="layered_subtitle dropdown-filter"><span>Kích thước</span></div>
                                        <div class="layered-content filter-size s-filter">
                                            <ul class="check-box-list clearfix">
                                            	{list_size}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <section class="main_container collection col-md-9 col-sm-12 col-xs-12">
                <div class="pottion">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="title-head margin-top-0">{cat_tieude}</h1>
                        </div>
                        <div class="col-md-4 hidden-sm hidden-xs">
                            <div class="sortPagiBar">
                                <div id="sort-by">
                                    <label class="left hidden">Sắp xếp: </label>
                                    <span class="custom-dropdown custom-dropdown--grey">
                                        <select class="sort-by custom-dropdown__select" name="sort">
                                            <option value="price-ascending">Giá: Tăng dần</option>
                                            <option value="price-descending">Giá: Giảm dần</option>
                                            <option value="title-ascending">Tên: A-Z</option>
                                            <option value="title-descending">Tên: Z-A</option>
                                            <option value="created-ascending">Cũ nhất</option>
                                            <option value="created-descending">Mới nhất</option>
                                            <option value="best-selling">Bán chạy nhất</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert-no-filter"></div>
                    <div class="category-products products clearfix margin-top-10">
                        <section class="products-view products-view-grid">
                            <div class="clearfix borderss row product-list filter">
                                {list_sanpham}
                            </div>
                            <div class="text-xs-right pagi">
                                <div class="page_redirect">
                                    {phantrang}
                                </div>
                            </div>
                            <input type="hidden" name="cat_id" value="{cat_id}">
                        </section>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="container">
        <div class="row recent_products-row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-hg-12">
                <div class="recent_products">
                    <div class="module-header">
                        <h2 class="title-head module-title">
                            <span>Sản phẩm bạn đã xem</span>
                        </h2>
                    </div>
                    <div class="module-content">
                        <div class="recent_items">
                            <div id="recent-content" class="not-dqowl owl-theme owl-carousel owl-loaded owl-drag">
                                <div class="owl-stage-outer">
                                    <div class="owl-stage swiper-container slide_daxem">
                                        <div class="swiper-wrapper">
                                            {list_daxem}                                                
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="owl-nav">
                                    <div class="owl-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
                                    <div class="owl-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
    <script>
    var slide_banner = new Swiper('.slide_daxem', {
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
        breakpoints: {
            320: {
              slidesPerView: 2,
              spaceBetween: 10,
            },
            768: {
              slidesPerView: 4,
              spaceBetween: 10,
            },
            1024: {
              slidesPerView: 5,
              spaceBetween: 10,
            },
        },
        // Navigation arrows
        navigation: {
            nextEl: '.recent_products .owl-next',
            prevEl: '.recent_products .owl-prev',
        },
    })
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('select[name=sort]').val('{sort}');
        });
    </script>
</body>

</html>