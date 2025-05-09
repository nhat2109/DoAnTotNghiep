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
                            <strong itemprop="name">{tieu_de}</strong>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container" itemscope itemtype="http://schema.org/Blog">
        <meta itemprop="name" content="">
        <meta itemprop="description" content="Chủ đề không có mô tả">
        <div class="row">
            <section class="right-content col-md-9 col-md-push-3 list-blog-page">
                <div class="box-heading">
                    <h1 class="title-head">{tieu_de}</h1>
                </div>
                <section class="list-blogs blog-main margin-top-30">
                    <div class="row">
                        {list_baiviet}
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="page_redirect">
                                {phantrang}
                            </div>  
                        </div>
                    </div>
                </section>
            </section>
            <aside class="left left-content col-md-3 col-md-pull-9">
                <aside class="aside-item collection-category blog-category">
                    <div class="heading">
                        <h2 class="title-head"><span>Danh mục</span></h2>
                    </div>
                    <div class="aside-content">
                        <nav class="nav-category  navbar-toggleable-md">
                            <ul class="nav navbar-pills">
                                {menu_top}
                            </ul>
                        </nav>
                    </div>
                </aside>
                <div class="aside-item">
                    <div class="heading">
                        <h2 class="title-head">Bài viết mới</h2>
                    </div>
                    <div class="list-blogs">
                        {list_baiviet_moi}
                    </div>
                </div>
            </aside>
        </div>
    </div>
    {footer}
    {script_footer}
</body>

</html>