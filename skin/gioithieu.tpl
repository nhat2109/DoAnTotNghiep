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
	                    <li class="active"><span>Giới thiệu</span></li>
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
                        <h2 class="title-head"><span>Menu</span></h2>
                    </div>
                    <div class="aside-content">
                        <nav class="nav-category navbar-toggleable-md">
                            <ul class="nav navbar-pills flex-column">
                            	{menu_left}
                            </ul>
                        </nav>
                    </div>
                    <div class="aside-title">
                        <h2 class="title-head title_tintuc"><span><a href="/bai-viet/tin-tuc.html" title="Bài viết mới">Bài viết mới</a></span></h2>
                    </div>
                    <div class="list_tintuc_right">
                    	{list_tintuc_right}
                    </div>
				</div>
				<div class="box_right">
                    <div class="col-md-12">
                        <h1 class="title-head">{tieu_de}</h1>
                        <div class="postby text-muted">
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
				</div>
			</div>
		</div>
	</div>
    <div class="ab-module-article-mostview"></div>
    {footer}
    {script_footer}
</body>

</html>