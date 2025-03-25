
<!DOCTYPE html>     
<html lang="vi">                                          
{header}
	<body id="template-customers/account">
		<div class="opacity_menu"></div>
		<link rel="preload" as='style'  type="text/css" href="/skin_shop/skin_7_nhat/tpl/css/header.css">
		<link rel="stylesheet" href="/skin_shop/skin_7_nhat/tpl/css/header.css">


		{box_banner}

{box_header}
<script type="text/x-custom-template" data-template="stickyHeader">
<header class="ega-header header header_sticky">
	<div class="container">	
		<div class="header-wrap">
			<div id="logo">


				
				<a href="/" class="logo-wrapper ">	
					<img class="img-fluid"
						 src="//bizweb.dktcdn.net/100/491/756/themes/956460/assets/logo.png?1727322848954" 
						 alt="{tieu_de}"
						 width="134"
						 height="45"
						 >
				</a>
				


			</div>

			<div class="ega-form-search">
				<form action="/search" method="get" class="input-group search-bar custom-input-group " role="search">
	<input type="text" name="query" value="" autocomplete="off" 
		   class="input-group-field auto-search form-control " required="" 
		   data-placeholder="Tìm theo tên sản phẩm...; Tìm theo thương hiệu...;">
	<input type="hidden" name="type" value="product">
	<span class="input-group-btn btn-action">
		<button type="submit"  aria-label="search" class="btn text-white icon-fallback-text h-100">
			<svg class="icon">
	<use xlink:href="#icon-search" />
</svg>		</button>
	</span>

</form>
				
								
				
								<div class="search-dropdow">
					<ul class="search__list pl-0 d-flex list-unstyled mb-0 flex-wrap">
												<li class="mr-2 mt-2" >
							<a id="filter-search-mau-sofa-moi" href="/search?q=tags:(M%E1%BA%ABu+Sofa+m%E1%BB%9Bi)&type=product">Mẫu Sofa mới</a>
						</li>	
						<li class="mr-2 mt-2" >
							<a id="filter-search-noi-that-phong-khach" href="/search?q=tags:(+N%E1%BB%99i+th%E1%BA%A5t+ph%C3%B2ng+kh%C3%A1ch)&type=product"> Nội thất phòng khách</a>
						</li>	
						<li class="mr-2 mt-2" >
							<a id="filter-search-den-trang-tri" href="/search?q=tags:(+%C4%90%C3%A8n+trang+tr%C3%AD)&type=product"> Đèn trang trí</a>
						</li>	
					</ul>
				</div>
											</div>

			<div class="header-right ega-d--flex">
				<div class="icon-action header-right__icons" style='--header-grid-template: repeat(3, 1fr);'>
				
					<div id="icon-account" class="ega-color--inherit header-icon icon-account d-none d-md-block d-lg-block">
						<svg class="icon">
	<use xlink:href="#icon-user" />
</svg>						<div class="account-action">
														<a rel="nofollow" href="/account" title="Tài khoản">Tài khoản</a>
							<a href="/account/logout" title="Đăng xuất">Đăng xuất</a>
													</div>
					</div>
					<div class="mini-cart text-xs-center">
						<a class="header-icon cart-count ega-color--inherit" href="/cart"  title="Giỏ hàng">
							<img src="//bizweb.dktcdn.net/100/491/756/themes/956460/assets/icon-cart.png?1727322848954" alt="icon-cart"/>
							<span class="count_item count_item_pr">0</span>
						</a>
						<div class="top-cart-content card ">
							<ul id="cart-sidebar" class="mini-products-list count_li list-unstyled">
								<li class="list-item">
									<ul></ul>
								</li>
								<li class="action">

								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="ega-header-layer"></div>
	</div>
</header>

</script>
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
                        <strong itemprop="name">Tích điểm</strong>
                        <meta itemprop="position" content="2" />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<div class="container mr-bottom-20">
    <div class="row">
        <div class="container_member">
            <div class="box_left">
                <div class="avatar">
                    <img src="{avatar}" alt="Hình đại diện" onerror="this.src='/images/no-images.jpg';">
                </div>
                <div class="name">{name}</div>
                <div class="email">{email}</div>
                <ul class="list_info">
                    <li class="list-item">
                        <b>Ngày sinh:</b> <a class="pull-right">{ngay_sinh}</a>
                    </li>
                    <li class="list-item">
                        <b>Điện Thoại:</b> <a class="pull-right">{dien_thoai}</a>
                    </li>
                    <li class="list-item">
                        <b>Ngày Tham Gia:</b> <a class="pull-right">{date_reg}</a>
                    </li>
                </ul>
                <a href="/doi-mat-khau.html" class="button">Thay đổi mật khẩu</a>
            </div>
            <div class="box_right">
                <div class="list_action">
                    <div class="action">
                        <a href="/don-hang.html">
                            <img src="/skin/css/images/icon/6.png" alt="Danh sách đơn hàng">
                            <h2>Danh sách đơn hàng</h2>
                        </a>
                    </div>
                    <div class="action">
                        <a href="/tai-khoan.html">
                            <img src="/skin/css/images/icon/2.png" alt="Thông tin tài khoản">
                            <h2>Thông tin tài khoản</h2>
                        </a>
                    </div>
                    <div class="action">
                        <a href="/doi-avatar.html">
                            <img src="/skin/css/images/icon/3.png" alt="Đổi hình đại diện">
                            <h2>Đổi hình đại diện</h2>
                        </a>
                    </div>
                    <div class="action">
                        <a href="/doi-mat-khau.html">
                            <img src="/skin/css/images/icon/4.png" alt="Đổi mật khẩu">
                            <h2>Đổi mật khẩu</h2>
                        </a>
                    </div>
                    <div class="action">
                        <a href="/tich-diem.html" class="active">
                            <img src="/skin/css/images/icon/tich_diem.png" alt="Tích điểm">
                            <h2>Tích điểm</h2>
                        </a>
                    </div>
                    <div class="action">
                        <a href="/lien-he.html">
                            <img src="/skin/css/images/hotro.png" alt="Liên hệ">
                            <h2>Liên hệ</h2>
                        </a>
                    </div>
                </div>
                <h1>Lịch sử tích điểm</h1>
                <div class="box_profile">
                    <div style="text-align: center;font-weight: 700;color: #f00;">
                        Tổng điểm khả dụng: {diem}
                    </div>
                    <table class="list_donhang">
                        <tr>
                            <th width="100" class="mobile_hide">Ngày</th>
                            <th width="100">Điểm</th>
                            <th width="150">Trạng thái</th>
                            <th class="mobile_hide">Nội dung</th>
                        </tr>
                        {list_tichdiem}
                    </table>
                    <div style="margin-top: 10px;">
                        + Trạng thái tạm giữ là trạng thái điểm tạm thời không sử dụng được trong thanh toán đơn hàng<br>
                        + Trạng thái tạm giữ sẽ chuyển sang trạng thái "đã cộng" khi đơn hàng hoàn thành.<br>
                        + Tổng điểm khả dụng là số điểm hiện tại mà bạn có thể sử dụng để thanh toán đơn hàng.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
  
    /* General Styles */

  
  .row {
    display: flex;
    flex-wrap: wrap;
  }
  
  .container_member {
    display: flex;
    
  }
  
  .box_left,
  .box_right {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .box_left a:hover{
    color: #ffffff !important;
  }
  .box_left {
    flex: 1 1 30%;
    text-align: center;
  }
  
  .box_right {
    flex: 1 1 65%;
  }
  
  .avatar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin-bottom: 10px;
    object-fit: cover;
  }
  
  .name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  .email {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
  }
  
  .list_info {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: left;
  }
  
  .list_info .list-item {
    font-size: 14px;
    margin-bottom: 8px;
  }
  
  .list_info .list-item b {
    color: #555;
  }
  
  .button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ec720e;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 15px;
    transition: background-color 0.3s ease;
  }
  
  .button:hover {
    background-color: #ff7300;
  }
  
  /* Right Side Actions */
  .list_action {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
  }
  
  .action {
    flex: 1 1 30%;
    text-align: center;
  }
  
  .action img {
    width: 50px;
    height: 50px;
    margin-bottom: 10px;
  }
  
  .action h2 {
    font-size: 14px;
    font-weight: bold;
    color: #555;
  }
  
  .action a {
    text-decoration: none;
    color: inherit;
    display: block;
    padding: 10px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
  }
  
  .action a:hover {
    background-color: #f0f0f0;
  }
  
  .action a.active {
    background-color: #ec720e;
    color: #fff;
  }
  
  /* Profile Form */
  .box_profile {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .li_input {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    flex-wrap: wrap;
  }
  
  .col_30 {
    flex: 1 1 30%;
  }
  
  .col_100 {
    flex: 1 1 100%;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #555;
  }
  
  input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
  }
  
  input[type="text"]:focus {
    border-color: #ec720e;
    outline: none;
  }
  
  button[name="change_profile"] {
    padding: 10px 20px;
    background-color: #ec720e;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
  }
  
  button[name="change_profile"]:hover {
    background-color: #ff7300;
  }
  
</style>




  


{footer}




<div class="modal fade" id="ega-modal-banner" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md align-vertical" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<a href="/">
					<img loading="lazy" class="img-fluid" src="{modal_header}" 
						 alt="welcome popup" width="590" height="590"/>
				</a>
				<button class="btn-form-close close" type="button" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
			</div>
		</div>
	</div>
</div>


<script type="text/x-custom-template" data-template="navigation">

<nav>
<ul  class="navigation navigation-horizontal list-group list-group-flush scroll">
		
	
	
			<li class="menu-item list-group-item">
		<a href="/collections/all"
		   
		   class="menu-item__link" title="Sản phẩm">
									<span>
			Sản phẩm</span>	 
			
			<i class='float-right' data-toggle-submenu>
				

<svg class="icon" >
	<use xlink:href="#icon-arrow" />
</svg>			</i>
			
			
			</a>			
		
		
			
						
			
										<div class="submenu scroll  mega-menu ">
			<div class='toggle-submenu d-lg-none d-xl-none'>
				<i class='mr-3'>
					

<svg class="icon" style="transform: rotate(180deg)"
>
	<use xlink:href="#icon-arrow" />
</svg>				</i>
				<span>Sản phẩm </span>
			</div>
			<ul class="submenu__list container">
			
			
			
			<li class="submenu__col">
				<span class="submenu__item submenu__item--main">
					<a 
					  
					   class="link" href="/san-pham-moi" title="Nội thất">Nội thất</a>
				</span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Sofa phòng khách">Sofa phòng khách</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Bàn ăn">Bàn ăn</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Ghế ăn">Ghế ăn</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Tủ và giá đỡ">Tủ và giá đỡ</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Nội thất sân vưởn">Nội thất sân vưởn</a>
				 </span>
				
			</li>
			
			
			
			
			<li class="submenu__col">
				<span class="submenu__item submenu__item--main">
					<a 
					  
					   class="link" href="/den-trang-tri" title="Đèn trang trí">Đèn trang trí</a>
				</span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Đèn ngoài trời">Đèn ngoài trời</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Đèn tường">Đèn tường</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Đèn bàn">Đèn bàn</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Đèn trần">Đèn trần</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Phụ kiện chống sét">Phụ kiện chống sét</a>
				 </span>
				
			</li>
			
			
			
			
			<li class="submenu__col">
				<span class="submenu__item submenu__item--main">
					<a 
					  
					   class="link" href="/tu-giay-tu-trang-tri" title="Vật dụng trong nhà">Vật dụng trong nhà</a>
				</span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Gương">Gương</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Móc và giá treo áo">Móc và giá treo áo</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Phụ kiện nhà bếp">Phụ kiện nhà bếp</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Chân nến và đèn lồng">Chân nến và đèn lồng</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="Bình hoa">Bình hoa</a>
				 </span>
				
			</li>
			
			
			
			
			<li class="submenu__col">
				<span class="submenu__item submenu__item--main">
					<a 
					  
					   class="link" href="/ban-ghe-an" title="Bộ sưu tập">Bộ sưu tập</a>
				</span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="MỚI! Nâng cao nỗi nhớ">MỚI! Nâng cao nỗi nhớ</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="BST Nỗi nhớ">BST Nỗi nhớ</a>
				 </span>
				
				 <span class="submenu__item submenu__item">
					 <a
						
						class="link" href="/" title="BST Bước ngoặc">BST Bước ngoặc</a>
				 </span>
				
			</li>
			
			
		</ul>
		</div>
			</li>
	
	
	
			<li class="menu-item list-group-item">
		<a href="/collections/all"
		   
		   class="menu-item__link" title="Phòng">
									<span>
			Phòng</span>	 
			
			<i class='float-right' data-toggle-submenu>
				

<svg class="icon" >
	<use xlink:href="#icon-arrow" />
</svg>			</i>
			
			
			</a>			
			
						
					
					
							<div class="submenu scroll  default ">
			<div class='toggle-submenu d-lg-none d-xl-none'>
				<i class='mr-3'>
					

<svg class="icon" style="transform: rotate(180deg)"
>
	<use xlink:href="#icon-arrow" />
</svg>				</i>
				<span>Phòng </span>
			</div>
			<ul class="submenu__list container">
			
			
			
			<li class="submenu__item submenu__item--main ">
					<a class="link"
					   						

					   href="/phong-khach" title="Phòng khách">Phòng khách</a>
				</li>
			
			
			
			
			<li class="submenu__item submenu__item--main ">
					<a class="link"
					   						

					   href="/giuong-ngu-hien-dai" title="Phòng ngủ">Phòng ngủ</a>
				</li>
			
			
			
			
			<li class="submenu__item submenu__item--main ">
					<a class="link"
					   						

					   href="/nha-bep" title="Phòng bếp">Phòng bếp</a>
				</li>
			
			
		</ul>
		</div>
			</li>
	
	
	
			<li class="menu-item list-group-item">
		<a href="/flashsale"
		   
		   class="menu-item__link" title="Khuyến mãi">
									<span>
			Khuyến mãi</span>	 
			</a>			
			
					</li>
	
	
	
			<li class="menu-item list-group-item">
		<a href="/tin-tuc"
		   
		   class="menu-item__link" title="Góc cảm hứng">
									<span>
			Góc cảm hứng</span>	 
			</a>			
			
					</li>
	
	
	
			<li class="menu-item list-group-item">
		<a href="https://wiki.egany.com/s/ega-furniture-sapo"
		    target="_blank" 
		   class="menu-item__link" title="Hướng dẫn thiết lập">
									<span>
			Hướng dẫn thiết lập</span>	 
			</a>			
			
					</li>
	
</ul>
	</nav>
 
</script>

<script type="text/x-custom-template" data-template="menuMobile">
	<div id="mobile-menu" class="scroll">
		<div class='media d-flex user-menu'>

			<i class="fas fa-user-circle mr-3 align-self-center"></i>
			<div class="media-body d-md-flex flex-column ">
				<a rel="nofollow" href="/tai-khoan.html" class="d-block" title="Tài khoản" >
					Tài khoản
				</a>
				<small>
					<a href="/dang-nhap.html" title="Đăng nhập" class="font-weight: light">
						Đăng nhập
					</a> </small>

			</div>
		</div>

		<div class="mobile-menu-body scroll">
			<nav>
				   <ul  class="navigation navigation-horizontal list-group list-group-flush scroll">
						{menu_mobile}

	</ul>
		</nav>

		</div>

		<div class="mobile-menu-footer border-top w-100 d-flex align-items-center text-center">
			<div class="hotline  w-50   p-2 ">
				<a  href="tel:{hotline}" title="{hotline}">
					Gọi điện <i class="fas fa-phone ml-3"></i>
				</a>
			</div>
					<div class="messenger border-left p-2 w-50 border-left">

				<a  href="https://m.me/" title="https://m.me/">
					Nhắn tin
					<i class="fab fa-facebook-messenger ml-3"></i>
				</a>
			</div>

		</div>
	</div>
	<div class='menu-overlay'>

	</div>
  </script>		<svg style="display:none">
  <defs>
<symbol class="icon " id="icon-cart" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.594 16.39a.703.703 0 0 1-.703.704h-.704v.703a.703.703 0 0 1-1.406 0v-.703h-.703a.703.703 0 0 1 0-1.407h.703v-.703a.703.703 0 1 1 1.406 0v.704h.704c.388 0 .703.314.703.703Zm0-10.968v6.75a.703.703 0 0 1-1.406 0V6.125H12.78v2.11a.703.703 0 1 1-1.406 0v-2.11h-6.75v2.11a.703.703 0 1 1-1.406 0v-2.11H1.813v10.969h7.453a.703.703 0 1 1 0 1.406H1.109a.703.703 0 0 1-.703-.703V5.422c0-.388.315-.703.703-.703h2.143A4.788 4.788 0 0 1 8 .5a4.788 4.788 0 0 1 4.748 4.219h2.143c.388 0 .703.315.703.703Zm-4.266-.703A3.38 3.38 0 0 0 8 1.906 3.38 3.38 0 0 0 4.672 4.72h6.656Z" fill="currentColor"/></symbol>
	</defs>
</svg>
<svg style="display:none">
  <defs>
<symbol id="icon-minus" class="icon icon-minus" viewBox="0 0 16 2" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M15.375 0H0.625C0.279813 0 0 0.279813 0 0.625C0 0.970187 0.279813 1.25 0.625 1.25H15.375C15.7202 1.25 16 0.970187 16 0.625C16 0.279813 15.7202 0 15.375 0Z" fill="#8C9196"/>
</symbol>
	</defs>
</svg>

<svg style="display:none">
  <defs>
<symbol id="icon-plus" class="icon icon-plus" viewBox="0 0 93.562 93.562" fill="none" xmlns="http://www.w3.org/2000/svg">
<path xmlns="http://www.w3.org/2000/svg" d="M87.952,41.17l-36.386,0.11V5.61c0-3.108-2.502-5.61-5.61-5.61c-3.107,0-5.61,2.502-5.61,5.61l0.11,35.561H5.61   c-3.108,0-5.61,2.502-5.61,5.61c0,3.107,2.502,5.609,5.61,5.609h34.791v35.562c0,3.106,2.502,5.61,5.61,5.61   c3.108,0,5.61-2.504,5.61-5.61V52.391h36.331c3.108,0,5.61-2.504,5.61-5.61C93.562,43.672,91.032,41.17,87.952,41.17z"  fill="currentColor"/>
	  </symbol>
	</defs>
</svg>

<svg style="display:none">
  <defs>
<symbol  class="icon icon-arrow" id="icon-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.8 490.8" fill="none" aria-hidden="true" focusable="false" role="presentation">
	<path d="M135.685 3.128c-4.237-4.093-10.99-3.975-15.083.262-3.992 4.134-3.992 10.687 0 14.82l227.115 227.136-227.136 227.115c-4.237 4.093-4.354 10.845-.262 15.083 4.093 4.237 10.845 4.354 15.083.262.089-.086.176-.173.262-.262l234.667-234.667c4.164-4.165 4.164-10.917 0-15.083L135.685 3.128z" fill="currentColor"/>
	<path d="M128.133 490.68a10.667 10.667 0 01-7.552-18.219l227.136-227.115L120.581 18.232c-4.171-4.171-4.171-10.933 0-15.104 4.171-4.171 10.933-4.171 15.104 0l234.667 234.667c4.164 4.165 4.164 10.917 0 15.083L135.685 487.544a10.663 10.663 0 01-7.552 3.136z"/>
</symbol>
	</defs>
</svg>

<svg style="display:none">
  <defs>
<symbol id="icon-search" class="icon icon-search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904">
  <path d="M190.707 180.101l-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 005.303 2.197 7.498 7.498 0 005.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z"/>
</symbol>
	</defs>
</svg>

<svg style="display:none">
	<defs>
		<symbol id="icon-play" viewBox="0 0 18 18" fill="currentColor">
			<path d="M15.562 8.1L3.87.225c-.818-.562-1.87 0-1.87.9v15.75c0 .9 1.052 1.462 1.87.9L15.563 9.9c.584-.45.584-1.35 0-1.8z" fill="currentColor"></path>
		</symbol>
	</defs>
</svg>

<svg style="display:none">
	<defs>
		<symbol id="icon-user" fill="currentColor" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
			<path d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z"></path>
		</symbol>
	</defs>
</svg>

<svg style="display:none">
	<defs>
		<symbol id="icon-star" viewBox="0 0 26 28">
			<path d="M26 10.109c0 0.281-0.203 0.547-0.406 0.75l-5.672 5.531 1.344 7.812c0.016 0.109 0.016 0.203 0.016 0.313 0 0.406-0.187 0.781-0.641 0.781-0.219 0-0.438-0.078-0.625-0.187l-7.016-3.687-7.016 3.687c-0.203 0.109-0.406 0.187-0.625 0.187-0.453 0-0.656-0.375-0.656-0.781 0-0.109 0.016-0.203 0.031-0.313l1.344-7.812-5.688-5.531c-0.187-0.203-0.391-0.469-0.391-0.75 0-0.469 0.484-0.656 0.875-0.719l7.844-1.141 3.516-7.109c0.141-0.297 0.406-0.641 0.766-0.641s0.625 0.344 0.766 0.641l3.516 7.109 7.844 1.141c0.375 0.063 0.875 0.25 0.875 0.719z"></path>
		</symbol>
	</defs>
</svg>

<svg style="display:none">
	<defs>
		<symbol id="icon-star-half" viewBox="0 0 26 28">
			<path d="M18.531 14.953l4.016-3.906-6.594-0.969-0.469-0.938-2.484-5.031v15.047l0.922 0.484 4.969 2.625-0.938-5.547-0.187-1.031zM25.594 10.859l-5.672 5.531 1.344 7.812c0.109 0.688-0.141 1.094-0.625 1.094-0.172 0-0.391-0.063-0.625-0.187l-7.016-3.687-7.016 3.687c-0.234 0.125-0.453 0.187-0.625 0.187-0.484 0-0.734-0.406-0.625-1.094l1.344-7.812-5.688-5.531c-0.672-0.672-0.453-1.328 0.484-1.469l7.844-1.141 3.516-7.109c0.203-0.422 0.484-0.641 0.766-0.641v0c0.281 0 0.547 0.219 0.766 0.641l3.516 7.109 7.844 1.141c0.938 0.141 1.156 0.797 0.469 1.469z"></path>
		</symbol>
	</defs>
</svg>

<svg style="display:none">
	<defs>
		<symbol id="icon-instagram" viewBox="0 0 448 512">
			<path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
		</symbol>
	</defs>
</svg>

<svg style="display:none">
	<defs>
		<symbol id="icon-share" xmlns="http://www.w3.org/2000/svg" width="14" height="16" fill="none" viewBox="0 0 14 16">
			<path fill="#000" d="M11 10c.8333 0 1.5417.2917 2.125.875.5833.5833.875 1.2917.875 2.125 0 .8333-.2917 1.5417-.875 2.125-.5833.5833-1.2917.875-2.125.875-.8333 0-1.54167-.2917-2.125-.875C8.29167 14.5417 8 13.8333 8 13c0-.3125.04167-.6146.125-.9062l-3.0625-1.9063C4.47917 10.7292 3.79167 11 3 11c-.83333 0-1.54167-.2917-2.125-.875C.291667 9.54167 0 8.83333 0 8c0-.83333.291667-1.54167.875-2.125C1.45833 5.29167 2.16667 5 3 5c.79167 0 1.47917.27083 2.0625.8125L8.125 3.90625C8.04167 3.61458 8 3.3125 8 3c0-.83333.29167-1.54167.875-2.125C9.45833.291667 10.1667 0 11 0c.8333 0 1.5417.291667 2.125.875C13.7083 1.45833 14 2.16667 14 3c0 .83333-.2917 1.54167-.875 2.125C12.5417 5.70833 11.8333 6 11 6c-.7917 0-1.47917-.27083-2.0625-.8125L5.875 7.09375c.1875.60417.1875 1.20833 0 1.8125l3.0625 1.90625C9.52083 10.2708 10.2083 10 11 10zm1.0625-8.0625C11.7708 1.64583 11.4167 1.5 11 1.5c-.4167 0-.7708.14583-1.0625.4375C9.64583 2.22917 9.5 2.58333 9.5 3s.14583.77083.4375 1.0625c.2917.29167.6458.4375 1.0625.4375.4167 0 .7708-.14583 1.0625-.4375.2917-.29167.4375-.64583.4375-1.0625s-.1458-.77083-.4375-1.0625zm-10.125 7.125C2.22917 9.35417 2.58333 9.5 3 9.5s.77083-.14583 1.0625-.4375S4.5 8.41667 4.5 8s-.14583-.77083-.4375-1.0625S3.41667 6.5 3 6.5s-.77083.14583-1.0625.4375S1.5 7.58333 1.5 8s.14583.77083.4375 1.0625zm8 5c.2917.2917.6458.4375 1.0625.4375.4167 0 .7708-.1458 1.0625-.4375.2917-.2917.4375-.6458.4375-1.0625 0-.4167-.1458-.7708-.4375-1.0625-.2917-.2917-.6458-.4375-1.0625-.4375-.4167 0-.7708.1458-1.0625.4375C9.64583 12.2292 9.5 12.5833 9.5 13c0 .4167.14583.7708.4375 1.0625z"></path>
		</symbol>
	</defs>
</svg>

<svg style="display:none">
	<defs>
		<symbol id="icon-compare" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
			<path fill="currentColor" d="M164 384h-44V48a16 16 0 0 0-16-16H88a16 16 0 0 0-16 16v336H28a12 12 0 0 0-8.73 20.24l68 72a12 12 0 0 0 17.44 0l68-72A12 12 0 0 0 164 384zm200.72-276.24l-68-72a12 12 0 0 0-17.44 0l-68 72A12 12 0 0 0 220 128h44v336a16 16 0 0 0 16 16h16a16 16 0 0 0 16-16V128h44a12 12 0 0 0 8.72-20.24z" class=""></path>
		</symbol>
	</defs>
</svg>
<svg style="display:none">
	<defs>
		<symbol xmlns="http://www.w3.org/2000/svg" id="icon-calendar" viewBox="0 0 25.881 25.88">
  <path id="Exclusão_32" data-name="Exclusão 32" d="M6150.835-12351.079h-17.79a4.047,4.047,0,0,1-4.043-4.042v-15.771a4.048,4.048,0,0,1,4.044-4.043h1.264v-1.012a1.014,1.014,0,0,1,1.011-1.012,1.014,1.014,0,0,1,1.012,1.011v1.013h4.547v-1.012a1.013,1.013,0,0,1,1.011-1.012,1.014,1.014,0,0,1,1.012,1.011v1.013h4.6v-1.012a1.012,1.012,0,0,1,1.011-1.011,1.013,1.013,0,0,1,1.012,1.011v1.012h1.315a4.048,4.048,0,0,1,4.044,4.042v15.773A4.05,4.05,0,0,1,6150.835-12351.079Zm-2.107-7.4a.974.974,0,0,0-.973.975.973.973,0,0,0,.973.969.971.971,0,0,0,.969-.97.972.972,0,0,0-.275-.707.969.969,0,0,0-.7-.293Zm-4.379,0a.973.973,0,0,0-.97.974.968.968,0,0,0,.283.687.97.97,0,0,0,.687.285.973.973,0,0,0,.973-.973.971.971,0,0,0-.276-.707.972.972,0,0,0-.7-.293Zm-4.76,0a.974.974,0,0,0-.973.975.973.973,0,0,0,.973.97.973.973,0,0,0,.97-.972.973.973,0,0,0-.274-.705.967.967,0,0,0-.7-.294Zm-4.38,0a.975.975,0,0,0-.973.975.973.973,0,0,0,.973.97.973.973,0,0,0,.974-.971.971.971,0,0,0-.275-.705.967.967,0,0,0-.7-.295Zm13.52-4.374a.972.972,0,0,0-.974.968.974.974,0,0,0,.973.974.972.972,0,0,0,.97-.973.962.962,0,0,0-.263-.727.971.971,0,0,0-.711-.3Zm-4.379,0a.97.97,0,0,0-.97.967.972.972,0,0,0,.97.976.976.976,0,0,0,.972-.975.969.969,0,0,0-.265-.726.971.971,0,0,0-.711-.3Zm-4.76,0a.972.972,0,0,0-.973.968.975.975,0,0,0,.973.974.973.973,0,0,0,.97-.974.969.969,0,0,0-.263-.725.969.969,0,0,0-.708-.306Zm-4.38,0a.972.972,0,0,0-.973.968.975.975,0,0,0,.973.974.971.971,0,0,0,.973-.973.969.969,0,0,0-.263-.726.97.97,0,0,0-.708-.306Zm13.519-4.381a.974.974,0,0,0-.973.973.974.974,0,0,0,.973.975.973.973,0,0,0,.969-.975.971.971,0,0,0-.28-.7.977.977,0,0,0-.695-.289Zm-4.379,0a.972.972,0,0,0-.969.973.971.971,0,0,0,.969.974.972.972,0,0,0,.973-.974.971.971,0,0,0-.281-.7.976.976,0,0,0-.7-.288Zm-4.76,0a.974.974,0,0,0-.973.973.975.975,0,0,0,.973.975.974.974,0,0,0,.971-.975.972.972,0,0,0-.279-.7.972.972,0,0,0-.693-.29Zm-4.379,0a.973.973,0,0,0-.973.973.974.974,0,0,0,.973.975.974.974,0,0,0,.973-.975.971.971,0,0,0-.28-.7.974.974,0,0,0-.693-.29Z" transform="translate(-6129.002 12376.958)" fill="currentColor"/>
</symbol>

	</defs>
</svg>
<svg style="display:none">
	<defs>
<symbol xmlns="http://www.w3.org/2000/svg" id="icon-clock" viewBox="0 0 28.145 28.163">
  <path id="União_49" data-name="União 49" d="M.4,10.781C1.864,4.681,6.792.6,13.385.021a13.276,13.276,0,0,1,3.692.308,15.16,15.16,0,0,1-.346,1.885,6.058,6.058,0,0,1-.682-.091,11.8,11.8,0,0,0-8.537,1.8,12.137,12.137,0,0,0,2.17,21.469,12.674,12.674,0,0,0,8.151.22,12.314,12.314,0,0,0,7.538-7.061c.1-.247.2-.4.24-.393s.453.165.909.347l.834.33-.11.287c-.063.158-.17.421-.236.595a14.559,14.559,0,0,1-4.145,5.371c-.165.132-.311.252-.327.271A15.556,15.556,0,0,1,18.8,27.353a14.471,14.471,0,0,1-4.74.81A14.076,14.076,0,0,1,.4,10.781ZM7.339,21.3a10.008,10.008,0,0,1,5.523-17c7.88-1.28,13.973,7.071,10.462,14.338a9.93,9.93,0,0,1-9.006,5.538A9.771,9.771,0,0,1,7.339,21.3ZM14.046,8.479c-.507.236-.5.158-.5,3.431v2.909l.685.748c1.019,1.114,3.893,3.928,4.066,3.979a.841.841,0,0,0,.992-1c-.04-.1-.973-1.093-2.079-2.2l-2-2.015-.024-2.677c-.02-2.9-.02-2.881-.4-3.126a.711.711,0,0,0-.4-.135.8.8,0,0,0-.34.086Zm12.037,7.6a2.655,2.655,0,0,1,.039-.543c.036-.287.063-.964.063-1.5,0-.747.02-.989.075-.992s.417-.039.838-.078.823-.084.89-.087c.24-.017.2,3.349-.039,3.5h-.018a18.522,18.522,0,0,1-1.848-.3Zm-.575-6.049c0-.013-.066-.165-.133-.346a13.968,13.968,0,0,0-.929-1.9c-.186-.311-.256-.481-.217-.521s.39-.278.787-.55.736-.494.74-.5a16.158,16.158,0,0,1,1.479,2.831l.123.333-.158.064c-.338.131-1.646.582-1.691.582ZM21.856,4.787a14.121,14.121,0,0,0-1.72-1.2l-.547-.323.351-.656c.189-.362.39-.744.444-.851.123-.235.079-.245.646.082,1.385.8,2.437,1.626,2.287,1.811-.248.315-1.161,1.331-1.193,1.331a1.381,1.381,0,0,1-.268-.194Z" transform="translate(-0.006 0)" fill="currentColor"/>
</symbol>
	</defs>
</svg>		 
	
			<!-- Add to cart -->
		<div id="popupCartModal" class="modal fade" role="dialog">
		</div>

		
		


		<link rel="stylesheet" href="/skin_shop/skin_7_nhat/tpl/css/addthis-sharing.css" media="print" onload="this.media='all'">

<noscript><link href="/skin_shop/skin_7_nhat/tpl/css/addthis-sharing.css" rel="stylesheet" type="text/css" media="all" /></noscript>	
<div class="addThis_listSharing ">
	
<a href="#" id="back-to-top" class="backtop back-to-top d-flex align-items-center justify-content-center"  title="Lên đầu trang">
	

<svg class="icon" style="transform: rotate(-90deg)"
>
	<use xlink:href="#icon-arrow" />
</svg>
</a>


	<ul class="addThis_listing list-unstyled  d-none d-sm-block">
		
		<li class="addThis_item">
			<a class="addThis_item--icon" href="tel:19006750" rel="nofollow" >
				<img class="img-fluid" src="/uploads/minh-hoa/addthis-phone.svg" alt="Gọi ngay cho chúng tôi" loading="lazy" width="44" height="44" />
				<span class="tooltip-text">Gọi ngay cho chúng tôi</span>
			</a>
		</li>
		<li class="addThis_item">
			<a class="addThis_item--icon" href="https://zalo.me/834141234794359440" target="_blank"  rel="nofollow">
				<img class="img-fluid" src="/uploads/minh-hoa/addthis-zalo.svg" alt="Gọi ngay cho chúng tôi" loading="lazy" width="44" height="44" />
				<span class="tooltip-text">Chat với chúng tôi qua Zalo</span>
			</a>
		</li>
		
			<li class="addThis_item">
				<a class="addThis_item--icon" href=" https://m.me/" target="_blank"  rel="nofollow">
					<img class="img-fluid" src="/uploads/minh-hoa/addthis-messenger.svg" alt="Chat với chúng tôi qua Messenger" loading="lazy" width="44" height="44" />
					<span class="tooltip-text">Chat với chúng tôi qua Messenger</span>
				</a>
			</li>

	</ul>
</div>
<!-- Messenger Plugin chat Code -->

<div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>

	$(document).ready(() => {
		const page_id = " 388836827817823"
		if(page_id && window.outerWidth  > 600){
		$(window).one(' mousemove touchstart scroll', () => {
			var chatbox = document.getElementById('fb-customer-chat');
			if(chatbox){
			chatbox.setAttribute("page_id", page_id);
								 chatbox.setAttribute("attribution", "biz_inbox");
			}
			window.fbAsyncInit = function() {
				FB.init({
					xfbml            : true,
					version          : 'v12.0'
				});
			};

			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		})
		}
	})

</script>

		
				<script type="text/x-custom-template" data-template="ItemDropCart">
	<li class="item productid-${id_item}">
		<div class="border_list"><div class="image_drop">
			<a class="product-image pos-relative embed-responsive embed-responsive-1by1" href="${url}" title="${title}">
				<img loading="lazy" alt="${title}" src="${image_url}"width="'+ '100' +'"\>
			</a>
			</div>
			<div class="detail-item">
				<div class="product-details">
					<span href="javascript:;" data-id="${id_item}" title="Xóa" class="remove-item-cart fa fa-times"></span>
					<p class="product-name"> <a class="link" href="${url}" title="${title}">${title}</a></p></div>
					<span class="variant-title">${variant_title}</span>
				<div class="product-details-bottom"><span class="price">${price}</span>
					<span class="quanlity">x ${quanty}</span>
					<div class="quantity-select qty_drop_cart d-none">
						<input class="variantID" type="hidden" name="variantId" value="${id_item}">
						<button onClick="var result = document.getElementById('qty${id_item}'); var qty${id_item} = result.value; if( !isNaN( qty${id_item} ) &amp;&amp; qty${id_item} &gt; 1 ) result.value--;return false;" class="btn btn_reduced reduced items-count btn-minus" ${buttonQty} type="button">–</button>
						<input type="text" maxlength="3" min="1" readonly class="form-control input-text number-sidebar qty${id_item}" id="qty${id_item}" name="Lines" id="updates_${id_item}" size="4" value="${quanty}">
						<button onClick="var result = document.getElementById('qty${id_item}'); var qty${id_item} = result.value; if( !isNaN( qty${id_item} )) result.value++;return false;" class=" btn btn_increase increase items-count btn-plus" type="button">+</button>
					</div>
				</div>
			</div>
		</div>
	  </li>
	</script>

	<script type="text/x-custom-template" data-template="HeaderCartPc">
	  <div class="cart page_cart hidden-xs hidden-sm row">
		<form action="/cart" method="post" novalidate class="formcartpage col-lg-12 col-md-12 margin-bottom-0">
			<div class="bg-scroll">
				<div class="cart-thead">
					<div style="width: 18%" class="a-center">Ảnh sản phẩm</div>
					<div style="width: 32%" class="a-center">Tên sản phẩm</div>
					<div style="width: 17%" class="a-center">Đơn giá</div>
					<div style="width: 14%" class="a-center">Số lượng</div>
					<div style="width: 14%" class="a-center">Thầnh tiền</div>
					<div style="width: 5%" class="a-center">Xóa</div>
				</div>
				<div class="cart-tbody">
				</div>
			</div>
		</form>
	  </div>
	</script>
	<script type="text/x-custom-template" data-template="pageCartCheckout">
	  <div class="col-lg-7 col-md-7">
		<a href="/" class="form-cart-continue">Tiếp tục mua hàng</a>
	  </div>
	  <div class="col-lg-5 col-md-5">
		<div class="section bg_cart shopping-cart-table-total">
			<div class="table-total">
				<table class="table">
					<tr>
						<td coldspan="20" class="total-text">Tổng tiền thanh toán: </td>
						<td class="txt-right totals_price price_end a-right">${price_total}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="section continued">
			<a href="/checkout" class="btn-checkout-cart button_checkfor_buy">Tiến hành thanh toán</a>
		</div>
	  </div>
	</script>
	
	<script type="text/x-custom-template" data-template="pageCartItem">
	  <div class="item-cart productid-${id_item}">
		<div style="width: 18%" class="image">
			<a class="product-image a-left" title="${title}" href="${url}">
				<img loading="lazy" width="75" height="auto" alt="${title}" src="${image_url}">
			</a>
		</div>
		<div style="width: 32%" class="a-center">
			<h3 class="product-name"> <a class="text2line link" href="${url}" title="${title}">
			${title}</a> </h3>
			<span class="variant-title">${variant_title}</span>
			<a class="remove-itemx remove-item-cart" title="Xóa" href="javascript:;" data-id="${id_item}">
				<span><i class="fa fa-times"></i></span>
			</a>
		</div>
		<div style="width: 17%" class="a-center">
			<span class="cart-prices">
				<span class="prices">${price}</span> 
			</span>
		</div>
		<div style="width: 14%" class="a-center">
			<div class="input_qty_pr">
				<input class="variantID" type="hidden" name="variantId" value="${id_item}">
				<button onClick="var result = document.getElementById('qtyItem${id_item}'); var qtyItem${id_item} = result.value; if( !isNaN( qtyItem${id_item} ) &amp;&amp; qtyItem${id_item} &gt; 1 ) result.value--;return false;" ${buttonQty} class="reduced_pop items-count btn-minus" type="button">-</button>
				<input type="text" maxlength="3" readonly min="0" class="check_number_here input-text number-sidebar input_pop input_pop qtyItem${id_item}" id="qtyItem${id_item}" name="Lines" id="updates_${id_item}" size="4" value="${quanty}">
				<button onClick="var result = document.getElementById('qtyItem${id_item}'); var qtyItem${id_item} = result.value; if( !isNaN( qtyItem${id_item} )) result.value++;return false;" class="increase_pop items-count btn-plus" type="button">+</button>
			</div>
		</div>
		<div style="width: 14%" class="a-center">
			<span class="cart-price">
				<span class="price">${price_quanty}</span> 
			</span>
		</div>
		<div style="width: 5%" class="a-center">
			<a class="remove-itemx remove-item-cart" title="Xóa" href="javascript:;" data-id="${id_item}">
				<span><i class="fa fa-trash-alt"></i></span>
			</a>
		</div>
	  </div>
	</script>
	
	<script type="text/x-custom-template" data-template="ItemCartMobile">
	  <div class="item-product item productid-${id_item} ">
		<div class="text-center">
			<a class="remove-itemx remove-item-cart " title="Xóa" href="javascript:;" data-id="${id_item}">
				<svg  class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0)">
<path d="M0.620965 12C0.462896 12 0.304826 11.9399 0.184729 11.8189C-0.0563681 11.5778 -0.0563681 11.1869 0.184729 10.9458L10.9497 0.180823C11.1908 -0.0602744 11.5817 -0.0602744 11.8228 0.180823C12.0639 0.421921 12.0639 0.8128 11.8228 1.05405L1.05795 11.8189C0.936954 11.9392 0.778884 12 0.620965 12Z" fill="#8C9196"/>
<path d="M11.3867 12C11.2287 12 11.0707 11.9399 10.9505 11.8189L0.184729 1.05405C-0.0563681 0.8128 -0.0563681 0.421921 0.184729 0.180823C0.425827 -0.0602744 0.816706 -0.0602744 1.05795 0.180823L11.8228 10.9458C12.0639 11.1869 12.0639 11.5778 11.8228 11.8189C11.7018 11.9392 11.5439 12 11.3867 12Z" fill="#8C9196"/>
</g>
<defs>
<clipPath id="clip0">
<rect width="12" height="12" fill="white"/>
</clipPath>
</defs>
</svg>
			</a>
		</div>
		<div class="item-product-cart-mobile">
			<a href="${url}">	
				<a class="product-images1  pos-relative embed-responsive embed-responsive-1by1" href=""  title="${title}">
					<img loading="lazy" class="img-fluid" src="${image_url}" alt="${title}">
				</a>
			</a>
		</div>
		<div class="product-cart-infor">
		<div class="title-product-cart-mobile">
			<h3 class="product-name"> <a class="text2line link" href="${url}" title="${title}">
			${title}</a>  </h3>
			<span class="variant-title">${variant_title}</span>
		</div>
		
		<div class="cart-price">
			<span class="product-price price">${price_quanty}</span>
		</div>
		<div class="select-item-qty-mobile">
			<div class="txt_center">
				<input class="variantID" type="hidden" name="variantId" value="${id_item}">
				<button onClick="var result = document.getElementById('qtyMobile${id_item}'); var qtyMobile${id_item} = result.value; if( !isNaN( qtyMobile${id_item} ) &amp;&amp; qtyMobile${id_item} &gt; 1 ) result.value--;return false;" class="reduced items-count btn-minus btn" type="button"><svg class="icon">
	<use xlink:href="#icon-minus" />
</svg></button>
				<input type="text" maxlength="3" min="1" class="form-control input-text number-sidebar qtyMobile${id_item}" id="qtyMobile${id_item}" name="Lines" id="updates_${id_item}" size="4" value="${quanty}">
				<button onClick="var result = document.getElementById('qtyMobile${id_item}'); var qtyMobile${id_item} = result.value; if( !isNaN( qtyMobile${id_item} )) result.value++;return false;" class="increase items-count btn-plus btn" type="button"><svg class="icon">
	<use xlink:href="#icon-plus" />
</svg></button>
			</div>
		</div>
		</div>
	  </div>
	</script>
		<script type="text/x-custom-template" data-template="pageCartCheckoutMobile">
								<div class='cart-upsell'>
	<div class='cart-upsell__progress-wrapper'>
		<div class='cart-upsell__progress'>
			<div class='cart-upsell__progress-bar' 
				 style='background-color: #dae1e8'>
				<div class='cart-upsell__percent'
					 style='width: 95%; background-color: #5bb72e;'>
				</div>
			</div>
			<span style='color: #2EB346;'></span>
		</div>
	</div>

	<div class='cart-upsell__promotion-wrapper'>
		<div class='cart-upsell__promotion'
			 style='border-width: 1px;
					border-style: solid;
					border-color: #f88b38;
					color: #dc7322;
					background: #feeee2;'>
						<img src='//bizweb.dktcdn.net/100/491/756/themes/956460/assets/cart_upsell_coupon.png?1727322848954' alt='cart-upsell'/>
						<strong>EGAFREESHIP</strong>
			<button style='background-color: #f88b38;
						   color: #ffffff;
						   border-radius: 99999px;
						   border-color: rgb(255, 140, 0);'>
				Sao chép
			</button>
		</div>
	</div>

	<div class='cart-upsell__content' 
		 style='--incomplete-color: #202223;
				--incomplete-price: #d22d00;
				--complete-color: #202223'>
	</div>
</div>					  <div class="header-cart-price">
	  	<div class="timedeli-modal">
		  <div class="timedeli-modal-content">
    		<button type="button" class="close window-close d-sm-none" aria-label="Close" style="z-index: 9;"><span aria-hidden="true">×</span></button>
	        <div class="timedeli d-sm-block"></div>
    		<div class="timedeli-cta">
	    		<button class="btn btn-block timedeli-btn  d-sm-none" type="button">
				  <span>Xong</span>
    		    </button>		
	    	</div>
		  </div>
		  <div class="timedeli-overaly"></div>
	    </div>
	  
<div class="r-bill">
	<div class="checkbox">
		<input type="hidden" name="attributes[invoice]" id="re-checkbox-bill"
			   value='không'>
		<input type="checkbox" id="checkbox-bill" value="có" 
			   class="regular-checkbox" />
		<label for="checkbox-bill" class="box"></label>
		<label for="checkbox-bill" class="title">Xuất hóa đơn công ty</label>
	</div>
	<div class="bill-field">
		<div class="form-group">
			<label>Tên công ty</label>
			<input type="text" class="form-control val-f" 
				   name="attributes[company_name]" 
				   value=""
				   placeholder="Tên công ty" >
		</div>	
		<div class="form-group">
			<label>Mã số thuế</label>
			<input type="number" pattern=".{10,}" onkeydown="return FilterInput(event)" 
				   onpaste="handlePaste(event)" 
				   class="form-control val-f val-n" 
				   name="attributes[tax_code]" 
				   value="" 
				   placeholder="Mã số thuế">
		</div>
		<div class="form-group">
			<label>Địa chỉ công ty</label>
			<textarea type="text" class="form-control val-f" 
					  name="attributes[company_address]"
					  placeholder="Nhập địa chỉ công ty (bao gồm Phường/Xã, Quận/Huyện, Tỉnh/Thành phố nếu có)"></textarea>
		</div>
		<div class="form-group">
			<label>Email nhận hoá đơn</label>
			<input type="email" class="form-control val-f val-email" 
				   name="attributes[invoice_email]" 
				   value="" 
				   placeholder="Email nhận hoá đơn">
		</div>
	</div>
</div>


		<div class="title-cart d-none d-sm-flex ">
			<h3 class="text-xs-left">TỔNG CỘNG</h3>
			<span class="text-xs-right  totals_price_mobile">${price_total}</span>
			<i class="text-xs-right price_vat ">(Đã bao gồm VAT nếu có)</i>		</div>
		
  			<div class='cart-limit-alert d-xs-none'
	  	           >
					<i class="fa fa-info-circle mr-1" aria-hidden="true"></i> Đơn hàng của bạn chưa đạt giá trị tối thiểu 100.000đ 
Vui lòng chọn mua thêm sản phẩm
		    </div>
		
			

		<div class="checkout mt-2">
			<button class="btn btn-block btn-proceed-checkout-mobile" title="Tiến hành thanh toán"
			        type="button" onclick='goToCheckout(event)'>
				<span>Thanh Toán</span>
		    </button>		
		</div>
				
		<div class="cart-trustbadge mt-3">
			<div class="product-trustbadge d-flex flex-wrap align-items-center">
	<a href="/collections/all" 
	   target="_blank"
	   title="Phương thức thanh toán">
		<img class=" img-fluid" loading="lazy"
			 src="/uploads/minh-hoa/footer_trustbadge.png" 
			 alt="Phương thức thanh toán"
			 width="301"
			 height="36"
			 >
	</a>
</div>
		</div>
			  </div>
	
	</script>
	<script type="text/x-custom-template" data-template="templateStickyCheckout">
  <div class="cart-sticky-cta">
	  	

	  	
  			<div class='cart-limit-alert '
	  	           >
					<i class="fa fa-info-circle mr-1" aria-hidden="true"></i> Đơn hàng của bạn chưa đạt giá trị tối thiểu 100.000đ 
Vui lòng chọn mua thêm sản phẩm
		    </div>
		
		<div class="cart-cta">
	
				<div class="toggle-delivery col-5 d-flex justify-content-start align-items-center flex-column px-2">
			<img loading="lazy" src="//bizweb.dktcdn.net/100/491/756/themes/956460/assets/delivery-icon.png?1727322848954" alt="delivery" ->
			<span>HẸN GIỜ NHẬN HÀNG</span>
		</div>
				<div>
				<button class="btn btn-block btn-proceed-checkout-mobile" title="Tiến hành thanh toán"
			        type="button" onclick="goToCheckout(event)">
				<span>Thanh Toán</span> <span class="text-xs-right  totals_price_mobile">${price_total}</span>
		    </button>	
					<i class="text-xs-right price_vat ">(Đã bao gồm VAT nếu có)</i>			</div>
		</div>
		</div>
</script>
	<script type="text/x-custom-template" data-template="TemplateItemPopupCart">
	<div class="item-popup productid-${id_item}">
		<div style="width: 13%;" class="height image_ text-left">
			<div class="item-image">
				<a class="product-image" href="${url}" title="${title}">
					<img loading="lazy" alt="${title}" src="${image_url}"width="'+ '90' +'"\>
				</a>
			</div>
		</div>
		<div style="width:40%;" class="height text-left fix_info">
			<div class="item-info">
				<p class="item-name">
					<a class="text2line textlinefix link" href="${url}" title="${title}">${title}</a>
				</p>
				<span class="variant-title-popup">${variant_title}</span>
				<a href="javascript:;" class="remove-item-cart" title="Xóa" data-id="${id_item}">
					<i class="fa fa-times"></i>&nbsp;&nbsp;Bỏ sản phẩm
				</a>
				<p class="addpass" style="color:#fff;margin:0px;">${id_item}</p>
			</div>
		</div>
		<div style="width: 15%;" class="height text-center">
			<div class="item-price">
				<span class="price">${price}</span>
			</div>
		</div>
		<div style="width: 15%;" class="height text-center">
			<div class="qty_h check_">
				<input class="variantID" type="hidden" name="variantId" value="${id_item}">
				<button onClick="var result = document.getElementById('qtyItemP${id_item}'); var qtyItemP${id_item} = result.value; if( !isNaN( qtyItemP${id_item} ) &amp;&amp; qtyItemP${id_item} &gt; 1 ) result.value--;return false;" ${buttonQty} class="num1 reduced items-count btn-minus" type="button">-</button>
				<input type="text" maxlength="3" min="0" readonly class="input-text number-sidebar qtyItemP${id_item}" id="qtyItemP${id_item}" name="Lines" id="updates_${id_item}" size="4" value="${quanty}">
				<button onClick="var result = document.getElementById('qtyItemP${id_item}'); var qtyItemP${id_item} = result.value; if( !isNaN( qtyItemP${id_item} )) result.value++;return false;" class="num2 increase items-count btn-plus" type="button">+</button>
			</div>
		</div>
		<div style="width: 17%;" class="height text-center">
			<span class="cart-price">
				<span class="price">${price_quanty}</span>
			</span>
		</div>
	</div>
	</script>
				
		

<div id="quick-view-product" class="quickview-product" style="display:none;">
	<div class="quickview-overlay fancybox-overlay fancybox-overlay-fixed"></div>
	<div class="quick-view-product align-verticle"></div>
	<div id="quickview-modal" style="display:none;">
		<div class="block-quickview primary_block details-product">
			<div class="row">
				<div class="product-left-column product-images col-xs-12 col-sm-4 col-md-4 col-lg-5 col-xl-6">
					<div class="image-block large-image col_large_default">
						<span class="view_full_size">
							<a class="img-product d-block  pos-relative embed-responsive embed-responsive-1by1" title="" href="javascript:;">
								<img loading="lazy" src="https://mixcdn.egany.com/themes/assets/thumb/large/noimage.gif" id="product-featured-image-quickview" class="img-responsive product-featured-image-quickview" alt="quickview"  />
							</a>
						</span>
						<div class="loading-imgquickview" style="display:none;"></div>
					</div>
					<div class="more-view-wrapper clearfix">
						<div class="thumbs_quickview owl_nav_custome1" id="thumbs_list_quickview">
							<ul class="product-photo-thumbs quickview-more-views-owlslider not-thuongdq" id="thumblist_quickview"></ul>
						</div>
					</div>
				</div>
				<div class="product-center-column product-info product-item col-xs-12 col-sm-6 col-md-8 col-lg-7 col-xl-6 details-pro style_product style_border">
					<div class="head-qv group-status">
						<h3 class="qwp-name title-product">abc</h3>
						<div class="vend-qv group-status">
							<div class="left_vend">
								<div class="first_status top_vendor d-inline-block">Thương hiệu:
									<span class="vendor_ status_name"></span>
								</div>		
								<span class="line_tt">|</span>
								<div class="top_sku first_status d-inline-block">Mã sản phẩm:
									<span class="sku_ status_name"></span>
								</div>
							</div>
						</div>
					</div>
						<input type='hidden' id='qv-product-tags'/>
					
					<div class="reviews_qv mt-2">
						<div class="sapo-product-reviews-badge" data-id=""></div>
					</div>
					
					<div class="quickview-info clearfix">
						<span class="prices price-box">
							<span class="price product-price"></span>
							<del class="old-price"></del>
							<span class="label_product"></span>
						</span>
					</div>
					
					<div class="product-description product-summary">
						<div class="rte">

						</div>
					</div>
					

					<form action="/cart/add" method="post" enctype="multipart/form-data" class="quick_option variants form-ajaxtocart form-product">
						<span class="price-product-detail hidden" style="opacity: 0;">
							<span class=""></span>
						</span>
						<select name='variantId' class="hidden" style="display:none"></select>
						
												<div class='product-promotion rounded-sm mb-3' id='qv-ega-salebox'></div>
												
						<div class="form-group form_product_content">
							<div class="count_btn_style quantity_wanted_p">
								<div class="custom input_number_product soluong1">									
									<button class="btn_num btn num_1 button button_qty" onClick="var result = document.getElementById('quantity-detail'); var qtyqv = result.value; if( !isNaN( qtyqv ) &amp;&amp; qtyqv &gt; 1 ) result.value--;return false;">
										<svg class="icon">
	<use xlink:href="#icon-minus" />
</svg></button>
									<input type="text" id="quantity-detail" name="quantity" value="1" maxlength="2" class="form-control prd_quantity" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" onchange="if(this.value == 0)this.value=1;">
									<button class="btn_num  btn num_2 button button_qty" onClick="var result = document.getElementById('quantity-detail'); var qtyqv = result.value; if( !isNaN( qtyqv )) result.value++;return false;">
										<svg class="icon">
	<use xlink:href="#icon-plus" />
</svg>									</button>
								</div>
								<div class="button_actions clearfix mb-0">
									<button type="submit" class="btn_cool btn fix_add_to_cart ajax_addtocart btn_add_cart btn-cart add_to_cart_detail">
										THÊM VÀO GIỎ
									</button>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>      
		<a title="Close" class="quickview-close close-window" href="javascript:;"><i class="fas fa-times"></i></a>
	</div>    
</div>
<script type="text/javascript">
	Bizweb.doNotTriggerClickOnThumb = false;
	function changeImageQuickView(img, selector) {
		var src = $(img).attr("src");
		src = src.replace("_compact", "");
		
		var $videoEl = $(selector).parent();
		
		if($(img).hasClass('video')) {
			$(selector).parent().find('img').hide()
			var codevideo = $(img).parent().data().videocode.split("_")[1];
			var videoHtml = `<iframe class="img-responsive" width="560" height="315" src="https://www.youtube.com/embed/${codevideo}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
			$videoEl.append(videoHtml);
		} else {
			$videoEl.find("iframe").remove();
			$(selector).parent().find('img').show()
			$(selector).attr("src", src);
		}
	}
	function validate(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode( key );
		var regex = /[0-9]|\./;
		if( !regex.test(key) ) {
			theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}
	var selectCallbackQuickView = function(variant, selector) {
		$('#quick-view-product form').show();
		var productItem = jQuery('.quick-view-product .product-item'),
			addToCart = productItem.find('.add_to_cart_detail'),
			productPrice = productItem.find('.price'),
			comparePrice = productItem.find('.old-price'),
			discountLabel= productItem.find('.label_product'),
			form2 = jQuery('.soluong1'),
			status = productItem.find('.soluong'),
			sku = productItem.find('.sku_'),
			totalPrice = productItem.find('.total-price span');		
		if(variant && variant.sku ) {
			sku.text(variant.sku);
		} else {
			sku.text('Đang cập nhật');
		}
		if (variant && variant.available) {
			var form = jQuery('#' + selector.domIdPrefix).closest('form');
			for (var i=0,length=variant.options.length; i<length; i++) {
				var radioButton = form.find('.swatch[data-option-index="' + i + '"] :radio[value="' + variant.options[i] +'"]');
				if (radioButton.size()) {
					radioButton.get(0).checked = true;
				}
			}

			addToCart.removeClass('disabled').removeAttr('disabled');
			addToCart.html(`THÊM VÀO GIỎ`).removeAttr('disabled');
			status.text('Còn hàng');
			if(variant.price < 1){			   
				$("#quick-view-product .price").html('Liên hệ');
				$("#quick-view-product del, #quick-view-product .quantity_wanted_p").hide();
				$("#quick-view-product .prices .old-price").hide();
								discountLabel.hide()
				form2.hide();
			} else {
				productPrice.html(Bizweb.formatMoney(variant.price, "{{amount_no_decimals_with_comma_separator}}₫"));
				if ( variant.compare_at_price > variant.price ) {
				  comparePrice.html(Bizweb.formatMoney(variant.compare_at_price, "{{amount_no_decimals_with_comma_separator}}₫")).show();         
				  let save = variant.compare_at_price - variant.price;
				  let savePerCent = Math.ceil(save / variant.compare_at_price * 100);
				  if(savePerCent > 99){
				  	savePerCent = 99
				  }
				  if(savePerCent < 1){
				  	savePerCent = 1
				  }
				  discountLabel.html('-'+savePerCent+ "%").show()
				  productPrice.addClass('on-sale');
			   } else {
				  comparePrice.hide();
				  discountLabel.hide()
				  productPrice.removeClass('on-sale');
			   }
			$(".quantity_wanted_p").show();
			$(".input_qty_qv_").show();
			form2.show();
		}


		
		updatePricingQuickView();
		
							/*begin variant image*/
							if (variant && variant.featured_image) {

			var originalImage = $("#product-featured-image-quickview");
			var newImage = variant.featured_image;
			var element = originalImage[0];
			Bizweb.Image.switchImage(newImage, element, function (newImageSizedSrc, newImage, element) {
				$('#thumblist_quickview img').each(function() {
					var parentThumbImg = $(this).parent();
					var productImage = $(this).parent().data("image");
					if (newImageSizedSrc.includes(productImage)) {
						$(this).parent().trigger('click');
						return false;
					}
				});

			});
			$('#product-featured-image-quickview').attr('src',variant.featured_image.src);
		}
	} else {
		addToCart.addClass('disabled').attr('disabled', 'disabled');
		addToCart.removeClass('hidden').addClass('btn_buy is-full').attr('disabled','disabled').html('<div class="disabled">Hết hàng</div>').show();
		status.text('Hết hàng');
		$(".quantity_wanted_p").show();
		if(variant){
			if(variant.price < 1){	
				$("#quick-view-product .price").html('Liên hệ');
				$("#quick-view-product del").hide();
				//$("#quick-view-product .quantity_wanted_p").hide();
				$("#quick-view-product .prices .old-price").hide();
								discountLabel.hide()

				form2.hide();
				comparePrice.hide();
				discountLabel.hide();
				productPrice.removeClass('on-sale');
				addToCart.addClass('disabled').attr('disabled', 'disabled');
				addToCart.removeClass('hidden').addClass('btn_buy is-full').attr('disabled','disabled').html('<div class="disabled">Hết hàng</div>').show();
			} else {
				productPrice.html(Bizweb.formatMoney(variant.price, "{{amount_no_decimals_with_comma_separator}}₫"));
				if (variant.compare_at_price > variant.price) {
					comparePrice.html(Bizweb.formatMoney(variant.compare_at_price, "{{amount_no_decimals_with_comma_separator}}₫")).show();         
					productPrice.addClass('on-sale');
					let save = variant.compare_at_price - variant.price;
                    let savePerCent = Math.ceil(save / variant.compare_at_price * 100);
					if(savePerCent > 99){
						savePerCent = 99
					}
					if(savePerCent < 1){
						savePerCent = 1
					}
					discountLabel.html('-'+savePerCent+ "%").show()
				} else {
					comparePrice.hide();
					productPrice.removeClass('on-sale');
					$("#quick-view-product .prices .old-price").html('');
				    discountLabel.hide()
				}
				
				$(".input_qty_qv_").hide();
				form2.hide();
				addToCart.addClass('disabled').attr('disabled', 'disabled');
				addToCart.removeClass('hidden').addClass('btn_buy is-full').attr('disabled','disabled').html('<div class="disabled">Hết hàng</div>').show();
			}
		}else{
			$("#quick-view-product .price").html('Liên hệ');
			$("#quick-view-product del").hide();
			$("#quick-view-product .quantity_wanted_p").hide();
			$("#quick-view-product .prices .old-price").hide();
							discountLabel.hide()

			form2.hide();
			comparePrice.hide();
			discountLabel.hide();

			productPrice.removeClass('on-sale');
			addToCart.addClass('disabled').attr('disabled', 'disabled');
			addToCart.removeClass('hidden').addClass('btn_buy is-full').attr('disabled','disabled').html('<div class="disabled">Hết hàng</div>').show();
		}
	}
	/*begin variant image*/
	if (variant && variant.featured_image) {

		var originalImage = $("#product-featured-image-quickview");
		var newImage = variant.featured_image;
		var element = originalImage[0];
		Bizweb.Image.switchImage(newImage, element, function (newImageSizedSrc, newImage, element) {
			$('#thumblist_quickview img').each(function() {
				var parentThumbImg = $(this).parent();
				var productImage = $(this).parent().data("image");
				if (newImageSizedSrc.includes(productImage)) {
					$(this).parent().trigger('click');
					return false;
				}
			});

		});
		$('#product-featured-image-quickview').attr('src',variant.featured_image.src);
	}
	
	
	setColorQuickview();
		
	};
	
    if(typeof copyButton === 'undefined' && typeof codeCopy === 'undefined') {
	  const copyButton = {"copiedText": "Đã chép", "copyText": "Sao chép"};
	  function codeCopy(el){
				const copyText = copyButton.copyText;
				const copiedText = el.dataset.copiedText;
				const coupon = el.dataset.code;

				const _this = $(el);
				_this.html(`<span>${copiedText}</span>`);
				_this.addClass('disabled');
				setTimeout(function() {
					_this.html(`<span>${copyText}</span>`);
					_this.removeClass('disabled');
				}, 3000)
				navigator.clipboard.writeText(coupon);
			}
	}
	
	function setColorQuickview() {
			 let colorHandle = $("#quick-view-product .swatch .color input:checked").parent().data().vhandle;

			 let newImagesArr = [];
			 if (productDetail && productDetail.images && productDetail.images.length > 1) {
				 productDetail.images.map(image => {
					 if (image.indexOf(colorHandle) > -1) {
						 newImagesArr.push(Bizweb.resizeImage(image, 'large'));
					 }
				 })
			 }

			 if (newImagesArr.length) {
				 let $quicviewSlider = $("#thumblist_quickview");
				 $quicviewSlider.slick('unslick');
				 if ($(".quickview_slider_clone").length == 0) {
					 $quicviewSlider.clone().removeClass().removeAttr('id').insertAfter('.quick-view-product .more-view-wrapper ul').addClass("quickview_slider_clone hidden");
				 }

				 let htmlSlider = "";
				 let boolMainImg = false;
				 $(".quickview_slider_clone").find("li").each(function(i, v) {
					 let thumbQuickviewSrc = $(v).find("img").attr("src");
					 if (newImagesArr.includes(thumbQuickviewSrc)) {
						 if (!boolMainImg) {
							 $('#product-featured-image-quickview').attr('src', thumbQuickviewSrc);
							 boolMainImg = true;
						 }
						 htmlSlider += $(v).wrap('<div/>').parent().html();
					 }
				 })

				 $quicviewSlider.html(htmlSlider);

				 $quicviewSlider.slick({
					 autoplay: true,
					 autoplaySpeed: 6000,
					 dots: false,
					 arrows: false,
					 infinite: true,
					 speed: 300,
					 slidesToShow: 4,
					 slidesToScroll: 4
				 }).css("visibility", "visible")
			 }
		 }
</script>		
			
		<link rel="preload" as="script" href="/skin_shop/skin_7_nhat/tpl/js/api.jquery.js">		
		
		<script src="/skin_shop/skin_7_nhat/tpl/js/api.jquery.js" type="text/javascript"></script>
		<script src="/skin_shop/skin_7_nhat/tpl/js/ega-gateway-min.js" type="text/javascript"></script>
		<script>
var GLOBAL = {
	common : {
		init: function(){
			$(document).on('click', '.add_to_cart',addToCart )
		    $(document).on('click', '.buynow',buynow )
		}
	},
	templateIndex : {
		init: function(){
		}
	},
	templateProduct : {
		init: function(){
		}
	},
	templateCart : {
		init: function(){
		}
	},
	money_format : "{{amount_no_decimals_with_comma_separator}}₫",
	urlMailChimp: "https://egany.us5.list-manage.com/subscribe/post?u=30fc9d9e428051fcf936d142c&id=8a0a96cc36",
	vendorUrl: "/skin_shop/skin_7_nhat/tpl/js/vendors.js",
	newsletterFormAction: "https://egany.us11.list-manage.com/subscribe/post?u=5a58afacba94c1c4a94c354c9&id=2a7da1a514&f_id=000694e0f0",
	bannerPopupShow: true}
var UTIL = {
	fire : function(func,funcname, args){
		var namespace = GLOBAL;
		funcname = (funcname === undefined) ? 'init' : funcname;
		if (func !== '' && namespace[func] && typeof namespace[func][funcname] == 'function'){
			namespace[func][funcname](args);
		}
	},
	loadEvents : function(){
		var bodyId = document.body.id;
		UTIL.fire('common');
		$.each(document.body.className.split(/\s+/),function(i,classnm){
			UTIL.fire(classnm);
			UTIL.fire(classnm,bodyId);
		});
	}
};
$(document).ready(UTIL.loadEvents);
Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
		c = isNaN(c = Math.abs(c)) ? 2 : c, 
		d = d == undefined ? "." : d, 
		t = t == undefined ? "." : t, 
		s = n < 0 ? "-" : "", 
		i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
		j = (j = i.length) > 3 ? j % 3 : 0;
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
function addToCart(e){
	if (typeof e !== 'undefined') e.preventDefault();
	var $this = $(this);
	var form = $this.parents('form');		
	$.ajax({
		type: 'POST',
		url: '/cart/add.js',
		async: false,
		data: form.serialize(),
		dataType: 'json',
		error: addToCartFail,
		beforeSend: function() {  
		},
		success: addToCartSuccess,
		cache: false
	});
}
function buynow(e){
	if (typeof e !== 'undefined') e.preventDefault();
	var $this = $(this);
	var form = $this.parents('form');		
	const callback = (cart) => {
		location.href = '/checkout';
	}
	
	$.ajax({
		type: 'POST',
		url: '/cart/add.js',
		async: false,
		data: form.serialize(),
		dataType: 'json',
		error: addToCartFail,
		beforeSend: function() {  
		},
		success: (jqXHR, textStatus, errorThrown) => {
			addToCartSuccess(jqXHR, textStatus, errorThrown,callback)
		},
		cache: false
	});
}
	function qty(){	
	var dqty = $('#qtym').val();	
		if (dqty == undefined){
		return 1;
	}
	return dqty;
	}
	
function checkCartLimit(e, totalPrice) {
		e.preventDefault();
		
		 if ((totalPrice) < Number('100000')) {
			 swal({
				 title: `Thông báo`,
				 text: `Đơn hàng của bạn chưa đạt giá trị tối thiểu 100.000đ 
Vui lòng chọn mua thêm sản phẩm`,
				 type: "warning",
				 className: 'cart-limit-modal',
				 button: 'Xác nhận'
			 })
			 return;
		 } else {
			 location.href = '/checkout';
		 }
		 
}
function addToCartSuccess (jqXHR, textStatus, errorThrown,callback){
	$.ajax({
		type: 'GET',
		url: ' ',
		async: false,
		cache: false,
		dataType: 'json',
		success: function (cart){
			
			awe.hidePopup('.loading');
			var url_product = jqXHR['url'];
			var class_id = jqXHR['product_id'];
			var name = jqXHR['name'];
			var textDisplay = ('<i style="margin-right:5px; color:red; font-size:13px;" class="fa fa-check" aria-hidden="true"></i>Sản phẩm vừa thêm vào giỏ hàng');
			var id = jqXHR['variant_id'];
			var dataList = $(".item-name a").map(function() {
				var plus = $(this).text();
				return plus;
			}).get();
			$('.title-popup-cart .cart-popup-name').html('<a href="'+ url_product +'" title="'+name+'">'+ name + '</a> ');
			var nameid = dataList,
				found = $.inArray(name, nameid);
			var textfind = found;

			var src = '';
			if(Bizweb.resizeImage(jqXHR['image'], 'small') == null || Bizweb.resizeImage(jqXHR['image'], 'small') =="null" || Bizweb.resizeImage(jqXHR['image'], 'small') ==''){
				src= 'https://mixcdn.egany.com/themes/assets/thumb/large/noimage.gif'
			}
			else
			{
				src=  Bizweb.resizeImage(jqXHR['image'], 'small')
			}
			$(".item-info > p:contains("+id+")").html('<span class="add_sus" style="color:#898989;"><i style="margin-right:5px; color:#3cb878; font-size:14px;" class="fa fa-check" aria-hidden="true"></i>Sản phẩm vừa thêm</span>');
			
			var va_title = jqXHR['variant_title'];

			if (va_title == 'Default Title') {
				va_title = "";
			}else {
				va_title = jqXHR['variant_title'];
			}
				var windowW = $(window).width();
                $('#popup-cart').addClass('opencart');
				$('body').addClass('opacitycart');
                $('#popup-cart').addClass('opencart');
				$('body').addClass('opacitycart');
				$('#popupCartModal').html('');
			const limit = Number('100000')
			const  cart_action = cart.total_price >= limit ? `
			<a href="/checkout" class="btn btn-main btn-full">Thanh toán</a>
				<a  href="/cart" class="btn checkout_button btn-full">Xem giỏ hàng</a>

			`: `
			<button type="button" class="btn btn-main" data-dismiss="modal" data-backdrop="false"
					aria-label="Close" >Mua thêm</button>
			<a  href="/cart" class="btn btn-main  checkout_button btn-full">Xem giỏ hàng</a>
			`
			let limit_message  = `Đơn hàng của bạn chưa đạt giá trị tối thiểu 100.000đ 
Vui lòng chọn mua thêm sản phẩm`
				limit_message = limit_message ? `<span class="mr-2"><i class="fa fa-info-circle" aria-hidden="true"></i></span> ${limit_message}`  : ''
				var $popupMobile = `<div class="modal-dialog align-vertical">
    <div class="modal-content "><button type="button" class="close" data-dismiss="modal" data-backdrop="false"
        aria-label="Close" style="z-index: 9;"><span aria-hidden="true">×</span></button>
      <div class="row row-noGutter">
        <div class="modal-left col-sm-12 col-lg-12 col-md-12">
          <h3 class="modal-title"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.00006 15.3803C12.0761 15.3803 15.3804 12.076 15.3804 7.99995C15.3804 3.92391 12.0761 0.619629 8.00006 0.619629C3.92403 0.619629 0.619751 3.92391 0.619751 7.99995C0.619751 12.076 3.92403 15.3803 8.00006 15.3803Z" fill="#2EB346"/>
            <path d="M8 16C3.58916 16 0 12.4115 0 8C0 3.58916 3.58916 0 8 0C12.4115 0 16 3.58916 16 8C16 12.4115 12.4115 16 8 16ZM8 1.23934C4.27203 1.23934 1.23934 4.27203 1.23934 8C1.23934 11.728 4.27203 14.7607 8 14.7607C11.728 14.7607 14.7607 11.7273 14.7607 8C14.7607 4.27203 11.728 1.23934 8 1.23934Z" fill="#2EB346"/>
            <path d="M7.03336 10.9434C6.8673 10.9434 6.70865 10.8771 6.59152 10.7582L4.30493 8.43438C4.06511 8.19023 4.06821 7.7986 4.31236 7.55816C4.55652 7.31898 4.94877 7.32145 5.18858 7.5656L7.0154 9.42213L10.7948 5.25979C11.0259 5.00635 11.4176 4.98838 11.6698 5.21766C11.9232 5.44757 11.9418 5.8392 11.7119 6.09326L7.49193 10.7408C7.3773 10.8672 7.21618 10.9403 7.04577 10.944C7.04143 10.9434 7.03771 10.9434 7.03336 10.9434Z" fill="white"/>
            </svg>
            <span>Thêm vào giỏ hàng thành công</span></h3>
          <div class="modal-body">
            <div class="media">
              <div class="media-left thumb_img">
                <div class="thumb-1x1"><img loading="lazy"
                    src="${src}"
                    alt="${jqXHR['title']}"></div>
              </div>
              <div class="media-body body_content">
                <div class="product-title">${jqXHR['title']}</div>
                <div class="variant_title font-weight-light"><span>${va_title}</span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-right margin-top-10 col-sm-12 col-lg-12 col-md-12">
          <div class="title right_title d-flex justify-content-between" ><a href="/cart"> Giỏ hàng hiện có </a>
        <div class="text-right">
            <span class="price">${Bizweb.formatMoney(cart.total_price, '{{amount_no_decimals_with_comma_separator}}₫')}</span>
            <div class="count font-weight-light">
				(<span
            class="cart-popup-count">4</span>) sản phẩm 
			</div>
        </div>
			
      
          </div>
			
			${cart.total_price < limit ? `  <div class="cart-message">${limit_message}</div>`:'' }
			  
			  <div class="cart-action">
				            ${cart_action}

			  </div>
        </div>
      </div>
    </div>
  </div>`;
				$('#popupCartModal').html($popupMobile);
			
			if(typeof callback == 'function' &&  cart.total_price >= limit){
			return	callback(cart)
			}
				$('#popupCartModal').modal(); 
			Bizweb.updateCartFromForm(cart, '.top-cart-content .mini-products-list');
			Bizweb.updateCartPopupForm(cart, '#popup-cart-desktop .tbody-popup');
				
			
		}
	});
}
function addToCartFail(jqXHR, textStatus, errorThrown){
	var response = $.parseJSON(jqXHR.responseText);
	var $info = '<div class="error">'+ response.description +'</div>';
}
function getDelivery(){
	if(!$('.ega-delivery').length && window.egaDeliveryValid){
	   	var head = document.getElementsByTagName('head').item(0);
        var script = document.createElement('script');
        script.setAttribute('src', '/skin_shop/skin_7_nhat/tpl/js/delivery-addon.js');
        head.appendChild(script);
	   }

}
$(document).on('click', ".remove-item-cart", function () {
	var variantId = $(this).attr('data-id');
	removeItemCart(variantId);
});
$(document).on('click', ".items-count", function () {
	$(this).parent().children('.items-count').prop('disabled', true);
	var thisBtn = $(this);
	var variantId = $(this).parent().find('.variantID').val();
	var qty =  $(this).parent().children('.number-sidebar').val();
	updateQuantity(qty, variantId);
});
$(document).on('change', ".number-sidebar", function () {
	var variantId = $(this).parent().children('.variantID').val();
	var qty =  $(this).val();
	updateQuantity(qty, variantId);
});
function updateQuantity (qty, variantId){
	var variantIdUpdate = variantId;
	$.ajax({
		type: "POST",
		// url: " ",,
		data: {"quantity": qty, "variantId": variantId},
		dataType: "json",
		success: function (cart, variantId) {
			Bizweb.onCartUpdateClick(cart, variantIdUpdate);
			cart_min();
		},
		error: function (qty, variantId) {
			Bizweb.onError(qty, variantId)
		}
	})
}
function removeItemCart (variantId){
	var variantIdRemove = variantId;
	$.ajax({
		type: "POST",
		// url: " ",,
		data: {"quantity": 0, "variantId": variantId},
		dataType: "json",
		success: function (cart, variantId) {
			Bizweb.onCartRemoveClick(cart, variantIdRemove);
			$('.productid-'+variantIdRemove).remove();
			if($('.tbody-popup>div').length == '0' ){
				$('#popup-cart').removeClass('opencart');
				$('body').removeClass('opacitycart');
			}
			if($('.list-item-cart>li').length == '0' ){
				$('.mini-products-list').html('<div class="no-item"><p>Không có sản phẩm nào.</p></div>');
			}
			if($('.cart-mobile .item-product').length == '0' ){
				$('.page_cart').empty();
				$('.header-cart-content').empty();
				$('.cart-mobile .header-cart').hide()
				$('.title_cart_pc').html('<p class="hidden-xs-down">Không có sản phẩm nào. Quay lại <a href="/" style="color:;">cửa hàng</a> để tiếp tục mua sắm.</p>');
				$('.cart-empty').show()
				$('.cart-sticky-cta').remove()
			}
			cart_min()
		},
		error: function (variantId, r) {
			Bizweb.onError(variantId, r)
		}
	})
}
function render(props) {
		return function(tok, i) {
			return (i % 2) ? props[tok] : tok;
		};
	}
	Bizweb.updateCartFromForm = function(cart, cart_summary_id, cart_count_id) {
		if ((typeof cart_summary_id) === 'string') {
			var cart_summary = jQuery(cart_summary_id);
			if (cart_summary.length) {
				// Start from scratch.
				cart_summary.empty();
				// Pull it all out.        
				jQuery.each(cart, function(key, value) {
					if (key === 'items') {
						var table = jQuery(cart_summary_id);           
						if (value.length) {   
							jQuery('<ul class="list-item-cart"></ul>').appendTo(table);
							jQuery.each(value, function(i, item) {	
								var buttonQty = "";
								if(item.quantity == '1'){
									buttonQty = 'disabled';
								}else{
									buttonQty = '';
								}
								var link_img0 = Bizweb.resizeImage(item.image, 'compact');
								if(link_img0=="null" || link_img0 =='' || link_img0 ==null){
									link_img0 = 'https://bizweb.dktcdn.net/thumb/large/assets/themes_support/noimage.gif';
								}
								if(item.variant_title == 'Default Title'){
								var ItemDropCart = [{
								  url: item.url,
								  image_url: link_img0,
								  price: Bizweb.formatMoney(item.price, '{{amount_no_decimals_with_comma_separator}}₫'),
								  title: item.title,
								  buttonQty: buttonQty,
								  quanty: item.quantity,
								  id_item: item.variant_id,
								  variant_title: ''
								}]
								}else {
								var ItemDropCart = [{
								  url: item.url,
								  image_url: link_img0,
								  price: Bizweb.formatMoney(item.price, '{{amount_no_decimals_with_comma_separator}}₫'),
								  title: item.title,
								  buttonQty: buttonQty,
								  quanty: item.quantity,
								  id_item: item.variant_id,
								  variant_title: item.variant_title,
								}];
															}
								$(function() {
									var TemplateItemDropCart = $('script[data-template="ItemDropCart"]').text().split(/\$\{(.+?)\}/g);
									$('.list-item-cart').append(ItemDropCart.map(function(item) {
										return TemplateItemDropCart.map(render(item)).join('');
									}));
								});
							}); 
							jQuery('<div class="pd"><div class="top-subtotal">Tổng tiền tạm tính: <span class="price price_big">' + Bizweb.formatMoney(cart.total_price, "{{amount_no_decimals_with_comma_separator}}₫") + '</span></div></div>').appendTo(table);
							jQuery('<div class="pd right_ct"><a href="/cart" class="btn btn-white"><span>Tiến hành thanh toán</span></a></div>').appendTo(table);
						}
						else {
							jQuery('<div class="no-item"><p>Không có sản phẩm nào.</p></div>').appendTo(table);

						}
					}
				});
			}
		}
		updateCartDesc(cart);
		var numInput = document.querySelector('#cart-sidebar input.input-text');
		if (numInput != null){
			// Listen for input event on numInput.
			numInput.addEventListener('input', function(){
				// Let's match only digits.
				var num = this.value.match(/^\d+$/);
				if (num == 0) {
					// If we have no match, value will be empty.
					this.value = 1;
				}
				if (num === null) {
					// If we have no match, value will be empty.
					this.value = "";
				}
			}, false)
		}
	}

	Bizweb.updateCartPageForm = function(cart, cart_summary_id, cart_count_id) {
		if ((typeof cart_summary_id) === 'string') {
			var cart_summary = jQuery(cart_summary_id);
			if (cart_summary.length) {
				// Start from scratch.
				cart_summary.empty();
				// Pull it all out.        
				jQuery.each(cart, function(key, value) {
					if (key === 'items') {
						var table = jQuery(cart_summary_id);           
						if (value.length) {  
			
							var HeaderCartPc = $('script[data-template="HeaderCartPc"]').text().split(/\$\{(.+?)\}/g);
							var pageCartCheckout = $('script[data-template="pageCartCheckout"]').text().split(/\$\{(.+?)\}/g);
							
							$(table).append((function() {
								return HeaderCartPc.map(render()).join('');
							}));
													
							jQuery.each(value, function(i, item) {
								var buttonQty = "";
								if(item.quantity == '1'){
									buttonQty = 'disabled';
								}else{
									buttonQty = '';
								}
								var link_img1 = Bizweb.resizeImage(item.image, 'compact');
								if(link_img1=="null" || link_img1 =='' || link_img1 ==null){
									link_img1 = 'https://bizweb.dktcdn.net/thumb/large/assets/themes_support/noimage.gif';
								}
								
								
								if(item.variant_title == 'Default Title'){
									var ItemCartPage = [{
									  url: item.url,
									  image_url: link_img1,
									  price: Bizweb.formatMoney(item.price, '{{amount_no_decimals_with_comma_separator}}₫'),
									  title: item.title,
									  buttonQty: buttonQty,
									  quanty: item.quantity,
									  variant_title: item.variant_title,
									  price_quanty: Bizweb.formatMoney(item.price * item.quantity, "{{amount_no_decimals_with_comma_separator}}₫"),
									  id_item: item.variant_id,
									  variant_title: ''
									}]
								}else {
									var ItemCartPage = [{
									  url: item.url,
									  image_url: link_img1,
									  price: Bizweb.formatMoney(item.price, '{{amount_no_decimals_with_comma_separator}}₫'),
									  title: item.title,
									  buttonQty: buttonQty,
									  quanty: item.quantity,
									  variant_title: item.variant_title,
									  price_quanty: Bizweb.formatMoney(item.price * item.quantity, "{{amount_no_decimals_with_comma_separator}}₫"),
									  id_item: item.variant_id
									}]
								}
								
								$(function() {
									var pageCartItem = $('script[data-template="pageCartItem"]').text().split(/\$\{(.+?)\}/g);
									$(table.find('.cart-tbody')).append(ItemCartPage.map(function(item) {
										return pageCartItem.map(render(item)).join('');
										
									}));
								});
								
							}); 
							
							var PriceTotalCheckout = [{
								  price_total: Bizweb.formatMoney(cart.total_price, "{{amount_no_decimals_with_comma_separator}}₫")
							}];				
							$(table.children('.cart')).append(PriceTotalCheckout.map(function(item) {
								return pageCartCheckout.map(render(item)).join('');
							}));
						}else {
							jQuery('<p class="hidden-xs-down ">Không có sản phẩm nào. Quay lại <a href="/collections/all" style="color:;">cửa hàng</a> để tiếp tục mua sắm.</p>').appendTo(table);
							 jQuery('.cart_desktop_page').css('min-height', 'auto');
						}
					}
				});
			}
		}
		updateCartDesc(cart);
		jQuery('#wait').hide();

	}
	Bizweb.updateCartPopupForm = function(cart, cart_summary_id, cart_count_id) {

		if ((typeof cart_summary_id) === 'string') {
			var cart_summary = jQuery(cart_summary_id);
			if (cart_summary.length) {
				// Start from scratch.
				cart_summary.empty();
				// Pull it all out.        
				jQuery.each(cart, function(key, value) {
					if (key === 'items') {
						var table = jQuery(cart_summary_id);           
						if (value.length) { 
							jQuery.each(value, function(i, item) {
								var src = item.image;
								if(src == null){
									src = "https://bizweb.dktcdn.net/thumb/large/assets/themes_support/noimage.gif";
								}
								var buttonQty = "";
								if(item.quantity == '1'){
									buttonQty = 'disabled';
								}else{
									buttonQty = '';
								}
													  
								if(item.variant_title == 'Default Title'){				  
									var ItemPopupCart = [{
										  url: item.url,
										  image_url: src,
										  price: Bizweb.formatMoney(item.price, '{{amount_no_decimals_with_comma_separator}}₫'),
										  title: item.title,
										  quanty: item.quantity,
										  variant_title: '',
										  price_quanty: Bizweb.formatMoney(item.price * item.quantity, "{{amount_no_decimals_with_comma_separator}}₫"),
										  id_item: item.variant_id
									}];
								}else {
									var ItemPopupCart = [{
										  url: item.url,
										  image_url: src,
										  price: Bizweb.formatMoney(item.price, '{{amount_no_decimals_with_comma_separator}}₫'),
										  title: item.title,
										  quanty: item.quantity,
										  variant_title: item.variant_title,
										  price_quanty: Bizweb.formatMoney(item.price * item.quantity, "{{amount_no_decimals_with_comma_separator}}₫"),
										  id_item: item.variant_id
									}];
								}
								
						
								$(function() {
									var TemplateItemPopupCart = $('script[data-template="TemplateItemPopupCart"]').text().split(/\$\{(.+?)\}/g);
									$(table).append(ItemPopupCart.map(function(item) {
										return TemplateItemPopupCart.map(render(item)).join('');
									}));
								});					  
								
								$('.link_product').text();
							}); 
						}
					}
				});
			}
		}
		jQuery('.total-price').html(Bizweb.formatMoney(cart.total_price, "{{amount_no_decimals_with_comma_separator}}₫"));
			updateCartDesc(cart);
		}
	Bizweb.updateCartPageFormMobile = function(cart, cart_summary_id, cart_count_id) {
			if ((typeof cart_summary_id) === 'string') {
				var cart_summary = jQuery(cart_summary_id);
				if (cart_summary.length) {
					// Start from scratch.
					cart_summary.empty();
					// Pull it all out.
					if (cart.items && cart.items.length) {
					  var table = jQuery(cart_summary_id);           
					  jQuery('<div class="cart_page_mobile content-product-list"></div>').appendTo(table);
					  jQuery.each(cart.items, function(i, item) {
									if ( item.image != null) {
										var src = Bizweb.resizeImage(item.image, 'compact');
									} else {
										var src = "https://mixcdn.egany.com/themes/assets/thumb/large/noimage.gif";
									}
									var ItemCartPageMobile = [{
									  url: item.url,
									  image_url: src,
									  price: Bizweb.formatMoney(item.price, '{{amount_no_decimals_with_comma_separator}}₫'),
									  title: item.title,
									  quanty: item.quantity,
									  variant_title: item.variant_title !== 'Default Title'?item.variant_title : '',
									  price_quanty: Bizweb.formatMoney(item.price * item.quantity, "{{amount_no_decimals_with_comma_separator}}₫"),
									  id_item: item.variant_id
									}];
									
										var pageCartItemMobile = $('script[data-template="ItemCartMobile"]').text().split(/\$\{(.+?)\}/g);
									
										$(table.children('.content-product-list')).append(ItemCartPageMobile.map(function(item) {
											return pageCartItemMobile.map(render(item)).join('');
										}));

								})
								
								var pageCartCheckoutMobile = $('script[data-template="pageCartCheckoutMobile"]').text().split(/\$\{(.+?)\}/g);  
								var PriceTotalCheckoutMobile = [{
									price_total: Bizweb.formatMoney(cart.total_price, "{{amount_no_decimals_with_comma_separator}}₫")
								}];
								if(window.outerWidth < 767 ){
								var stickyCartCheckout = $('script[data-template="templateStickyCheckout"]').text().split(/\$\{(.+?)\}/g);  
								$('body').append(PriceTotalCheckoutMobile.map(function(item) {
									return stickyCartCheckout.map(render(item)).join('');
					    		}));
								}										
								$(table).append(PriceTotalCheckoutMobile.map(function(item) {
									return pageCartCheckoutMobile.map(render(item)).join('');
					    		}));
								
					
								
									
					$('.cart_page_mobile').append(`<div class="cart-note">
					<label for="note" class="note-label">Ghi chú đơn hàng</label>
					<textarea id="note" name="note" rows="8"></textarea>
				</div>`)
					  }
									
				}
			}
			updateCartDesc(cart);
						updateCartUpsell(cart)
  		    	}


	function updateCartDesc(data){
		var $cartPrice = Bizweb.formatMoney(data.total_price, "{{amount_no_decimals_with_comma_separator}}₫"),
			$cartMobile = $('#header .cart-mobile .quantity-product'),
			$cartDesktop = $('.count_item_pr, .count_sidebar, .cart-popup-count'),
			$cartDesktopList = $('.cart-counter-list'),
			$cartPopup = $('.cart-popup-count');

		switch(data.item_count){
			case 0:
				$cartMobile.text('0');
				$cartDesktop.text('0');
				$cartDesktopList.text('0');
				$cartPopup.text('0');

				break;
			case 1:
				$cartMobile.text('1');
				$cartDesktop.text('1');
				$cartDesktopList.text('1');
				$cartPopup.text('1');

				break;
			default:
				$cartMobile.text(data.item_count);
				$cartDesktop.text(data.item_count);
				$cartDesktopList.text(data.item_count);
				$cartPopup.text(data.item_count);

				break;
		}
		$('.top-cart-content .top-subtotal .price, aside.sidebar .block-cart .subtotal .price, .popup-total .total-price').html($cartPrice);
		$('.popup-total .total-price').html($cartPrice);
		$('.shopping-cart-table-total .totals_price, .price_sidebar .price_total_sidebar').html($cartPrice);
		$('.totals_price_mobile').html($cartPrice);
		$('.cartCount, .cart-popup-count, #ega-cart-count').html(data.item_count);
																
															
	}

	Bizweb.onCartUpdate = function(cart) {
		Bizweb.updateCartFromForm(cart, '.mini-products-list');
		Bizweb.updateCartPopupForm(cart, '#popup-cart-desktop .tbody-popup');
		
		 };
		 Bizweb.onCartUpdateClick = function(cart, variantId) {
      updateCartUpsell(cart)
  			 jQuery.each(cart, function(key, value) {
				 if (key === 'items') {    
					 jQuery.each(value, function(i, item) {	
						 if(item.variant_id == variantId){
							 $('.productid-'+variantId).find('.cart-price span.price').html(Bizweb.formatMoney(item.price * item.quantity, "{{amount_no_decimals_with_comma_separator}}₫"));
							 $('.productid-'+variantId).find('.items-count').prop("disabled", false);
							 $('.productid-'+variantId).find('.number-sidebar').prop("disabled", false);
							 $('.productid-'+variantId +' .number-sidebar').val(item.quantity);
                              $('.list-item-cart .item.productid-'+variantId).find( '.quanlity').text('x ' + item.quantity) 
								if(item.quantity == '1'){
								 $('.productid-'+variantId).find('.items-count.btn-minus').prop("disabled", true);
							 }
						 }
					 }); 
				 }
			 });
			 updateCartDesc(cart);
		 }
		 Bizweb.onCartRemoveClick = function(cart, variantId) {
			 jQuery.each(cart, function(key, value) {
				 if (key === 'items') {    
					 jQuery.each(value, function(i, item) {	
						 if(item.variant_id == variantId){
							 $('.productid-'+variantId).remove();
						 }
					 }); 
				 }
			 });
			 updateCartDesc(cart);
						updateCartUpsell(cart)
  		 }
const initCart = ()=>{
							 $.ajax({
				 type: 'GET',
				 url: ' ',
				 async: false,
				 cache: false,
				 dataType: 'json',
				 success: function (cart){
					 Bizweb.updateCartFromForm(cart, '.mini-products-list');
					 Bizweb.updateCartPopupForm(cart, '#popup-cart-desktop .tbody-popup'); 
					 
						if(!cart.item_count){
																	
						}
					  }
					 });
			 
			 var wDWs = $(window).width();
			if (wDWs < 1199) {
				$('.top-cart-content').remove();

			}									
																
		}														
		 $(window).ready(function(){
			

			$(window).one(' mousemove touchstart scroll',initCart)	
			
			 
});
																
	//Check inventory
	$(document).on('click', ".items-count", function () {
		$(this).parent().children('.items-count').prop('disabled', true);
		var variantId = $(this).parent().find('.variantID').val(),
			qty = $(this).parent().children('.number-sidebar').val(),
			url = $(this).parent().parent().parent().find('.product-name a').attr('href');
		CheckQtyCart(qty, variantId, url);
	})
		function CheckQtyCart(qty, variantId, url) {
		if(!url) return																	
		$.ajax({
			type : 'GET',
			dataType : 'json',
			url: ""+url+".json",
			success : function(data) {
				locationData = data;
				for(var i = 0; i < locationData.variants.length; i++) {
					if(locationData.variants[i].id == variantId){
						var maxS = locationData.variants[i].inventory_quantity,
							allow = locationData.variants[i].inventory_management,
							continues = locationData.variants[i].inventory_policy;
						if (allow == 'bizweb'){
							$('.productid-'+variantId+'').find('.items-count.btn-plus').css("pointer-events","auto");
							if (continues == "deny") {
								$('.productid-'+variantId+'').find('.items-count.btn-plus').css("pointer-events","none");
								if (qty >= maxS) {
									updateQuantity(maxS, variantId);
									$('.productid-'+variantId+'').find('.quanlity').text(`x ${maxS}`)
									$('.productid-'+variantId+'').find('.items-count.btn-plus').css("pointer-events","none");
								}else {
									$('.productid-'+variantId+'').find('.items-count.btn-plus').css("pointer-events","auto");
								}
							} else if (continues == "continue") {
								$('.productid-'+variantId+'').find('.items-count.btn-plus').css("pointer-events","auto");
							} else{
								$('.productid-'+variantId+'').find('.items-count.btn-plus').css("pointer-events","auto");
							}
						}
					}
				}
			}
		})
	}
	function alertInvalidQty(qty){
		alert(`Bạn chỉ có thể mua tối đa ${qty} sản phẩm`)			
	}
	function validateQty(product, variantId, qty){
		let isInValidQty = false;
		/** check variant **/
		let variant = product && product.variants.find(item => item.id == variantId )
		if(variant && variant.inventory_management === "bizweb" && variant.inventory_policy == "deny" ){
			isInValidQty = qty > variant.inventory_quantity 
			isInValidQty && alertInvalidQty(variant.inventory_quantity)
			return isInValidQty ? variant.inventory_quantity: false
		}
		return 	isInValidQty

	}
function cart_min() {
	var sts = true;
	$.ajax({
		type: 'GET',
		url: ' ',
		async: false,
		success:function(data) {
			var cart = parseInt(data.total_price+'');
			var cart_compare = parseInt(100000);
			if(cart < cart_compare) {
				$('.btn-proceed-checkout-mobile').addClass('disabled');
				$('.cart-limit-alert').css('display', 'block');
				$('#template-cart').removeClass('cart-available')
				sts = false;
			} else {
				$('.btn-proceed-checkout-mobile').removeClass('disabled');
				$('.cart-limit-alert').css('display', 'none');
				$('#template-cart').addClass('cart-available')
			}
		}
	})
	return sts;
}
 

  $(document).ready(function () {
	  
	  	$(window).one('mousemove touchstart scroll',cart_min)	
	    })
  

    function updateCartUpsell(cart) {
		const priceMin = 500000
			  const totalPrice = cart.total_price
			  let remain = priceMin > totalPrice ? priceMin - totalPrice : 0;
		let percent = priceMin > totalPrice
		? Math.round((totalPrice/priceMin*100)) === 100 ? '99%' : Math.round((totalPrice/priceMin*100)) + '%'
		: '100%'
		let incompleteInfo = "Bạn cần mua thêm [price] nữa để được Freeship"
		const completeInfo = "Chúc mừng! Đơn hàng của bạn đã đủ điều kiện được Freeship 🎉"
		const copyBtnContent = "Sao chép"
		const copiedBtnContent = "Đã sao chép"
		const coupon = "EGAFREESHIP"

		remain = `<span class="cart-upsell__price">${Bizweb.formatMoney(remain, '{{amount_no_decimals_with_comma_separator}}₫')}</span>`

																		incompleteInfo = incompleteInfo.replaceAll('[price]', remain)

		$('.cart-upsell__percent').css('width', percent)

		// incomplete
		if (totalPrice === 0) {
			$('.cart-upsell__empty-wrapper').show()
			$('.cart-upsell__progress-wrapper, .cart-upsell__promotion, .cart-upsell__content').hide()

		} else {
			$('.cart-upsell__empty-wrapper').hide()

			$('.cart-upsell__progress-wrapper, .cart-upsell__content').show()

			$('.cart-upsell__progress span').html(percent)

			if (totalPrice < priceMin) {
				$('.cart-upsell__content').removeClass('complete').addClass('incomplete').html(incompleteInfo)

				$('.cart-upsell__promotion-wrapper').hide()
			} else {
				$('.cart-upsell__content').removeClass('incomplete').addClass('complete').html(completeInfo)

								$('.cart-upsell__promotion-wrapper').show()
				$('.cart-upsell__promotion button:not(.disabled)').on('click', function (e) {
					e.preventDefault()
					const _this = $(this);
					_this.html(copiedBtnContent);
					_this.addClass('disabled');
					setTimeout(function() {
						_this.html(copyBtnContent);
						_this.removeClass('disabled');
					}, 3000)
					navigator.clipboard.writeText(coupon);
				})
							}
		}
	}
						
</script>
		<script src="/skin_shop/skin_7_nhat/tpl/js/api-jquery-custom.js" type="text/javascript"></script>

		
		
		<link rel="preload" as="script" href="/skin_shop/skin_7_nhat/tpl/js/main.js" />
		<script src="/skin_shop/skin_7_nhat/tpl/js/main.js" type="text/javascript"></script>
		
								

		<script>
			var cro_show = true,
			  cro_addcart_show = true,
			  cro_cart_show = true,
			  cro_addcart_title = "Thêm vào giỏ",
			  cro_addcart_bg = "#090302",
			  cro_addcart_color = "#fff",
			  cro_price_color = "#e9330d",
			  cro_compare_price_color = "#979797";
			  (cro_variant_color = "#EC720E"),
			  (cro_variant_bg = "#fff"),
			  (cro_cta_bg = "#090302"),
			  (cro_cta_color = ""),
			  (cro_addcart_modal_mess = "Tiến hành thanh toán"),
			  (cro_addcart_modal_redirect = ""),
			  (cro_modal_btn_text = ""),
			  (cro_modal_btn_bg = ""),
			  (cro_modal_btn_color = ""),
			  (cro_hotline_show = true),
			  (cro_hotline_number = "{hotline}"),
			  (cro_mess_show = true),
			  (cro_mess_url = "https://m.me/SocDoPage/"),
			  (cro_home_show = 3),
			  (cro_home_title = "Ưu đãi"),
			  (cro_home_url = "flash-sale.html"),
			  (cro_coll_title = "Danh mục"),
			  (cro_coll_url = "/san-pham.html"),
			  (cro_blog_title = "Cửa hàng"),
			  (cro_blog_url = "/lien-he.html"),
			  (cro_general_color = "#EC720E"),
			  (cro_product_color = "#EC720E"),
			  (cro_background_color = "#fff"),
			  (cro_label_background = " #e9330d"),
			  (cro_label_color = "#ffffff");
		
			const crAddonScript =
			  "/skin_shop/skin_7_nhat/tpl/js/index.min.js";
			window["cro-btn"] = {
			  shop: "ega-furniture.mysapo.net",
			  platform: "sapo",
			  moneyFormat: "{{amount_no_decimals}}₫",
			  currentTemplate: "collection",
			  platformApi: Bizweb,
			  scripts: [],
			  lang: {
				email_invalid: "Email không đúng định dạng",
				phone_invalid: "Số điện thoại không đúng định dạng",
				require_invalid: "Vui lòng điền trường này",
				unavailable: "Liên hệ",
			  },
			};
			window.egany = window.egany || {};
		
			window.egany["cro-btn"] = {
			  mobile: {
				enable: true,
				general: {
				  enable: true,
				  design: {
					template: "shoppee",
					background: "#ffffff",
					customCss: "",
					croBorderRadius: 0,
					ctaBorderRadius: 5,
				  },
				  buttons: [
					{
					  id: "cro-link-1",
					  className: "",
					  order: "4",
					  type: "link",
					  title: cro_coll_title,
					  link: cro_coll_url,
					  icon: "//bizweb.dktcdn.net/100/491/756/themes/956460/assets/icon-cro-coll.png?1727322848954",
					  background: "#fff",
					  color: cro_general_color,
					  action: "",
					},
					{
					  id: "cro-link-2",
					  className: "",
					  order: "5",
					  type: "link",
					  title: cro_blog_title,
					  link: cro_blog_url,
					  icon: "//bizweb.dktcdn.net/100/491/756/themes/956460/assets/icon-cro-blog.png?1727322848954",
					  background: "#fff",
					  color: cro_general_color,
					  action: "",
					},
		
					{
					  id: "cro-link-3",
					  className: "",
					  order: "3",
					  type: "link",
					  title: cro_home_title,
					  link: cro_home_url,
					  icon: "//bizweb.dktcdn.net/100/491/756/themes/956460/assets/cro-home-icon.png?1727322848954",
					  background: "#fff",
					  color: cro_general_color,
					  action: "",
					},
		
					{
					  id: "cro-mess-1",
					  className: "",
					  order: "2",
					  type: "chat",
					  title: "Nhắn tin",
					  link: cro_mess_url,
					  icon: "//bizweb.dktcdn.net/100/491/756/themes/956460/assets/cro-mess-icon.png?1727322848954",
					  background: "#fff",
					  color: cro_general_color,
					},
		
					{
					  id: "cro-phone-1",
					  className: "",
					  order: "1",
					  type: "call",
					  title: "Gọi điện",
					  link: cro_hotline_number,
					  icon: "//bizweb.dktcdn.net/100/491/756/themes/956460/assets/cro-phone-icon.png?1727322848954",
					  background: "#fff",
					  color: cro_general_color,
					},
				  ],
				},
				product: {
				  enable: true,
				  buttons: [
					{
					  id: "cro-mess-1",
					  className: "",
					  order: "2",
					  type: "chat",
					  title: "Nhắn tin",
					  link: cro_mess_url,
					  icon: "//bizweb.dktcdn.net/100/491/756/themes/956460/assets/cro-mess-icon.png?1727322848954",
					  background: "#fff",
					  color: cro_general_color,
					},
		
					{
					  id: "cro-phone-1",
					  className: "",
					  order: "1",
					  type: "call",
					  title: "Gọi điện",
					  link: cro_hotline_number,
					  icon: "//bizweb.dktcdn.net/100/491/756/themes/956460/assets/cro-phone-icon.png?1727322848954",
					  background: "#fff",
					  color: cro_general_color,
					},
		
					{
					  id: "cro-view-cart",
					  order: 3,
					  type: "cart",
					  title: "Giỏ hàng",
					  icon: "//bizweb.dktcdn.net/100/491/756/themes/956460/assets/cro-cart-icon.png?1727322848954",
					  background: "#ffff",
					  color: cro_general_color,
					  countColor: "red",
					  countBg: "yellow",
					  labelBackgorund: "#ff0000",
					  labelColor: "#fff",
					  labelBackground: "#ff0000",
					},
		
					{
					  id: "cro-buy-add-cart",
					  order: 5,
					  type: "addtocart",
					  title: "Thêm vào giỏ",
					  subTitle: "Hết hàng",
					  icon: "",
					  background: cro_addcart_bg,
					  color: cro_addcart_color,
					  className: "",
					  border: "none",
					  borderColor: "transparent",
					  padding: "transparent",
					  borderRadius: "0px",
					},
				  ],
				},
			  },
			  productPopup: {
				variantInfo: {
				  enable: false,
				  title: "<p><u>Bảng quy đổi kích cỡ</u></p>",
				  color: "#2E72D2",
				  url: "/",
				  action: "new_page",
				  img: "https://mixcdn.egany.com/media/egaApp/cro-btn/maxcool-ao.jpg",
				},
				design: {
				  comparePriceColor: cro_compare_price_color,
				  variantBg: cro_variant_bg,
				  variantBorderColor: cro_variant_color,
				  priceColor: cro_price_color,
				  variantBorderRadius: 20,
				  variantColor: cro_variant_color,
				  variantBorder: "1px solid",
				  ctaIcon: true,
				  template: "default",
				},
				saleLabel: {
				  background: cro_label_background,
				  priceColor: cro_price_color,
				  color: cro_label_color,
				  discountColor: "#000",
				  title: "",
				  template: "price",
				},
				qty: {
				  borderRadius: 20,
				  background: "#fff",
				  borderColor: "#D7D7D7",
				  enable: true,
				  title: "Số lượng",
				  color: "#8C9196",
				  border: "1px solid",
				},
				cta: {
				  animation: "",
				  background: cro_addcart_bg,
				  gaEventLabel: "",
				  borderRadius: "4",
				  color: cro_addcart_color,
				  icon: "",
				  id: "cro-product-cta",
				  title: "Thêm vào giỏ",
				  type: "cta",
				  className: "",
				},
				auto: false,
				lang: {
				  ctaDescription: "",
				  contact: "Liên Hệ",
				  soldout: "Hết hàng",
				},
				enable: true,
			  },
			  cartPopup: {
				header: {
				  color: "#2EB346",
				  background: "#EBF6ED",
				  borderColor: "#2EB346",
				  border: "1px dashed",
				  icon: "http://theme.hstatic.net/1000406621/1000576502/14/cartpopup.header.icon-cro-icon.png?v=2134",
				},
				cta: {
				  background: "#fe3945",
				  title: "Xem giỏ hàng",
				  color: "#fff",
				  link: "/gio-hang.html",
				  type: "cta",
				  id: "cro-popup-cta",
				  borderRadius: "4",
				},
				subCta: {
				  borderColor: "#aeaeae",
				  title: "Mua thêm",
				  color: "#000000",
				  border: "1px solid",
				  id: "subCta",
				  borderRadius: "4",
				  link: "close",
				  type: "cta",
				},
				title: "<p>Thêm vào giỏ hàng thành công</p>",
				subCtaEnable: false,
				closeCta: { title: "Mua thêm", color: "#212B36" },
				enable: false,
			  },
			};
		
			$(document).ready(function ($) {
			  if (window.outerWidth <= 600) {
				var isInit = false;
				window.egany["cro-btn"].mobile.general.buttons.sort((a, b) =>
				  a.order > b.order ? 1 : -1
				);
				$(window).on("scroll click mousemove touchstart", () => {
				  if (!isInit) {
					isInit = true;
					$("body").append(
					  `<script src="${crAddonScript}" defer ><\/script>`
					);
				  }
				});
			  }
			});
		  </script>

				

		
		
			<link rel="preload" as="style" media="all" href="/skin_shop/skin_7_nhat/tpl/css/sapo-popup.css" >
<link rel="stylesheet" href="/skin_shop/skin_7_nhat/tpl/css/sapo-popup.css" media="all"  >
<div class="popup-sapo ">
	<div class="icon">
		<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"></path></svg>
	</div>
	<div class="content">
        <div class="title">Tích hợp sẵn các ứng dụng</div>
        <ul class="">
            <li>
                <a href="https://socdo.vn" target="_blank" title="Đánh giá sản phẩm"
                    aria-label="Đánh giá sản phẩm">Đánh giá sản phẩm</a>
            </li>

            <li>
                <a href="https://socdo.vn" target="_blank">Ứng dụng Affiliate</a>
            </li>
            <li>
                <a href="https://socdo.vn" target="_blank">
                    Đa ngôn ngữ</a>
            </li>
            <li>
                <a href="https://socdo.vn" target="_blank">
                    Mua X Tặng Y
                </a>
            </li>
            <li>
                <a href="https://socdo.vn/" target="_blank">Combo sản phẩm</a>
            </li>
        </ul>
        <div class="ghichu">
            Lưu ý với các ứng dụng trả phí bạn cần cài đặt và mua ứng dụng này
            trên Web Socdo.vn để sử dụng ngay
        </div>
        <span title="Đóng" class="close-popup-sapo">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px"
                y="0px" viewBox="0 0 512.001 512.001" style="enable-background: new 0 0 512.001 512.001"
                xml:space="preserve">
                <g>
                    <g>
                        <path
                            d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z">
                        </path>
                    </g>
                </g>
            </svg>
        </span>
    </div>
</div>

<script>
	$('.popup-sapo .icon').click(function() {
		$(".popup-sapo").toggleClass("active");
	}); 
	$('.close-popup-sapo').click(function() {
		$(".popup-sapo").toggleClass("active");
	}); 
	setTimeout(()=>{
	$(".popup-sapo").removeClass("active");
	
	}, 15000)
</script>		<script>
  window.EGASmartSearchConfigs = {
    // color
    colorBg: '#ffffff',
    colorBgHover: '#f7f7f7',
    colorItemTextTitle: '#000000',
    colorItemTextPrice: '#d82e4d',
    colorItemTextCompareAtPrice: '#8a8a8a',
    colorItemTextViewAll: '#ec720e',
    colorHeaderText: '#000000',
    navBg: '#faedd9',
    navTextColor: '#ec720e',
    navBgActive: '#ec720e',
    navTextColorActive: '#ffffff',
    colorLoading: '#d82e4d',
    // general
    searchAccuracy: 'all',
    searchWidth: '450px',
    searchHeight: '400px',
    // product
    productSortby: 'default',
    productLimit: 4,
    // article
    displayArticle: true,
    articleLimit: 4,
    moneyFormat: "{{amount_no_decimals_with_comma_separator}}₫",
    shopDomain: '',
    textHeaderSectionTitle: 'Kết quả tìm kiếm cho ',
    textProductSectionTitle: 'Sản phẩm ',
    textArticleSectionTitle: 'Bài viết',
    notFound: 'Không tìm thấy kết quả ',
    textFrom: '',
    textShowAll: 'Xem thêm kết quả có chứa '
  }

</script>

		
    
	  	  	<link href="/skin_shop/skin_7_nhat/tpl/css/ae-multilang-custom.css" rel="stylesheet" type="text/css" media="all" />
<style id="ae-switch-lang-css">.ae-lang-vi {display:inline!important;}</style>
<style id="ae-position-lang-css">.ae-hover {box-shadow: 0 0 5px #bbb}</style>



<script>




var langDefault = "vi";
var currentLang = "us";
var defaultLangAdmin = "vi";
var position = "0-0-0-2";
var positionTablet = "";
var positionSmartphone = "";
var aeUrlDestination = window.location.protocol + "//aelang.aecomapp.com/bizweb/aelang/setting";
var isChangeUrl = "";
var aeData = {"data":[]};

                                                         

var productId = "122127259";
var requireInit = "";
/*setTimeout(function() {
	if (document.getElementsByClassName("ae-block-language")) {
		document.getElementsByClassName("ae-block-language")[0].remove()
	}
}, 1000);
*/
</script>
	 <script>
	let elementDesktop = $("#desktop-lang")[0]; 
	let elementTablet = $("#desktop-lang")[0]; 
	let elementMobile = $("#desktop-lang")[0]; 

    function detectHTML (element) {
    var arrTags = [];

    function buildTagsArray(el) {
        if (el && el.tagName !== "BODY") {
            arrTags.push({ tag: ">" + el.tagName, index: $(el).index() });
            buildTagsArray(el.parentElement);
        }
    }

    buildTagsArray(element);

    var selector = "";
    for (var i = arrTags.length - 1; i >= 0; i--) {
        var index = arrTags[i].index;
        selector += selector ? "-" + index : index;
    }

    return selector;
};
    var position =  detectHTML(elementDesktop); 
	var positionTablet = detectHTML(elementTablet)
	var positionSmartphone = detectHTML(elementMobile)
</script>
	  

</body>
<style>
	/* Bố cục tổng thể */
.container_member {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Cột trái */
.box_left {
    flex: 1 1 30%;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.box_left .avatar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
}

.box_left .name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
}

.box_left .email {
    font-size: 14px;
    color: #555;
    margin-bottom: 15px;
}

.box_left .list_info {
    list-style: none;
    padding: 0;
    text-align: left;
}

.box_left .list_info .list-item {
    font-size: 14px;
    margin-bottom: 10px;
}

.box_left .button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #fb9b24;
    color: #fff;
    text-transform: uppercase;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.box_left .button:hover {
    background-color: #FFA500;
}

/* Cột phải */
.box_right {
    flex: 1 1 65%;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Danh sách hành động */
.box_right .list_action {
    display: flex;
    gap: 15px;
    justify-content: space-between;
    flex-wrap: wrap;
    overflow: hidden; /* Bố cục hàng ngang trên desktop và tablet */
}

.box_right .list_action .action {
    flex: 1 1 calc(16.666% - 10px); /* Mỗi action chiếm 1/6 chiều ngang */
    text-align: center;
}

.box_right .list_action .action img {
    width: 50px;
    height: 50px;
    margin-bottom: 10px;
}

.box_right .list_action .action h2 {
    font-size: 14px;
    color: #333;
}

/* Hộp thông tin chi tiết */
.box_right .box_profile {
    width: 100%;
}

.box_right .box_profile .li_input {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 15px;
}

.box_right .box_profile .col_30 {
    flex: 1 1 calc(33.333% - 20px);
}

.box_right .box_profile .col_100 {
    flex: 1 1 100%;
    text-align: center;
}

.box_right .box_profile label {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
    color: #555;
}

.box_right .box_profile input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.box_right .box_profile button {
    padding: 10px 20px;
    font-size: 14px;
    background-color: #fb9b24;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.box_right .box_profile button:hover {
    background-color: #FFA500;
}

.box_right .list_action {
    display: flex;
    flex-wrap: wrap; /* Đảm bảo các mục xuống dòng khi không đủ không gian */
    gap: 10px; /* Khoảng cách giữa các mục */
    justify-content: space-between; /* Dàn đều khoảng cách */
}

.box_right .list_action .action {
    flex: 1 1 calc(20% - 10px); /* Chiếm 20% chiều ngang trừ khoảng cách */
    max-width: calc(20% - 10px); /* Đảm bảo không vượt quá chiều rộng */
    text-align: center;
}

/* Responsive cho Mobile */
@media (max-width: 768px) {
    .box_right .list_action .action {
        flex: 1 1 calc(50% - 10px); /* Mỗi mục chiếm 50% chiều ngang */
        max-width: calc(50% - 10px); /* Giới hạn chiều rộng tối đa */
    }
}

/* Responsive cho Tablet */
@media (min-width: 769px) and (max-width: 1024px) {
    .box_right .list_action .action {
        flex: 1 1 calc(33.333% - 10px); /* Mỗi mục chiếm 33.33% chiều ngang */
        max-width: calc(33.333% - 10px); /* Giới hạn chiều rộng tối đa */
    }
}

/* Desktop */
@media (min-width: 1025px) {
    .box_right .list_action .action {
        flex: 1 1 calc(20% - 10px); /* Mỗi mục chiếm 20% chiều ngang */
        max-width: calc(20% - 10px); /* Giới hạn chiều rộng tối đa */
    }
}
    .box_right .list_action .action {
        flex: 0 0 auto; /* Cố định kích thước phần tử */
        width: 150px; /* Kích thước cố định cho mỗi action */
    }


</style>	
</html>
<style>
    .list-group .list-group-item .mega-menu {
        height: 200% !important;
    }
</style>