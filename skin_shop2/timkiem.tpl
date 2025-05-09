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
                        <li>
                            <strong itemprop="name">Kết quả tìm kiếm</strong>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="signup search-main collections-container margin-bottom-20">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-head text-center margin-bottom-10">Có {total_sanpham} kết quả tìm kiếm phù hợp</h1>
                </div>
                <div class="col-md-12">
                    <div class="products-view-grid products">
                        <div class="clearfix borderss">
                        	{list_sanpham}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {footer}
    {script_footer}
</body>

</html>