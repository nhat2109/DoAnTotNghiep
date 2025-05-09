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
	                        <a href="/tai-khoan.html" target="_self">
	                            <span> Tài khoản </span></a>
	                        <span class="mr_lr">&nbsp;/&nbsp;</span>
	                    </li>
	                    <li class="active"><span>Đổi mật khẩu</span></li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="box_member">
		<div class="container">
			<div class="container_member">
				<div class="box_left">
					<div class="avatar">
						<img src="{avatar}" alt="Hình đại diện" onerror="this.src='/images/no-images.jpg';">
					</div>
					<div class="name">{name}</div>
					<div class="email">{email}</div>
					<ul class="list_info">
					    <li class="list-item">
					        <b>Tài khoản:</b> <a class="pull-right">{username}</a>
					    </li>
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
							<a href="/thongbao.html">
								<img src="/skin/css/images/icon/7.png" alt="Thông báo">
								<h2>Thông báo</h2>
							</a>
						</div>
						<div class="action">
							<a href="/don-hang.html">
								<img src="/skin/css/images/icon/1.png" alt="Danh sách đơn hàng">
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
                            <a href="/tich-diem.html">
                                <img src="/skin/css/images/icon/tich_diem.png" alt="Tích điểm">
                                <h2>Tích điểm</h2>
                            </a>
                        </div>
						<div class="action">
							<a href="/doi-mat-khau.html" class="active">
								<img src="/skin/css/images/icon/4.png" alt="Đổi mật khẩu">
								<h2>Đổi mật khẩu</h2>
							</a>
						</div>
<!-- 						<div class="action">
							<a href="/dang-xuat.html">
								<img src="/skin/css/images/icon/5.png" alt="Đăng xuất">
								<h2>Đăng xuất</h2>
							</a>
						</div> -->
					</div>
					<h1>Đổi mật khẩu mới</h1>
					<div class="box_profile" style="width: 400px;">
						<div class="li_input">
							<div class="col_100">
								<label for="">Mật khẩu hiện tại</label>
								<input type="password" name="password" value="" placeholder="Nhập mật khẩu hiện tại">
							</div>
						</div>
						<div class="li_input">
							<div class="col_100">
								<label for="">Mật khẩu mới</label>
								<input type="password" name="new_password" value="" placeholder="Nhập mật khẩu mới">
							</div>
						</div>
						<div class="li_input">
							<div class="col_100">
								<label for="">Xác nhận mật khẩu mới</label>
								<input type="password" name="confirm_password" value="" placeholder="Nhập lại mật khẩu mới">
							</div>
						</div>
						<div class="li_input">
							<div class="col_100" style="text-align: center;">
								<button type="button" name="change_password">Lưu thay đổi</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{footer}
	{script_footer}
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  <script>
	  $( function() {
	    $( ".datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});
	  } );
	  </script>
</body>
</html>