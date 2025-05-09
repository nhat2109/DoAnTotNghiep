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
                            <a itemprop="item" href="/tin-tuc.html" title="Tin tức">
                                <span itemprop="name">Tin tức</span>
                                <meta itemprop="position" content="2" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">{tieu_de}</strong>
                            <meta itemprop="position" content="3" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container article-wraper">
        <div class="row">
            <section class="right-content col-md-9 col-md-push-3">
                <article class="article-main" itemscope itemtype="http://schema.org/Article">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="title-head">{tieu_de}</h1>
                            <div class="postby">
                                <span>Đăng lúc {date_post}</span>
                            </div>
                            <div class="article-details">
                                <div class="article-content">
                                    <div class="rte">
                                        <div class="caption" id="fancy-image-view">
                                        	{noi_dung}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a099baca270babc"></script>
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_inline_share_toolbox_jje8"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="blog_related">
                                <h2>Bài viết liên quan</h2>
                                <div class="row">
                                	{list_lienquan}
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-12">
                            <div id="article-comments" class="clearfix">
                                <h5 class="title-form-coment">Bình luận {total_comment}</h5>
                                {list_comment}
                            </div>
                            <div class="form-coment margin-bottom-10">
                                <div class="">
                                    <h5 class="title-form-coment">VIẾT BÌNH LUẬN CỦA BẠN:</h5>
                                </div>
                                <fieldset class="form-group">
                                    <input placeholder="Họ tên" type="text" class="form-control form-control-lg" value="{name}" id="full-name" name="name"/>
                                </fieldset>
                                <fieldset class="form-group">
                                    <input placeholder="Email" type="email" class="form-control form-control-lg" value="{email}" id="email" name="email" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <textarea placeholder="Nội dung" class="form-control form-control-lg" id="comment" name="noidung" rows="6"></textarea>
                                </fieldset>
                                <div>
                                    <button type="button" class="btn btn-blues" name="comment"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Gửi bình luận</button>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </article>
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