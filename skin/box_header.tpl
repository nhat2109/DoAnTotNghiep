<?php
	global $conn;
	$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
	while ($r_s=mysqli_fetch_assoc($setting)) {
		$index_setting[$r_s['name']]=$r_s['value'];
	}
?>
<header>
	{banner_top}
	<div class="top-header">
		<div class="container">
			<div class="topbar">
				<div class="kenh_ban">
					<a href="/dangky-ncc.html"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Kênh nhà cung
						cấp</a>
					<a href="/dangky-banhang.html"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Kênh
						dropship</a>
				</div>
				<div class="text_top">
					<!-- <?php echo $index_setting['title_link_top'];?>
					<a href="<?php echo $index_setting['link_top'];?>">Đến ngay <i
						class="fa fa-long-arrow-right"></i></a> -->
						<a href="/setup-domain.php" class="text_pc"><i class="fa fa-server" aria-hidden="true"></i> Quản lý công việc</a>
						<a href="/setup-domain.php" class="text_mobile"><i class="fa fa-server" aria-hidden="true"></i> Quản lý công việc</a>
				</div>
			</div>
		</div>
	</div>
	<div class="main-header-mobile">
		<div class="container">
			<div class="row">
				<div class="button_menu">
					<i class="fa fa-th-list"></i>
				</div>
				<div class="logo_mobile">
					<a href="/">
						<img src="{logo}" alt="logo">
					</a>
				</div>
				<div class="cart_mobile">
					<a href="/gio-hang.html" class="button-cart" title="Giỏ hàng">
						<i class="fa fa-shopping-bag"></i>
						<span class="count_item">
							<?php echo count((array)$_SESSION['cart']);?>
						</span>
					</a>
				</div>
			</div>
			<!-- Chức năng tìm kiếm nâng cao -->
			<div class="box_search">
				<div class="input_search">
					<input type="text" id="key_mobile" name="key_mobile" placeholder="Tìm kiếm sản phẩm"
						autocomplete="off">
					<button type="button"><i class="fa fa-search"></i></button>
					<button type="button" id="voiceSearchBtn_mobile"><i class="fa fa-microphone"></i></button>
				</div>
				<ul id="output_search_mobile">
					<li>
						<button id="closeOutputSearchMobile" class="close-btn">✖</button>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="main-header">
		<div class="container">
			<div class="logo">
				<a href="/">
					<img src="{logo}" alt="logo">
				</a>
			</div>

			<!-- <div class="box_menu">
				<div class="menu_item">
					<a class="danh-muc"><i style="col" class="fa fa-tasks"></i> Danh mục</a>
					<div class="dropdown-content new-dropdown-content">
						<div class="menu-parent">
							{list_danhmuc}
						</div>
						<div class="menu-child">
							{list_danhmuc_sub}
						</div>
					</div>
				</div>
			</div> -->
			<script>
				document.addEventListener('DOMContentLoaded', function () {
					// Lấy các phần tử cần thiết
					const boxMenu = document.querySelector('.box_menu');
					const parentItems = document.querySelectorAll('.new-parent-menu li.parent-item');

					// Hàm kích hoạt submenu theo data-target
					function activateSubmenu(targetId) {
						// Tìm tất cả các submenu và loại bỏ lớp active
						document.querySelectorAll('.submenu').forEach(sub => {
							sub.classList.remove('active');
						});
						// Tìm submenu có id tương ứng và thêm class active
						const submenu = document.getElementById(targetId);
						if (submenu) {
							submenu.classList.add('active');
						}
					}

					// Khi hover vào toàn bộ box_menu, kích hoạt submenu của mục cha đầu tiên
					boxMenu.addEventListener('mouseenter', function () {
						if (parentItems.length > 0) {
							// Lấy phần tử cha đầu tiên
							const firstItem = parentItems[0];
							const target = firstItem.getAttribute('data-target'); // ví dụ: "submenu-1"
							activateSubmenu(target);

							// Optionally: đánh dấu active cho mục cha đầu tiên
							parentItems.forEach(item => item.classList.remove('hover-active'));
							firstItem.classList.add('hover-active');
						}
					});

					// Khi hover vào từng mục cha, kích hoạt submenu tương ứng
					parentItems.forEach(item => {
						item.addEventListener('mouseenter', function () {
							// Loại bỏ active của tất cả mục cha
							parentItems.forEach(el => el.classList.remove('hover-active'));
							// Thêm active cho mục đang hover
							this.classList.add('hover-active');
							// Kích hoạt submenu dựa trên data-target
							const target = this.getAttribute('data-target');
							activateSubmenu(target);
						});
					});
				});
			</script>

			<script>
				document.addEventListener('DOMContentLoaded', function () {
					const parentItems = document.querySelectorAll('.parent-item');
					const submenus = document.querySelectorAll('.submenu');
					const dropdown = document.querySelector('.new-dropdown-content');

					parentItems.forEach(item => {
						item.addEventListener('mouseover', function () {
							// Ẩn tất cả submenu và xóa class hover-active
							submenus.forEach(submenu => submenu.classList.remove('active'));
							parentItems.forEach(parent => parent.classList.remove('hover-active'));

							// Hiển thị submenu tương ứng và thêm class hover-active
							const targetId = item.getAttribute('data-target');
							const targetSubmenu = document.getElementById(targetId);
							if (targetSubmenu) {
								targetSubmenu.classList.add('active');
								item.classList.add('hover-active');
							}
						});
					});

					// Khi hover vào submenu, giữ hiệu ứng cho danh mục cha
					submenus.forEach(submenu => {
						submenu.addEventListener('mouseover', function () {
							const targetId = submenu.id;
							const parentItem = document.querySelector(`.parent-item[data-target="${targetId}"]`);
							if (parentItem) {
								parentItem.classList.add('hover-active');
							}
						});
					});

					// Khi rời khỏi dropdown, xóa hiệu ứng và ẩn submenu
					dropdown.addEventListener('mouseleave', function () {
						submenus.forEach(submenu => submenu.classList.remove('active'));
						parentItems.forEach(parent => parent.classList.remove('hover-active'));
					});
				});

			</script>
			<div class="form_search">
				<!-- Chức năng tìm kiếm nâng cao -->
				<div class="input_search">
					<input type="text" name="key" id="key" placeholder="Tìm kiếm sản phẩm" autocomplete="off">
					<button type="button"><i class="fa fa-search"></i></button>
					<button type="button" id="voiceSearchBtn"><i class="fa fa-microphone"></i></button>
				</div>
				<ul id="output_search">
				</ul>
			</div>
			<div class="box_control">
				<a href="javascript:;" class="show_login"><img
						src="/skin/css/images/icon-header/icon_user_not_login.svg" alt="icon user"></a>
				<a href="/gio-hang.html">
					<img src="/skin/css/images/icon-header/icon_giohang.svg" alt="icon giỏ hàng">
					<span class="count_item">
						<?php echo count((array)$_SESSION['cart']);?>
					</span>
				</a>
			</div>
		</div>
	</div>
	<!-- <div class="sub-header">
		<div class="container">
			<button class="btn-prev" onclick="scrollContent(-500)">&#9664;</button>
			<ul
				style="border:1px white solid; background-color: #e97213; border-radius: 20px; padding: 4px 8px 4px 31px;">
				{list_category_top}
			</ul>
			<button class="btn-next" onclick="scrollContent(200)">&#9654;</button>
		</div>
	</div> -->
</header>

<script>
	function scrollContent(value) {
		const container = document.querySelector('.sub-header ul');
		container.scrollLeft += value;
	}
</script>
<script src="https://unpkg.com/@ffmpeg/ffmpeg@0.11.0/dist/ffmpeg.min.js"></script>
<!-- Chức năng tìm kiếm nâng cao -->
<script>

	/* CSS cho phần box_danhmuc_noibat_timkiem */
	$(document).ready(function () {
		var defaultSuggestions = `
			
            <button id="closeOutputSearch" class="close-btn">✖</button>
        	<li>
				<div class="title_box_timkiem" style="--background: url('{bg_box_noibat}');">
                	<img style=" width:5% !important;" src="{icon_box_noibat}" alt=""> Danh mục nổi bật
				</div>
			</li>
			  <div class="box_danhmuc_noibat_timkiem">
				<div class="container" style="height: 100% !important;">
					
					<div class="list_danhmuc_timkiem" id="slide_danhmuc_noibat_timkiem">
							{list_danhmuc_noibat_timkiem}
					</div>
					 
				</div>
			</div>
		`;
		// Ẩn output_search khi click vào nút "X"
		$(document).on("click", ".close-btn", function () {
			$("#output_search").hide();
		});
		$("#key").on("focus", function () {
			$("#output_search").html(defaultSuggestions).show();
		});

		// Hiển thị lịch sử tìm kiếm từ cookie khi focus vào ô input
		$("#key").on("focus", function () {
			let searchHistory = getSearchHistory();
			if (searchHistory.length > 0) {
				let historyHtml = `<li><strong>Lịch sử tìm kiếm</strong></li>`;
				searchHistory.forEach(keyword => {
					historyHtml += `
					<li>
						<a href="/tim-kiem.html?key=${encodeURIComponent(keyword)}">
							<i class="fas fa-history"></i> ${keyword}
						</a>
						<span class="delete-keyword" data-key="${keyword}">✖</span>
						
					</li>`;
				});
				$("#output_search").html(historyHtml + defaultSuggestions).show();
			} else {
				$("#output_search").html(defaultSuggestions).show();
			}
		});


		// Xử lý tìm kiếm khi nhập từ khóa

		$("#key").on("keyup", function () {
			var key = $(this).val().trim();
			if (key !== "") {
				$.ajax({
					url: "/process.php",
					method: "POST",
					data: { action: 'filter_search', key: key },
					success: function (data) {
						let searchHistory = getSearchHistory();
						let historyHtml = "";

						if (searchHistory.length > 0) {
							historyHtml = `<li><strong>Lịch sử tìm kiếm</strong></li>`;
							searchHistory.forEach(keyword => {
								historyHtml += `
									<li>
										<a href="/tim-kiem.html?key=${encodeURIComponent(keyword)}">
											<i class="fas fa-history"></i> ${keyword}
										</a>
										<span class="delete-keyword" data-key="${keyword}">✖</span>
									</li>`;
							});
						}
						$("#output_search").html(historyHtml + data + defaultSuggestions).show();
					}
				});
			} else {
				let searchHistory = getSearchHistory();
				if (searchHistory.length > 0) {
					let historyHtml = `<li><strong>Lịch sử tìm kiếm</strong></li>`;
					searchHistory.forEach(keyword => {
						historyHtml += `
							<li>
								<a href="/tim-kiem.html?key=${encodeURIComponent(keyword)}">
									<i class="fas fa-history"></i> ${keyword}
								</a>
								<span class="delete-keyword" data-key="${keyword}">✖</span>
							</li>`;
					});
					$("#output_search").html(historyHtml + defaultSuggestions).show();
				} else {
					$("#output_search").html(defaultSuggestions).show();
				}
			}
		});



		// Ẩn gợi ý khi click ra ngoài
		$(document).on("click", function (e) {
			if (!$(e.target).closest(".form_search").length) {
				$("#output_search").hide();
			}
		});
		// Ẩn output_search khi click vào nút "X"
		$(document).on("click", ".close-btn", function () {
			$("#output_search").hide();
		});

		// Lưu từ khóa vào cookie khi nhấn Enter
		$("#key").on("keypress", function (e) {
			if (e.which == 13) { // Nhấn Enter
				let keyword = $(this).val().trim();
				if (keyword !== "") {
					saveSearchHistory(keyword);
					window.location.href = "?key=" + encodeURIComponent(keyword);
				}
			}
		});
		$(".input_search button").on("click", function () {
			let keyword = $("#key").val().trim();
			if (keyword !== "") {
				saveSearchHistory(keyword); // Lưu lịch sử tìm kiếm
			}
		});
		// Hàm lấy lịch sử tìm kiếm từ cookie
		function getSearchHistory() {
			let history = localStorage.getItem("search_history");
			return history ? JSON.parse(history) : [];
		}

		// Hàm lưu từ khóa tìm kiếm vào localStorage
		function saveSearchHistory(keyword) {
			let history = getSearchHistory();

			// Xóa từ khóa trùng trước khi thêm
			history = history.filter(item => item !== keyword);

			// Thêm từ khóa mới vào đầu danh sách
			history.unshift(keyword);

			// Nếu danh sách vượt quá 5 phần tử, xóa phần tử cũ nhất
			if (history.length > 3) {
				history.pop(); // Xóa phần tử cuối cùng (cũ nhất)
			}

			// Lưu vào localStorage
			localStorage.setItem("search_history", JSON.stringify(history));
		}
		$(document).on("click", ".delete-keyword", function (e) {
			e.preventDefault();
			e.stopPropagation(); // Ngăn chặn sự kiện click lan truyền lên các phần tử cha

			let keyword = $(this).data("key");

			let history = getSearchHistory();
			history = history.filter(item => item !== keyword); // Xóa từ khóa khỏi danh sách

			localStorage.setItem("search_history", JSON.stringify(history)); // Cập nhật localStorage

			$(this).parent().remove(); // Xóa khỏi giao diện

			// Kiểm tra lại số lượng từ khóa còn lại
			if ($("#output_search li").length === 0) { // Không còn từ khóa nào
				$("#output_search").html(defaultSuggestions).show(); // Hiển thị gợi ý mặc định
			}
		});
	});


</script>
<style>
	.btn-prev,
	.btn-next {
		background-color: #e97213;
		color: #604e4e;
		border: none;
		border-radius: 50%;
		width: 32px;
		height: 32px;
		cursor: pointer;
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 99;
	}

	.sub-header .container {
		display: flex;
		align-items: center;
		position: relative;
	}

	.sub-header ul {
		display: flex;
		gap: 12px;
		overflow-x: auto;
		scrollbar-width: smooth;
		max-width: 100%;
		white-space: nowrap;
	}

	.sub-header ul li {
		height: 100%;
		/* Giới hạn chiều cao của các mục */
		line-height: 10px;
		/* Căn chỉnh nội dung theo chiều cao */
		padding-left: 20px;
	}

	.sub-header ul::-webkit-scrollbar {
		height: 2px;
	}

	.sub-header ul::-webkit-scrollbar-track {
		background: transparent;
	}

	.btn-prev {
		left: 0;
	}

	.btn-next {
		right: 0;
	}

	#output_search li {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 10px;
		border-bottom: 1px solid #eee;
	}

	.delete-keyword {
		float: right;
		color: red;
		cursor: pointer;
		font-size: 14px;
	}

	.delete-keyword:hover {
		color: darkred;
	}

	#output_search {
		padding-top: 6px !important;
		top: 0%;
		left: 41%;
		background: #fff;
		width: 43%;
		z-index: 1000;
		list-style: none;
		padding: 10px;
		border-radius: 8px !important;
		margin: 0;
		border: 1px solid #ddd;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		max-height: 400px;
		overflow-y: auto;
		display: none;
		/* Ẩn mặc định */
		border-radius: 5px;
	}

	@media (max-width: 768px) {


		#output_search {
			width: 81% !important;
			left: 2% !important;
			max-height: 300px !important;
			overflow-y: auto !important;
			-webkit-overflow-scrolling: touch;
			/* Cuộn mượt trên mobile */
		}
	}

	#output_search li {
		padding: 10px;
		border-bottom: 1px solid #eee;
	}

	#output_search li:last-child {
		border-bottom: none;
	}

	#output_search li strong {
		font-size: 16px;
		color: #333;
	}

	#output_search a {
		text-decoration: none;
		color: #333;
		font-size: 14px;
		display: flex;
		align-items: center;
	}

	#output_search a i {
		margin-right: 8px;
		color: #888;
	}

	#output_search li:hover {
		background: #f8f9fa;
	}

	.list-group {
		padding: 10px;
	}

	.row {
		display: flex;
		align-items: center;
	}

	.col-2 {
		flex: 0 0 60px;
	}

	.image img {
		width: 50px;
		height: 50px;
		border-radius: 4px;
		object-fit: cover;
	}

	.col-10 {
		flex: 1;
		padding-left: 10px;
	}

	.name_product a {
		font-size: 14px;
		font-weight: bold;
		color: #222;
		display: block;
		margin-bottom: 5px;
	}

	.price_product_new {
		font-size: 14px;
		font-weight: bold;
		color: #d0021b;
	}

	.price_product_old {
		font-size: 13px;
		color: #888;
	}

	.price_product_old del {
		text-decoration: line-through;
	}
</style>
<script>


	$(document).ready(function () {
		var defaultSuggestions = `
           <button id="closeOutputSearchMobile" class="close-btn">✖</button>
		   <li>
				<div class="title_box_timkiem" style="--background: url('{bg_box_noibat}');">
                	<img style=" width:5% !important;" src="{icon_box_noibat}" alt=""> Danh mục nổi bật
				</div>
		</li>
		<div class="box_danhmuc_noibat_timkiem">
				<div class="container">
					<div class="list_danhmuc_timkiem" id="slide_danhmuc_noibat_timkiem">
							{list_danhmuc_noibat_timkiem}
					</div>
				</div>
			</div>
			
		`;
		/*
		
		*/
		$("#key_mobile").on("focus", function () {
			$("#output_search_mobile").html(defaultSuggestions).show();
		});

		$(document).on("click", ".close-btn", function () {
			$("#output_search_mobile").addClass("hidden");
		});
		// Hiển thị lịch sử tìm kiếm từ cookie khi focus vào ô input
		$("#key_mobile").on("focus", function () {

			let searchHistory = getSearchHistory();
			if (searchHistory.length > 0) {
				let historyHtml = `<li><strong>Lịch sử tìm kiếm</strong></li>`;
				searchHistory.forEach(keyword => {
					historyHtml += `
					<li>
						<a href="/tim-kiem.html?key=${encodeURIComponent(keyword)}">
							<i class="fas fa-history"></i> ${keyword}
						</a>
						<span class="delete-keyword" data-key="${keyword}">✖</span>
						
					</li>`;
				});
				$("#output_search_mobile").html(historyHtml + defaultSuggestions).show();
			} else {
				$("#output_search_mobile").html(defaultSuggestions).show();
			}
		});


		// Xử lý tìm kiếm khi nhập từ khóa

		$("#key_mobile").on("keyup", function () {
			var key = $(this).val().trim();
			if (key !== "") {
				$.ajax({
					url: "/process.php",
					method: "POST",
					data: { action: 'filter_search', key: key },
					success: function (data) {
						let searchHistory = getSearchHistory();
						let historyHtml = "";

						if (searchHistory.length > 0) {
							historyHtml = `<li><strong>Lịch sử tìm kiếm</strong></li>`;
							searchHistory.forEach(keyword => {
								historyHtml += `
									<li>
										<a href="/tim-kiem.html?key=${encodeURIComponent(keyword)}">
											<i class="fas fa-history"></i> ${keyword}
										</a>
										<span class="delete-keyword" data-key="${keyword}">✖</span>
									</li>`;
							});
						}
						$("#output_search_mobile").html(historyHtml + data + defaultSuggestions).show();
					}
				});
			} else {
				let searchHistory = getSearchHistory();
				if (searchHistory.length > 0) {
					let historyHtml = `<li><strong>Lịch sử tìm kiếm</strong></li>`;
					searchHistory.forEach(keyword => {
						historyHtml += `
							<li>
								<a href="/tim-kiem.html?key=${encodeURIComponent(keyword)}">
									<i class="fas fa-history"></i> ${keyword}
								</a>
								<span class="delete-keyword" data-key="${keyword}">✖</span>
							</li>`;
					});
					$("#output_search_mobile").html(historyHtml + defaultSuggestions).show();
				} else {
					$("#output_search_mobile").html(defaultSuggestions).show();
				}
			}
		});



		// Ẩn gợi ý khi click ra ngoài
		$(document).on("click", function (e) {
			if (!$(e.target).closest(".box_search").length) {
				$("#output_search_mobile").hide();
			}
		});
		// Ẩn output_search_mobile khi click vào nút "X"
		$(document).on("click", ".close-btn", function () {
			$("#output_search_mobile").hide();
		});

		// Lưu từ khóa vào cookie khi nhấn Enter
		$("#key_mobile").on("keypress", function (e) {
			if (e.which == 13) { // Nhấn Enter
				let keyword = $(this).val().trim();
				if (keyword !== "") {
					saveSearchHistory(keyword);
					window.location.href = "?key=" + encodeURIComponent(keyword);
				}
			}
		});
		$(".input_search button").on("click", function () {
			let keyword = $("#key_mobile").val().trim();
			if (keyword !== "") {
				saveSearchHistory(keyword); // Lưu lịch sử tìm kiếm
			}
		});
		// Hàm lấy lịch sử tìm kiếm từ cookie
		function getSearchHistory() {
			let history = localStorage.getItem("search_history");
			return history ? JSON.parse(history) : [];
		}

		// Hàm lưu từ khóa tìm kiếm vào localStorage
		function saveSearchHistory(keyword) {
			let history = getSearchHistory();

			// Xóa từ khóa trùng trước khi thêm
			history = history.filter(item => item !== keyword);

			// Thêm từ khóa mới vào đầu danh sách
			history.unshift(keyword);

			// Nếu danh sách vượt quá 5 phần tử, xóa phần tử cũ nhất
			if (history.length > 3) {
				history.pop(); // Xóa phần tử cuối cùng (cũ nhất)
			}

			// Lưu vào localStorage
			localStorage.setItem("search_history", JSON.stringify(history));
		}
		$(document).on("click", ".delete-keyword", function (e) {
			e.preventDefault();
			e.stopPropagation(); // Ngăn chặn sự kiện click lan truyền lên các phần tử cha

			let keyword = $(this).data("key_mobile");

			let history = getSearchHistory();
			history = history.filter(item => item !== keyword); // Xóa từ khóa khỏi danh sách

			localStorage.setItem("search_history", JSON.stringify(history)); // Cập nhật localStorage

			$(this).parent().remove(); // Xóa khỏi giao diện

			// Kiểm tra lại số lượng từ khóa còn lại
			if ($("#output_search_mobile li").length === 0) { // Không còn từ khóa nào
				$("#output_search_mobile").html(defaultSuggestions).show(); // Hiển thị gợi ý mặc định
			}
		});


	});
	// giong noi
	/*

	
	document.addEventListener("DOMContentLoaded", function () {

		const voiceBtn = document.getElementById("voiceSearchBtn");
		const voiceBtn_mobile = document.getElementById("voiceSearchBtn_mobile");
		const searchInput = document.getElementById("key");
		const searchInput_mobile = document.getElementById("key_mobile");
		if ('webkitSpeechRecognition' in window) {
			const recognition = new webkitSpeechRecognition();
			recognition.continuous = false;
			recognition.interimResults = false;
			recognition.lang = "vi-VN"; // Ngôn ngữ tiếng Việt

			voiceBtn.addEventListener("click", function () {
				recognition.start();
			});
			voiceBtn_mobile.addEventListener("click", function () {
				recognition.start();
			});

			recognition.onresult = async function (event) {
				const transcript = event.results[0][0].transcript;
				searchInput_mobile.value = transcript; // Gán kết quả vào ô input
				searchInput.value = transcript; // Gán kết quả vào ô input
				
				// Gửi transcript đến Wit.ai
				try {
					const response = await fetch("speech-to-text.php", {
						method: "POST",
						body: JSON.stringify({ text: transcript }),
						headers: { "Content-Type": "application/json" }
					});

					const data = await response.json();
					console.log("Kết quả từ Wit.ai:", data);
				} catch (err) {
					console.error("Lỗi giao tiếp với Wit.ai:", err);
				}
			};

			recognition.onerror = function (event) {
				console.error("Lỗi nhận diện giọng nói:", event.error);
			};
		} else {
			alert("Trình duyệt của bạn không hỗ trợ ghi âm giọng nói.");
		}
	});
	*/

	document.addEventListener("DOMContentLoaded", function () {
		const voiceBtn = document.getElementById("voiceSearchBtn");
		const voiceBtn_mobile = document.getElementById("voiceSearchBtn_mobile");
		const searchInput = document.getElementById("key");
		const searchInput_mobile = document.getElementById("key_mobile");

		if ('webkitSpeechRecognition' in window) {
			const recognition = new webkitSpeechRecognition();
			recognition.continuous = false;
			recognition.interimResults = false;
			recognition.lang = "vi-VN"; // Ngôn ngữ tiếng Việt

			voiceBtn.addEventListener("click", function () {
				recognition.start();
			});
			voiceBtn_mobile.addEventListener("click", function () {
				recognition.start();
			});

			recognition.onresult = function (event) {
				const transcript = event.results[0][0].transcript;
				searchInput_mobile.value = transcript; // Gán kết quả vào ô input
				searchInput.value = transcript; // Gán kết quả vào ô input
			};

			recognition.onerror = function (event) {
				console.error("Lỗi nhận diện giọng nói:", event.error);
				alert("Chỉ hỗ trợ file WAV hoặc WebM. Vui lòng thử lại.");
			};
		} else {
			alert("Trình duyệt của bạn không hỗ trợ ghi âm giọng nói.");
		}
	});


	document.addEventListener("DOMContentLoaded", function () {
		const slider = document.getElementById("slide_danhmuc_noibat_timkiem");

		let isDown = false;
		let startX;
		let scrollLeft;

		slider.addEventListener("mousedown", (e) => {
			isDown = true;
			slider.classList.add("active");
			startX = e.pageX - slider.offsetLeft;
			scrollLeft = slider.scrollLeft;
		});

		slider.addEventListener("mouseleave", () => {
			isDown = false;
			slider.classList.remove("active");
		});

		slider.addEventListener("mouseup", () => {
			isDown = false;
			slider.classList.remove("active");
		});

		slider.addEventListener("mousemove", (e) => {
			if (!isDown) return;
			e.preventDefault();
			const x = e.pageX - slider.offsetLeft;
			const walk = (x - startX) * 2; // Tăng tốc độ cuộn
			slider.scrollLeft = scrollLeft - walk;
		});

		// Cho phép kéo bằng cảm ứng trên mobile
		slider.addEventListener("touchstart", (e) => {
			isDown = true;
			startX = e.touches[0].pageX - slider.offsetLeft;
			scrollLeft = slider.scrollLeft;
		});

		slider.addEventListener("touchmove", (e) => {
			if (!isDown) return;
			const x = e.touches[0].pageX - slider.offsetLeft;
			const walk = (x - startX) * 2;
			slider.scrollLeft = scrollLeft - walk;
		});

		slider.addEventListener("touchend", () => {
			isDown = false;
		});
	});



</script>
<style>
	#output_search_mobile li {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 10px;
		border-bottom: 1px solid #eee;
	}

	#output_search_mobile {
		position: absolute;

		top: 100%;
		left: 41%;
		background: #fff;
		width: 43%;
		z-index: 1000;
		list-style: none;
		padding-bottom: 20px !important;
		border-radius: 8px !important;
		margin: 0;
		border: 1px solid #ddd;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		max-height: 400px;
		overflow-y: auto;
		display: none;
		/* Ẩn mặc định */
		border-radius: 5px;
	}



	/* CSS cho phần box_danhmuc_noibat_timkiem */
	.box_danhmuc_noibat_timkiem {
		height: 150px;
	}

	.li_danhmuc_content_timkiem {
		background: #ffffff;
		border-radius: 10px;
		padding: 5px;
		/* Giảm padding */
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: space-between;
		height: 100%;
	}

	.minh_hoa_timkiem img {

		object-fit: contain;
		/* Đảm bảo không bị méo ảnh */
		display: block;
	}

	.tieu_de_timkiem {
		font-size: 12px;
		/* Giảm kích thước chữ */
		font-weight: 600;
		text-align: center;
		white-space: nowrap;
		/* Ngăn chữ bị xuống dòng */
		overflow: hidden;
		text-overflow: ellipsis;
		/* Nếu quá dài thì hiển thị dấu "..." */
		width: 100%;
	}

	/* Đảm bảo tất cả các ô có chiều cao bằng nhau */
	.list_danhmuc_timkiem {
		padding-top: 20px;
		height: 55%;
		position: relative;
		top: 0px;
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
		/* Giảm khoảng cách giữa các ô */
		overflow: hidden;
		max-height: 200px;
		/* Giới hạn chiều cao để hiển thị tối đa 2 hàng */
		transition: max-height 0.3s ease-in-out;
	}

	.li_danhmuc_timkiem {
		border-radius: 4px;
		border: 0.5px solid #888;
		width: calc(25% - 10px);
		/* 4 sản phẩm mỗi hàng */
		box-sizing: border-box;
	}

	/* Hiệu ứng hover */
	.li_danhmuc_timkiem:hover {
		background-color: #f0f0f0;
		/* Màu nền khi hover */
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
		/* Đổ bóng khi hover */
		transform: translateY(-5px);
		/* Di chuyển lên trên một chút */
		border-color: #533dc1;
		/* Màu viền khi hover */
	}

	/* Thay đổi màu chữ khi hover */
	.li_danhmuc_timkiem:hover .tieu_de_timkiem {
		color: #d0021b;
		/* Màu chữ khi hover */
	}

	/* Thay đổi ảnh khi hover */
	.li_danhmuc_timkiem:hover .minh_hoa_timkiem img {
		filter: brightness(90%);
		/* Làm tối ảnh khi hover */
		transform: scale(1.1);
		/* Phóng to ảnh khi hover */
	}

	/* CSS cho ảnh */
	.minh_hoa_timkiem img {
		width: 50px;
		height: 30px;
		transition: all 0.3s ease;
	}

	/* CSS cho tiêu đề */
	.tieu_de_timkiem {
		font-size: 14px;
		font-weight: 500;
		text-align: center;
		color: #333;
		margin-top: 10px;
		transition: color 0.3s ease;
		/* Hiệu ứng mượt cho màu chữ */
	}

	/* Khi mở rộng danh sách */
	.list_danhmuc_timkiem.show-all {
		max-height: none;
	}

	/**/

	#output_search_mobile li {
		padding: 10px;
		border-bottom: 1px solid #eee;
	}

	#output_search_mobile li:last-child {
		border-bottom: none;
	}

	#output_search_mobile li strong {
		font-size: 16px;
		color: #333;
	}

	#output_search_mobile a {
		text-decoration: none;
		color: #333;
		font-size: 14px;
		display: flex;
		align-items: center;
	}

	#output_search_mobile a i {
		margin-right: 8px;
		color: #888;
	}

	#output_search_mobile li:hover {
		background: #f8f9fa;
	}

	#voiceSearchBtn {
		left: 90%;
		top: -38px;
		z-index: 9999999000000000000001;
		position: relative;
		background: none;
		border: none;
		cursor: pointer;
		font-size: 18px;
		color: #474b4e;
	}

	#voiceSearchBtn:hover {
		color: #0056b3;
	}

	#voiceSearchBtn_mobile {
		left: 87%;
		top: -38px;
		z-index: 9999999000000000000001;
		position: relative;
		background: none;
		border: none;
		cursor: pointer;
		font-size: 18px;
		color: #474b4e;
	}

	#voiceSearchBtn_mobile:hover {
		color: #0056b3;
	}

	@media (max-width: 768px) {


		#output_search_mobile {
			width: 96% !important;
			left: 2% !important;
			max-height: 300px !important;
			overflow-y: auto !important;
			-webkit-overflow-scrolling: touch;
			/* Cuộn mượt trên mobile */
		}

		#voiceSearchBtn {
			left: 69% !important;
			top: -35px !important;
		}

		#voiceSearchBtn_mobile {
			left: 69% !important;
			top: -35px !important;
		}

		header .main-header-mobile .container .box_search .input_search button {
			height: 35px;
			width: 60px;
			border: none;
			background: #fff !important;
			color: #040404 !important;
			float: left;
			border-radius: 0px 5px 5px 0px;
			cursor: pointer;
		}

		.li_danhmuc_timkiem {
			flex: 1 1 calc(50% - 10px);
			/* Hiển thị 2 cột trên mobile */
		}

		/**/
		#output_search_mobile {
			position: absolute !important;
			/* Đảm bảo nút "X" nằm đúng vị trí */
			padding: 10px;
			background: #fff;
			border: 1px solid #ccc;
			width: 100% !important;
			left: 0% !important;
			max-width: 100%;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
		}

		.list_danhmuc_timkiem {
			padding-top: 20px;
			height: 100% !important;
		}

		#voiceSearchBtn_mobile {
			display: none !important;
			;
		}
	}

	.close-btn {
		position: absolute;
		top: 5px;
		right: 5px;
		background: none;
		border: none;
		font-size: 16px;
		cursor: pointer;
		color: #888;
		z-index: 999991;
		/* Đảm bảo nút hiển thị trên cùng */
	}


	.close-btn:hover {
		color: #333;
	}

	#output_search,
	#output_search_mobile {
		position: relative;
		/* Đảm bảo nút "X" nằm đúng vị trí */
		padding: 10px;
		background: #fff;
		border: 1px solid #ccc;
		width: 100% !important;
		left: 0% !important;
		max-width: 100%;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
	}


	.close-btn.hidden {
		display: none;
	}

	.label_product_timkiem {
		position: relative;
		top: -2px;
		left: 55px;
		right: -1px;
		width: 32px;
		background: linear-gradient(135deg, #ff7f00, #ff5500);
		color: white;
		font-weight: bold;
		font-size: 10px;
		padding: 0px -2px;
		border-radius: 5px;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
		z-index: 10;
	}


	/* CSS REPONSIVE TABLET  */

	@media screen and (min-width: 980px) and (max-width: 1271px) {
		.main-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			max-width: 1271px;
			margin: 0 auto;
			padding: 0 20px;
		}

		header .main-header .box_menu a.danh-muc {
			text-transform: uppercase;
			color: #fff;
			font-size: 14px;
			padding: 0px 0px;
			font-weight: 700;
			height: 80px;
			display: flex;
			align-items: center;
			transition: background 0.3sease;
		}


		header .main-header .box_menu {
			width: calc(72% - 534px);
			display: flex;
			height: 100%;
			align-items: center;
			justify-content: flex-end;
		}

		/* Đảm bảo 3 khối bên trong chiếm không gian bằng nhau */
		.main-header>.form_search,
		.main-header>.box_menu,
		.main-header>.box_control {
			flex: 1;
			text-align: center;
		}

		/* Nếu cần, điều chỉnh margin cho từng khối để cân đối */
		.form_search {
			margin-right: 10px;
		}

		header .main-header .logo img {
			max-width: 80%;
			max-height: 100%;
			object-fit: cover;
		}

		header .main-header .box_menu .danh-muc {
			font-size: 12px;
			padding: 0 7px;
		}

		.new-sub-menu {
			position: absolute;
			top: 0;
			left: 100%;
			width: 456px;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 4px;
			height: 100%;
			display: none;
			z-index: 999;
			overflow-x: hidden;
			overflow-y: auto;
		}

		.box_menu .menu_item .dropdown-content.new-dropdown-content {
			width: 653px;
		}

		.box_control {
			margin-left: 10px;
		}
	}
</style>