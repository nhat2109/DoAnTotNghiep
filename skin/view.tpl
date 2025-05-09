{header}
<style>
	body {
		opacity: 0;
		transition: opacity 0.1s ease-in-out;
	}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		document.body.style.opacity = "1"; 
	});

</script>

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
	<div class="sanpham_detail">
		<div class="container">
			<div class="box_top_sanpham">
				<div class="info">
					<h1>{tieu_de}</h1>
					{info_rate}
				</div>
				<div class="share"></div>
			</div>
			<div class="box_info_sanpham">
				<div class="box_left_info">
					<div class="box_slide">
						<div class="small">
							<div class="swiper-wrapper">
								{list_small}
							</div>
							<div class="prev"><button><i class="fa fa-angle-up"></i></button></div>
							<div class="next"><button><i class="fa fa-angle-down"></i></button></div>
						</div>
						<div class="big" id="big">
							<div class="swiper-container slide_big">
								<div class="swiper-wrapper">
									{list_big}
								</div>
							</div>
							<div class="prev"><button><i class="fa fa-angle-left"></i></button></div>
							<div class="next"><button><i class="fa fa-angle-right"></i></button></div>
						</div>
						<script src="/dist/jquery.magnific-popup.min.js"></script>
						<link rel="stylesheet" type="text/css" href="/dist/magnific-popup.css">
						<script type="text/javascript">
							$(document).ready(function () {
								$('.slide_small').magnificPopup({
									delegate: 'a',
									type: 'image',
									closeOnContentClick: false,
									closeBtnInside: false,
									mainClass: 'mfp-with-zoom mfp-img-mobile',
									image: {
										verticalFit: true
									},
									gallery: {
										enabled: true
									},
									zoom: {
										enabled: true,
										duration: 300,
										opener: function (element) {
											return element.find('img');
										}
									}

								});
								$('#big').magnificPopup({
									delegate: 'a',
									type: 'image',
									closeOnContentClick: false,
									closeBtnInside: false,
									mainClass: 'mfp-with-zoom mfp-img-mobile',
									image: {
										verticalFit: true
									},
									gallery: {
										enabled: true
									},
									zoom: {
										enabled: true,
										duration: 300, 
										opener: function (element) {
											return element.find('img');
										}
									}

								});
							});
						</script>
						<style type="text/css">
							.image-source-link {
								color: #98C3D1;
							}

							.mfp-with-zoom .mfp-container,
							.mfp-with-zoom.mfp-bg {
								opacity: 0;
								-webkit-backface-visibility: hidden;
								-webkit-transition: all 0.3s ease-out;
								-moz-transition: all 0.3s ease-out;
								-o-transition: all 0.3s ease-out;
								transition: all 0.3s ease-out;
							}

							.mfp-with-zoom.mfp-ready .mfp-container {
								opacity: 1;
							}

							.mfp-with-zoom.mfp-ready.mfp-bg {
								opacity: 0.8;
							}

							.mfp-with-zoom.mfp-removing .mfp-container,
							.mfp-with-zoom.mfp-removing.mfp-bg {
								opacity: 0;
							}

							.bk-btn-paynow {
								width: 75%;
								padding-top: 10px;
								padding-bottom: 10px;
							}

							.bk-btn-installment {
								padding-top: 10px;
								padding-bottom: 10px;
							}
						</style>
					</div>
					<div class="box_control">
						<div class="li_control">
							<div class="icon_control"><i class="icondetail-noibat"></i></div>
							<div class="text">Điểm nổi bật</div>
						</div>
						<div class="li_control">
							<div class="icon_control"><i class="icondetail-thongso"></i></div>
							<div class="text">Thông số</div>
						</div>
						<div class="li_control">
							<div class="icon_control"><i class="icondetail-danhgia"></i></div>
							<div class="text">Thông tin</div>
						</div>
					</div>
					<script>
						document.addEventListener("DOMContentLoaded", function () {
							document.querySelectorAll(".li_control").forEach((item, index) => {
								item.addEventListener("click", function () {
									let targetSection;
									if (index === 0) {
										targetSection = document.querySelector(".box_noibat");
									} else if (index === 1) {
										targetSection = document.querySelector(".list_thongso");
									} else if (index === 2) {
										targetSection = document.querySelector(".mota_sanpham");
									}

									if (targetSection) {
										let targetOffset = targetSection.getBoundingClientRect().top + window.scrollY - 115;

										if (targetOffset < 0) targetOffset = 0;

										window.scrollTo({
											top: targetOffset,
											behavior: "smooth",
										});
									}
								});
							});
						});


					</script>
					<div class="box_note_chinhsach">
						<div class="li_note">
							<div class="iconl">
								<i class="icondetail-doimoi"></i>
							</div>
							<p>
								Đổi trả dễ dàng.
							</p>
						</div>
						<div class="li_note">
							<div class="iconl">
								<i class="icondetail-baohanh"></i>
							</div>
							<p>
								Bảo hành chính hãng.

							</p>
						</div>
						<div class="li_note">
							<div class="iconl"><i class="icondetail-ship"></i></div>
							<p>Nhận hàng tại nhà.</p>
						</div>
					</div>

				</div>
				<div class="box_right_info">
					<div class="price_info">
						<div class="price_new">{gia_moi} đ</div>
						<div class="price_old">{gia_cu} đ</div>
						<div class="sale" style="font-size: 13px;">{sale}%</div>
					</div>
					<div class="box_phanloai">
						<div class="title">Tình trạng: <span
								style="color: #fff;background: #f60;padding: 5px;padding-left: 10px;padding-right: 10px;border-radius: 5px;">{tinh_trang}</span>
						</div>
					</div>
					<div class="box_phanloai">
						<div class="attribute_group">
							<div class="attribute_container">
								<div class="title title_color">Màu sắc: <span>{color_active}</span></div>
							</div>
							<div class="attribute_container">
								<div class="title title_size">Kích cỡ: <span>{size_active}</span></div>
							</div>
						</div>
						<div class="attribute_group">
							<div class="attribute_container">
								<div class="list_phanloai list_color">{list_color}</div>
							</div>
							<div class="attribute_container">
								<div class="list_phanloai list_size">{list_size}</div>
							</div>
						</div>
					</div>
					<div class="box_action">
						<div class="quantity-container">
							<div class="box_quanlity">
								<button><i class="fa fa-minus"></i></button>
								<input type="text" name="so_luong" value="1">
								<button><i class="fa fa-plus"></i></button>
							</div>

							<button class="them_gio" {disabled} sp_id="{sp_id}" pl="" color="" size="" loai="{loai}">
								<img src="/skin/css/images/icon-header/icon_giohang.svg"> Thêm vào giỏ hàng
							</button>
						</div>
						<div class="add_cart">
							<button class="mua_ngay" {disabled} sp_id="{sp_id}" pl="" color="" size="" kho="kho"
								loai="{loai}">Mua Ngay</button>
						</div>
						<div class="support-container">
							<div class="zalo_support">
								<a href="https://zalo.me/0943.051.818" class="zalo-button">
									<i class="zalo-icon"></i> Tư vấn miễn phí
								</a>
							</div>
							<div class="hotline_support">
								<a href="tel:0943051818" class="hotline_button">
									<i class="fa fa-phone"></i>
									Hotline: 0943.051.818
								</a>
							</div>
						</div>
					</div>
					<div class="sticky-action">
						<button class="btn-consult">Tư vấn</button>
						<button class="btn-buy">Mua ngay</button>
					</div>
					<div class="hr"></div>
					<div class="contact-info">
						<p class="socdo-info">
							<b>Socdo.vn - Trên 5 năm Uy tín cung cấp<br> Dịch vụ Bán hàng & Thu tiền tại nhà toàn
								quốc</b>
						</p>
						<div class="call_buy">
							Gọi đặt mua <a href="tel:0943051818">0943.051.818</a> (08:15 - 22:00)
						</div>
						<div class="chat_buy">
							<a href="https://zalo.me/0943.051.818">
								<img src="/skin/css/images/zalo.png"> Chat để được Sóc Đỏ tư vấn ngay (08:15 - 22:00)
							</a>
						</div>
					</div>

					<!-- <div class="box_note_giaohang">
						<div class="title" style="text-align: center;">Miễn phí giao hàng nhanh toàn quốc <br> cho mọi
							đơn hàng bất kỳ</div>
						<div class="li_note"> <img src="/skin/css/images/fast_1.png"> Nội thành Hà Nội nhận hàng trong 1
							- 2 ngày</div>
						<div class="li_note"> <img src="/skin/css/images/time_1.png"> Ở tỉnh thành khác nhận hàng từ 2 -
							5 ngày</div>
					</div> -->
				</div>
			</div>
			<div class="shop-info-container">
				<div class="shop-left">
					<div class="shop-logo-wrapper">
						{shop_avatar}
					</div>
					<div class="shop-details">
						<h3 class="shop-name">{shop_name}</h3>
						<span class="online-status">Online 2 phút trước</span>
						<div class="shop-buttons">
							<div class="zalo_support">
								<a href="https://zalo.me/{shop_mobile}" class="zalo-button">
									<i class="zalo-icon"></i> Chat ngay
								</a>
							</div>
							<div class="zalo_support">
								<a href="/shop/{shop_username}/san-pham.html" class="zalo-button">
									<i class="shop-logo-icon"></i> Xem shop
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="shop-info-container">
					<div class="shop-right">
						{shop_info}
					</div>
				</div>
			</div>
			<script>
				let startTime = Math.floor(Date.now() / 1000) - 120;

				function updateOnlineStatus() {
					let timeDisplay = document.querySelector('.online-status');
					let currentTime = Math.floor(Date.now() / 1000);
					let timeDiff = currentTime - startTime;

					if (timeDiff < 120) {
						timeDisplay.textContent = 'Online';
					} else if (timeDiff < 3600) {
						timeDisplay.textContent = `Online ${Math.floor(timeDiff / 60)} phút trước`;
					} else if (timeDiff < 86400) {
						timeDisplay.textContent = `Online ${Math.floor(timeDiff / 3600)} giờ trước`;
					} else {
						timeDisplay.textContent = `Online ${Math.floor(timeDiff / 86400)} ngày trước`;
					}
				}

				// Gọi khi load
				updateOnlineStatus();

				// Cập nhật mỗi phút
				setInterval(updateOnlineStatus, 60000);

				document.addEventListener("DOMContentLoaded", function () {
					let stickyAction = document.querySelector(".sticky-action");
					let boxRightInfo = document.querySelector(".box_right_info");
					let stickyBuyBtn = document.querySelector(".btn-buy");
					let stickyConsultBtn = document.querySelector(".btn-consult");
					let muaNgayBtn = document.querySelector(".mua_ngay");
					let callBuyLink = document.querySelector(".call_buy a");

					function checkPosition() {
						let boxRect = boxRightInfo.getBoundingClientRect();

						if (boxRect.top <= window.innerHeight && boxRect.bottom >= 0) {
							stickyAction.style.bottom = "-100px";
						} else {
							stickyAction.style.bottom = "0";
						}
					}

					window.addEventListener("scroll", checkPosition);
					checkPosition();

					if (stickyBuyBtn && muaNgayBtn) {
						stickyBuyBtn.addEventListener("click", function () {
							muaNgayBtn.click();
						});
					}

					if (stickyConsultBtn && callBuyLink) {
						stickyConsultBtn.addEventListener("click", function () {
							window.location.href = callBuyLink.href;
						});
					}
				});

			</script>

			<script>
				document.addEventListener("DOMContentLoaded", function () {
					let stickyAction = document.querySelector(".sticky-action");
					let boxRightInfo = document.querySelector(".box_right_info");
					let stickyBuyBtn = document.querySelector(".btn-buy");
					let stickyConsultBtn = document.querySelector(".btn-consult");
					let muaNgayBtn = document.querySelector(".mua_ngay");
					let callBuyLink = document.querySelector(".call_buy a");

					function checkPosition() {
						let boxRect = boxRightInfo.getBoundingClientRect();

						if (boxRect.top <= window.innerHeight && boxRect.bottom >= 0) {
							stickyAction.style.bottom = "-100px";
						} else {
							stickyAction.style.bottom = "0";
						}
					}

					window.addEventListener("scroll", checkPosition);
					checkPosition();

					if (stickyBuyBtn && muaNgayBtn) {
						stickyBuyBtn.addEventListener("click", function () {
							muaNgayBtn.click();
						});
					}

					if (stickyConsultBtn && callBuyLink) {
						stickyConsultBtn.addEventListener("click", function () {
							window.location.href = callBuyLink.href;
						});
					}
				});

			</script>
			<script type="text/javascript">
				$(document).ready(function () {
					if ($('.box_phanloai .list_color .li_color.active').length > 0) {
						size = $('.box_phanloai .list_color .li_color.active').attr('size');
						color = $('.box_phanloai .list_color .li_color.active').attr('color');
						pl = $('.box_phanloai .list_color .li_color.active').attr('pl');
						$('button.them_gio').attr('size', size);
						$('button.them_gio').attr('color', color);
						$('button.them_gio').attr('pl', pl);
						$('button.mua_ngay').attr('size', size);
						$('button.mua_ngay').attr('color', color);
						$('button.mua_ngay').attr('pl', pl);
					}

				});
			</script>
			<div class="box_sanpham_lienquan">
				<div class="title">Sản phẩm liên quan</div>
				<div class="list_sanpham">
					<div class="swiper-container slide_lienquan">
						<div class="swiper-wrapper">
							{list_lienquan}
						</div>
						<div class="prev"><button><i class="fa fa-angle-left"></i></button></div>
						<div class="next"><button><i class="fa fa-angle-right"></i></button></div>
					</div>
				</div>
			</div>
			<div class="box_sanpham_chitiet">
				<div class="box_chitiet_left">
					<div class="mota_sanpham">
						<div class="mota_short">{noidung}</div>
						<div class="bg-article"></div>
						<a href="javascript:void(0)" class="btn-detail">
							<span>Xem thêm <i class="fa fa-angle-down"></i></span>
						</a>
					</div>
					{box_danhgia}
				</div>
				<div class="box_chitiet_right">
					<div class="title">Đặc điểm nổi bật</div>
					<div class="box_noibat">{noi_bat}</div>
					<div class="title">Thông số kỹ thuật</div>
					<div class="list_thongso">{list_thongso}</div>
				</div>
			</div>
		</div>
	</div>
	{footer}
	{script_footer}
	<script>
		$(document).ready(function () {
			$(".mota_sanpham *").css({ "font-family": "", "font-size": "13px;" });
		});
		if ($(window).width() < 480) {
			var sl = 1;
		} else if ($(window).width() < 768) {
			var sl = 2;
		} else if ($(window).width() < 960) {
			var sl = 4;
		}
		else {
			var sl = 5;
		}
		var slide_lienquan = new Swiper('.slide_lienquan', {
			direction: 'horizontal',
			slidesPerView: sl,
			loop: true,
			observer: true,
			observeParents: true,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			autoplay: {
				delay: 3000,
			},
			navigation: {
				nextEl: '.slide_lienquan .next',
				prevEl: '.slide_lienquan .prev',
				disabledClass: 'hide_button',
				hiddenClass: 'hide_button'
			},
		})
		var galleryTop = new Swiper('.slide_big', {
			spaceBetween: 10,
			slidesPerView: 1,
			navigation: {
				nextEl: '.big .next',
				prevEl: '.big .prev',
				disabledClass: 'hide_button',
				hiddenClass: 'hide_button'
			},
			loop: false,
			on: {
				slideChange: function () {
					var activeIndex = this.activeIndex;
					var small_active = $('.small .active').attr('data-index');
					var totalSlides = document.querySelectorAll('.small .swiper-wrapper > .swiper-slide').length;
					var smallSlides = document.querySelectorAll('.small .swiper-slide');
					if (activeIndex < small_active) {
						$('.small .prev button').click();
					} else {
						$('.small .next button').click();
					}
				},
			},
		});
		function slideTo(index) {
			galleryTop.slideTo(index, 300); 
		}
		var prevButton = document.querySelector('.small .prev button');
		var nextButton = document.querySelector('.small .next button');

		var totalSlides = document.querySelectorAll('.small .swiper-wrapper > .swiper-slide').length;
		var visibleSlides = 3;
		var currentSlideIndex = $('.small .active').attr('data-index');

		nextButton.addEventListener('click', function () {
			if (currentSlideIndex < totalSlides - visibleSlides) {
				currentSlideIndex++;
				moveSlides('next');
				$('.small .swiper-slide').removeClass('active');
				$('.small .swiper-slide[data-index=' + currentSlideIndex + ']').addClass('active');
				slideTo(currentSlideIndex);
			} else {
				if (currentSlideIndex < totalSlides - 1) {
					currentSlideIndex++;
					$('.small .swiper-slide').removeClass('active');
					$('.small .swiper-slide[data-index=' + currentSlideIndex + ']').addClass('active');
					slideTo(currentSlideIndex);
				} else {

				}
			}

		});

		prevButton.addEventListener('click', function () {
			if (currentSlideIndex > visibleSlides) {
				currentSlideIndex--;
				moveSlides('prev');
				slideTo(currentSlideIndex);
				$('.small .swiper-slide').removeClass('active');
				$('.small .swiper-slide[data-index=' + currentSlideIndex + ']').addClass('active');
			} else {
				if (currentSlideIndex > 0) {
					currentSlideIndex--;
					moveSlides('prev');
					slideTo(currentSlideIndex);
					$('.small .swiper-slide').removeClass('active');
					$('.small .swiper-slide[data-index=' + currentSlideIndex + ']').addClass('active');
				}

			}
		});

		function moveSlides(loai) {
			var slideHeight = document.querySelector('.small .swiper-slide').offsetHeight;
			if (loai == 'next') {
				var moveDistance = -currentSlideIndex * slideHeight - 5;
			} else {
				if (currentSlideIndex == totalSlides - 2) {
					var moveDistance = -slideHeight;

				} else {
					var moveDistance = -currentSlideIndex * slideHeight;
				}
			}

			document.querySelector('.small .swiper-wrapper').style.transform = 'translateY(' + moveDistance + 'px)';
		}

	</script>
	<div id='bk-modal'></div>

</body>
<style>
	html,
	body {
		max-width: 100%;
		position: relative;
	}

	@media (max-width: 768px) {
		img {
			max-width: 100%;
			height: auto;
		}

		html,
		body,
		.box_right_info {
			overflow-x: hidden;
		}
	}

	.price_info {
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.price_new {
		font-size: 18px;
		font-weight: bold;
	}

	.price_old {
		font-size: 13px;
		color: gray;
		text-decoration: line-through;
	}

	.shop-logo-wrapper {
		margin-bottom: 35px;
	}

	.shop-logo-icon {
		display: inline-block;
		width: 30px;
		height: 30px;
		background: url('/skin/css/images/shop-icon.png') no-repeat center/contain;
		vertical-align: middle;
		margin-right: 5px;
	}

	.shop-info-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 20px;
		border-radius: 10px;
		background: #f5f5f5;
		margin: 10px 20px 10px 0;
		text-align: center;
	}

	.shop-left {
		display: flex;
		align-items: center;
	}

	.shop-logo {
		width: 60px;
		height: 60px;
		border-radius: 50%;
		border: 1px solid #c0c0c0;
		background: #ede6e6;
		object-fit: cover;
		margin: 0 auto;
	}

	.favorite-badge {
		display: inline-block;
		background: #ee4d2d;
		color: #fff;
		padding: 2px 6px;
		border-radius: 4px;
		margin-left: -10px;
		font-size: 12px;
		position: relative;
		top: 10px;
	}

	.shop-details {
		margin-left: 15px;
	}

	.shop-name {
		margin: 0;
		font-size: 18px;
		font-weight: bold;
	}

	.online-status {
		color: gray;
		margin: 5px 0;
	}

	.shop-buttons {
		display: flex;
		gap: 10px;
	}

	.chat-button,
	.view-shop-button {
		border: 1px solid #ddd;
		padding: 6px 12px;
		border-radius: 5px;
		cursor: pointer;
	}

	.chat-button {
		background: #ffe1e1;
		color: #ee4d2d;
	}

	.shop-right {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 30px;
		text-align: left;
	}

	.info-item {
		display: flex;
		align-items: center;
		gap: 5px;
	}

	.info-title {
		color: #666;
	}

	.info-value {
		margin-left: 10px;
		color: #ee4d2d;
		font-weight: bold;
	}

	.contact-info {
		display: flex;
		flex-direction: column;
		align-items: center;
		margin: 20px auto;
		max-width: 90%;
		text-align: center;
	}

	.support-container {
		display: flex;
		justify-content: center;
		gap: 10px;
		width: 100%;
	}

	.hotline_support {
		margin-top: 30px;
	}

	.box_phanloai {
		display: flex;
		flex-wrap: wrap;
		gap: 20px;
		align-items: center;
		justify-content: flex-start;
	}

	.attribute_group {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 20px;
	}

	.attribute_container {
		display: flex;
		align-items: center;
		gap: 10px;
		flex-wrap: nowrap;
	}

	.title {
		font-weight: bold;
		white-space: nowrap;
	}

	.list_phanloai {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
	}

	.list_phanloai.list_size {
		gap: 8px;
	}

	.list_size .li_size {
		min-width: 45px;
		height: 35px;
		padding: 0 12px;
		border: 1px solid #e0e0e0;
		border-radius: 4px;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		font-size: 14px;
		color: #333;
		background: #fff;
		transition: all 0.2s ease;
		position: relative;
	}

	.list_size .li_size:hover:not(.disabled) {
		border-color: #f60;
		color: #f60;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	}

	.list_size .li_size.active {
		border-color: #f60;
		background: #fff;
		color: #f60;
		font-weight: 500;
	}

	.list_size .li_size.active::after {
		content: '';
		position: absolute;
		bottom: -1px;
		right: -1px;
		width: 0;
		height: 0;
		border: solid 0 0 8px 8px;
		border-color: transparent transparent #f60 transparent;
	}

	.list_size .li_size.disabled {
		background: #f5f5f5;
		border-color: #e0e0e0;
		color: #999;
		cursor: not-allowed;
		position: relative;
	}

	.list_size .li_size.disabled::before {
		content: '';
		position: absolute;
		top: 50%;
		left: 0;
		right: 0;
		border-top: 1px solid #ccc;
		transform: rotate(-35deg);
	}

	.sticky-action {
		display: none;
	}

	@media (max-width: 768px) {
		.sanpham_detail .box_info_sanpham .box_right_info .box_action {
			width: 85%;
			display: flex;
			justify-content: flex-start;
			flex-wrap: wrap;
			gap: 20px;
			padding-bottom: 0;
			margin-bottom: 0;
		}

		.hotline_support {
			margin-top: 31px;
			text-align: center;
		}

		.zalo_support a,
		.hotline_support a {
			flex: 1;
			max-width: 95%;
			font-size: 14px;
		}

		.contact-info {
			max-width: 100%;
			padding-left: 0;
		}

		.call_buy,
		.chat_buy {
			text-align: center;
			width: 100%;
		}

		.chat_buy img {
			display: inline-block;
			vertical-align: middle;
		}

		.box_phanloai {
			flex-direction: column;
			align-items: flex-start;
			gap: 10px;
		}

		.attribute_group {
			flex-wrap: nowrap;
			justify-content: flex-start;
			width: 100%;
		}

		.attribute_container {
			flex-wrap: nowrap;
			width: 100%;
		}

		.list_phanloai {
			gap: 5px;
		}

		.list_color div,
		.list_size div {
			padding: 6px 10px;
			border-radius: 15px;
			border: 2px solid red;
			font-size: 14px;
			text-align: center;
			cursor: pointer;
			min-width: 35px;
			background: #fff;
			transition: all 0.3s ease-in-out;
		}

		.list_color div:hover,
		.list_size div:hover {
			background: red;
			color: white;
		}

		.quantity-container {
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 15px;
			width: 100%;
		}

		.box_quanlity {
			display: flex;
			align-items: center;
			gap: 5px;
		}

		.box_quanlity button {
			width: 30px;
			height: 30px;
			border: 1px solid #ccc;
			background: #f9f9f9;
			cursor: pointer;
			font-size: 16px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 5px;
		}

		.box_quanlity input {
			width: 40px;
			text-align: center;
			font-size: 16px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}

		.box_action {
			display: flex;
			flex-direction: column;
			gap: 10px;
			align-items: center;
			width: 100%;
		}

		.them_gio,
		.mua_ngay {
			width: 90%;
			padding: 12px;
			font-size: 16px;
			text-align: center;
			border-radius: 8px;
			border: none;
		}

		.them_gio {
			background: black;
			color: white;
		}

		.mua_ngay {
			background: #f60;
			color: white;
		}

		.support-container {
			justify-content: space-between;
			width: 117%;
			flex-wrap: nowrap;
		}

		.zalo_support a,
		.hotline_support a {
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 5px;
			font-size: 14px;
			text-decoration: none;
			width: 100%;
			font-weight: bold;
		}

		.zalo_support a {
			background: #0084ff;
			color: white;
		}

		.hotline_support a {
			background: #17b72c;
			color: white;
		}

		.sticky-action {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
			display: flex;
			justify-content: space-between;
			background: white;
			box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
			z-index: 999;
		}

		.sticky-action button {
			width: 50%;
			padding: 14px;
			font-size: 16px;
			text-align: center;
			font-weight: bold;
			border: none;
			color: white;
			cursor: pointer;
		}

		.btn-buy {
			background: #f60;
		}

		.btn-consult {
			background: #17b72c;
		}

		.list_size .li_size {
			min-width: 40px;
			height: 32px;
			padding: 0 10px;
			font-size: 13px;
		}

		.list_phanloai.list_size {
			gap: 6px;
		}

		.shop-info-container {
			flex-direction: column;
			align-items: flex-start;
			padding: 15px;
			margin: 10px 0;
			gap: 15px;
		}

		.shop-left {
			flex-direction: column;
			align-items: center;
			width: 100%;
			text-align: center;
		}

		.shop-logo {
			width: 50px;
			height: 50px;
		}

		.favorite-badge {
			margin-left: 0;
			top: 5px;
		}

		.shop-details {
			margin: 10px 0 0;
		}

		.shop-name {
			font-size: 16px;
		}

		.online-status {
			font-size: 12px;
		}

		.shop-buttons {
			justify-content: center;
			width: 100%;
		}

		.chat-button,
		.view-shop-button {
			padding: 5px 10px;
			font-size: 12px;
		}

		.shop-right {
			grid-template-columns: repeat(2, 1fr);
			gap: 10px;
			width: 100%;
			text-align: center;
		}

		.info-item {
			flex-direction: column;
			align-items: flex-start;
		}

		.info-title {
			font-size: 12px;
		}

		.info-value {
			margin-left: 0;
			font-size: 12px;
		}
	}
</style>
<script>
	const colorOptions = document.querySelectorAll('.li_color');
	const sizeOptions = document.querySelectorAll('.li_size');

	colorOptions.forEach(color => {
		color.addEventListener('click', function () {
			colorOptions.forEach(c => c.classList.remove('active'));
			this.classList.add('active');

			sizeOptions.forEach(size => {
				size.classList.remove('disabled');
			});

			console.log('Đã chọn màu:', this.getAttribute('color'));
		});
	});

	sizeOptions.forEach(size => {
		size.addEventListener('click', function () {
			if (!this.classList.contains('disabled')) {
				sizeOptions.forEach(s => s.classList.remove('active'));
				this.classList.add('active');

				const selectedSize = this.getAttribute('tieu_de');
				const price = this.getAttribute('gia_moi');
				console.log('Đã chọn kích thước:', selectedSize, 'Giá:', price);
			}
		});
	});
</script>
<script>
	$(document).ready(function () {
		$('.list_color .li_color').on('click', function () {
			var sp_id = $(this).attr('sp_id');
			var color = $(this).attr('color');
			var ten_color = $(this).attr('tieu_de');

			$('.color-active').text(ten_color);
			$('.list_color .li_color').removeClass('active');
			$(this).addClass('active');

			loadPriceByPhanloai(sp_id, color, '');
		});

		$(document).on('click', '.list_size .li_size:not(.disabled)', function () {
			var sp_id = $('.list_color .li_color.active').attr('sp_id');
			var color = $('.list_color .li_color.active').attr('color');
			var size = $(this).attr('size');
			var ten_size = $(this).attr('tieu_de');

			$('.size-active').text(ten_size);
			$('.list_size .li_size').removeClass('active');
			$(this).addClass('active');

			loadPriceByPhanloai(sp_id, color, size);
		});
	});
</script>

</html>